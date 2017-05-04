<?php

/* Uploads a stored file

Author: Jonathan Karr <jonrkarr@gmail.com>
Date: 2017-05-03
Copyright: 2017, Karr Lab
License: MIT
*/

$token = rtrim(file_get_contents('../tokens/CODE_SERVER_TOKEN'));

if ($_POST['token'] != $token) {
    http_response_code(403);
    die();
}
    
if ($_FILES['file']['error'] != 0) {
    http_response_code(400);
    die();
}

if (file_exists($_POST['filename'])) {
    $max_ver = -1;
    foreach (glob($_POST['filename'].'.*') as $filename){
        $ver = array_pop(explode('.', $filename));
        $max_ver = max($max_ver, (int)$ver);
    }
    rename($_POST['filename'], $_POST['filename'].".".($max_ver + 1));
}

if (!move_uploaded_file($_FILES['file']['tmp_name'], $_POST['filename'])) {
    http_response_code(500);
    die();
}

?>