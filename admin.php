<?php

require "db.php";
require "fonctions.php";
session_start();
if(!isset($_SESSION["id"])) {
      session_destroy();
       header('Location: login.php');}


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <link rel="icon" type="image/jpg" href="images/iconsnef.jpg">
  <link rel="stylesheet" href="css/bootstrap.css">
  <title>Feuille De Pointage</title>
</head>

<body>

  <nav class="navbar navbar-light bg-dark">
    <a class="navbar-brand text-white" href="#">
      <img src="images/iconsnef.jpg" width="80" height="50" alt=""><span class="align-middle"> SNEF Algérie</span>
    </a>
    <form class="form-inline">
      <span class="navbar-text text-white">Connecté en tant que<b>
          <?= $_SESSION["name"]?></b></span>
      <a class="btn btn-link text-white" href="logout.php">(Se Déconnecter)</a>
    </form>
  </nav>

  <br>
  <br>
  <br>


  <div class="container">

    <div class="row justify-content-md-center mb-2">
      <a href="pointages.php" role="button" class="btn  btn-outline-info btn-lg" style="width:50%">Le pointage du
        personnel</a>
    </div>
    <div class="row justify-content-md-center mb-2">
      <a href="projet.php" class="btn btn-outline-info btn-lg" style="width:50%">Les codes projets</a>

    </div>
    <div class="row justify-content-md-center mb-2">
    <a class="btn btn-outline-info btn-lg" style="width:50%" href="profil.php">Le personnel de l'entreprise</a>
    </div>


  </div>
  <script src="js/jquery-3.3.1.slim.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>


  <script>
  </script>
</body>

</html>