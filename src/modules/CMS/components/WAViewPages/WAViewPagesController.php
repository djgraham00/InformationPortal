<?php

class WAViewPagesController extends MPComponent {

    public function __GET($params)
    {
        $this->template = 'ViewPages.twig';
        $this->pages = cms_page::GetAll();
        $this->__render();
    }
}