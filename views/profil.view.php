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
   
   <form class="form-inline" action="profil.php" method="POST">
                <div class="form-group mb-2">
                    <input type="hidden" name="id" value="<?= $updateid ?>">
                </div>
                <div class="form-group mb-2">
                  <label for="recipient-name" class="form-label">Nom et Prénom </label>
                  <input type="text" class="form-control" name="nomprenom" placeholder="" value="<?= $updatename ?>">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                  <label for="recipient-name" class="form-label">Position</label>
                  <select class="form-control" name="position">
                         <option value="" disabled selected>choisir</option>
                         <?php foreach ($positions as $position) { ?>
                         <option  <?= ($updateposition == $position->name)? "selected" : "" ; ?>> <?= $position->name ?> </option>
                         <?php } ?>
                  </select>
                </div>
                <div class="form-group mb-2">
                <?php 
                if($update==true):
                ?>

                  <input class="form-control btn btn-primary" type="submit" name="updateprofil" value="Mettre à jour" >
                <?php else: ?>
                  <input class="form-control btn btn-info" type="submit" name="submitprofil" value="Ajouter utilisateur" >
                <?php endif; ?>
                </div>
    </form>
    <br>
    <br>    
            <input type="text" id="searchprofil" class="form-control mb-2" placeholder="Recherche">
            <table id="table2" class="table table-sm  table-bordered table-striped text-center">
              <thead>
                <tr>
                  <th>Nom et Prénom</th>
                  <th>Nom d'utilisateuer</th>
                  <th>Mot de passe</th>
                  <th>Position</th>
                  <th>Operations</th>

                </tr>
              </thead>
              <tbody>
                <?php foreach ($users as $staff): 
                  foreach ($positions as $position) {
                    if($staff->position_id == $position->id){  
                    $position_name = $position->name;
                    }
                  }
                ?>
                <tr>
                  <td><?= $staff->name  ?></td>
                  <td><?= $staff->username ?></td>
                  <td><?= $staff->password ?></td>
                  <td><?= $position_name?></td>
                  <td>
                   <a class="btn btn-info m-2" href="profil.php?editUser=<?= $staff->id ?>">Modifier</a>
                   <a class="btn btn-danger m-2" href="profil.php?deleteUser=<?= $staff->id ?>">Cloturer</a>
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