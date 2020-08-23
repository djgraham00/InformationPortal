<?php

class CreateTicketExternalController extends MPComponent {

    public function __GET($params)
    {
        $this->Sites = om_Org::GetAll();
        $this->template = "CreateTicketForm.twig";
        $this->__render();
    }

    public function __POST($params)
    {
        header("Content-Type: application/json");
        $err = false;



        /*$userFound = coreauth_userprofile::GetWhere(["emailAddress" => $params["email"]]);

        if(is_object($userFound)) {
            $user = $userFound->User();
        }
        else {
            $user = new coreauth_USER();
        }

        if(!$user) {
            $user = coreauth_USER::GetWhereID(826);
        } */

        $user = true;

        if($user) {
            $ticket = new workorder_ticket();
            $ticket->coreauth_user = $params['email'];
            $ticket->site = $params['org'];
            $ticket->priority = $params['priority'];
            $ticket->ticketBody = $params['body'];
            $ticket->ticketTitle = $params['title'];

            /* if (isset($params['attachment'])) {

            } else {

            } */


            if($ticket->save()) {
                $err = false;
            } else {
                $err = true;
            }
        } else {
            $err = true;
        }

        if($err) {
            echo '{ "success" : false }';
        } else {

            $body = "
                    <html>
                        <style>
                            body {
                                font-family: sans-serif;
                            }
                        </style>
                        <img src=\"https://it.p-t.k12.ok.us/portal-v2/static/img/pthorizontal.png\" height=\"100\">
                        <p>Your new IT Support Ticket titled \"{$params['title']}\" has been created.</p>
                    </html>
                    ";

            //$this->_WorkOrder->sendEmail($params["email"], "New Support Ticket Created", $body);

            echo '{ "success" : true }';
        }
    }




    /**
     * Check if a given ip is in a network
     * @param  string $ip    IP to check in IPV4 format eg. 127.0.0.1
     * @param  string $range IP/CIDR netmask eg. 127.0.0.0/24, also 127.0.0.1 is accepted and /32 assumed
     * @return boolean true if the ip is in this range / false if not.
     */
    private function ip_in_range( $ip, $range ) {
        if ( strpos( $range, '/' ) == false ) {
            $range .= '/32';
        }
        // $range is in IP/CIDR format eg 127.0.0.1/24
        list( $range, $netmask ) = explode( '/', $range, 2 );
        $range_decimal = ip2long( $range );
        $ip_decimal = ip2long( $ip );
        $wildcard_decimal = pow( 2, ( 32 - $netmask ) ) - 1;
        $netmask_decimal = ~ $wildcard_decimal;
        return ( ( $ip_decimal & $netmask_decimal ) == ( $range_decimal & $netmask_decimal ) );
    }

}