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
    $name = "Login";
    include "templates/header.php";
    ?>
    <div class="row mt-4 ml-2 mr-2">
        <div class="col-4"></div>
        <div class="col-4">
            <form class="mt-4" action="<?php echo base_url() ?>/login_user" method="post">
                <div class="form-group">
                    <label for="usernameInput">Username</label>
                    <?php if (isset($errors['username'])):?>
                        <input type="text" class="form-control is-invalid" id="usernameInput" name="username" placeholder="Enter your username">
                        <div class="invalid-feedback"><?php echo $errors['username']; ?></div>
                    <?php else: ?>
                        <input type="text" class="form-control" id="usernameInput" name="username" placeholder="Enter your username">
                    <?php endif;?>
                </div>
                <br>
                <div class="form-group">
                    <label for="password">Passwort</label>
                    <?php if (isset($errors['passwort'])):?>
                        <input type="password" class="form-control is-invalid" id="password" name="passwort" placeholder="Passwort">
                        <div class="invalid-feedback"><?php echo $errors['passwort']; ?></div>
                    <?php else: ?>
                        <input type="password" class="form-control" id="password" name="passwort" placeholder="Passwort">
                    <?php endif;?>
                </div>
                <br>
                <div class="d-inline mb-3">
                    <?php if (isset($errors['agb'])):?>
                        <input type="checkbox" class="is-invalid" id="agb" name="agb">
                        <label for="agb">AGBs und Datenschutzbedingungen akzeptieren</label>
                        <label class="invalid-feedback"><?php echo $errors['agb']; ?></label>
                    <?php else: ?>
                        <input type="checkbox" id="agb" name="agb" checked>
                        <label for="agb">AGBs und Datenschutzbedingungen akzeptieren</label>
                    <?php endif;?>
                    <br><br>
                </div>
                <input type="submit" class="btn btn-primary font-weight-bold" value="Einloggen">
            </form>
            <div class="d-inline">
                <small>Noch nicht registriert?</small>
                <small><a class="text-decoration-none" href="#">Registrierung</a></small>
            </div>
        </div>
        <div class="col-4"></div>
    </div>
</div>
</body>
</html>
