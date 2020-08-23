<?php

class coreauth_USER extends MPModel {

    public $tableName    = "ca_users";
    public $firstName    = "varchar(255) NOT NULL";
    public $lastName     = "varchar(255) NOT NULL";
    public $username     = "varchar(255) NOT NULL";
    public $password     = "varchar(255) NOT NULL";



    public function isStudent() {
        if(wengage_Student::GetWhere(["StudentUid" => $this->Profile()->CWID])) {
            return true;
        } else {
            return false;
        }
    }

    public function Student () {

        if($this->isStudent()) {
             return wengage_Student::GetWhere(["StudentUid" => $this->Profile()->CWID]);
        } else {
            return false;
        }

    }

    public function fullName(){
        return $this->firstName." ".$this->lastName;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function Profile() {
        $profile = coreauth_userprofile::GetWhere(["userID" => $this->id]);

        if(is_object($profile)) {
            return $profile;
        } else {
            return new coreauth_userprofile();
        }
    }
}
