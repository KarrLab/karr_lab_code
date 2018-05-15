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
        <link rel="stylesheet" href="http://www.karrlab.org/static/css/foundation.css" />
        <link rel="stylesheet" href="http://www.karrlab.org/static/css/foundation-icons.css" />
        <link rel="stylesheet" href="http://www.karrlab.org/static/css/extras.css" />
        <script src="http://www.karrlab.org/static/js/vendor/modernizr.js"></script>

        <link rel="icon" type="image/x-icon" href="http://www.karrlab.org/static/img/logo-mssm-16x16.ico" />

        <style>
            table {
                width: 100%;
            }
            tbody tr td{
                font-size: 80%;
                vertical-align: top;
                padding: 0px;
            }
            tbody tr:nth-child(even) {
                background: none;
            }
            tbody tr.package-summary {
                background: #f3f3f3;
            }
            
            tbody tr td:first-child{
                padding-left: 10px;
            }
            tbody tr td:last-child{
                padding-right: 10px;
            }
            .spacing td {
                height:20px;
            }
            .issue-num {
                width: 55px;
                text-align: right;
                padding:0px;
                padding-right: 30px;
            }
            .nowrap {
                white-space: nowrap;
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

                            <table cellpadding=0 cellspacing=0>
                                <thead>
                                    <tr>
                                        <th colspan="2">Package</th>
                                        <th>Bugs</th>
                                        <th>Enhancements</th>
                                        <th>Future features</th>
                                        <th>Wontfix</th>
                                        <th>Other</th>
                                        <th>Closed</th>
                                    </tr>
                                    <tr>
                                        <th class="issue-num">No.</th>
                                        <th colspan="2">Title</th>
                                        <th>Label(s)</th>
                                        <th>Author</th>
                                        <th>Assignee(s)</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                    </tr>
                                </thead>
<?php

error_reporting(E_ERROR);
ini_set('display_errors', 1);

require 'functions.php';

function format_label($pkg_id, $label) {
    return sprintf("<a href=https://github.com/KarrLab/%s/issues?q=is:issue+is:open+label:%s>%s</a>",
        $pkg_id, $label->name, $label->name);
}
function format_assignee($assignee) {
    return sprintf("<a href='https://github.com/%s'>%s</a>", $assignee->login, $assignee->login);
}

$types = get_package_types();
$pkg_configs_by_type = get_packages();

$pkg_configs = array();
foreach (array_keys($pkg_configs_by_type) as $type) {
    foreach ($pkg_configs_by_type[$type] as $pkg_id => $pkg_config) {
        $pkg_configs[$pkg_id] = $pkg_config;
    }
}

$pkg_ids = array_keys($pkg_configs);
sort($pkg_ids, SORT_NATURAL | SORT_FLAG_CASE);
foreach ($pkg_ids as $pkg_id) {
    $source = get_source_github($pkg_id, $cache, false, false, false, false, false, false, true);
    
    $bugs = 0;
    $enhancements = 0;
    $future_features = 0;
    $wontfix = 0;
    $other = 0;
    $closed = 0;
    foreach ($source['issues']['issues'] as $issue) {
        if ($issue->state == 'closed') {
            $closed++;
        } else {
            foreach ($issue->labels as $label) {
                if ($label->name == 'bug')
                    $bugs++;
                elseif ($label->name == 'enhancement')
                    $enhancements++;
                elseif ($label->name == 'future feature')
                    $future_features++;
                elseif ($label->name == 'wontfix')
                    $wontfix++;
                else
                    $other++;
            }
        }
    }
    
    echo "<tbody>\n";
    echo "<tr class='spacing'><td colspan='8'></span></tr>\n";
    
    echo "<tr class='package-summary'>\n";
    echo sprintf("  <th colspan='2'><a href='https://github.com/KarrLab/%s/issues'>%s</a></th>\n",
        $pkg_id, $pkg_id);
    echo sprintf("  <th><a href='https://github.com/KarrLab/%s/issues?q=label:bug'>%d</a></th>\n",
        $pkg_id, $bugs);
    echo sprintf("  <th><a href='https://github.com/KarrLab/%s/issues?q=label:enhancement'>%d</a></th>\n",
        $pkg_id, $enhancements);
    echo sprintf("  <th><a href='https://github.com/KarrLab/%s/issues?q='>%d</a></th>\n",
        $pkg_id, $future_features);
    echo sprintf("  <th><a href='https://github.com/KarrLab/%s/issues?q=label:wontfix'>%d</a></th>\n",
        $pkg_id, $wontfix);
    echo sprintf("  <th><a href='https://github.com/KarrLab/%s/issues?q=is:open'>%d</a></th>\n",
        $pkg_id, $other);
    echo sprintf("  <th><a href='https://github.com/KarrLab/%s/issues?q=is:closed'>%d</a></th>\n",
        $pkg_id, $closed);
    echo "</tr>\n";
    
    foreach ($source['issues']['issues'] as $issue) {
        if ($issue->state != 'closed') {
            echo "<tr>\n";
            echo sprintf("  <td class='issue-num'><a href='https://github.com/KarrLab/%s/issues/%d'>%d</a></td>\n",
                $pkg_id, $issue->number, $issue->number);
            echo sprintf("  <td colspan='2'><a href='https://github.com/KarrLab/%s/issues/%d'>%s</a></td>\n",
                $pkg_id, $issue->number, $issue->title);
            
            $labels = array();
            foreach($issue->labels as $label) {
                array_push($labels, format_label($pkg_id, $label));
            }
            echo sprintf("  <td>%s</td>\n", join(", ", $labels));
            echo sprintf("  <td><a href='https://github.com/%s'>%s</a></td>\n",
                $issue->user->login, $issue->user->login);
            echo sprintf("  <td>%s</td>\n", join(', ', array_map('format_assignee', $issue->assignees)));
            echo sprintf("  <td class='nowrap'>%s</td>\n", strftime('%Y-%m-%d', strtotime($issue->created_at)));
            echo sprintf("  <td class='nowrap'>%s</td>\n", strftime('%Y-%m-%d', strtotime($issue->updated_at)));
            echo "</tr>\n";
        }
    }
    
    echo "</tbody>\n";
}

?>
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
