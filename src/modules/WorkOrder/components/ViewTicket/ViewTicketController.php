<?php

class ViewTicketController extends MPComponent {

    public $allTickets = [];

    public function __GET($params)
    {

        $this->template = "ViewTicket.twig";

        $this->attachedTickets = workorder_ticket::GetAllWhere(["attachedTo" => $params['id']]);
        $tickets = workorder_ticket::GetAllWhere(["attachedTo" => "0"]);

        foreach ($tickets as $t) {
            if($t->id != $params['id']) {
                array_push($this->allTickets, $t);
            }
        }


        $act = $params['action'] ?? null;

        if($act == "delete") {
            MPDatabaseHandler::deleteObject(workorder_ticket::GetWhereID($params['id']));
            echo "<meta http-equiv=\"refresh\" content=\"0; URL='./ViewTickets'\" />";
        }

        $this->ticket = workorder_ticket::GetWhereID($params['id']);


        $this->__render();
    }

}