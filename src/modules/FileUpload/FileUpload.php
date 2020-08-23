<?php

class FileUpload extends MPModule {

    public $rts = [
        "/upload" => [
                        "path" => "/upload",
                        "component" => "UploadFile"
                     ]
    ];

    public function __initmodels() {

    }
}