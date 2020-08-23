<?php

class AdminPanel extends MPModule {

    /*
    * ROUTE DEFINITIONS
    */
    public $rts = array(
        "/APHome" => array(
            "path" => "/APHome",
            "component" => "APHome"
        ),
        "/APHOME" => array(
            "path" => "/APHOME",
            "redirect" => "./APHome"
        )
    );
    public $registeredPages = array();

    protected function init()
    {
        $this->registerPage("Home", "./APHome");
    }

    public function registerPage($display, $route, $roles = array(), $pos = null) {
        $page = array("displayName" => $display, "route" => $route, "roles" => $roles);

        if(!isset($pos)) {
            array_push($this->registeredPages, $page);
        } else {
            $this->array_insert($this->registeredPages, $pos, array($page));
        }
    }

    //Function by: Halil Özgür on StackOverflow
    function array_insert(&$array, $position, $insert)
    {
        if (is_int($position)) {
            array_splice($array, $position, 0, $insert);
        } else {
            $pos   = array_search($position, array_keys($array));
            $array = array_merge(
                array_slice($array, 0, $pos),
                $insert,
                array_slice($array, $pos)
            );
        }
    }

    public function getPages() {
        $pages = array();

        foreach ($this->registeredPages as $page) {
            $hasRole = false;
            foreach ($page['roles'] as $role) {
                if ($this->Parent->Modules['_CoreAuth']->hasRole($role)) {
                    $hasRole = true;
                }
            }

            if($hasRole || $page["roles"] == array()) {
                array_push($pages, $page);
            }
        }

        return $pages;
    }

    public function APHEADER() {
       include($this->Parent->MOD_DIR . "/AdminPanel/templates/header.blk.php");
    }

}