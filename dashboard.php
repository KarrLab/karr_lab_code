<!doctype html>
<!-- Cast to TV with
- Dashcast (http://stestagg.github.io/dashcast/)
- Web2cast Android app (https://play.google.com/store/apps/details?id=com.rabidgremlin.web2cast&hl=en)

Formatted for 720p for Chromecast (limited to 720p)
-->
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

        <title>Karr Lab dashboard</title>

        <link rel="icon" type="image/x-icon" href="http://www.karrlab.org/static/img/logo-mssm-16x16.ico" />
        <link rel="stylesheet" type="text/css" href="dashboard.css">

        <meta http-equiv="refresh" content="300">
    </head>
    <body>
        <div class="title-bar">Karr Lab code</div>
        <div class="row">

<?php

require 'functions.php';

$types = get_package_types();
$pkg_configs = get_packages();

$types_1 = array(
    'Cell models',
    'Cell modeling and simulation tools',
    'Modeling and simulation tools',
    'Software development tools'
    );
$types_2 = array(
    'Other scientific and software tools',
    'Karr Lab utilities',
    'Training materials',
    'Code used for papers',
    'Other'
    );

print_table($types_1, $pkg_configs, $cache);
print_table($types_2, $pkg_configs, $cache);

function print_table($types, $pkg_configs, $cache) {
    echo "<div class='column'>\n";
    echo "<div class='inner'>\n";
    echo "<table cellpadding=0 cellspacing=0>\n";
    echo "    <thead>\n";
    echo "        <tr class='margin'><th colspan='9'></th></tr>\n";
    echo "        <tr>\n";
    echo "            <th>Package</th>\n";
	echo "            <th>Update</th>\n";
    echo "            <th colspan='3' class='status-title'>Test results</th>\n";
    echo "            <th colspan='2' class='status-title'>Test coverage</th>\n";
    echo "            <th class='issues'>Issues</th>\n";
    echo "        </tr>\n";
    echo "    </thead>\n";

    foreach ($types as $type) {
        echo "<tbody>\n";
        echo "<tr class='margin'><th colspan='9'></th></tr>\n";
        echo "<tr class='type'><th colspan='9'>$type</th></tr>\n";

        $pkg_ids = array_keys($pkg_configs[$type]);
        sort($pkg_ids, SORT_NATURAL | SORT_FLAG_CASE);

        foreach ($pkg_ids as $pkg_id) {
            $pkg = $pkg_configs[$type][$pkg_id];

            #start row
            if ($pkg->test_results && $pkg->build && $pkg->build->circleci) {
                $latest_build = get_latest_build_circleci($pkg_id, $cache)[0];
                $tests = get_tests_circleci($pkg_id, $latest_build->build_num, $cache);
                if ($latest_build->status != 'fixed' &&
                    $latest_build->status != 'success') {
                    $status = 'alert';
                } else {
                    $status = '';
                }
            } else {
                $status = '';
            }
            echo "<tr class='$status'>\n";

            #name
            if (strlen($pkg_id) <= 12) {
                $name = $pkg_id;
            } else {
                $name = substr($pkg_id, 0, 9)."&#8230;";
            }
            echo sprintf("<td><a href='https://github.com/KarrLab/%s'>%s</a></td>\n", $pkg_id, $name);
			
			#time of last commit
            $github_info = get_source_github($pkg_id, $cache, false, true, false, false, false, false, true);
            
            $diff = time() - $github_info['latest_commit']['date'];
            $years = floor($diff / (365 * 24 * 60 * 60));
            $diff = $diff % (365 * 24 * 60 * 60);
            $weeks = floor($diff / (7 * 24 * 60 * 60));
            $diff = $diff % (7 * 24 * 60 * 60);
            $days = floor($diff / (24 * 60 * 60));
            $diff = $diff % (24 * 60 * 60);
            $hours = floor($diff / (60 * 60));
            $diff = $diff % (60 * 60);
            $minutes = floor($diff / 60);
            
            $diff = '';
            if ($years > 0)
                $diff .= sprintf('%dy ', $years);
            if ($weeks > 0)
                $diff .= sprintf('%dw ', $weeks);
            if ($days > 0)
                $diff .= sprintf('%dd ', $days);
            if ($hours > 0)
                $diff .= sprintf('%dh ', $hours);
            if ($minutes > 0)
                $diff .= sprintf('%dm', $minutes);
			echo sprintf("<td class='latest-commit'><a href='https://github.com/KarrLab/%s/tree/%s'>%s</a></td>", 
				$pkg_id, $github_info['latest_commit']['sha'], $diff);
            
            #tests results
            if ($pkg->test_results && $pkg->build && $pkg->build->circleci) {
                if ($latest_build->status != 'fixed' &&
                    $latest_build->status != 'success') {
                    $status = 'alert';
                } else {
                    $status = '';
                }

                echo sprintf("<td class='status-bar'>\n");
                echo sprintf("  <a href='http://tests.karrlab.org/KarrLab/%s'>\n", $pkg_id);
                echo sprintf("    <div class='container alert-fill' title='Failed'>\n");
                if ($tests['total'] > 0) {
                    echo sprintf("<div class='bar' style='width:%.0f%%' title='Passed'></div>\n", $tests['passes'] / $tests['total']  * 100);
                    echo sprintf("<div class='bar warn' style='width:%.0f%%' title='Skipped'></div>\n", $tests['skips'] / $tests['total'] * 100);
                    echo sprintf("<div style='clear: both;'></div>\n");
                }
                echo sprintf("    </div>\n");
                echo sprintf("  </a>\n");
                echo sprintf("</td>\n");
                echo sprintf("<td class='status-percent'><a href='http://tests.karrlab.org/KarrLab/%s'>%.0f%%</a></td>\n",
                    $pkg_id, $percent);
                echo sprintf("<td class='status-number'><a href='http://tests.karrlab.org/KarrLab/%s'>of %d</a></td>\n",
                    $pkg_id, $tests['total']);
            } else {
                echo "<td class='status-bar'></td>\n";
                echo "<td class='status-percent'></td>\n";
                echo "<td class='status-number'></td>\n";
            }

            #coverage
            if ($pkg->test_coverage && $pkg->test_coverage->coveralls) {
                $coverage = get_coverage_coveralls($pkg_id, $pkg->test_coverage->coveralls->token, $cache);

                $percent = $coverage->covered_percent;
                if ($percent < 70) {
                    $status = 'alert';
                } elseif ($percent < 90) {
                    $status = 'warn';
                } else {
                    $status = '';
                }

                echo sprintf("<td class='status-bar'>\n");
                echo sprintf("  <a href='https://coveralls.io/github/KarrLab/%s'>\n", $pkg_id);
                echo sprintf("    <div class='container'>\n");
                echo sprintf("      <div class='bar %s' style='width:%.0f%%' title='Covered'></div>\n", $status, $percent);
                echo sprintf("      <div style='clear: both;'></div>\n");
                echo sprintf("    </div>\n");
                echo sprintf("  </a>\n");
                echo sprintf("</td>\n");
                echo sprintf("<td class='status-percent'><a href='https://coveralls.io/github/KarrLab/%s'>%.0f%%</a></td>\n",
                    $pkg_id, $percent);
            } else {
                echo "<td class='status-bar'></td>\n";
                echo "<td class='status-percent'></td>\n";
            }
            
            # issues
            $issues = $github_info['issues'];
            echo sprintf("<td class='issues'><a href='https://github.com/KarrLab/%s/issues' class='%s'>%d</a> / <a href='https://github.com/KarrLab/%s/issues?q='>%d</a></td>\n", 
                $pkg_id, $issues['needs-work'] > 0 ? 'alert' : '', $issues['needs-work'], 
                $pkg_id, $issues['total']);

            #end row
            echo "</tr>\n";
        }

        echo "</tbody>\n";
    }

    echo "</table>\n";
    echo "</div>\n";
    echo "</div>\n";
}

$cache->commit();
?>
        <div style="clear: both;">
        </div>
    </body>
</html>
