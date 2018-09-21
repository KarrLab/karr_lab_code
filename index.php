<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

      	<meta name="description" content="The Karr Lab is a computational systems biology research lab at the Icahn School of Medicine at Mount Sinai." />
      	<meta name="keywords" content="Jonathan Karr, systems biology, translational medicine, whole-cell, modeling" />
      	<meta name="author" content="Jonathan Karr" />
      	<meta name="revised" content="Jonathan Karr, 03/03/2018" />
      	<meta name="copyright" content="&copy; 2013-2018 Karr Lab" />
      	<meta name="robots" content="ALL" />
      	<meta http-equiv="content-language" content="en-US" />
      	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>Karr Lab</title>
        <link rel="stylesheet" href="https://www.karrlab.org/static/css/foundation.css" />
        <link rel="stylesheet" href="https://www.karrlab.org/static/css/foundation-icons.css" />
        <link rel="stylesheet" href="https://www.karrlab.org/static/css/extras.css" />
        <script src="https://www.karrlab.org/static/js/vendor/modernizr.js"></script>

        <link rel="icon" type="image/x-icon" href="https://www.karrlab.org/static/img/logo-mssm-16x16.ico" />

        <style>
            .row {
                max-width: 80rem;
            }
            #code{
                width:100%;
            }
            #code th {
                background:#999;
            }
            #code th,
            #code td {
                text-align:center;
                padding-left:2px;
                padding-right:2px;
                padding-top:4px;
                padding-bottom:4px;
            }
            #code th:first-child,
            #code td:first-child{
                text-align:left;
                whitespace: nowrap;
            }

            #code tr.margin th {
                background:none;
                height:30px;
            }
            #code tr.type th {
                background:#d9d9d9
            }

            tr.alert td, tr.alert td a{
              color:red;
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
                        <li><a href="https://www.karrlab.org/">Home</a></li>
                        <li><a href="https://www.karrlab.org/research">Research</a></li>
                        <li><a href="https://www.karrlab.org/resources">Resources</a></li>
                        <li><a href="https://www.karrlab.org/publications">Publications</a></li>
                        <li><a href="https://www.karrlab.org/press">Press</a></li>
                        <li><a href="https://www.karrlab.org/funding">Funding</a></li>
                        <li><a href="https://www.karrlab.org/people">People</a></li>
                        <li><a href="https://www.karrlab.org/join">Join us</a></li>
                        <li><a href="https://www.karrlab.org/contact">Contact</a></li>
                    </ul>
                </aside>

                <section class="main-section">
                <!-- canvas wrapping -->

                    <!-- top bar -->
                    <div class="top-bar row show-for-medium-up">
                        <div class="small-12 columns">
                            <dl class="sub-nav">
                                <dd><a href="https://www.karrlab.org/">Home</a></dd>
                                <dd><a href="https://www.karrlab.org/research">Research</a></dd>
                                <dd class="active"><a href="https://www.karrlab.org/resources">Resources</a></dd>
                                <dd><a href="https://www.karrlab.org/publications">Publications</a></dd>
                                <dd><a href="https://www.karrlab.org/press">Press</a></dd>
                                <dd><a href="https://www.karrlab.org/funding">Funding</a></dd>
                                <dd><a href="https://www.karrlab.org/people">People</a></dd>
                                <dd><a href="https://www.karrlab.org/join">Join us</a></dd>
                                <dd><a href="https://www.karrlab.org/contact">Contact</a></dd>
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
                                        <th colspan="13"></th>
                                        <th colspan="2">Downloads</th>
                                        <th colspan="1"></th>
                                        <th colspan="2">Latest commit</th>
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
                                        <th>Issues</th>
                                        <th>Views</th>
                                        <th>Clones</th>
                                        <th>GitHub</th>
                                        <th>Dist</th>
                                        <th>Forks</th>
                                        <th>Author</th>
                                        <th>Date</th>
                                        <th>Contributors</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php

error_reporting(E_ERROR);
ini_set('display_errors', 1);

require 'functions.php';

$types = get_package_types();
$pkg_configs = get_packages();

foreach ($types as $type) {
    echo "<tr class='margin'><th colspan='19'></th></tr>\n";
    echo "<tr class='type'><th colspan='19'>$type</th></tr>\n";

    $pkg_ids = array_keys($pkg_configs[$type]);
    sort($pkg_ids, SORT_NATURAL | SORT_FLAG_CASE);

    foreach ($pkg_ids as $pkg_id) {
        $pkg = $pkg_configs[$type][$pkg_id];
        $source = get_source_github($pkg->id, $cache);

        if ($pkg->build && $pkg->build->circleci) {
          $latest_build = get_latest_build_circleci($pkg->id, $cache)[0];
          $artifacts = get_artifacts_circleci($pkg->id, $latest_build->build_num, $cache);
        } else {
          $latest_build = NULL;
          $artifacts = array();
        }

        #start row
        if ($pkg->build && $pkg->build->circleci && $latest_build->status != 'fixed' && $latest_build->status != 'success')
            echo "<tr class='alert'>";
        else
            echo "<tr>";

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
          $dist_pkg_id = (property_exists($pkg->distribution, 'package') ? $pkg->distribution->package : $pkg->id);
          switch ($pkg->distribution->repo) {
              case 'pypi':
                $distribution = get_latest_distribution_pypi($dist_pkg_id, $cache);
                echo sprintf("<a href='https://pypi.python.org/pypi/%s'>%s</a>", $dist_pkg_id, $distribution->info->version);
                break;
              case 'ctan':
                $distribution = get_latest_distribution_ctan($dist_pkg_id, $cache);
                echo sprintf("<a href='https://www.ctan.org/pkg/%s'>%s</a>", $dist_pkg_id, $distribution->version->number);
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
            $docs_url = "view_docs.php?package=".$pkg->id;
        } elseif ($pkg->docs && $pkg->docs->url) {
            $docs_url = "view_docs.php?package=".$pkg->id;
        } elseif ($artifacts['docs']) {
            $docs_url = "view_docs.php?package=".$pkg->id;
        } else {
            $docs_url = NULL;
        }
        if ($docs_url)
            echo "<a href='$docs_url'>Latest</a>";
        echo "</td>\n";

        #build
        echo "<td>";
        if ($pkg->build && $pkg->build->circleci)
            echo sprintf("<a href='https://circleci.com/gh/KarrLab/%s'>%s</a>",
              $pkg->id, ucfirst($latest_build->status));
        echo "</td>\n";

        #tests results
        echo "<td>";
        if ($pkg->test_results)
            echo sprintf("<a href='https://tests.karrlab.org/KarrLab/%s'>Results</a>", $pkg->id);
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
              $gpa = '';
            } else {
              $url = sprintf('https://codeclimate.com/repos/%s', $pkg->code_analysis->code_climate->token);
              $analysis = get_analysis_codeclimate($pkg->code_analysis->code_climate->token, $cache);
              $gpa = $analysis->last_snapshot->gpa;
            }
            echo sprintf("<a href='%s'>%s</a>", $url, $gpa);
        }
        echo "</td>\n";
        
        #issues
        echo sprintf("<td><a href='https://github.com/KarrLab/%s/issues' class='%s'>%d</a> / <a href='https://github.com/KarrLab/%s/issues?q='>%d</a></td>\n",
          $pkg->id, $source['issues']['needs-work'] > 0 ? 'alert' : '', $source['issues']['needs-work'],
          $pkg->id, $source['issues']['total']
          );

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
          
        #latest commit
        echo sprintf("<td><a href='https://github.com/%s'>%s</a></td>\n", 
            $source['latest_commit']['author_login'], $source['latest_commit']['author_name']);
        echo sprintf("<td><a href='https://github.com/KarrLab/%s/tree/%s'>%s</a></td>\n", 
            $pkg->id, $source['latest_commit']['sha'],
            strftime('%Y-%m-%d %H:%M', $source['latest_commit']['date']));
        
        #contributors
        echo sprintf("<td>%d</td>\n", $source['num_contributors']);

        #end row
        echo "</tr>\n";
        echo "<tr>\n";
        echo sprintf("<td colspan='19'>%s</td>\n", $pkg->description);
        echo "</tr>\n";
    }
}

$cache->commit();
?>
                                </tbody>
                            </table>

                        <!-- common footer -->
                        </div>
                    </div>

                    <!-- bottom bar -->
                    <div class="row bottom-bar">
                        <div class="logo">
                            <a href="https://www.mssm.edu"><img src="https://www.karrlab.org/static/img/logo-mssm-32x32.png" /></a>
                        </div>

                        <div class="text-left">
                            <a href="https://icahn.mssm.edu/departments-and-institutes/genomics">Icahn Institute for Genomics &amp; Multiscale Biology</a><br/>
                            <a href="https://icahn.mssm.edu/departments-and-institutes/genomics">Department of Genetics &amp; Genomic Sciences</a><br/>
                            <a href="https://www.mssm.edu">Icahn School of Medicine at Mount Sinai</a>
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

        <script src="https://www.karrlab.org/static/js/vendor/jquery.js"></script>
        <script src="https://www.karrlab.org/static/js/foundation.min.js"></script>
        <script>
        $(document).foundation();
        </script>
    </body>
</html>
