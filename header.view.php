<!doctype html>
<html lang="fr">

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
    <a class="btn btn-link text-white" href="logout.php" >(Se Déconnecter)</a>
  </form>
</nav>
<br>