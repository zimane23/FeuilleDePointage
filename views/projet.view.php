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
            <br>
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