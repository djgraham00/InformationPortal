<?php
class CreateTicketController extends MPComponent {

    public function __GET($params) {

        $this->sites = om_Org::GetAll();
        $this->template = "CreateTicket.twig";
        $this->__render();

    }

    public function __POST($params) {

        $this->hasMsg = true;

        $ticket = new workorder_ticket();
        
        $ticket->CWID        = $this->_CoreAuth->getCurrentUser()->id;
        $ticket->priority    = $_POST['priority'];
        $ticket->site        = $_POST['org'];
        $ticket->room        = $_POST['room'];
        $ticket->ticketTitle = $_POST['title'];
        $ticket->ticketBody  = $_POST['body'];

        /* $users = $_CoreAuth->getUsersWithRoles(array("05", "06"));

        foreach ($users as $usr) {
            if($usr->siteCode == "DIST" || $usr->siteCode == $_POST['site']) {
                $messageBody  = "<h3>{$ticket->ticketTitle}</h3>";
                $messageBody .= "<p>{$ticket->ticketBody}</p>";
                $_WorkOrder->sendTicketAdminEmail($messageBody,  $_CoreAuth->getCurrentUser(), $usr);
            }
        } */

        if ($ticket->save()) {
            $this->msg = "Ticket Successfully Created!";
        } else {
            $this->msg = "Unable to create ticket...";
        }

        $this->template = "CreateTicket.twig";

        $this->__render();

    }

}