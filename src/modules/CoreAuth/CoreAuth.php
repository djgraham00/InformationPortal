<?php

class CoreAuth extends MPModule {

    public $rts = array(
        "/" => array(
            "path" => "/",
            "redirect" => "./Login"
        ),
        "/Login" => array(
            "path" => "/Login",
            "component" => "Login"
            /* "redirect" => "../portal/login" */
        ),
        "/Register" => array(
            "path" => "/Register",
            "component" => "CreateAccount"
        ),
        "/CoreAuthHome" => array(
            "path" => "/CoreAuthHome",
            "component" => "CoreAuthHome"
        ),
        "/Logout" => array(
            "path" => "/Logout",
            "component" => "Logout"
        ),
        "/CoreAuthAPI" => array(
            "path" => "/CoreAuthAPI",
            "component" => "CoreAuthAPI"
        ),
        /* "/UserManagement" => [
            "path" => "/UserManagement",
            "component" => "ShowUsers"
        ] */
        "/AddUser" => [
            "path" => "/AddUser",
            "component" => "AddUser"
        ]
    );

    public $enableLoginRedir = true;

    public $currentUser;

    protected function init()
    {
        if($this->checkAuth()) {
            $this->currentUser = $this->getCurrentUser();
        } else {
            $this->currentUser = null;
        }
     }

    public function getPassword($username) {

       $obj = $this->Parent->getObject(new coreauth_USER(), array("username" => $username));

       if($obj){
           return $obj->password;
       }
       else{
           return false;
       }

    }

   public function getUsername($param)
    {

        $obj = $this->Parent->getObject(new coreauth_USER(), array("username"=> $param));

        if($obj){
            return $obj->username;
        }
        else{
            return false;
        }


    }

    public function getUser($username)
    {

        $obj = $this->Parent->getObject(new coreauth_USER(), array("username" => $username));

        if($obj){
            return $obj;
        }
        else{
            return false;
        }

    }
    public function getUserByID($id)
    {

        $obj = $this->Parent->getObject(new coreauth_USER(), array("id" => $id));

        if($obj){
            return $obj;
        }
        else{
            return false;
        }

    }
    public function getCurrentUser()
    {
        $userID = $this->getCurrentUserFromSessionID();

        $obj = $this->Parent->getObject(new coreauth_USER(), array("id" => $userID));

        if($obj){
            return $obj;
        }
        else{
            return false;
        }
    }

    /*
       Authentication without LDAP

    public function auth($username, $password){

        if (password_verify($password, $this->getPassword($username))) {
            $this->createSession($this->getUser($username)->id);
            return true;
        } else {
            return false;
        }

    } */


    public function auth($username, $password){


        if(!in_array($username, $this->Config->AuthorizedUsers)) {
            return false;
        }

        if($this->Config->UseLDAP == false) {
            if (password_verify($password, $this->getPassword($username))) {
                $this->createSession($this->getUser($username)->id);
                return true;
            } else {
                return false;
            }
        }
        else if($this->Config->UseLDAP == true) {


            $adServer = "ldap://".$this->Config->LDAP_Server;

            $ldap = ldap_connect($adServer);




            if (strpos($username, '@') !== false) {
                $ldaprdn = $username; //$this->Config->AD_Domain . "\\" . $username;
                $searchParam = "userPrincipalName";
            }else {
                $ldaprdn = $this->Config->AD_Domain . "\\" . $username;
                $searchParam = "sAMAccountName";
            }


            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

            $bind = @ldap_bind($ldap, $ldaprdn, $password);

            if ($bind) {
                $filter="($searchParam=$username)";
                $result = ldap_search($ldap,$this->Config->Base_DN,$filter);
                ldap_sort($ldap,$result,"sn");
                $info = ldap_get_entries($ldap, $result);
                for ($i=0; $i<$info["count"]; $i++)
                {
                    if($info['count'] > 1)
                        break;
                    $CWID = $info[$i]["sisid"][0];


                    $userID = $this->getUserIDFromCWID($CWID);

                    if($userID != false) {
                        $this->createSession($userID->id);
                        return true;
                    }
                    else {
                        $newUsr  = new coreauth_USER();
                        $profile = new coreauth_userprofile();

                        $newUsr->firstName = $info[$i]["givenname"][0];
                        $newUsr->lastName = $info[$i]["sn"][0];
                        $profile->CWID = $CWID;
                        $profile->siteCode = $info[$i]["department"][0];
                        $newUsr->username = $info[$i]["samaccountname"][0];
                        $newUsr->password = "USE_LDAP";

                        //$ou = ldap_explode_dn($output[$i], 0);

                        $profile->gradeLvl = intval($info[$i]["physicaldeliveryofficename"][0]);


                        $profile->emailAddress = $info[$i]["mail"][0];


                        $newUsr->save();

                        $profile->userID = coreauth_USER::GetWhere(["username" => $newUsr->username])->id;
                        $profile->save();

                        $userID = $this->getUserIDFromCWID($CWID);

                        //$baseRole = $info[$i]["title"][0];



                        /* if($baseRole == "Teacher") {
                            $this->addRole("02", $CWID);
                        }
                        else if($baseRole == "Student") {
                            $this->addRole("04", $CWID);
                        } */



                        if($userID != false) {
                            $this->createSession($userID->id);
                            return true;
                        }

                        return false;
                    }
                }
                @ldap_close($ldap);
            } else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public function getUserIDFromCWID($cwid) {
        if($p = coreauth_userprofile::GetWhere(["CWID" => $cwid])) {
            return $p->User();
        } else {
            return false;
        }
    }

    public function deAuth(){
        $sessID = $_COOKIE['session'];

        setcookie( "session", "NULL", strtotime( '+30 days' ), '/');

        if($this->destroySession($sessID)){
            return true;
        }
        else{
            return false;
        }
    }

    public function checkAuth(){

        if(!isset($_COOKIE['session'])){
            return false;
        }
        else if(!$this->validateSession($_COOKIE['session'])){
            return false;
        }
        else{
            return true;
        }

    }

    /*
        Session Management
    */

    public function validateSession($id){

        $obj = $this->Parent->getObject(new coreauth_SESSION(), array("sessionID" => $id));

        if(is_object($obj)){

            if($obj->ipAddress != $_SERVER["REMOTE_ADDR"]) {
                $this->destroySession($_COOKIE['session']);
                return false;
            }

            /*if(strtotime('+1 day', $obj->date) > $obj->date) {
                $this->destroySession($_COOKIE['session']);
                return false;
            }*/

            return true;
        }
        else{
            return false;
        }
    }

    public function destroySession($id){

        $obj = $this->Parent->conditionalDeleteRow(new coreauth_SESSION(), "sessionID", $id);

        if($obj){
            unset($_COOKIE['session']);
            return true;
        }
        else{
            return false;
        }
    }

    public function createSession($userID){

        $sessID = md5(time()*rand(10, 10000));

        $newSession = new coreauth_SESSION();
        $newSession->userID    = $userID;
        $newSession->sessionID = $sessID;
        $newSession->ipAddress = $_SERVER['REMOTE_ADDR'];
        $newSession->date      = time();

        $newSession->save();

        setcookie( "session", $sessID, strtotime( '+30 days' ), '/');



    }

    public function getCurrentUserFromSessionID(){

        if(isset($_COOKIE['session'])){
            $sessID = $_COOKIE['session'];
        }
        else{
            return false;
        }

        $obj = $this->Parent->getObject(new coreauth_SESSION(), array("sessionID" => $sessID));

        if($obj){
            return $obj->userID;
        }
        else{
            return false;
        }
    }


    public function requireAuth(){
        if(!$this->checkAuth()){
            header("Location:".$this->Parent->APP_BASE_URL);
          }
    }

    public function loginRedir() {
        if($this->checkAuth()) {
            header("Location: " . $this->Config->APP_HOME_URL);
        }
     }



    public function __initModels() {
        $this->Parent->createTable(new coreauth_USER());
        $this->Parent->createTable(new coreauth_SESSION());
        $this->Parent->createTable(new coreauth_userprofile());
    }

}