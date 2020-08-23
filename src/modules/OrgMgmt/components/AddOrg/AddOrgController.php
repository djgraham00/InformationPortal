<?php

class AddOrgController extends MPComponent {

    public $orgs;

    public function __GET($params)
    {
        $this->template = "AddOrg.twig";

        $this->orgs = om_Org::GetAll();

        $this->__render();
    }

    public function __POST($params)
    {
        $newOrg = new om_Org();
        $newOrg->orgDisplay = $params["orgDisplay"];
        $newOrg->orgID = $params["orgID"];

        if($newOrg->save()) {
            echo '{ "success" : true }';

        } else {
            echo '{ "success" : false }';
        }

    }
}