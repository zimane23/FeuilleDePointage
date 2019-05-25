<?php
require "db.php";
require "fonctions.php";
session_start();

$var_alert= 'ok';

if(isset($_POST["submit"])){
	if(isset($_POST["ch_login"])){
		setcookie("username",$_POST["username"],time()+31556926);
		setcookie("password",$_POST["password"],time()+31556926);
	}
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$users=$conn->query("SELECT * FROM users");
  $users=$users->fetchAll(PDO::FETCH_OBJ);
    foreach ($users as $user) {
    	if($_POST["username"] == $user->username && $_POST["password"] == $user->password) {
			
			$_SESSION["id"] = $user->id;
			$_SESSION["name"] =$user->name;
			$_SESSION["username"] = $_POST["username"];
			
			if ($user->position_id==3)  header('Location: admin.php'); 
			elseif ($user->position_id==2) header('Location: chefpro.php'); 
			else header('Location: feuille.php'); 
		
			}
			unset($var_alert);
		}    	
}

require "views\login.view.php";

?>