<?php
$_CoreAuth->requireAuth();

$pageTitle = "New Support Ticket";

$ModularPHP->loadComponent(array("component"=>"APHeader"));

$sites = om_Org::GetAll();

?>

<main role="main" class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./home">Home</a></li>
            <li class="breadcrumb-item active"><a href="./itsupport">New Support Ticket</a></li>
        </ol>
    </nav>
    <div class="card" style="margin-bottom: 20px;">
        <h5 class="card-header"><span class="float-left"><?= $pageTitle ?></span></h5>
        <div class="card-body">
            <form onsubmit="addTicket(); return false;">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Title</label>
                    <input type="text" class="form-control" name="title" id="exampleFormControlInput1" placeholder="e.x. Can't print to copier...">
                </div>

                <div class="form-group">
                    <label for="priortySelect">Priority</label>
                    <select class="form-control" id="priortySelect" name="priority">
                        <option>Low</option>
                        <option>Normal</option>
                        <option>High</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="siteSelect">Organization</label>
                    <select class="form-control" id="siteSelect" name="org">
                        <?php foreach ($sites as $site) { ?>
                        <option value="<?= $site->id; ?>"><?= $site->orgDisplay; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput1">Room #</label>
                    <input type="text" class="form-control" name="room" id="exampleFormControlInput1" placeholder="205">
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Ticket Details</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="body" rows="3"></textarea>
                </div>


                <small class="d-block text-right mt-3">
                    <button class="btn btn-sm btn-primary" type="submit">Open Ticket</button>
                </small>
            </form>
        </div>

</main>

<script src="static/js/jquery.js"></script>
<script src="static/js/bootstrap.min.js"></script>
<script src="static/js/offcanvas.js"></script>
<script src="static/js/coreauth.js"></script>
<script src="static/js/itsupport.js"></script>
</body>
</html>
