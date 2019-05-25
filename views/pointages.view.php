<div class="container-fluid">
    <div class="float-right">
    <input type="text" class="form-control" id="search" placeholder="Recherche">
    </div>
  <br><br>
  <table id="table" class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Pointage établie par </th>
      <th scope="col">Le</th>
      <th scope="col">Semaine</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
 <?php foreach($users as $user){ ?>
    <tr>
      <td><a class="btn btn-link text-black" href="feuille.php?id=<?=$user->id ?>" ><?= $user->name?></a></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
 <?php } ?>
   </tbody>
</table>



  </div>

  <script src="js/jquery-3.3.1.slim.min.js"></script>
  <script src="searchfield/jquery.searchable.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script>
  $( '#table' ).searchable();

 
  </script>
