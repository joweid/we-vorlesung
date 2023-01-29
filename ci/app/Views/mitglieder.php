<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="https://unpkg.com/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<style>
    .no-border{
        border: none;
    }
</style>
<body>
<div class="container-fluid">
    <?php
    $name = "Mitglieder";
    include "templates/header.php";
     if (!isset($persons)): echo('false');endif;
    ?>
    <div class="row mt-4 ml-2 mr-2 mb-3">
        <div class="col-2"><?php //include "templates/sidebar.php";?></div>
        <div class="col-8">
            <?php include "templates/navbar.php"; ?>
            <form method="post" action="<?php echo base_url() ?>/edit_user">
                <table class="table table-striped table-hover rounded">
                    <thead class="bg-light">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">E-Mail</th>
                        <th scope="col">in Projekt</th>
                        <th scope="col">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($persons as $item): ?>
                            <tr>
                                <td id="<?php echo ($item['id'] . "_username"); ?>"><?= $item['username']?></td>
                                <td><?= $item['email'] ?></td>
                                <?php $mitglieder_model = new \App\Models\MitgliederModel(); ?>
                                <td>
                                    <?php if($mitglieder_model->in_projekt($item['id'], $_SESSION['chosen_projekt'])): ?>
                                        <span class="badge badge-success bg-success">&#10003;</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="no-border" name="edit_btn" type="submit" value="<?php echo $item['id']?>"><img width="18" height="18" src="edit_svg.svg"></button>
                                    <button class="no-border" type="button" value="<?php echo $item['id']?>" data-toggle="modal" data-target="#deleteModal" onclick="fill_delete_modal(this.value)"><img width="18" height="18" src="delete_svg.svg"></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
            <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#userModal">+ neu</a>
        </div>
        <div class="col-2"></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="<?php base_url() ?>/we-vorlesung/ci/public/create_user" method="post">
                    <h3>Mitglied erstellen</h3>
                    <br>
                    <div class="form-group">
                        <label for="person_name">Username</label>
                        <input type="text" class="form-control" id="person_name" name="username" placeholder="max_mustermann">
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="person_email">E-Mail</label>
                        <input type="email" class="form-control" id="person_email" name="email" placeholder="max-mustermann@web.de">
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="person_passwort">Passwort</label>
                        <input type="password" class="form-control" id="person_passwort" name="passwort" placeholder="Passwort">
                        <br>
                    </div>
                    <div class="d-inline">
                        <input type="checkbox" name="in_projekt">
                        <label>dem Projekt zugeordnet</label>
                    </div>
                    <br>
                    <br>
                    <div class="d-inline">
                        <input type="submit" class="btn btn-primary btn-sm" value="Erstellen">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal DELETE Confirm -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mitglied löschen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Bist du sicher, dass du das Mitglied <strong id="item_name"></strong> löschen möchtest?</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="<?php echo base_url() ?>/edit_user">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
            <button name="delete_btn" id="delete_button" type="submit" class="btn btn-danger">Löschen</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    function fill_delete_modal(item_id) {
        document.getElementById("delete_button").value = item_id;
        document.getElementById("item_name").innerHTML = document.getElementById(item_id + "_username").innerHTML;
    }
</script>
</body>
</html>



