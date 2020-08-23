<?php
$_CoreAuth->requireAuth();

$pageTitle = "Support Tickets";

$ModularPHP->loadComponent(array("component"=>"APHeader"));



if(isset($siteId)) {
    $site = om_Org::GetWhereID($siteId);
    $pageTitle = "{$site->orgDisplay}";
}

?>
<style>
    .container {
        max-width: 100%;
    }
</style>
<div class="container">
<div class="row" >

    <?php
        WOSidebarController::Load($this);
    ?>

    <!-- Main page content -->
    <div class="col">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./home">Home</a></li>
                <li class="breadcrumb-item <?php if(!isset($siteId)) { ?> active <?php } ?>"><a href="./viewTickets">Support Tickets</a></li>
                <?php if(isset($siteId)) {?> <li class="breadcrumb-item active"><a href="./ViewTicket/<?= $site->id; ?>"><?= $pageTitle ?></a></li> <?php } ?>
            </ol>
        </nav>

        <div class="card" style="margin-bottom: 20px;">
                <h5 class="card-header"><span class="float-left"><?= $pageTitle ?></span></h5>
                <div class="card-body" style="padding: 0px;">
                    <div class="table-responsive">
                        <table class="table ">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Full Name</th>
                                <th scope="col">Ticket Title</th>
                                <th scope="col">Site</th>
                                <th scope="col">Room</th>
                                <th scope="col">Priority</th>
                                <th scope="col">View Ticket</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $conn = $ModularPHP->MYSQL;

                            /* if ($_CoreAuth->getCurrentUser()->siteCode != "DIST") {
                               $sql = "SELECT * FROM itdept_ticket WHERE site='{$_CoreAuth->getCurrentUser()->siteCode}'";
                            }
                            else { */
                                $sql = "SELECT * FROM itdept_ticket";
                            //}

                            if(isset($siteId)) {
                                $sql = "SELECT * FROM itdept_ticket WHERE site='{$siteId}'";
                            }



                            $result = $conn->query($sql);

                            if($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {

                                    $user = coreauth_USER::GetWhere(["CWID" => $row['CWID']]);
                                    $siteDisplay = om_Org::GetWhereID($row['site']);

                                    ?>


                                    <tr>
                                        <th scope="row"><?= $user->fullName(); ?></th>
                                        <td><?= $row['ticketTitle'] ?></td>
                                        <td><?= $siteDisplay->orgDisplay; ?></td>
                                        <td><?= $row['room'] ?></td>
                                        <td><?= $row['priority'] ?></td>
                                        <td><a href="./viewTicket/<?= $row["id"] ?>" class="btn btn-sm btn-primary">View Ticket</a></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
    </div>
</div>

</div>
</div>


<script src="static/js/jquery.js"></script>
<script src="static/js/bootstrap.min.js"></script>
<script src="static/js/offcanvas.js"></script>
<script src="static/js/coreauth.js"></script>
</body>
</html>
