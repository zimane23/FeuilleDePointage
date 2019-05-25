<?php
require "db.php";
require "fonctions.php";
session_start();

if(!isset($_SESSION["id"])) {
    session_destroy();
    header('Location: login.php');
}

$projets=$conn->query("SELECT * FROM projets ORDER BY chef_id");
$projets=$projets->fetchAll(PDO::FETCH_OBJ);

$users=$conn->query("SELECT * FROM users WHERE position_id=2");
$users=$users->fetchAll(PDO::FETCH_OBJ);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(isset($_POST["submitcode"])){
    if(!$_POST["code"]) {
        $_SESSION['message'] = "Vous devez entrer un code.";
        $_SESSION['msg_typ'] = "danger";
        header("Location: projet.php");
        die();
    }
    if(!$_POST["responsable"]) {
        $_SESSION['message'] =  "Vous devez selectionner un responsable projet.";
        $_SESSION['msg_typ'] = "danger";
        header("Location: projet.php");
        die();
    }
      foreach ($users as $user) {
        if($_POST["responsable"] == $user->name){  
        $chef_id = $user->id;
        }
      }
      query("INSERT INTO projets(code,chef_id,details) VALUES (:code,:chef_id,:details)",
      array("code"=>$_POST["code"],"chef_id"=>$chef_id, "details"=>$_POST["details"]),
      $conn);
      header("Location: projet.php");

  }
}

require "views/header.view.php";
require "views/projet.view.php";
?>