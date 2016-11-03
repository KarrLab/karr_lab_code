<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

      	<meta name="description" content="The Karr Lab is a computational systems biology research lab at the Icahn School of Medicine at Mount Sinai." />
      	<meta name="keywords" content="Jonathan Karr, systems biology, translational medicine, whole-cell, modeling" />
      	<meta name="author" content="Jonathan Karr" />
      	<meta name="revised" content="Jonathan Karr, 04/28/2015" />
      	<meta name="copyright" content="&copy; 2013-2015 Karr Lab" />
      	<meta name="robots" content="ALL" />
      	<meta http-equiv="content-language" content="en-US" />
      	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>Karr Lab</title>
        <link rel="stylesheet" href="http://www.karrlab.org/static/css/foundation.css" />
        <link rel="stylesheet" href="http://www.karrlab.org/static/css/foundation-icons.css" />
        <link rel="stylesheet" href="http://www.karrlab.org/static/css/extras.css" />
        <script src="http://www.karrlab.org/static/js/vendor/modernizr.js"></script>

        <link rel="icon" type="image/x-icon" href="http://www.karrlab.org/static/img/logo-mssm-16x16.ico" />

        <style>
            #code{
                width:100%;
            }
            #code th {
                background:#d9d9d9;
            }
            #code th,
            #code td {
                text-align:center;
                padding-left:2px;
                padding-right:2px;
            }
            #code th:first-child,
            #code td:first-child{
                text-align:left;
                whitespace: nowrap;
            }

            a.alert {
              color:red;
            }
        </style>
    </head>
    <body>
        <div class="off-canvas-wrap" data-offcanvas>
            <div class="inner-wrap">
                <nav class="tab-bar hide-for-medium-up">
                   <section class="left-small">
                        <a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
                    </section>

                    <section class="right tab-bar-section">
                        <h1 class="title">Karr Systems Biology Lab</h1>
                    </section>
                </nav>

                <aside class="left-off-canvas-menu">
                    <ul class="off-canvas-list">
                        <li><label>Karr Systems Biology Lab</label></li>
                        <li><a href="http://www.karrlab.org/">Home</a></li>
                        <li><a href="http://www.karrlab.org/research">Research</a></li>
                        <li><a href="http://www.karrlab.org/resources">Resources</a></li>
                        <li><a href="http://www.karrlab.org/publications">Publications</a></li>
                        <li><a href="http://www.karrlab.org/press">Press</a></li>
                        <li><a href="http://www.karrlab.org/funding">Funding</a></li>
                        <li><a href="http://www.karrlab.org/people">People</a></li>
                        <li><a href="http://www.karrlab.org/join">Join us</a></li>
                        <li><a href="http://www.karrlab.org/contact">Contact</a></li>
                    </ul>
                </aside>

                <section class="main-section">
                <!-- canvas wrapping -->

                    <!-- top bar -->
                    <div class="top-bar row show-for-medium-up">
                        <div class="small-12 columns">
                            <dl class="sub-nav">
                                <dd><a href="http://www.karrlab.org/">Home</a></dd>
                                <dd><a href="http://www.karrlab.org/research">Research</a></dd>
                                <dd class="active"><a href="http://www.karrlab.org/resources">Resources</a></dd>
                                <dd><a href="http://www.karrlab.org/publications">Publications</a></dd>
                                <dd><a href="http://www.karrlab.org/press">Press</a></dd>
                                <dd><a href="http://www.karrlab.org/funding">Funding</a></dd>
                                <dd><a href="http://www.karrlab.org/people">People</a></dd>
                                <dd><a href="http://www.karrlab.org/join">Join us</a></dd>
                                <dd><a href="http://www.karrlab.org/contact">Contact</a></dd>
                            </dl>
                        </div>
                    </div>
                    <div class="top-bar-bg show-for-medium-up">
                    </div>

                    <!-- content -->
                    <div class="row content">
                        <div class="centered">
                        <!-- end common header -->
                            <h3>Code</h3>

                            <table cellpadding=0 cellspacing=0 id="code">
                                <thead>
                                    <tr>
                                        <th colspan="12"></th>
                                        <th colspan="2">Downloads</th>
                                        <th colspan="1"></th>
                                    </tr>
                                    <tr>
                                        <th>Package</th>
                                        <th>Open?</th>
                                        <th>License</th>
                                        <th>Dist</th>
                                        <th>Source</th>
                                        <th>Docs</th>
                                        <th>Build</th>
                                        <th>Tests</th>
                                        <th>Coverage</th>
                                        <th>Analysis</th>
                                        <th>Views</th>
                                        <th>Clones</th>
                                        <th>GitHub</th>
                                        <th>Dist</th>
                                        <th>Forks</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php

require_once('lib/Simple-PHP-Cache-1.6/cache.class.php');
$cache = new Cache(array(
  'name'      => 'index',
  'path'      => '.',
  'extension' => '.cache'
));

if ($_GET['erase_cache'])
  $cache->eraseAll();

function get_url($url, $cache, $expiration=86400, $post=NULL, $username=NULL, $password=NULL, $token=NULL) {
  $response = $cache->retrieve($url);

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

    $response = json_decode(curl_exec($ch));

    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode < 200 || $httpcode >= 300)
      throw new Exception(sprintf('Error reading URL: %s', $url));

    $cache->store($url, $response, $expiration);
  }

  return $response;
}

function get_source_github($repo, $cache){
  $username = rtrim(file_get_contents('tokens/GITHUB_USERNAME'));
  $password = rtrim(file_get_contents('tokens/GITHUB_PASSWORD'));
  $client_id = rtrim(file_get_contents('tokens/GITHUB_CLIENT_ID'));
  $client_secret = rtrim(file_get_contents('tokens/GITHUB_CLIENT_SECRET'));
  $user_agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.0 Safari/537.36';

  #latest release
  $url = sprintf('https://api.github.com/repos/KarrLab/%s/tags', $repo);
  $data = get_url($url, $cache, 24*60*60, NULL, $username, $password);
  $tags = array();
  foreach($data as $tag)
    array_push($tags, $tag->name);
  rsort($tags, SORT_NATURAL | SORT_FLAG_CASE);
  $latest_tag = $tags[0];

  #views and clones
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

  #downloads
  $url = sprintf('https://api.github.com/repos/KarrLab/%s/releases', $repo);
  $data = get_url($url, $cache, 24*60*60, NULL, $username, $password);
  $downloads = 0;
  foreach ($data as $release)
    $downloads += $release->assets->download_count;

  #forks
  $url = sprintf('https://api.github.com/repos/KarrLab/%s/forks', $repo);
  $data = get_url($url, $cache, 24*60*60, NULL, $username, $password);
  $forks = count($data);

  #return info
  return array(
    'latest_tag' => $latest_tag,
    'views' => $views,
    'unique_views' => $unique_views,
    'downloads' => $downloads,
    'clones' => $clones,
    'unique_clones' => $unique_clones,
    'forks' => $forks,
  );
}

function get_latest_build_circleci($repo, $cache){
  $circleci_token = rtrim(file_get_contents('tokens/CIRCLECI_TOKEN'));

  $url = sprintf('https://circleci.com/api/v1.1/project/github/KarrLab/%s?circle-token=%s&limit=1&filter=completed', $repo, $circleci_token);
  return get_url($url, $cache, 60);
}

function get_latest_distribution_pypi($repo, $cache) {
  $url = sprintf('https://pypi.python.org/pypi/%s/json', str_replace('_', '-', $repo));
  return get_url($url, $cache, 60);
}

function get_latest_distribution_ctan($repo, $cache) {
  $url = sprintf('http://www.ctan.org/json/pkg/%s', $repo);
  return get_url($url, $cache, 60);
}

function get_latest_docs_rtd($repo, $cache) {
  $url = sprintf('http://readthedocs.org/api/v1/version/%s/highest/?format=json', $repo);
  return get_url($url, $cache, 60);
}

function get_latest_artifacts_circleci($repo, $build_num, $cache) {
  $circleci_token = rtrim(file_get_contents('tokens/CIRCLECI_TOKEN'));

  $url = sprintf('https://circleci.com/api/v1.1/project/github/KarrLab/%s/%d/artifacts?circle-token=%s',
    $repo, $build_num, $circleci_token);
  $data = get_url($url, $cache, 60);

  $docs_url = NULL;
  foreach ($data as $artifact) {
    if ($artifact->pretty_path == "\$CIRCLE_ARTIFACTS/docs/index.html") {
      $docs_url = $artifact->url;
      break;
    }
  }

  return array(
    'docs' => $docs_url,
  );
}

function get_coverage_coveralls($repo, $token=NULL, $cache) {
  $url = sprintf('https://coveralls.io/github/KarrLab/%s.json?repo_token=%s', $repo, $token);
  return get_url($url, $cache, 60);
}

function get_analysis_codeclimate($token, $cache) {
  $codeclimate_api_token = rtrim(file_get_contents('tokens/CODECLIMATE_API_TOKEN'));

  $url = sprintf('https://codeclimate.com/api/repos/%s?api_token=%s', $token, $codeclimate_api_token);
  return get_url($url, $cache, 60);
}

$pkg_configs = scandir('repo');
sort($pkg_configs, SORT_NATURAL | SORT_FLAG_CASE);

foreach ($pkg_configs as $pkg_config) {
    if (pathinfo($pkg_config, PATHINFO_EXTENSION) != 'json')
      continue;

    $handle = fopen("repo/$pkg_config", "r");
    $pkg = json_decode(fread($handle, filesize("repo/$pkg_config")));
    fclose($handle);

    $source = get_source_github($pkg->id, $cache);

    if ($pkg->build && $pkg->build->circleci) {
      $latest_build = get_latest_build_circleci($pkg->id, $cache)[0];
      $artifacts = get_latest_artifacts_circleci($pkg->id, $latest_build->build_num, $cache);
    } else {
      $latest_build = NULL;
      $artifacts = array();
    }

    #start row
    echo "<tr>\n";

    #name
    echo sprintf("<td><a href='https://github.com/KarrLab/%s'>%s</a></td>\n", $pkg->id, $pkg->id);

    #status
    echo sprintf("<td>%s</td>\n", $pkg->availability);

    #license
    echo "<td>";
    if ($pkg->license)
      echo sprintf("<a href='https://github.com/KarrLab/%s/blob/master/LICENSE'>%s</a>", $pkg->id, $pkg->license);
    echo "</td>";

    #distribution
    echo "<td>";
    if ($pkg->distribution) {
      $dist_pkg_id = ($pkg->distribution->package ? $pkg->distribution->package : $pkg->id);
      switch ($pkg->distribution->repo) {
          case 'pypi':
            $distribution = get_latest_distribution_pypi($dist_pkg_id, $cache);
            echo sprintf("<a href='https://pypi.python.org/pypi/%s'>%s</a>", $pkg->id, $distribution->info->version);
            break;
          case 'ctan':
            $distribution = get_latest_distribution_ctan($dist_pkg_id, $cache);
            echo sprintf("<a href='https://www.ctan.org/pkg/%s'>%s</a>", $pkg->id, $distribution->version->number);
            break;
      }
    }
    echo "</td>\n";

    #source code
    echo sprintf("<td><a href='https://github.com/KarrLab/%s'>%s</a></td>\n",
      $pkg->id, ($source['latest_tag'] ? $source['latest_tag'] : 'Latest'));

    #documentation
    echo "<td>";
    if ($pkg->docs && $pkg->docs->readthedocs) {
        $docs_pkg_id = ($pkg->docs->readthedocs->id ? $pkg->docs->readthedocs->id : $pkg->id);
        $docs_url = sprintf('http://%s.readthedocs.org', $docs_pkg_id);
    } elseif ($pkg->docs && $pkg->docs->url) {
        $docs_url = $pkg->docs->url;
    } elseif ($artifacts['docs']) {
        $docs_url = $artifacts['docs'];
    } else {
        $docs_url = NULL;
    }
    if ($docs_url)
        echo "<a href='$docs_url'>Latest</a>";
    echo "</td>\n";

    #build
    echo "<td>";
    if ($pkg->build && $pkg->build->circleci)
        echo sprintf("<a href='https://circleci.com/gh/KarrLab/%s' class='%s'>%s</a>",
          $pkg->id,
          ($latest_build->status == 'fixed' || $latest_build->status == 'success' ? '' : 'alert'),
          ucfirst($latest_build->status));
    echo "</td>\n";

    #tests results
    echo "<td>";
    if ($pkg->test_results)
        echo sprintf("<a href='http://tests.karrlab.org/KarrLab/%s'>Results</a>", $pkg->id);
    echo "</td>\n";

    #coverage
    echo "<td>";
    if ($pkg->test_coverage && $pkg->test_coverage->coveralls) {
        $coverage = get_coverage_coveralls($pkg->id, $pkg->test_coverage->coveralls->token, $cache);
        echo sprintf("<a href='https://coveralls.io/github/KarrLab/%s'>%.1f%%</a>", $pkg->id, $coverage->covered_percent);
    }
    echo "</td>\n";

    #analysis
    echo "<td>";
    if ($pkg->code_analysis && $pkg->code_analysis->code_climate){
        if ($pkg->code_analysis->code_climate->open_source) {
          $url = sprintf('https://codeclimate.com/github/KarrLab/%s', $pkg->id);
          $gpa = 'N/A';
        } else {
          $url = sprintf('https://codeclimate.com/repos/%s', $pkg->code_analysis->code_climate->token);
          $analysis = get_analysis_codeclimate($pkg->code_analysis->code_climate->token, $cache);
          $gpa = $analysis->last_snapshot->gpa;
        }
        echo sprintf("<a href='%s'>%s</a>", $url, $gpa);
    }
    echo "</td>\n";

    #views
    echo sprintf("<td><a href='https://github.com/KarrLab/%s/graphs/traffic'>%d</a></td>\n",
      $pkg->id, $source['views']);

    #clones
    echo sprintf("<td><a href='https://github.com/KarrLab/%s/graphs/traffic'>%d</a></td>\n",
      $pkg->id, $source['clones']);

    #downloads
    echo sprintf("<td><a href='https://github.com/KarrLab/%s/graphs/traffic'>%d</a></td>\n",
      $pkg->id, $source['downloads']);

    echo "<td>";
    if ($pkg->distribution && $pkg->distribution->repo == 'pypi') {
      $dist_pkg_id = ($pkg->distribution->package ? $pkg->distribution->package : $pkg->id);

      $downloads = 0;
      foreach($distribution->releases as $release)
        foreach($release as $file)
          $downloads += $file->downloads;

      echo sprintf("<a href='https://pypi.python.org/pypi/%s'>%d</a>", $pkg->id, $downloads);
    }
    echo "</td>\n";

    #forks
    echo sprintf("<td><a href='https://github.com/KarrLab/%s/graphs/traffic'>%d</a></td>\n",
      $pkg->id, $source['forks']);

    #end row
    echo "</tr>\n";
    echo "<tr>\n";
    echo sprintf("<td colspan='15'>%s</td>\n", $pkg->description);
    echo "</tr>\n";
}
?>
                                </tbody>
                            </table>

                        <!-- common footer -->
                        </div>
                    </div>

                    <!-- bottom bar -->
                    <div class="row bottom-bar">
                        <div class="logo">
                            <a href="http://www.mssm.edu"><img src="http://www.karrlab.org/static/img/logo-mssm-32x32.png" /></a>
                        </div>

                        <div class="text-left">
                            <a href="http://icahn.mssm.edu/departments-and-institutes/genomics">Icahn Institute for Genomics &amp; Multiscale Biology</a><br/>
                            <a href="http://icahn.mssm.edu/departments-and-institutes/genomics">Department of Genetics &amp; Genomic Sciences</a><br/>
                            <a href="http://www.mssm.edu">Icahn School of Medicine at Mount Sinai</a>
                        </div>

                        <div class="text-right show-for-medium-up">
                            &copy; Karr Lab 2016
                        </div>

                        <div class="clear"></div>
                    </div>

                <!-- canvas wrapping -->
                </section>
                <a class="exit-off-canvas"></a>
            </div>
        </div>

        <script src="http://www.karrlab.org/static/js/vendor/jquery.js"></script>
        <script src="http://www.karrlab.org/static/js/foundation.min.js"></script>
        <script>
        $(document).foundation();
        </script>
    </body>
</html>
