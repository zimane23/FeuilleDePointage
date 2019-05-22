<?php

require "db.php";
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
    <a class="navbar-brand text-white" href="admin.php">
      <img src="images/iconsnef.jpg" width="80" height="50" alt=""><span class="align-middle"> SNEF Algérie</span>
    </a>
    <form class="form-inline">
      <span class="navbar-text text-white">Connecté en tant que<b>
          <?= $_SESSION["name"]?></b></span>
      <a class="btn btn-link text-white" href="logout.php" >(Se Déconnecter)</a>
    </form>
  </nav>
<br>
  <div class="container-fluid">
    <div class="float-right">
    <input type="text" class="form-control" id="search" placeholder="Recherche">
    </div>
    <br>
    <br>
    <table id="table" class="table table-sm table-striped text-center">
  <thead>
    <tr>
      <th scope="col">Nom et prénom </th>
      <th scope="col">Semaine</th>
      <th scope="col">Visa direction</th>
      <th scope="col">Remarque</th>

    </tr>
  </thead>
  <tbody>
    <tr>
      <td><a href="feuille.php?id=1">Ziar Imane</a></td>
      <td>Du 01-02-2019 au 06-02-2019</td>
      <td>
           <a class="btn btn-info" href="" >Annuler</a>
      </td>
      <td><textarea></textarea></td>
    </tr>
    <tr>
      <td><a href="feuille.php?id=2">Hakoum Amel</a></td>
      <td>Du 02-02-2019 au 06-02-2019</td>
      <td>
           <a class="btn btn-info" href="" >Annuler</a></td>
      <td><textarea></textarea></td>
    </tr>
    <tr>
      <td><a href="feuille.php?id=3">Ouhassaine Zohir</a></td>
      <td>Du 03-02-2019 au 06-02-2019</td>
      <td>
           <a class="btn btn-info" href="" >Annuler</a></td>
      <td><textarea></textarea></td>
    </tr>

  </tbody>
</table>



  </div>

  <script src="js/jquery-3.3.1.slim.min.js"></script>
  <script src="searchfield/jquery.searchable.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script>
  $( '#table' ).searchable();

 
  </script>

</body>
</html>