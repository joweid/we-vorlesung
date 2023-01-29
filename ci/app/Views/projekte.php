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
    <div>
        <?php
        $name = "Projekte";
        include "templates/header.php";
        ?>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8"></div>
            <div class="col-2"></div>
        </div>
    </div>
    <div class="row mt-4 ml-2 mr-2">
        <div class="col-2">
            <?php 
                //include 'templates/sidebar.php'; 
            ?>
        </div>
        <div class="col-8">
            <?php include "templates/navbar.php"; ?>
            <form id="form1" action="<?php echo base_url() ?>/edit_projekt" method="post">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Projektname</th>
                        <th scope="col">Beschreibung</th>
                        <th scope="col">Ersteller</th>
                        <th scope="col">auswählen</th>
                        <th scope="col">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($projekte as $projekt):?>
                        <tr>
                            <td id="<?php echo ($projekt['id'] . "_name")?>"><?php echo $projekt['name']; ?></td>
                            <td id="<?php echo ($projekt['id'] . "_beschreibung")?>"><?php echo $projekt['beschreibung']?></td>
                            <td>
                                <?php
                                $mitglieder = new \App\Models\MitgliederModel();
                                $ersteller = $mitglieder->get_user($projekt['ersteller']);
                                echo $ersteller['username'];
                                ?>
                            </td>
                            <td>
                                <?php if(isset($_SESSION['chosen_projekt']) && $_SESSION['chosen_projekt'] == $projekt['id']): ?>
                                    <span class="badge badge-success bg-success">&#10003;</span>
                                <?php else: ?>
                                    <input type="checkbox" name="choose" value="<?php echo $projekt['id']?>" onchange="this.form.submit()">
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="no-border" type="button" value="<?php echo $projekt['id']?>" data-toggle="modal" data-target="#edit_projekt" onclick="fill_edit_modal(this.value)">
                                    <img width="18" height="18" src="edit_svg.svg">
                                </button>
                                <button class="no-border" type="button" value="<?php echo $projekt['id']?>" data-toggle="modal" data-target="#deleteModal" onclick="fill_delete_modal(this.value)">
                                    <img width="18" height="18" src="delete_svg.svg">
                                </button>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </form>
            <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#neues_projekt">+ neu</a>
        </div>
        <div class="col-2"></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="neues_projekt" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="<?php base_url() ?>/we-vorlesung/ci/public/create_projekt" method="post">
                    <h4>Projekt erstellen</h4>
                    <div class="form-group">
                        <label for="projekt_name">Projektname</label>
                        <input type="text" class="form-control" id="projekt_name" name="projekt_name" placeholder="Projekt">
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="beschreibung">Beschreibung</label>
                        <textarea class="form-control" rows="3" id="beschreibung" name="beschreibung" placeholder="Beschreibung"></textarea>
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
<div class="modal fade" id="edit_projekt" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="<?php echo base_url() ?>/update_projekt" method="post">
                    <h4>Projekt bearbeiten</h4>
                    <div class="form-group">
                        <label for="projekt_name">Projektname</label>
                        <input type="hidden" id="projekt_id_modal" name="projekt_id">
                        <input type="text" class="form-control" id="projekt_name_modal" name="projekt_name">
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="beschreibung">Beschreibung</label>
                        <textarea class="form-control" rows="3" id="beschreibung_modal" name="beschreibung"></textarea>
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
        <p>Bist du sicher, dass du das Projekt <strong id="item_name"></strong> löschen möchtest?</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="<?php echo base_url() ?>/edit_projekt">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
            <button name="delete_btn" id="delete_button" type="submit" class="btn btn-danger">Löschen</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    function fill_edit_modal(button_id) {
        projekt_name = document.getElementById(button_id + "_name").innerHTML;
        beschreibung = document.getElementById(button_id + "_beschreibung").innerHTML;

        document.getElementById("projekt_id_modal").value = button_id;
        document.getElementById("projekt_name_modal").value = projekt_name;
        document.getElementById("beschreibung_modal").innerHTML = beschreibung;
    }

    function fill_delete_modal(item_id) {
        document.getElementById("delete_button").value = item_id;
        document.getElementById("item_name").innerHTML = document.getElementById(item_id + "_name").innerHTML;
    }
</script>
</body>
</html>

