<?php

class WOSidebarController extends MPComponent {

    public function __GET($params)
    {
        $this->template = "sidebar.twig";
        $this->sites    = om_Org::GetAll();

        $this->__render();
    }

}