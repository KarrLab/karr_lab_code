<?php

require 'functions.php';

# get package id
$pkg_id = $_GET['package'];

# get metadata for package
$handle = fopen("repo/$pkg_id.json", "r");
$pkg = json_decode(fread($handle, filesize("repo/$pkg_id.json")));
fclose($handle);

# get URL for documentation
$url = NULL;
 if ($pkg->docs && $pkg->docs->readthedocs) {
    $docs_pkg_id = ($pkg->docs->readthedocs->id ? $pkg->docs->readthedocs->id : $pkg->id);
    $url = sprintf('http://%s.readthedocs.org', $docs_pkg_id);
} elseif ($pkg->docs && $pkg->docs->url) {
    $url = $pkg->docs->url;
} elseif ($pkg->build && $pkg->build->circleci) {
    $latest_build = get_latest_build_circleci($pkg->id, $cache)[0];
    $artifacts = get_latest_artifacts_circleci($pkg->id, $latest_build->build_num, $cache);
    if ($artifacts['docs']) {
        $url = $artifacts['docs'];
    }
}

# redirect to URL or return error
if ($url) {
    header('Location: '.$url);
    exit();
} else {
    http_response_code(404);
    echo 'No documentation found for package "$pkg_id"';
    die();
}

?>