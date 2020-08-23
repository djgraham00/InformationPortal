<?php

class CMS extends MPModule {

    public $rts = [
        "/CMSAdmin"     => [
            "path"      => "/CMSAdmin",
            "component" => "WebsiteAdmin"
        ],
        "/CMSViewPages" => [
            "path"      => "/CMSViewPages",
            "component" => "WAViewPages"
        ],
        "/CMSEditPage"  => [
            "path"      => "/CMSEditPage",
            "component" => "WAEditPage"
        ]
    ];

    protected function init() {
        $AdminPanel = $this->Parent->Modules['_AdminPanel'];
        $AdminPanel->registerPage("Website Admin", "./CMSAdmin");
    }

    public function __initModels() {

        cms_page::init();

    }

}