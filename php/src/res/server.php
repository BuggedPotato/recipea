<?php
define('CHUNK_SIZE', 1048576);

function getResource($filename=''){
    $link_array = explode('/',$filename);
    $filename = __DIR__ . '/' . end($link_array); // last segment of url

    if(!$filename || !($fd = fopen($filename, 'rb'))){
        header('Status: 404');
        return;
    }
    ob_start();
    ob_clean();
    // header('Content-Type:' . filetype($filename));
    while(!feof($fd)){
        echo fread($fd, CHUNK_SIZE);
        ob_flush();
    }
    fclose($fd);
}
