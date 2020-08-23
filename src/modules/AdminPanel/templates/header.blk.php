<?php
$_CoreAuth->requireAuth();


$sites = array(
    "HS"    => "High School",
    "MS"    => "Middle School",
    "INT"   => "Intermediate School",
    "ELEM"  => "Elementary School"
);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= $ModularPHP->APP_NAME;?> | <?= $pageTitle ?></title>
    <base href="<?= $ModularPHP->APP_BASE_URL ?>" target="_self">
    <script src="static/js/common.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="static/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <meta name="theme-color" content="#563d7c">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .table {
            margin-bottom: 0px;
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="static/css/bootstrap-offcanvas.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <a class="navbar-brand mr-auto mr-lg-0" href="#"><?= $ModularPHP->APP_NAME;?></a>
    <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
    </button>

    <?php if(!isset($disableUsr) || !$disableUsr) { ?>
    <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $_CoreAuth->getCurrentUser()->fullName(); ?></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="./account">My Account</a>
                        <a class="dropdown-item" href="#" onclick="deAuth();">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <?php } ?>
</nav>
<?php if(!isset($disableNav) || !$disableNav) {?>
<div class="nav-scroller bg-white shadow-sm">
    <nav class="nav nav-underline ">
        <!-- <a class="nav-link active" href="#">Editors</a> -->
        <a class="nav-link" href="./APHOME">Home</a>

        <?php

        foreach ($_AdminPanel->registeredPages as $page) {
            $canLoadPage = false;

            foreach ($page['roles'] as $role) {
                if($_CoreAuth->hasRole($role)) {
                 $canLoadPage = true;
                }
            }

            if($canLoadPage) {
                echo "<a class=\"nav-link\" href=\"{$page["route"]}\">{$page["displayName"]}</a>";
            }
        }
        ?>

    </nav>
</div>
<?php } ?>

<div class="container">
    <div id="errView" style="margin-top: 15px;"></div>
</div>
