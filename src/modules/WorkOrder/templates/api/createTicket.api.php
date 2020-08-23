<?php
header("Content-Type: application/json");
error_reporting(0);
ini_set('display_errors', 0);

echo $post['org'];
exit;

$ticket = new workorder_ticket();

$ticket->CWID        = $_CoreAuth->getCurrentUser()->id;
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
    echo '{ "success" : true }';
} else {
    echo '{ "success" : false }';
}