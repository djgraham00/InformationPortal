<?php

$pageTitle = "Home";

$_AdminPanel->APHEADER();

?>

<main role="main" class="container">
    <div class="d-flex align-items-center p-3 my-3 text-black-50 bg-white rounded shadow-sm">
        <img class="mr-3" src="static/img/perkinstryon.png" alt="" width="48" height="48">
        <div class="lh-100">
            <h6 class="mb-0 text-black-50 lh-100"><?= $ModularPHP->APP_ORG ?></h6>
            <small><?= $ModularPHP->APP_NAME?> v<?= $ModularPHP->APP_VER ?></small>
        </div>

    </div>


    <small class="d-block text-right mt-3">
        <a href="#" onclick="deAuth();">Logout</a>
    </small>

</main>
<script src="static/js/jquery.js"></script>
<script src="static/js/bootstrap.min.js"></script>
<script src="static/js/offcanvas.js"></script>
<script src="static/js/coreauth.js"></script>
</body>
</html>
