<!DOCTYPE html>
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
    $name = "Reiter";
    include "templates/header.php";
    ?>
    <div class="row mt-4 ml-2 mr-2">
        <div class="col-2">
            <?php //include 'templates/sidebar.php';?>
        </div>
        <div class="col-8">
            <?php include "templates/navbar.php"; ?>
            <form method="post" action="<?php echo base_url() ?>/edit_reiter">
                <table class="table table-striped">
                    <thead class="bg-light">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Beschreibung</th>
                        <th scope="col">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($reiter as $item):?>
                        <tr>
                            <td id="<?php echo ($item['id'] . "_name")?>"><?= $item['name']?></td>
                            <td id="<?php echo ($item['id'] . "_beschreibung")?>"><?= $item['beschreibung'] ?></td>
                            <td>
                                <button class="no-border" type="button" value="<?php echo $item['id']?>" data-toggle="modal" data-target="#edit_reiter" onclick="fill_edit_modal(this.value)">
                                    <img width="18" height="18" src="edit_svg.svg">
                                </button>
                                <button class="no-border" type="button" value="<?php echo $item['id']?>" data-toggle="modal" data-target="#deleteModal" onclick="fill_delete_modal(this.value)">
                                    <img width="18" height="18" src="delete_svg.svg">
                                </button>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </form>
            <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#reiterModal">+ neu</a>
        </div>
        <div class="col-2"></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="reiterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="<?php base_url() ?>/we-vorlesung/ci/public/create_reiter" method="POST">
                    <h3>Reiter hinzufügen</h3>
                    <div class="form-group">
                        <label for="reiter_bezeichnung">Bezeichnung des Reiters</label>
                        <input type="text" class="form-control" name="name" placeholder="Bezeichnung">
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="reiter_beschreibung">Beschreibung</label>
                        <textarea class="form-control" rows="3" placeholder="Beschreibung" name="beschreibung"></textarea>
                        <br>
                    </div>
                    <div class="d-inline">
                        <input type="submit" class="btn btn-primary btn-sm" value="Speichern">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="edit_reiter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
            <form action="<?php base_url() ?>/we-vorlesung/ci/public/update_reiter" method="POST">
                    <h3>Reiter bearbeiten</h3>
                    <div class="form-group">
                        <input type="hidden" id="reiter_id_modal" name="reiter_id">
                        <label for="reiter_bezeichnung">Bezeichnung des Reiters</label>
                        <input type="text" class="form-control" id="reiter_name_modal" name="reiter_name">
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="reiter_beschreibung">Beschreibung</label>
                        <textarea class="form-control" rows="3" id="reiter_beschreibung_modal" name="beschreibung"></textarea>
                        <br>
                    </div>
                    <div class="d-inline">
                        <input type="submit" class="btn btn-success btn-sm" value="Speichern">
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
        <p>Bist du sicher, dass du den Reiter <strong id="item_name"></strong> löschen möchtest?</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="<?php echo base_url() ?>/edit_reiter">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
            <button name="delete_btn" id="delete_button" type="submit" class="btn btn-danger">Löschen</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    function fill_edit_modal(button_id) {
        reiter_name = document.getElementById(button_id + "_name").innerHTML;
        beschreibung = document.getElementById(button_id + "_beschreibung").innerHTML;

        document.getElementById("reiter_id_modal").value = button_id;
        document.getElementById("reiter_name_modal").value = reiter_name;
        document.getElementById("reiter_beschreibung_modal").innerHTML = beschreibung;
    }

    function fill_delete_modal(item_id) {
        document.getElementById("delete_button").value = item_id;
        document.getElementById("item_name").innerHTML = document.getElementById(item_id + "_name").innerHTML;
    }
</script>
</body>
</html>


