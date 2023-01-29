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
<body>
<div class="container-fluid">
    <?php
    $name = "Aufgabe bearbeiten";
    include "templates/header.php";
    ?>
    <div class="row mt-4 ml-2 mr-2">
        <div class="col-4"></div>
        <div class="col-4">
            <form action="<?php base_url() ?>/we-vorlesung/ci/public/update_aufgabe" method="POST">
                <h3>Aufgabe bearbeiten</h3>
                <div class="form-group">
                    <input type="hidden" name="aufgaben_id" value="<?php echo $aufgabe['id'];?>">
                    <label for="aufgaben_bezeichnung">Aufgabenbezeichnung</label>
                    <input type="text" class="form-control" name="bezeichnung" value="<?php echo $aufgabe['name']?>">
                    <br>
                </div>
                <div class="form-group">
                    <label for="aufgaben_beschreibung">Beschreibung der Aufgabe</label>
                    <textarea class="form-control" rows="3" name="beschreibung"><?php echo $aufgabe['beschreibung']?></textarea>
                    <br>
                </div>
                <div class="form-group">
                    <label for="erstellungsdatum">Erstellungsdatum</label>
                    <input type="text" class="form-control" name="startdatum" value="<?php echo $aufgabe['erstellungsdatum']?>">
                    <br>
                </div>
                <div class="form-group">
                    <label for="enddatum">fällig bis:</label>
                    <input type="text" class="form-control" name="enddatum" value="<?php echo $aufgabe['faelligkeitsdatum']?>">
                    <br>
                </div>
                <div class="form-group">
                    <label>Zugehöriger Reiter</label>
                    <select class="form-select" name="reiter[]">
                    <?php foreach($reiter as $item):?>
                        <option value="<?php echo $item['id']?>" <?php if ($item['id'] == $aufgabe['reiter']){echo "selected";}?>>
                            <?php echo $item['name']?>
                        </option>
                    <?php endforeach;?>
                    </select>
                    <br>
                </div>
                <div class="form-group">
                    <?php 
                        $aufgaben_model = new App\Models\AufgabenModel();
                        $assigned_mitglieder = $aufgaben_model->get_assigned_mitglieder($aufgabe['id']);
                    ?>
                    <label>Zuständige Person</label>
                    <select class="form-select" name="mitglieder[]" multiple>
                    <?php foreach($mitglieder as $item):?>
                        <option value="<?php echo $item['id']?>" 
                        <?php 
                            foreach($assigned_mitglieder as $mitglied_id){
                                if (in_array($item['id'], $mitglied_id)){
                                    echo "selected";
                                    break;
                                }
                            }
                        ?>>
                        <?php echo $item['username']?>
                        </option>
                        <?php endforeach;?>
                    </select>
                    <br>
                </div>
                <div class="d-inline">
                    <input type="submit" value="Speichern" class="btn btn-success btn-sm">
                    <br>
                    <br>
                </div>
            </form>
        </div>
        <div class="col-4"></div>
    </div>
</div>
</body>
</html>



