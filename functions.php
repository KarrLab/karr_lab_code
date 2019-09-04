<?php

require('lib/phpFastCache-6.1.2/src/autoload.php');
use phpFastCache\CacheManager;

CacheManager::setDefaultConfig([
    'path' => __DIR__ . '/cache/',
]);
$cache = CacheManager::getInstance('files');

if (array_key_exists('refresh', $_GET))
    $cache->clear();

function get_url($url, $cache, $expiration=5*60, $post=NULL, $username=NULL, $password=NULL, $token=NULL) {
    $cache_item = $cache->getItem(preg_replace('/[^a-z0-9_]/i', '_', $url));
    $response = $cache_item->get();

    if (is_null($response)) {
        $user_agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.0 Safari/537.36';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($token)
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(sprintf('Authorization: token %s', $token)));
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        }
        if ($username && $password)
            curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header_lines = substr($response, 0, $header_size);        
        $header_lines = explode("\r\n", $header_lines);
        $headers = array();
        foreach($header_lines as $header_line){
            list($key, $val) = explode(': ', $header_line);
            $headers[$key] = $val;
        }
        $body = json_decode(substr($response, $header_size));
        $response = array($body, $headers);
        
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (($httpcode < 200 || $httpcode >= 300) && $httpcode != 301 && $httpcode != 302)
            throw new Exception(sprintf('Error %d reading URL: %s', $httpcode, $url));
        
        $cache_item->set($response)->expiresAfter($expiration);
        $cache->save($cache_item);
    }

    return $response;
}

function get_source_github($owner, $repo, $cache, $get_release=true, $get_commit=true, $get_contributors=true, 
    $get_views=true, $get_downloads=true, $get_forks=true, $get_issues=true){
    $api_token = rtrim(file_get_contents('tokens/GITHUB_API_TOKEN'));
    $user_agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.0 Safari/537.36';

    #latest release
    if ($get_release) {
        $url = sprintf('https://api.github.com/repos/%s/%s/tags', $owner, $repo);
        list($data, $headers) = get_url($url, $cache, 5*60, NULL, NULL, NULL, $api_token);
        $tags = array();
        foreach($data as $tag)
            array_push($tags, $tag->name);
        rsort($tags, SORT_NATURAL | SORT_FLAG_CASE);
        $latest_tag = $tags[0];
    }
    
    #latest commit
    if ($get_commit) {
        $url = sprintf('https://api.github.com/repos/%s/%s/commits', $owner, $repo);
        list($data, $headers) = get_url($url, $cache, 5*60, NULL, NULL, NULL, $api_token);
        
        if (!is_array($data)) {
            throw new Exception("Unable to download commit data for $repo from GitHub. Check that the repo name is correct.");
        }
            
        $latest_commit = array(
            'sha' => $data[0]->sha,
            'author_login' => $data[0]->author->login,
            'author_name' => $data[0]->commit->author->name,
            'date' => strtotime($data[0]->commit->author->date)
            );
    }
    
    #contributors
    if ($get_contributors) {
        $url = sprintf('https://api.github.com/repos/%s/%s/contributors', $owner, $repo);
        list($data, $headers) = get_url($url, $cache, 5*60, NULL, NULL, NULL, $api_token);
        $num_contributors = count($data);
    }

    #views and clones
    if ($get_views) {
    $views = 0;
        $clones = 0;
        $unique_views = 0;
        $unique_clones = 0;

        $stats_filename = sprintf('repo/%s.stats.tsv', $repo);
        if (file_exists($stats_filename)) {
            $fp = fopen($stats_filename, 'r');
            if (!feof($fp))
                $line = fgets($fp); #header
            while (!feof($fp)) {
                $line = rtrim(fgets($fp));
                $data = preg_split('/\t/', $line);
                $views += $data[1];
                $unique_views += $data[2];
                $clones += $data[3];
                $unique_clones += $data[4];
            }
            fclose($fp);
        }
    }

    #downloads
    if ($get_downloads) {
        $url = sprintf('https://api.github.com/repos/%s/%s/releases', $owner, $repo);
        list($data, $headers) = get_url($url, $cache, 24*60*60, NULL, NULL, NULL, $api_token);
        $downloads = 0;
        foreach ($data as $release)
            $downloads += $release->assets->download_count;
    }
    
    #forks
    if ($get_forks) {
        $url = sprintf('https://api.github.com/repos/%s/%s/forks', $owner, $repo);
        list($data, $headers) = get_url($url, $cache, 24*60*60, NULL, NULL, NULL, $api_token);
        $forks = count($data);
    }
    
    # issues
    if ($get_issues) {
        $issues = array(
            'total' => 0,
            'closed' => 0,
            'needs-work' => 0,
            'issues' => array()
            );
        $page = 0;
        while (true) {
            $page++;
            $url = sprintf('https://api.github.com/repos/%s/%s/issues?state=all&page=%d&per_page=100', $owner, $repo, $page);
            list($data, $headers) = get_url($url, $cache, 24*60*60, NULL, NULL, NULL, $api_token);            
            $issues['total'] += count($data);
            foreach ($data as $issue) {
                array_push($issues['issues'], $issue);
                if ($issue->state == 'closed') {
                    $issues['closed']++;
                } else {
                    $needs_work = count($issue->labels) == 0;
                    foreach ($issue->labels as $label) {
                        if (in_array($label->name, array('enhancement', 'bug', 'invalid'))) {
                            $needs_work = true;
                            break;
                        }
                    }
                    if ($needs_work) {
                        $issues['needs-work']++;
                    }
                }
            }
            
            if (!array_key_exists('Link', $headers) || strpos($headers['Link'], 'next') === false)
                break;
        }
    }

    #return info
    return array(
        'latest_tag' => $latest_tag,
        'latest_commit' => $latest_commit,
        'num_contributors' => $num_contributors,
        'views' => $views,
        'unique_views' => $unique_views,
        'downloads' => $downloads,
        'clones' => $clones,
        'unique_clones' => $unique_clones,
        'forks' => $forks,
        'issues' => $issues
    );
}

function get_latest_build_circleci($owner, $repo, $cache){
    $circleci_token = rtrim(file_get_contents('tokens/CIRCLECI_TOKEN'));
    
    $url = sprintf('https://circleci.com/api/v1.1/project/github/%s/%s?circle-token=%s&limit=1&filter=completed', 
        $owner, $repo, $circleci_token);
    list($response, $headers) = get_url($url, $cache, 60);
    return $response;
}

function get_tests_circleci($owner, $repo, $build_num, $cache){
    $circleci_token = rtrim(file_get_contents('tokens/CIRCLECI_TOKEN'));

    $url = sprintf('https://circleci.com/api/v1.1/project/github/%s/%s/%d/tests?circle-token=%s', 
        $owner, $repo, $build_num, $circleci_token);
    list($data, $headers) = get_url($url, $cache, 60);

    $passes = 0;
    $skips = 0;
    $errors = 0;
    $failures = 0;
    foreach ($data->tests as $test) {
        if ($test->result == 'success') {
            $passes++;
        } elseif ($test->result == 'skipped') {
            $skips++;
        }elseif ($test->result == 'error') {
            $errors++;
        } elseif ($test->result == 'failure') {
            $failures++;
        }
    }
    $total = $passes + $skips + $errors + $failures;

    $url = sprintf('https://circleci.com/api/v1.1/project/github/%s/%s/%d/artifacts?circle-token=%s', 
        $owner, $repo, $build_num, $circleci_token);
    list($data, $headers) = get_url($url, $cache, 60);
    $py2 = false;
    $py3 = false;
    foreach ($data as $artifact) {
        if (strpos($artifact->pretty_path, '.coverage.') === 0) {
            $tmp = explode('.', $artifact->pretty_path);
            if ($tmp[2] == 2)
                $py_2 = true;
            elseif ($tmp[2] == 3)
                $py_3 = true;
        }
    }

    return array(
        'py_2' => $py_2,
        'py_3' => $py_3,
        'total' => $total,
        'passes' => $passes,
        'skips' => $skips,
        'errors' => $errors,
        'failures' => $failures,
        'others' => $others
        );
}

function get_latest_distribution_pypi($repo, $cache) {
    $url = sprintf('https://pypi.python.org/pypi/%s/json', str_replace('_', '-', $repo));
    list($response, $headers) = get_url($url, $cache, 24*60*60);
    return $response;
}

function get_latest_distribution_ctan($repo, $cache) {
    $url = sprintf('https://www.ctan.org/json/pkg/%s', $repo);
    list($response, $headers) = get_url($url, $cache, 24*60*60);
    return $response;
}

$bioportal_api_token = rtrim(file_get_contents('tokens/BIOPORTAL_API_TOKEN'));
function get_latest_distribution_bioportal($repo, $cache) {
    $url = sprintf('http://data.bioontology.org/ontologies/%s/submissions?apikey=%s', $repo, $bioportal_api_token);
    list($response, $headers) = get_url($url, $cache, 24*60*60);
    return $response;
}

function get_latest_docs_rtd($repo, $cache) {
    # The API doesn't seem to return the status of builds
    # See also https://docs.readthedocs.io/en/latest/api.html
    $url = sprintf('https://readthedocs.org/api/v1/version/%s/?format=json', $repo);
    list($response, $headers) = get_url($url, $cache, 5*60);
    return $response;
}

function get_artifacts_circleci($owner, $repo, $build_num, $cache) {
    $circleci_token = rtrim(file_get_contents('tokens/CIRCLECI_TOKEN'));

    $url = sprintf('https://circleci.com/api/v1.1/project/github/%s/%s/%d/artifacts?circle-token=%s',
        $owner, $repo, $build_num, $circleci_token);
    list($data, $headers) = get_url($url, $cache, 60);

    $docs_url = NULL;
    foreach ($data as $artifact) {
        if ($artifact->pretty_path == "docs/index.html") {
            $docs_url = $artifact->url;
            break;
        }
    }

    return array(
        'docs' => $docs_url,
    );
}

function get_coverage_coveralls($owner, $repo, $token=NULL, $cache) {
    $url = sprintf('https://coveralls.io/github/%s/%s.json?repo_token=%s', $owner, $repo, $token);
    list($response, $headers) = get_url($url, $cache, 60);
    return $response;
}

function get_coverage_codecov($owner, $repo, $cache) {
    $url = sprintf('https://codecov.io/api/gh/%s/%s', $owner, $repo);
    list($response, $headers) = get_url($url, $cache, 60);
    return $response;
}

function get_analysis_codeclimate($token, $cache) {
    $codeclimate_api_token = rtrim(file_get_contents('tokens/CODECLIMATE_API_TOKEN'));

    $url = sprintf('https://codeclimate.com/api/repos/%s?api_token=%s', $token, $codeclimate_api_token);
    list($response, $headers) = get_url($url, $cache, 60);
    return $response;
}

function get_package_types() {
    return array(
        'Cell models',
        'Cell modeling and simulation tools',
        'Modeling and simulation tools',
        'Software development tools',
        'Other scientific and software tools',
        'Karr Lab utilities',
        'Training materials',
        'Code used for papers',
        'Other'
        );
}

function get_packages() {
    $pkg_ids = scandir('repo');
    
    $pkg_configs = array();
    foreach (get_package_types() as $type)
        $pkg_configs[$type] = array();    
    
    foreach ($pkg_ids as $pkg_id) {
        if (pathinfo($pkg_id, PATHINFO_EXTENSION) != 'json')
          continue;

        $handle = fopen("repo/$pkg_id", "r");
        $pkg = json_decode(fread($handle, filesize("repo/$pkg_id")));
        fclose($handle);

        if (property_exists($pkg, 'type')) {
            $type = $pkg->type;
        } else {
            $type = 'Other';
        }

        $pkg_configs[$type][$pkg->id] = $pkg;
    }
    return $pkg_configs;
}

?>