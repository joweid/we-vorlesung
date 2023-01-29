<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="https://unpkg.com/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container-fluid">
    <?php

use Config\App;

    $name = "Mitglied bearbeiten";
    include "templates/header.php";
    ?>
    <div class="row mt-4 ml-2 mr-2">
        <div class="col-4"></div>
        <div class="col-4">
            <form action="<?php echo base_url() ?>/update_user" method="post">
                <h3>Bearbeiten</h3>
                <div class="form-group">
                    <label for="person_name">Username</label>
                    <input type="hidden" name="user_id" value="<?php echo $user['id']?>">
                    <input type="text" class="form-control" id="person_name" name="username" value="<?php echo $user['username']?>">
                    <br>
                </div>
                <div class="form-group">
                    <label for="person_email">E-Mail</label>
                    <input type="email" class="form-control" id="person_email" name="email" value="<?php echo $user['email']?>">
                    <br>
                </div>
                <div class="d-inline">
                    <?php $mitglieder_model = new \App\Models\MitgliederModel(); ?>
                    <input type="checkbox" class="form-check-input" name="in_projekt" <?php if ($mitglieder_model->in_projekt($user['id'], $_SESSION['chosen_projekt'])){ echo "checked";} ?>>
                    <label>dem Projekt <strong><?php $projekt_model = new \App\Models\ProjektModel(); echo($projekt_model->get_projekt($_SESSION['chosen_projekt'])['name']); ?></strong> zugeordnet</label>
                </div>
                <br>
                <br>
                <input class="btn btn-success btn-sm text-white" type="submit" value="Speichern">
            </form>
        </div>
        <div class="col-4"></div>
    </div>
</div>
</body>
</html>
