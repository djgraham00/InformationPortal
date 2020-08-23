<?php

class ManageOrgsController extends MPComponent {
    public $orgs;

    public function __GET($params = array()) {
        $this->template = "ManageOrgs.twig";

        $this->orgs = om_Org::GetAll();

        $this->__render();
    }

    public function __POST($params) {

        MPDatabaseHandler::deleteObject(om_Org::GetWhereID($params['id']));

        header("Location:");

    }
}