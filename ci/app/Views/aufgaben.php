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
    $name = "Aufgaben";
    include "templates/header.php";
    ?>
    <div class="row mt-4 ml-2 mr-2">
        <div class="col-2">
            <?php //include 'templates/sidebar.php';?>
        </div>
        <div class="col-8">
            <?php include "templates/navbar.php"; ?>
            <form method="post" action="<?php echo base_url() ?>/edit_aufgabe">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Aufgabenbezeichnung</th>
                        <th scope="col">Beschreibung der Aufgabe</th>
                        <th scope="col">Reiter</th>
                        <th scope="col">zuständig</th>
                        <th scope="col">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($aufgaben as $item):?>
                        <tr>
                            <td id="<?php echo($item['id'] . "_name") ?>"><?= $item['name']?></td>
                            <td><?= $item['beschreibung'] ?></td>
                            <td>
                                <?php 
                                    $reiter_model = new App\Models\ReiterModel();
                                    if ($reiter_model->get_assigned_data()) {
                                        $reiter_name = $reiter_model->get_reiter_by_id($item['reiter'])['name'];
                                        echo $reiter_name;
                                    }
                                    
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $aufgaben_model = new App\Models\AufgabenModel();
                                    $mitglieder_model = new App\Models\MitgliederModel();
                                    $assigned_mitglieder = $aufgaben_model->get_assigned_mitglieder($item['id']);
                                ?>
                                <?php if (isset($assigned_mitglieder)):?>
                                    <?php foreach($assigned_mitglieder as $mitglieder_id):?>
                                        <a><?php 
                                            if ($mitglieder_model->get_user($mitglieder_id)) {
                                                echo $mitglieder_model->get_user($mitglieder_id)['username'];
                                            }
                                            ?>
                                            </a>
                                        <br>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <button class="no-border" name="edit_btn" type="submit" value="<?php echo $item['id']?>">
                                        <img width="18" height="18" src="edit_svg.svg">
                                    </button>
                                    <button class="no-border" type="button" value="<?php echo $item['id']?>" data-toggle="modal" data-target="#deleteModal" onclick="fill_delete_modal(this.value)">
                                        <img width="18" height="18" src="delete_svg.svg">
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </form>
            <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#neue_aufgabe">+ neu</a>
        </div>
        <div class="col-2"></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="neue_aufgabe" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="<?php base_url() ?>/we-vorlesung/ci/public/create_aufgabe" method="POST">
                    <h3>Aufgabe erstellen</h3>
                    <div class="form-group">
                        <label for="aufgaben_bezeichnung">Aufgabenbezeichnung</label>
                        <input type="text" class="form-control" id="aufgaben_bezeichnung" name="bezeichnung" placeholder="Aufgabe">
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="aufgaben_beschreibung">Beschreibung der Aufgabe</label>
                        <textarea class="form-control" rows="3" id="aufgaben_beschreibung" name="beschreibung"></textarea>
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="erstellungsdatum">Erstellungsdatum</label>
                        <input type="text" class="form-control" id="erstellungsdatum" name="startdatum" placeholder="YYYY-MM-DD">
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="enddatum">fällig bis:</label>
                        <input type="text" class="form-control" id="enddatum" name="enddatum" placeholder="YYYY-MM-DD">
                        <br>
                    </div>
                    <div class="form-group">
                        <label>Zugehöriger Reiter</label>
                        <select class="form-select" name="reiter[]">
                        <?php foreach($reiter as $item):?>
                            <option value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
                            <?php endforeach;?>
                        </select>
                        <br>
                    </div>
                    <div class="form-group">
                        <label>Zuständige Person</label>
                        <select class="form-select" name="mitglieder[]" multiple>
                        <?php foreach($mitglieder as $item):?>
                            <option value="<?php echo $item['id']?>"><?php echo $item['username']?></option>
                            <?php endforeach;?>
                        </select>
                        <br>
                    </div>
                    <div class="d-inline">
                        <input type="submit" value="Speichern" class="btn btn-primary btn-sm">
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
        <p>Bist du sicher, dass du die Aufgabe <strong id="item_name"></strong> löschen möchtest?</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="<?php echo base_url() ?>/edit_aufgabe">
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
        document.getElementById("item_name").innerHTML = document.getElementById(item_id + "_name").innerHTML;
    }
</script>
</body>
</html>



