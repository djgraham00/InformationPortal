<?php

class ViewTicketsController extends MPComponent {

    public $tickets;
    public $site;
    public $pageTitle = "Support Tickets";


    public function __GET($params)
    {
       $this->template = "ViewTickets.twig";

        if(isset($params['site'])) {

            $this->site = om_Org::GetWhereID($params['site']);

            $this->tickets = workorder_ticket::GetAllWhere(["site" => $params['site'], "attachedTo" => "0"], true);

            $this->pageTitle = $this->site->orgDisplay;
        } else {
            $this->tickets = workorder_ticket::GetAllWhere(["attachedTo" => "0"], true);
        }
       $this->__render();
    }

}