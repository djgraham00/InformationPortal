<?php

class cms_navlink extends MPModel {
    public $tableName = "cms_navlink";
    public $navId     = "VARCHAR(255)";
    public $parentId  = "VARCHAR(255)";
    public $linkTitle = "VARCHAR(255)";
    public $linkHref  = "VARCHAR(255)";
}