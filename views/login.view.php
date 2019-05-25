<!doctype html>
<html lang="en">
 <head>
	 <meta charset="UTF-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 	<title>Feuille De pointage</title>
	<link rel="icon" type="image/jpg" href="images/iconsnef.jpg">
	<link rel="stylesheet" href="css/bootstrap.css">
	<style>

		table       { margin: auto; }
		td          { padding: 5px; }

	</style>
 </head>
 <body>
 <nav class="navbar navbar-light bg-dark">
  <a class="navbar-brand text-white" href="#">
    <img src="images/iconsnef.jpg" width="80" height="50" alt=""><span class="align-middle"> SNEF Algérie</span>
  </a>
  <span class="navbar-text text-white">
    Authentification requise, veuillez vous connecter
</span>
</nav>
 <?php if(!isset($var_alert)) echo "<div class='alert alert-danger text-center' role='alert'>Verifier votre nom d'utilisateur ou votre mot de passe</div>"; ?>
  <div class="container">
  <h1> </h1><br>
  <div class="card card-body border-info text-center m-auto" style="width: 400px;">
  <br><br><br><br>
   <form action="login.php" method="POST">
    <table>
		<tr>
		 <td><input class="form-control" type="text" id="username" name="username" placeholder="Nom d'utilisateur" value="<?=$_COOKIE["username"]?>"></td>
		</tr>
		<tr>
		 <td><input class="form-control" type="password" id="password" name="password" placeholder="Mot de passe" value="<?=$_COOKIE["password"]?>"></td>
		</tr>
		<tr>
		 <td><div class="form-check">
                <input type="checkbox" class="form-check-input" name="ch_login">
                <label class="form-check-label" for="ch_login">Rester connecter</label>
            </div>
		</td>
		</tr>	
		<tr>
         <td><input class="form-control btn btn-info" type="submit" name="submit" value="Se Connecter"></td>
        </tr>
    </table>		 
   </form>
   <br><br><br><br>
  </div>
</body>
</html>