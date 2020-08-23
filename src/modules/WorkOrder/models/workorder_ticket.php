<?php
class workorder_ticket extends MPModel {
    public $tableName        = "workorder_ticket";
    public $coreauth_user    = "VARCHAR(255)";
    public $priority         = "VARCHAR(255)";
    public $site             = "VARCHAR(255)";
    public $room             = "VARCHAR(255)";
    public $ticketTitle      = "VARCHAR(255)";
    public $ticketBody       = "VARCHAR(255)";
    public $attachedTo       = "0"; //"VARCHAR(255)";

    public function GetUser() {

        $userProfile = coreauth_userprofile::GetWhere(["emailAddress" => $this->coreauth_user]);

        if(is_object($userProfile)) {
            return $userProfile->User();
        } else {
            return false;
        }
    }

    public function GetSite() {
        return om_Org::GetWhere(["id" => $this->site]);
    }
}