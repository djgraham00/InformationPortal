<?php
$_CoreAuth->requireAuth();

$pageTitle = "View Ticket";

$ModularPHP->loadComponent(array("component"=>"APHeader"));

$conn = $ModularPHP->MYSQL;

$sql = "SELECT * FROM itdept_ticket WHERE id='$ticketID' LIMIT 1";

$result = $conn->query($sql);

$res = null;

if($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $res = $row;

    }
}


$sites = om_ORG::GetAll();

/*array(
    "HS"    => "High School",
    "MS"    => "Middle School",
    "INT"   => "Intermediate School",
    "ELEM"  => "Elementary School"
); */

$ticket = workorder_ticket::GetWhereID($ticketID);

?>
<style>
    .container {
        max-width: 100%;
    }
</style>
<div class="container">
    <div class="row" >


        <?php
        $_WorkOrder->getComponent("WOSidebar");
        ?>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./home">Home</a></li>
                <li class="breadcrumb-item"><a href="./viewTickets">Support Tickets</a></li>
                <li class="breadcrumb-item active"><a href="./viewTicket/<?= $res['id']; ?>"><?=  $res['ticketTitle'] ?></a></li>
            </ol>
        </nav>
        <div class="card" style="margin-top: 20px; padding: 0px;">
            <h5 class="card-header"><?= $res["ticketTitle"]; ?></h5>
            <div class="card-body" style="padding: 0px;">

                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Site</th>
                            <th scope="col">Room</th>
                            <th scope="col">Priority</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= coreauth_USER::GetWhere(["CWID" => $res['CWID']])->fullName(); ?></td>
                            <td><?= om_Org::GetWhereID($res['site'])->orgDisplay; ?> </td>
                            <td><?= $res['room'] ?></td>
                            <td><?= $res['priority'] ?></td>
                        </tr>
                    </tbody>
                </table>
                <hr/>

                <div style="padding: 15px;">
                    <p class="card-text"><?= $res['ticketBody'] ?></p>
                    <small class="d-block text-right mt-3">
                        <a href="#" onclick="closeTicket('<?= $res['id']; ?>'); return false;" class="btn btn-sm btn-danger">Close Ticket</a>
                    </small>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="static/js/jquery.js"></script>
<script src="static/js/bootstrap.min.js"></script>
<script src="static/js/offcanvas.js"></script>
<script src="static/js/coreauth.js"></script>
<script src="static/js/itsupport.js"></script>
</body>
</html>
