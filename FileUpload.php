<?php

if(!class_exists("Allmedia\Shared\FileUpload\UploadAWS")) {
    require_once __DIR__ . "/vendor/autoload.php";
}

class FileUpload {

    public static function aws() {
        $config = [
            'region' => "ap-southeast-1",
            'bucket' => "allmediaindo-2",
            'folder' => "ibftrader",
        ];

        $fileUpload = new Allmedia\Shared\FileUpload\UploadAWS($config);
        return $fileUpload; 
    }
    
}