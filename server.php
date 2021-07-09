<?php

/*require __DIR__.'/vendor/autoload.php';*/
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

/*$request_uri = $_SERVER['REQUEST_URI'];
$accept = $_SERVER['HTTP_ACCEPT'];

//get first "folder" of uri
$explode = explode('/',$request_uri);
$folder = $explode[1];
//dont apply changes for those folders
if($folder !== 'uploads' && $folder !== 'api' && $folder !== 'download'){
    //build the new uri
    $request_uri = '/export';

    foreach($explode as $key => $value){
        if(strlen($value) === 0) continue;

        $request_uri = $request_uri.'/'.$value;
    }

    if(strpos($request_uri,'.') === false && str_contains($accept,'text/html')){
        $request_uri = $request_uri.'/index.html';
    }
}
//set new uri
$_SERVER['REQUEST_URI'] = $request_uri;*/

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
$path = __DIR__.'/public'.$uri;

if ($uri !== '/' && file_exists($path)) {
    //return our file
    /*$mimes = new Mimey\MimeTypes();

    $fileExtension = explode('.',$path);

    $data = file_get_contents($path);
    $size = strlen($data);
    $mime = 'application/octet-stream';

    if($fileExtension[1] != null){
        $fileExtension = $fileExtension[1];
        error_log("fileExtendsion $fileExtension path: $path");
        $mime = $mimes->getMimeType($fileExtension);
        error_log("mime $mime");
    }

    header("Content-Length: $size");
    header("Content-Type: $mime");
    echo $data;
    return;*/
    return false;    
}

require_once __DIR__.'/public/index.php';
