<?php

/* Downloads a stored file

Author: Jonathan Karr <jonrkarr@gmail.com>
Date: 2017-05-03
Copyright: 2017, Karr Lab
License: MIT
*/

$token = rtrim(file_get_contents('../tokens/CODE_SERVER_TOKEN'));

if ($_GET['token'] != $token) {
    http_response_code(403);
    die();
}
    
$filename = $_GET['filename'];
if (!file_exists($filename)) {
    http_response_code(404);
    die();
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename='$filename'");
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: '.filesize($filename));
readfile($filename);

?>