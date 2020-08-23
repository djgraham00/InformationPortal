<?php

class APHomeController extends MPComponent {

    public function __GET($params)
    {

        $this->template = "APHome.twig";

        $this->_CoreAuth->requireAuth();


        $this->sites = array(
            "HS"    => "High School",
            "MS"    => "Middle School",
            "INT"   => "Intermediate School",
            "ELEM"  => "Elementary School"
        );



        $this->__render();

    }

    public function __POST($params)
    {

    }


}