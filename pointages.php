<?php

require "db.php";

session_start();

if(!isset($_SESSION["id"])) {
        session_destroy();
        header('Location: login.php');}


$users=$conn->query("SELECT * FROM users ORDER BY name");
$users=$users->fetchAll(PDO::FETCH_OBJ);

require "header.view.php";
require "pointages.view.php";
?>