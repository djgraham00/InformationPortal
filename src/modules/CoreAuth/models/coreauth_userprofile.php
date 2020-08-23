<?php
class coreauth_userprofile extends MPModel {

    public $tableName = "ca_profile";
    public $room         = "VARCHAR(255)";
    public $CWID         = "VARCHAR(255)";
    public $siteCode     = "VARCHAR(255)";
    public $emailAddress = "VARCHAR(255)";
    public $userType     = "varchar(255)";
    public $gradeLvl     = "INT(11)";
    public $userID       = "INT(11)";

    public function User() {
        return coreauth_USER::GetWhereID($this->userID);
    }
}