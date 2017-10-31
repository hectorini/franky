<?php
$list_of_files = array(
    'librerias/vendor/modernizr-2.8.3.min.js',
    'librerias/vendor/jquery-3.2.1.min.js'
);

$max_ftime = 0;
$file_salt = 'v1.0.5';
$file_size = 0;

for ($i=0,$n=sizeof($list_of_files);$i<$n;$i++) {
    $file_size+= filesize($list_of_files[$i]);
    $file_time = filemtime($list_of_files[$i]);
    if ($max_ftime < $file_time) $max_ftime = $file_time;
}

$file_date = gmdate('D, d M Y H:i:s T', $max_ftime);
$file_hash = md5($file_salt . $file_size . $file_time);

if ((isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) || isset($_SERVER['HTTP_IF_NONE_MATCH']))) {
    if ($_SERVER['HTTP_IF_MODIFIED_SINCE'] == $file_date && $_SERVER['HTTP_IF_NONE_MATCH'] == $file_hash) {
        header('Content-type: text/javascript');
        header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
        die();
    }
}

header('Content-type: text/javascript');
header('Content-Length: ' . $file_size);
header('Last-Modified: ' . $file_date);
header('ETag: ' . $file_hash);
header('Accept-Ranges: none');
header('Cache-Control: max-age=604800, must-revalidate');
header('Expires: ' . gmdate('D, d M Y H:i:s T', strtotime('+7 days')));

for ($i=0;$i<$n;$i++) { readfile($list_of_files[$i]); }
