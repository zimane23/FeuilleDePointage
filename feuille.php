<?php

require "db.php";
require "fonctions.php";
session_start();

$renvoyer = false;

// Verifier que week est valide sinon renvoyer vers le bon dimanche
if (!isset($_GET["week"]) || !isValideDate($_GET["week"]))
{
  $sunday = prevSunday();
  $renvoyer = true;
}
elseif (!isSunday($_GET["week"]))
{
  $sunday = prevSunday($_GET["week"]);
  $renvoyer = true;
}
else
{
  $sunday = $_GET["week"];
}

if (!isset($_GET["id"]))
{
  $id = $_SESSION["id"];
  $renvoyer = true;
}
else
{
  $id = $_GET["id"];
}

if ($renvoyer)
{
  header('Location: feuille.php?id=' . $id . '&week=' . $sunday);
}


$userGet = getUserById($_GET["id"], $conn);
$userSession = getUserById($_SESSION["id"], $conn);
$weekCodes = query("SELECT * FROM projets WHERE id IN
                    (SELECT DISTINCT code_id FROM heures 
                    WHERE user_id=:id AND (date BETWEEN :sunday AND :nextSaturday))",
                    array(
                        "id" => $_GET["id"],
                        "sunday" => $sunday,
                        "nextSaturday" => date("Y-m-d", strtotime("+6 day", strtotime($sunday)))
                    ),
                    $conn)->fetchAll(PDO::FETCH_OBJ);

if($userGet->id == $userSession->id) 
{
    $userSession->is = "owner";
} 
elseif($userSession->position_id == 3)
{
    $userSession->is = "drh";
}
elseif($userSession->position_id == 6)
{
    $userSession->is = "directeur";
} 
else
{
  $codeToValid = array();
    foreach($weekCodes as $code)
    {
        if($code->chef_id == $userSession->id)
        {
            $userSession->is = "validator";
            array_push($codeToValid,$code);

        }

    }
    if ($userSession->is == "validator") $weekCodes=$codeToValid;
}

if (!$userGet || !isset($userSession->is))
{
    header('Location: feuille.php?id=' . $_SESSION["id"] . '&week=' . $sunday);
}

$prevSunday = date("Y-m-d", strtotime("-7 day", strtotime($sunday)));
$nextSunday = date("Y-m-d", strtotime("+7 day", strtotime($sunday)));
$nextSaturday = date("Y-m-d", strtotime("+6 day", strtotime($sunday)));
$weekdays = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];

// Récuperer les codes de la base de données (le select)
$addCodes = array_udiff(
              $conn->query("SELECT * FROM projets")->fetchAll(PDO::FETCH_OBJ),
              $weekCodes,
              "compareCodes"
            );

// Supprimer code
if (isset($_GET["suppcodeid"]) && isset($_GET["week"]) && isset($_GET["id"])) {
  foreach ($weekCodes as $code) {
    if ($code->id == $_GET["suppcodeid"]) {
      $ligne = query(
        "SELECT * FROM projets WHERE  code=:code",
        array("code" => $code->code),
        $conn
      );
      $ligne = $ligne->fetchAll(PDO::FETCH_OBJ);

      query(
        "DELETE FROM heures WHERE code_id=:codeid AND (date BETWEEN :sunday AND :nextSaturday)",
        array("codeid" =>  $ligne[0]->id, "sunday" => $sunday, "nextSaturday" => $nextSaturday),
        $conn
      );
      query(
        "DELETE FROM validations WHERE code_id=:codeid AND week=:week",
        array("codeid" =>  $ligne[0]->id, "week"=>$_GET["week"]),
        $conn
      );
      header('Location: feuille.php?id=' . $_GET["id"] . '&week=' . $_GET["week"]);
    }
  }
}

// Ajouter code
if (isset($_GET["ajoutercode"]) && isset($_GET["week"]) && isset($_GET["id"])) {

  for ($i=0; $i < 7; $i++) { 
    query(
      "INSERT INTO heures(user_id, code_id, date) VALUES (:user_id, :code_id, :date)",
      array("user_id" => $_GET["id"], "code_id" => $_GET["ajoutercode"], "date" => date("Y-m-d", strtotime("+$i day", strtotime($sunday)))),
      $conn
    );
  
  }
  
  
  header('Location: feuille.php?id=' . $_GET["id"] . '&week=' . $_GET["week"]);
}

////button valider chef de projet
if (isset($_GET["projetvalid"]) && isset($_GET["week"]) && isset($_GET["id"])) {
  $ligne = query(
    "SELECT * FROM projets WHERE  code=:code",
    array("code" => $_GET["projetvalid"]),
    $conn
  );
  $ligne = $ligne->fetchAll(PDO::FETCH_OBJ);
  query(
    "INSERT INTO validations(week,approved,user_id,code_id,validator_id,date) VALUES (:week,1,:user_id,:code_id,:validator_id,NOW())",
    array("week" => $_GET["week"], "user_id" => $_GET["id"], "code_id" => $ligne[0]->id, "validator_id" =>$_SESSION["id"] ),
    $conn
  );
  header('Location: feuille.php?id=' . $_GET["id"] . '&week=' . $_GET["week"]);
}

if (isset($_GET["projetrejet"]) && isset($_GET["week"]) && isset($_GET["id"])) {
  $ligne = query(
    "SELECT * FROM projets WHERE  code=:code",
    array("code" => $_GET["projetrejet"]),
    $conn
  );
  $ligne = $ligne->fetchAll(PDO::FETCH_OBJ);
  query(
    "INSERT INTO validations(week,approved,user_id,code_id,validator_id,date) VALUES (:week,0,:user_id,:code_id,:validator_id,NOW())",
    array("week" => $_GET["week"], "user_id" => $_GET["id"], "code_id" => $ligne[0]->id, "validator_id" =>$_SESSION["id"] ),
    $conn
  );

  header('Location: feuille.php?id=' . $_GET["id"] . '&week=' . $_GET["week"]);

}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Bouton "Enregistrer" fonctionnel
  if (isset($_POST["submitsave"])) {

    foreach ($_POST["hnor"] as $keycode => $tabhnor) {
      foreach ($_POST["date"] as $keydate => $tabdate) {
       

        $ligne = query(
          "SELECT * FROM projets WHERE  code=:code",
          array("code" => $keycode),
          $conn
        );
        $ligne = $ligne->fetchAll(PDO::FETCH_OBJ);
        

        query(
          "UPDATE heures 
           SET heurenle=:heurenle, heuresup=:heuresup, abs=:abs, remarque=:remarque
           WHERE user_id=:user_id AND code_id=:code_id AND date=:date",
          array(
            "heurenle" => $tabhnor[$keydate],
            "heuresup" => $_POST["hsup"][$keycode][$keydate],
            "abs" => $_POST["absence"][$keycode][$keydate],
            "remarque" => $_POST["remarques"][$keydate],
            "user_id" => $_GET["id"],
            "code_id" => $ligne[0]->id,
            "date" => $tabdate
          ),
          $conn
        );

      }
    }
  


  }

  // Bouton "Envoyer" fonctionnel
  if (isset($_POST["submitsend"])) {
    foreach ($_POST["hnor"] as $keycode => $tabhnor) {
      $ligne = query(
        "SELECT * FROM projets WHERE  code=:code",
        array("code" => $keycode),
        $conn
      );
      $ligne = $ligne->fetchAll(PDO::FETCH_OBJ);
      query(
        "INSERT INTO validations(week,approved,user_id,code_id,validator_id,date) VALUES (:week,1,:user_id,:code_id,:validator_id,NOW())",
        array("week" => $_GET["week"], "user_id" => $_GET["id"], "code_id" => $ligne[0]->id, "validator_id" =>$_SESSION["id"] ),
        $conn
      );
      foreach ($_POST["date"] as $keydate => $tabdate) {
       
        query(
          "UPDATE heures 
           SET heurenle=:heurenle, heuresup=:heuresup, abs=:abs, remarque=:remarque
           WHERE user_id=:user_id AND code_id=:code_id AND date=:date",
          array(
            "heurenle" => $tabhnor[$keydate],
            "heuresup" => $_POST["hsup"][$keycode][$keydate],
            "abs" => $_POST["absence"][$keycode][$keydate],
            "remarque" => $_POST["remarques"][$keydate],
            "user_id" => $_GET["id"],
            "code_id" => $ligne[0]->id,
            "date" => $tabdate
          ),
          $conn
        );

  
      }
    }
  }

  //Rejeter administration 
  if (isset($_POST["rejeter"])) {

    foreach ($_POST["hnor"] as $keycode => $tabhnor) {
      $ligne = query(
        "SELECT * FROM projets WHERE  code=:code",
        array("code" => $keycode),
        $conn
      );
      $ligne = $ligne->fetchAll(PDO::FETCH_OBJ);
      query(
        "INSERT INTO validations(week,approved,user_id,code_id,validator_id,date) VALUES (:week,0,:user_id,:code_id,:validator_id,NOW())",
        array("week" => $_GET["week"], "user_id" => $_GET["id"], "code_id" => $ligne[0]->id, "validator_id" =>$_SESSION["id"] ),
        $conn
      );
    }

}

// Afficher la feuille a partir de la base de donnée enregistrer


}
require "feuille.view.php";





// Bouton Valider/Annuler Validation sous chaque code