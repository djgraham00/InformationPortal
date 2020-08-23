<?php
//https://docs.google.com/forms/d/e/1FAIpQLScMiTX7HyW7j3PSIFuaiUaR4Bo0bKRYzyFIWra0p4SL303Llw/viewform?usp=sf_link
require_once ("include/PHPMailer.php");

class WorkOrder extends MPModule {

    public $rts = array(
        "/_Ticket_Add" => array(
            "path" => "/_Ticket_Add",
            "template" => "WorkOrder/templates/api/createTicket.api.php"
        ),
        "/ViewTickets" => array(
            "path"  => "/ViewTickets",
            "component" => "ViewTickets"
        ),
        "/ViewTicket" => array(
            "path" => "/ViewTicket",
            "component" => "ViewTicket"
        ),
        "/closeTicket" => array(
            "path" => "/closeTicket",
            "template" => "WorkOrder/templates/api/closeTicket.api.php"
        ),
        "/NewTicket" => array(
            "path"      => "/NewTicket",
            "component" => "CreateTicket"
        ),
        "/Support" => array(
            "path" => "/Support",
            "component" => "CreateTicketExternal"
        )
        );

    protected function init() {

        $AdminPanel = $this->Parent->Modules['_AdminPanel'];
        /*
         * Register WorkOrder Pages in Admin Panel
         */
        $AdminPanel->registerPage("Support Tickets", "./ViewTickets");
        //$this->execInBackground('powershell.exe "& C:\\ITDEPT_SCRIPTS\\cu.ps1 \'OU=2023,OU=Students,OU=High School,DC=PTSchools,DC=local\' Test2 Student2 \'test2.student2\' Perkins1 true"');


    }

    private function execInBackground($cmd) {
        if (substr(php_uname(), 0, 7) == "Windows"){
            pclose(popen("start /B ". $cmd, "r"));
        }
        else {
            exec($cmd . " > /dev/null &");
        }
    }

    public function sendTicketAdminEmail($message, $creator, $user) {

        //Create a new PHPMailer instance
        $mail = new PHPMailer;

        $mail->isSMTP();

        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->Host = 'smtp.gmail.com';

        $mail->Port = 587;

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->SMTPAuth = true;

        $mail->Username = 'support@p-t.k12.ok.us';

        $mail->Password = 'QSE1qwwq';

        $mail->setFrom('support@p-t.k12.ok.us', 'Support');

        $mail->addReplyTo('djgraham@p-t.k12.ok.us', 'Drew Graham');

        $mail->addAddress($user->emailAddress, $user->fullName());

        $mail->Subject = "New Support Ticket from {$creator->fullName()}";

        $mail->Body = $message;

        $mail->IsHTML(true);

        $mail->send();

    }

    public function sendEmail ($to, $subject, $body) {
        //Create a new PHPMailer instance
        $mail = new PHPMailer;

        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';

        $mail->Port = 587;

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->SMTPAuth = true;

        $mail->Username = 'support@p-t.k12.ok.us';

        $mail->Password = 'QSE1qwwq';

        $mail->setFrom('support@p-t.k12.ok.us', 'Support');

        $mail->addReplyTo('djgraham@p-t.k12.ok.us', 'Drew Graham');

        $mail->addAddress($to);

        $mail->Subject = $subject;

        $mail->Body = $body;

        $mail->IsHTML(true);

        $mail->send();

    }

    public function __initModels() {
        $this->Parent->createTable(new workorder_ticket());
    }


}