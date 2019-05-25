<?php 
require "db.php";
require "fonctions.php";
session_start();
if(!isset($_SESSION["id"])) {
    session_destroy();
     header('Location: login.php');}


$validations = query(
        "SELECT
          validations.id,
          validations.week,
          validations.user_id,
          users.name,
          validations.date
        FROM validations
          INNER JOIN
            (SELECT *, MAX(date) as last_date FROM validations GROUP BY user_id, week) AS validations_last_date
                ON 
                  validations.user_id = validations_last_date.user_id
                  AND validations.week = validations_last_date.week
          INNER JOIN users ON validations.user_id = users.id
          INNER JOIN projets ON validations.code_id = projets.id
        WHERE
          validations.date = validations_last_date.last_date
          AND validations.user_id = validations.validator_id
          AND projets.chef_id = :chef_id",
        array("chef_id" => $_SESSION["id"]),
        $conn
      );
      $validations = $validations->fetchAll(PDO::FETCH_OBJ);

      require "views/header.view.php";
      require "views/validate.view.php";
 ?>
