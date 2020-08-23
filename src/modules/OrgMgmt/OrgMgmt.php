<?php

class OrgMgmt extends MPModule {

    public $rts = array(
        "/ManageOrgs" => array(
            "path" => "/ManageOrgs",
            "component" => "ManageOrgs"
        ),
        "/AddOrg" => array(
            "path" => "/AddOrg",
            "component" => "AddOrg"
        )
    );

    protected function init()
    {
        $this->Parent->Modules['_AdminPanel']->registerPage("Organization Management", "./ManageOrgs");
    }

    public function __initModels() {
        $this->Parent->createTable(new om_Org());
    }
}
