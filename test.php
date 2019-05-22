<?php
        $nom="imane";
        $prenom="ziar";
    $login = $nom.".".$prenom.rand(1, 100);
    
    echo $login;
// on declare une chaine de caractÃ¨res
$chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@";
//nombre de caractÃ¨res dans le mot de passe
$nb_caract = 5;
// on fait une variable contenant le futur pass
$pass = $login;
//on fait une boucle
for($u = 1; $u <= $nb_caract; $u++) {
    //on compte le nombre de caractÃ¨res prÃ©sents dans notre chaine
    $nb = strlen($chaine);
    // on choisie un nombre au hasard entre 0 et le nombre de caractÃ¨res de la chaine
    $nb = mt_rand(0,($nb-1));
    // on ajoute la lettre a la valeur de $pass
    $pass.=$chaine[$nb];
}

// on affiche le rÃ©sultat :
echo $pass;
die();
function random($car) {
	$string = "";
	$chaine = "ABCDEFGHIJQLMNOPQRSTUVWXYZabcdefghijqlmnopqrstuvwxyz0123456789";
	srand((double)microtime()*1000000);
	for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
	}
	return $string;
}
 
$mdp = random(8);
$mdp_crypt = hash('sha512', $mdp);
?>
<html>
<button onclick="document.getElementById('up7913').disabled=true;document.getElementById('down7913').disabled=false;" type="submit" class="positive" name="up7913" id="up7913">First</button>

<button onclick="this.disabled=true;document.getElementById('up7913').disabled=false;" type="submit" class="negative" name="down7913" id="down7913">Second</button>
</html>



$lignes = query( "SELECT * FROM codes WHERE  code=:code",
  array("code" => $code),
  $conn);
  $ligne = $ligne->fetchAll(PDO::FETCH_OBJ);
  foreach ($codes as $codesId => $code){
    if($codesId==$_GET["ajoutercodeid"]) { 
     $ligne = query( "SELECT * FROM codes WHERE  code=:code",
     array("code" => $code),
     $conn);
     $ligne = $ligne->fetchAll(PDO::FETCH_OBJ);
     var_dump($ligne);
     query("INSERT INTO heures(user_id,code_id,semaine) VALUES (:user_id,:code_id,:semaine)",
            array("user_id"=>$_GET["id"], "code_id"=>$ligne[0]->id,"semaine"=>$_GET["week"]),
            $conn);



			$ligne = query( "SELECT * FROM codes WHERE  code=:code",
  array("code" =>$_GET["ajoutercode"] ),
  $conn);
  $ligne = $ligne->fetchAll(PDO::FETCH_OBJ);
  query("INSERT INTO heures(user_id,code_id,semaine) VALUES (:user_id,:code_id,:semaine)",
            array("user_id"=>$_GET["id"], "code_id"=>$ligne[0]->id,"semaine"=>$_GET["week"]),
            $conn);

  header('Location: feuille.php?id=' . $_GET["id"] . '&week=' . $_GET["week"]);