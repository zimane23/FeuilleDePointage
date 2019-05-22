<?php require "header.view.php" ?>

<!--<fieldset id="myFieldset" <?=  $userSession->is == "owner" ? "" : "disabled" ?>> -->

<div class="container-fluid">
  <div class="alert alert-danger" role="alert" <?= !($userSession->is == "owner") ? "hidden" : "" ?>>
    Rejeté pour motif
  </div>
  <div class="text-center"><span>Feuille de pointage de <b><?= $userGet->name ?></b></span></div>
  <br>
  <div class="form-group row">
    <a href="feuille.php?id=<?= $id ?>&week=<?= $prevSunday ?>" role="button" class="btn btn-info mx-2 col-3">Semaine
      Précédente</a>
    <span class="col-form-label mx-3">Semaine du</span>
    <div class="col">
      <input class="form-control datepicker" type="date" value="<?= $sunday ?>">
    </div>
    <span class="col-form-label ">au</span>
    <div class="col">
      <input id="datepicker" class="form-control datepicker " type="date" value="<?= $nextSaturday ?>">
    </div>
    <a href="feuille.php?id=<?= $id ?>&week=<?= $nextSunday ?>" role="button" class="btn btn-info mx-2 col-3">Semaine
      Suivante</a>
  </div>

  <hr>

  <div class="form-group row" <?= $weekCodes ? "hidden" : ""; ?>>
    <button type="button" class="btn btn-light dropdown-toggle col mx-2" data-toggle="dropdown" aria-haspopup="true"
      aria-expanded="false">
      <b> Choisir un code projet pour commencer</b>
    </button>
    <div class="dropdown-menu col">
      <?php foreach ($addCodes as $addCode): ?>
      <a class="dropdown-item text-center" href="feuille.php?id=<?= $id ?>&week=<?= $_GET["week"] ?>&ajoutercode=<?= $addCode->id ?>"><?= $addCode->code ?></a>
      <?php endforeach; ?>
    </div>
  </div>


  <form action="feuille.php?id=<?= $_GET["id"] ?>&week=<?= $_GET["week"] ?>" method="POST" <?= $weekCodes ? "" : "hidden"; ?>>
    <table class="table table-bordered border-black table-hover table-sm text-center align-middle">
      <thead>
        <tr class="">
          <th class="pb-3">Imputation</th>
          <?php foreach ($weekCodes as $code): ?>
          <th colspan="3" class="pb-3">
            <?= $code->code ?>
            <a href="feuille.php?id=<?= $id ?>&week=<?= $_GET["week"] ?>&suppcodeid=<?= $code->id ?>" style="border:0px"
              class="btn btn-outline-secondary btn-sm float-right" title="Supprimer le code" data-toggle="tooltip"
              data-placement="top" <?= !($userSession->is == "owner") ? "hidden" : "" ?>>✕</a>
          </th>
          <?php endforeach; ?>

          <th colspan="2">
            <div class="btn-group btn-sm" role="group"
              <?= !$addCodes || !($userSession->is == "owner") ? "hidden" : "" ?>>
              <button id="btnGroupDrop1" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <b> Ajouter un code projet </b>
              </button>
              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <?php foreach ($addCodes as $addCode): ?>
                <a class="dropdown-item"
                  href="feuille.php?id=<?= $id ?>&week=<?= $_GET["week"] ?>&ajoutercode=<?= $addCode->id ?>"><?= $addCode->code ?></a>
                <?php endforeach; ?>
              </div>
            </div>
          </th>
        </tr>
        <tr class="text-center">
          <th class="align-top">Date</th>
          <?php foreach ($weekCodes as $code): ?>
          <th class="align-top">Heure Normale</th>
          <th class="align-top">Heure Supp.</th>
          <th class="align-top">Absence</th>
          <?php endforeach; ?>
          <th class="align-top">Remarque</th>
          <th class="align-top">Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($weekdays as $weekdayId => $weekday): ?>

        <tr>

          <td scope="row" class="text-center">
            <input type="hidden" name="date[]"
              value="<?= date("Y-m-d", strtotime("+$weekdayId day", strtotime($sunday))) ?>">
            <?= "<b>" . $weekday . "</b> " ?>
          </td>
          <?php foreach ($weekCodes as $code): 
           $ligneProjets = query("SELECT * FROM projets WHERE  code=:code",
             array("code" => $code->code),
             $conn);
           $ligneProjets = $ligneProjets->fetchAll(PDO::FETCH_OBJ);  

           $ligneHeures = query("SELECT * FROM heures WHERE code_id=:code_id AND user_id=:user_id AND date=:date ",
           array("code_id" => $ligneProjets[0]->id, "user_id" =>$_GET["id"], "date"=>date("Y-m-d", strtotime("+$weekdayId day", strtotime($sunday)))),
           $conn);
           $ligneHeures = $ligneHeures->fetchAll(PDO::FETCH_OBJ);
           
        ?>
          <td><input type="number" min="0" max="8" name="hnor[<?= $code->code ?>][]"
              value="<?= $ligneHeures[0]->heurenle ?>"></td>
          <td><input type="number" min="0" max="8" name="hsup[<?= $code->code ?>][]"
              value="<?= $ligneHeures[0]->heuresup ?>"></td>
          <td><select class="form-control" id="select1" name="absence[<?= $code->code ?>][]">
              <option></option>
              <option <?= ($ligneHeures[0]->abs=="Absence irrégulière") ? "selected" : ""; ?>>Absence irrégulière
              </option>
              <option <?= ($ligneHeures[0]->abs=="Congé annuel") ? "selected" : ""; ?>>Congé annuel</option>
              <option <?= ($ligneHeures[0]->abs=="Congé maladie") ? "selected" : ""; ?>>Congé maladie</option>
              <option <?= ($ligneHeures[0]->abs=="Décès") ? "selected" : ""; ?>>Décès</option>
              <option <?= ($ligneHeures[0]->abs=="Mariage") ? "selected" : ""; ?>>Mariage</option>
              <option <?= ($ligneHeures[0]->abs=="Maternité") ? "selected" : ""; ?>>Maternité</option>
              <option <?= ($ligneHeures[0]->abs=="Mission") ? "selected" : ""; ?>>Mission</option>
              <option <?= ($ligneHeures[0]->abs=="Naissance") ? "selected" : ""; ?>>Naissance</option>
              <option <?= ($ligneHeures[0]->abs=="Récupération") ? "selected" : ""; ?>>Récupération</option>
            </select>
          </td>


          <?php endforeach; ?>

          <td><input type="text" name="remarques[]" value="<?= $ligneHeures[0]->remarque ?>"></td>
          <td></td>
        </tr>
        <?php endforeach; ?>
        <tr>
          <th scope="row" class="text-center">Total</th>
          <?php foreach ($weekCodes as $code): ?>
          <td></td>
          <td></td>
          <td></td>
          <?php endforeach; ?>
          <td></td>
          <td></td>
        </tr>
          <tr class="">

            <th scope="row" class="text-center">Visa résponsable projet</th>
            <?php foreach ($weekCodes as $code): ?>
            <td colspan="3">
              <span class="badge badge-primary" <?= ($userSession->is == "validator") ? "hidden" : "" ?>>Soumise pour
                validation par <b>John Doe</b> le dd/mm/yyyy à hh:mm</span>
              <span class="badge badge-secondary" <?= ($userSession->is == "validator") ? "hidden" : "" ?>>En attente de validation par <b>Chef Projet</b></span>
              <span class="badge badge-success" <?= ($userSession->is == "validator") ? "hidden" : "" ?>>Validée par Chef
                Projet le dd/mm/yyyy à hh:mm</span>
              <span class="badge badge-danger" <?= ($userSession->is == "validator") ? "hidden" : "" ?>>Rejetée par Chef
                Projet le dd/mm/yyyy à hh:mm <br> Motif : </span>
              <a class="btn btn-outline-info"
                href="feuille.php?id=<?= $_GET["id"] ?>&week=<?= $_GET["week"]?>&projetvalid=<?=$code->code ?>"
                <?= !($userSession->is == "validator") ? "hidden" : "" ?>> Valider</a>
              <a class="btn btn-outline-info"
                href="feuille.php?id=<?= $_GET["id"] ?>&week=<?= $_GET["week"]?>&projetrejet=<?=$code->code ?>"
                <?= !($userSession->is == "validator") ? "hidden" : "" ?>> Rejeter </a>
            </td>
            <?php endforeach; ?>
          </tr>
      </tbody>
    </table>
    <div class="row justify-content-md-center" <?= ($userSession->is == "validator") ? "hidden" : "" ?>>
      <table class="table table-bordered text-center" style="width:50%">
        <thead>
          <tr>
            <th>Visa de la direction</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <span class="badge badge-success">Auto-validée par la DRH</span>
              <span class="badge badge-secondary">En attente de validation par les chefs de projet</span>
              <span class="badge badge-danger">Rejetée par la drh le dd/mm/yyyy à hh:mm <br> Motif : </span>
              <input class="btn btn-outline-info" type="submit" name="rejeter" value="Rejeter"
                <?= !($userSession->is == "drh") ? "hidden" : "" ?>>


            </td>
          </tr>
        </tbody>
      </table>
    </div>

              <div class="float-right" <?= !($userSession->is == "owner") ? "hidden" : "" ?>>
                <input class="btn btn-outline-info" type="submit" name="submitsave" value="Enregistrer">
                <input class="btn btn-outline-info" type="submit" name="submitsend" value="Envoyer pour Validation">
              </div>
              <!-- <div class="float-right" <?= !($userSession->is == "validator") ? "hidden" : "" ?>>
    <input class="btn btn-outline-info" type="submit" name="submitvalid" value="Valider">
    <input class="btn btn-outline-info" type="submit" name="cancelmanager" value="Annuler">
  </div>
  <div class="float-right" <?= !($userSession->is == "drh") ? "hidden" : "" ?>>  
    <input class="btn btn-outline-info" type="submit" name="submit" value="Annuler">
  </div>
 -->
    <br>
    <br>
    <br>
  </form>

</div>


<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script>
  $(".datepicker").change(function () {
    window.location = "feuille.php?week=" + $(this).val();
  });
  $('[data-toggle="tooltip"]').tooltip()
</script>
</body>

</html>