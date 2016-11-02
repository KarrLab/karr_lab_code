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
                                        <th colspan="10"></th>
                                        <th>Views</th>
                                        <th>Clones</th>
                                        <th>GitHub</th>
                                        <th>Dist</th>
                                        <th>Forks</th>
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
                                        <th>/week</th>
                                        <th>/week</th>
                                        <th>/total</th>
                                        <th>/mo</th>
                                        <th>/total</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php

function get_source_github($repo){
  $username = rtrim(file_get_contents('tokens/GITHUB_USERNAME'));
  $password = rtrim(file_get_contents('tokens/GITHUB_PASSWORD'));
  $client_id = rtrim(file_get_contents('tokens/GITHUB_CLIENT_ID'));
  $client_secret = rtrim(file_get_contents('tokens/GITHUB_CLIENT_SECRET'));
  $access_token = rtrim(file_get_contents('tokens/GITHUB_ACCESS_TOKEN'));
  $user_agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.0 Safari/537.36';

  //authorize access to repository
  $ch = curl_init();
  $url = sprintf('https://api.github.com/authorizations', $repo);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);
  curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    'scopes' => array('repo', 'repo:status', 'repo_deployment', 'public_repo'),
    'note' => 'For code.karrlab.org',
    'note_url' => 'http://code.karrlab.org',
    'client_id' => $client_id,
    'client_secret' => $client_secret
  )));
  $data = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpcode<200 || $httpcode>=300)
    throw new Exception(sprintf('Error authorizing code.karrlab.org: %s', $repo));

  $data = json_decode($data);
  $access_token = $data->token;

  #latest release
  $ch = curl_init();
  $url = sprintf('https://api.github.com/repos/KarrLab/%s/tags', $repo);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(sprintf('Authorization: token %s', $access_token)));
  curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpcode<200 || $httpcode>=300)
    throw new Exception(sprintf('Error reading info from GitHub: %s', $repo));

  $data = json_decode($data);
  $tags = array();
  foreach($data as $tag)
    array_push($tags, $tag->name);
  rsort($tags);
  $latest_tag = $tags[0];

  #views
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, sprintf('https://api.github.com/repos/KarrLab/%s/traffic/views?per=week', $repo));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      sprintf('Authorization: token %s', $access_token),
      'Accept: application/vnd.github.spiderman-preview'
    ));
  curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpcode<200 || $httpcode>=300)
    throw new Exception('Error reading info from GitHub');

  $data = json_decode($data);
  $views = $data->count;

  #downloads
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, sprintf('https://api.github.com/repos/KarrLab/%s/releases', $repo));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(sprintf('Authorization: token %s', $access_token)));
  curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpcode<200 || $httpcode>=300)
    throw new Exception('Error reading info from GitHub');

  $downloads = 0;
  foreach (json_decode($data) as $release)
    $downloads += $release->assets->download_count;

  #clones
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, sprintf('https://api.github.com/repos/KarrLab/%s/traffic/clones?per=week', $repo));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    sprintf('Authorization: token %s', $access_token),
    'Accept: application/vnd.github.spiderman-preview'
  ));
  curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpcode<200 || $httpcode>=300)
    throw new Exception('Error reading info from GitHub');

  $data = json_decode($data);
  $clones = $data->count;

  #forks
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, sprintf('https://api.github.com/repos/KarrLab/%s/forks', $repo));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(sprintf('Authorization: token %s', $access_token)));
  curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpcode<200 || $httpcode>=300)
    throw new Exception('Error reading info from GitHub');

  $forks = count(json_decode($data));

  #return info
  return array(
    'latest_tag' => $latest_tag,
    'views' => $views,
    'downloads' => $downloads,
    'clones' => $clones,
    'forks' => $forks,
  );
}

function get_latest_build_circleci($repo){
  $circleci_token = rtrim(file_get_contents('tokens/CIRCLECI_TOKEN'));

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, sprintf('https://circleci.com/api/v1.1/project/github/KarrLab/%s?circle-token=%s&limit=1&filter=completed', $repo, $circleci_token));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpcode<200 || $httpcode>=300)
    throw new Exception('Error reading build from CircleCI');

  return json_decode($data);
}

function get_latest_distribution_pypi($repo) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, sprintf('https://pypi.python.org/pypi/%s/json', str_replace('_', '-', $repo)));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpcode<200 || $httpcode>=300)
    throw new Exception('Error reading distribution info from PyPI');

  return json_decode($data);
}

function get_latest_distribution_ctan($repo) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, sprintf('http://www.ctan.org/json/pkg/%s', $repo));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpcode<200 || $httpcode>=300)
    throw new Exception('Error reading distribution info from CTAN');

  return json_decode($data);
}

function get_latest_docs_rtd($repo) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, sprintf('http://readthedocs.org/api/v1/version/%s/highest/?format=json', $repo));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpcode<200 || $httpcode>=300)
    throw new Exception('Error reading docs info from Read The Docs');

  return json_decode($data);
}

function get_latest_artifacts_circleci($repo, $build_num) {
  $circleci_token = rtrim(file_get_contents('tokens/CIRCLECI_TOKEN'));

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, sprintf('https://circleci.com/api/v1.1/project/github/KarrLab/%s/%d/artifacts?circle-token=%s',
    $repo, $build_num, $circleci_token));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpcode<200 || $httpcode>=300)
    throw new Exception('Error reading build from CircleCI');

  $docs_url = NULL;
  foreach (json_decode($data) as $artifact) {
    if ($artifact->pretty_path == "\$CIRCLE_ARTIFACTS/docs/index.html") {
      $docs_url = $artifact->url;
      break;
    }
  }

  return array(
    'docs' => $docs_url,
  );
}

function get_coverage_coveralls($repo, $token=NULL) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, sprintf('https://coveralls.io/github/KarrLab/%s.json?repo_token=%s', $repo, $token));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpcode<200 || $httpcode>=300)
    throw new Exception('Error reading coverage info Coveralls');

  return json_decode($data);
}

function get_analysis_codeclimate($token) {
  $codeclimate_api_token = rtrim(file_get_contents('tokens/CODECLIMATE_API_TOKEN'));

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, sprintf('https://codeclimate.com/api/repos/%s?api_token=%s', $token, $codeclimate_api_token));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpcode<200 || $httpcode>=300)
    throw new Exception('Error reading analysis info Code Climate');

  return json_decode($data);
}

$pkg_configs = scandir('repo');
sort($pkg_configs, SORT_NATURAL | SORT_FLAG_CASE);

foreach ($pkg_configs as $pkg_config) {
    if (pathinfo($pkg_config, PATHINFO_EXTENSION) != 'json')
      continue;

    $handle = fopen("repo/$pkg_config", "r");
    $pkg = json_decode(fread($handle, filesize("repo/$pkg_config")));
    fclose($handle);

    $source = get_source_github($pkg->id);

    if ($pkg->build && $pkg->build->circleci) {
      $latest_build = get_latest_build_circleci($pkg->id)[0];
      $artifacts = get_latest_artifacts_circleci($pkg->id, $latest_build->build_num);
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
            $distribution = get_latest_distribution_pypi($dist_pkg_id);
            echo sprintf("<a href='https://pypi.python.org/pypi/%s'>%s</a>", $pkg->id, $distribution->info->version);
            break;
          case 'ctan':
            $distribution = get_latest_distribution_ctan($dist_pkg_id);
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
        $coverage = get_coverage_coveralls($pkg->id, $pkg->test_coverage->coveralls->token);
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
          $analysis = get_analysis_codeclimate($pkg->code_analysis->code_climate->token);
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
