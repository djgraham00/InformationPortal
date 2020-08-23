<?php

class cms_page extends MPModel {
    public $tableName   = "cms_page";
    public $pageTitle   = "VARCHAR(255)";
    public $pageRoute   = "VARCHAR(255)";
    public $pageContent = "TEXT";
}