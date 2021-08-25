<?php

namespace App\Console;

class Files{

    public static function deleteFolder($src){
        $files = self::getAllFiles($src);

        foreach($files as $file){

            if(is_dir($file)){
                self::deleteFolder($file);
                if(self::dirIsEmpty($file)){
                    rmdir($file);
                }
            }
            else if (is_file($file)){
                unlink($file);
            }
        }
    }

    public static function createFolder($path){
        if(!is_dir($path)){
            mkdir($path);
        }
    }

    public static function copyFolder($src,$dst){
        // open the source directory
        $dir = opendir($src);

        // Make the destination directory if not exist
        self::createFolder($dst);

        // Loop through the files in source directory
        while( $file = readdir($dir) ) {

            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ){
                    // Recursively calling custom copy function
                    // for sub directory
                    self::copyFolder($src . '/' . $file, $dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }

        closedir($dir);
    }

    protected static function getAllFiles($src){
        return glob($src . '{,.}[!.,!..]*',GLOB_MARK|GLOB_BRACE);
    }

    protected static function dirIsEmpty($dir) :bool{
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
            closedir($handle);
            return false;
            }
        }
        closedir($handle);
        return true;
    }
}
