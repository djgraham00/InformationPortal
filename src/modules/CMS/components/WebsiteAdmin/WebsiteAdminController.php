<?php

class WebsiteAdminController extends MPComponent {

    public function __GET($params)
    {
        $this->template = "admin.twig";
        $this->__render();
    }
}