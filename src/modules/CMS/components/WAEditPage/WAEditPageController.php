<?php

class WAEditPageController extends MPComponent {

    public function __GET($params)
    {
        $this->template = "EditPage.twig";
        $this->page = cms_page::GetWhereID($params['id']);
        $this->__render();
    }

}