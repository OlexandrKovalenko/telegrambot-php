<?php


namespace App\Services;


class FileStorageService
{
    static function findImg($name)
    {
        $folderName = 'storage/img/';
        $fileName   = $name;

        return self::search_file( $folderName, $fileName );
    }

    static function deleteImg($file)
    {
        return unlink($file);
    }

    private static function search_file( $folderName, $fileName ){
        $found = array();
        $folderName = rtrim( $folderName, '/' );

        $dir = opendir( $folderName );

        while( ($file = readdir($dir)) !== false ){
            $file_path = "$folderName/$file";

            if( $file == '.' || $file == '..' ) continue;

            if( is_file($file_path) ){
                if( false !== strpos($file, $fileName) ) $found[] = $file_path;
            }
            elseif( is_dir($file_path) ){
                $res = self::search_file( $file_path, $fileName );
                $found = array_merge( $found, $res );
            }

        }

        closedir($dir);

        return $found;
    }
}