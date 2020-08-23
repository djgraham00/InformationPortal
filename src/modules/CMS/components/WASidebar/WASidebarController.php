<?php

class WASidebarController extends MPComponent {

    public function __GET($params) {
        $this->template = "Sidebar.twig";
        $this->__render();
    }

}