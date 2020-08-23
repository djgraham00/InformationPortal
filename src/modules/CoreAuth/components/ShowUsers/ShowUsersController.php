<?php

class ShowUsersController extends MPComponent {

    public $users;

    public function __GET($params)
    {
        $this->template = "showUsers.twig";
        $this->users = coreauth_USER::GetAll();


        $query = $params['query'];
        $pg = $params['pg'];

        $no_of_records_per_page = 8;
        $offset = ($pg-1) * $no_of_records_per_page;



        if($query != "all") {

            $this->users = MPDatabaseHandler::getObjects(coreauth_USER::Reference(), [], ["WHERE (CWID LIKE '%{$query}%' OR siteCode LIKE '%{$query}%' OR gradeLvl LIKE '%{$query}%' OR firstName LIKE '%{$query}%'  OR lastName LIKE '%{$query}%'  OR username LIKE '%{$query}%'  OR emailAddress LIKE '%{$query}%')  LIMIT $offset, $no_of_records_per_page\""]);

            $total_pages_sql = "SELECT COUNT(*) FROM coreauth_users  WHERE (CWID LIKE '%{$query}%' OR siteCode LIKE '%{$query}%' OR gradeLvl LIKE '%{$query}%' OR firstName LIKE '%{$query}%'  OR lastName LIKE '%{$query}%'  OR username LIKE '%{$query}%'  OR emailAddress LIKE '%{$query}%')";
        }
        else {
            $sql = "SELECT * FROM coreauth_users LIMIT $offset, $no_of_records_per_page";
            $total_pages_sql = "SELECT COUNT(*) FROM coreauth_users";
        }

        $result = $this->ModularPHP->MYSQL->query($total_pages_sql);
        $total_rows = $result->fetch_array()[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);



        $this->__render();
    }

    public function __POST($params)
    {
        /*
         * Implement features for when a POST request is sent
         */
    }

}