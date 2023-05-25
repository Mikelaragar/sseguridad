<?php
session_start();
$auth=$_SESSION["auth"];
if (isset($auth)){
    session_destroy();
    unset($_SESSION["id"]);
    unset($_SESSION["usuario"]);
    unset($_SESSION["rol"]);
}

header('location:../index.php');
?>