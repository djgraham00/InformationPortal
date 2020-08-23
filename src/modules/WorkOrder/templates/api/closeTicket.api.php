<?php
header("Content-Type: application/json");
error_reporting(0);
ini_set('display_errors', 0);

$id = $_POST['id'];

$sql = "DELETE FROM itdept_ticket WHERE id='$id'";

if ($ModularPHP->MYSQL->query($sql) === TRUE) {
    echo '{ "success" : true }';
} else {
    echo '{ "success" : false }';
}