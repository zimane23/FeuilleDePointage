<?php 
require "db.php";
require "fonctions.php";
session_start();
if(!isset($_SESSION["id"])) {
    session_destroy();
     header('Location: login.php');}

     require "views/header.view.php";
     require "views/chefpro.view.php";
 ?>