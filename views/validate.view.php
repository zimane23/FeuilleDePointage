<div class="container-fluid">
    <div class="float-right">
    <input type="text" class="form-control" id="search" placeholder="Recherche">
    </div>
  <br><br>
  <table id="table" class="table table-hover text-center">
  <thead>
    <tr>
      <th scope="col">Etablie par </th>
      <th scope="col">Le</th>
      <th scope="col">Semaine</th>

    </tr>
  </thead>
  <tbody>
  <?php foreach ($validations as $validation): 
  ?>
    <tr class='clickable-row' style="cursor:pointer;" data-href='feuille.php?id=<?= $validation->user_id ?>&week=<?= $validation->week ?>'>
      <td><?= $validation->name ?></td>
      <td><?= $validation->date ?></td>
      <td><?= $validation->week ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>



  </div>

  <script src="js/jquery-3.3.1.slim.min.js"></script>
  <script src="searchfield/jquery.searchable.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script>
  $( '#table' ).searchable();
  $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });

 
  </script>
