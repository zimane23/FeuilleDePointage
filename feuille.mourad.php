<?php
session_start();

// Reorienter vers le bon dimanche
if(!isset($_GET["week"]) || !isValideDate($_GET["week"])) {
  header('Location: feuille.php?week=' . prevSunday());
} else if(!isSunday($_GET["week"])) {
  header('Location: feuille.php?week=' . prevSunday($_GET["week"]));
}

function isValideDate($date, $format = 'Y-m-d') {
  $d = DateTime::createFromFormat($format, $date);
  return $d && $d->format($format) === $date;
}

function isSunday($date) {
  return (date('N', strtotime($date)) == 7);
}

function prevSunday($date = null) {
  if (!$date) $date = date('Y-m-d', time());

  if (isSunday($date)) return $date;
  else return date('Y-m-d', strtotime('last Sunday', strtotime($date)));
}

$sunday = $_GET["week"];
$prevSunday = date("Y-m-d", strtotime("-7 day", strtotime($sunday)));
$nextSunday = date("Y-m-d", strtotime("+7 day", strtotime($sunday)));

$codes = ["x1", "x2", "x3", "x4"];
$weekdays = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];

?>


<!doctype html>
 <html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <link rel="icon" type="image/jpg" href="iconsnef.jpg">
  <link rel="stylesheet" href="css/bootstrap.css">
	<title>Feuille De Pointage</title>
 </head>

 <body>
 
 <div class="card">
  <div class="card-header border-info">
  <ul class="nav nav-pills card-header-pills">
      <li class="nav-item">
        <a class="nav-link disabled" href="#"><b><?= $_SESSION["name"]?></b></a>
      </li>
      <li class="nav-item ml-auto">
        <a class="nav-link" href="logout.php">Se Déconnecter</a>
      </li>      
  </ul>
  </div>
  <div class="card-body">

  <div class="btn-group" role="group">
       <a href="feuille.php?week=<?= $prevSunday ?>" role="button" class="btn btn-info">Préc</a>
       <input id="datepicker" class="form-control" type="date" value="<?= $sunday ?>">
       <a href="feuille.php?week=<?= $nextSunday ?>" role="button" class="btn btn-info">Suiv</a>
  </div>
  
<table>
  <thead>
    <tr>
      <th></th>
      <?php 
        foreach ($codes as $codeId => $code) {
          echo "<th>$code</th>";
        }
      ?>
    </tr>
  </thead>
  <tbody>
      <?php 
        foreach ($weekdays as $weekdayId => $weekday) {
          $weekdayDate = date("d/m/Y", strtotime("+$weekdayId day", strtotime($sunday)));
          echo "<tr><th>$weekday $weekdayDate</th>";
          foreach ($codes as $codeId => $code) {
            echo "<td>Present</td>";
          }
          echo "</tr>";
        }
      ?>
  </tbody>
</table>

</div>
</div>
<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/bootstrap.min.js"></script> 
<script>
    $("#datepicker").change(function() {
      window.location = "feuille.php?week=" + $('#datepicker').val();
    });
</script>
</body>
</html>