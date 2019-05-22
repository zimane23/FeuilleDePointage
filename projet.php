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
  <?php 
    if(isset($_SESSION['message'])): 
  ?>   
   <div class="alert alert-<?= $_SESSION['msg_typ']?>">
   <a href="#" class="close" data-dismiss="alert" aria-label="fermer">&times;</a>
      <?php 
      echo $_SESSION['message'];
      unset($_SESSION['message']);
      ?>
   </div>
   <?php endif ?>
   
            <form  action="projet.php" method="POST">
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Code</label>
                  <input type="text" class="form-control"  name="code">
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Responsable projet</label>
                  <select class="form-control" name="responsable">
                        <option value="" disabled selected>choisir</option>
                        <?php foreach ($users as $user) { ?>
                         <option> <?= $user->name ?> </option>
                         <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="message-text" class="col-form-label">Details</label>
                  <textarea class="form-control" name="details"></textarea>
                </div>
                <div class="form-group" style="text-align:center;">
                  <input class="form-control btn btn-info center" type="submit" name="submitcode" value="Ajouter" style="width:50%">
                </div>
              </form>
            <br>
            <input type="text" id="searchcode" class="form-control mb-2" placeholder="Recherche" >
            <table id ="table1" class="table  table-bordered table-striped text-center">
              <thead>
                <tr>
                  <th>Code </th>
                  <th>Responsable projet</th>
                  <th>Details</th>
                  <th>Operations</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($projets as $projet): 
                  foreach ($users as $user) {
                    if($projet->chef_id == $user->id){  
                    $chef_name = $user->name;
                    }
                  }
                ?>
                <tr>
                  <td><?= $projet->code ?></td>
                  <td><?= $chef_name ?></td>
                  <td><?= $projet->details ?></td>
                  <td>
                   <a class="btn btn-info m-2" href="projet.php?editCode=<?= $projet->id ?>">Modifier</a>
                   <a class="btn btn-danger m-2" href="projet.php?deleteCode=<?= $projet->id ?>">Cloturer</a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>

 </div>
 <script src="js/jquery-3.3.1.slim.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="searchfield/jquery.searchablecode.js"></script>
  <script src="searchfield/jquery.searchableprofil.js"></script>

  <script>
    $('#table1').searchablecode();
    $('#table2').searchableprofil();
  </script>
</body>

</html>