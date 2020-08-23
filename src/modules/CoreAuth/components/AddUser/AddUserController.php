<?php

class AddUserController extends MPComponent {

    public function __GET($params)
    {
        $this->template = "AddUser.twig";
        $this->__render();
    }

    public function __POST($params)
    {
        $newUser = new coreauth_USER();
        $profile = new coreauth_userprofile();

        $newUser->username  = $params['username'];
        $newUser->firstName = $params['fName'];
        $newUser->lastName  = $params['lName'];
        $newUser->password  = "USE_LDAP";

        $newUser->save();

        $profile->userID       = coreauth_USER::GetWhere(["username" => $params['username']])->id;
        $profile->gradeLvl     = "0";
        $profile->userType     = "0";
        $profile->CWID         = "DEPRECATED";
        $profile->emailAddress = $params['email'];
        $profile->siteCode     = $params['site'];
        $profile->room         = $params['rm'];

        $profile->save();

        echo '{ "success" : true }';

    }
}