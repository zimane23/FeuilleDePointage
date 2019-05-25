<?php

require "db.php";
require "fonctions.php";
session_start();

if(!isset($_SESSION["id"])) {
    session_destroy();
    header('Location: login.php');
}

$positions=$conn->query("SELECT * FROM positions");
$positions=$positions->fetchAll(PDO::FETCH_OBJ);

$users=$conn->query("SELECT * FROM users ORDER BY name ASC");
$users=$users->fetchAll(PDO::FETCH_OBJ);
$updateid=0;
$updatename='';
$updateposition='';
$update= false;
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(isset($_POST["submitprofil"])){
    if(!$_POST["nomprenom"]) {
        $_SESSION['message'] =  $nameuser[0]->name."Vous devez entrer un nom.";
        $_SESSION['msg_typ'] = "danger";
        header("Location: profil.php");
        die();
    }
    if(!$_POST["position"]) {
        $_SESSION['message'] =  $nameuser[0]->name."Vous devez selectionner une position.";
        $_SESSION['msg_typ'] = "danger";
        header("Location: profil.php");
        die();
    }
    foreach ($positions as $position) {
      if($_POST["position"] == $position->name){  
      $position_id = $position->id;
      }
    }
    $username = str_replace(' ','.',$_POST["nomprenom"]);
     // on declare une chaine de caracteres
   $chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@";
    //nombre de caractÃ¨res dans le mot de passe
    $nb_caract = 5;
    // on fait une variable contenant le futur pass
    $password = $username;
   //on fait une boucle
    for($u = 1; $u <= $nb_caract; $u++) {
    //on compte le nombre de caracteres presents dans notre chaine
    $nb = strlen($chaine);
    // on choisie un nombre au hasard entre 0 et le nombre de caracteres de la chaine
    $nb = mt_rand(0,($nb-1));
    // on ajoute la lettre a la valeur de $password
    $password.=$chaine[$nb];
    }
    
    query("INSERT INTO users(username,password,name,position_id) VALUES (:username,:password,:name,:position_id)",
                 array("username"=>$username,"password"=>$password, "name"=>$_POST["nomprenom"],"position_id"=>$position_id),
                 $conn);

  
    $_SESSION['message'] = $_POST['nomprenom']." ajouté avec succés";
    $_SESSION['msg_typ'] = "success";
    header("Location: profil.php");
    die();
  }
  if(isset($_POST["updateprofil"])){
    foreach ($positions as $position) {
        if($_POST["position"] == $position->name){  
        $position_id = $position->id;
        }
      }
    
      $username = str_replace(' ','.',$_POST["nomprenom"]);
      // on declare une chaine de caracteres
    $chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@";
     //nombre de caractÃ¨res dans le mot de passe
     $nb_caract = 5;
     // on fait une variable contenant le futur pass
     $password = $username;
    //on fait une boucle
     for($u = 1; $u <= $nb_caract; $u++) {
     //on compte le nombre de caracteres presents dans notre chaine
     $nb = strlen($chaine);
     // on choisie un nombre au hasard entre 0 et le nombre de caracteres de la chaine
     $nb = mt_rand(0,($nb-1));
     // on ajoute la lettre a la valeur de $password
     $password.=$chaine[$nb];
     }

    query(
        "UPDATE users 
         SET name=:name, position_id=:position_id, username=:username,password=:password
         WHERE id=:id",
         array("username"=>$username,"password"=>$password,"name"=>$_POST["nomprenom"],"position_id"=>$position_id,"id"=>$_POST["id"]),
         $conn
       );
       $_SESSION['message'] = $_POST['nomprenom']." Modifié avec succés";
       $_SESSION['msg_typ'] = "success";
       header("Location: profil.php");
       die();

}
     
}

if (isset($_GET["deleteUser"])){
    $nameuser = query("SELECT * FROM users WHERE id=:id",
    array("id" => $_GET["deleteUser"] ),
    $conn);
    $nameuser = $nameuser->fetchAll(PDO::FETCH_OBJ);

    query("DELETE FROM users WHERE id=:id",
    array("id" => $_GET["deleteUser"] ),
    $conn);
    $_SESSION['message'] =  $nameuser[0]->name." supprimé avec succés";
    $_SESSION['msg_typ'] = "danger";
    header("Location: profil.php");
    die();
}

if (isset($_GET["editUser"])){
    $updateid=$_GET["editUser"];
    $update=true;
    $updateuser = query("SELECT * FROM users WHERE id=:id",
    array("id" => $_GET["editUser"] ),
    $conn);
    $updateuser = $updateuser->fetchAll(PDO::FETCH_OBJ);
    $updatename=$updateuser[0]->name;

    $updatepos = query("SELECT * FROM positions WHERE id=:id",
    array("id" => $updateuser[0]->position_id ),
    $conn);
    $updatepos = $updatepos->fetchAll(PDO::FETCH_OBJ);

    $updateposition=$updatepos[0]->name;
    
    
}


require "views/header.view.php";
require "views/profil.view.php";

?>