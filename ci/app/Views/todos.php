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
    <style>
        .dropbtn {
            background-color: #3385ff;
            color: white;
            padding: 5px;
            font-size: 10px;
            border: none;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            font-size: 10px;
            color: black;
            padding: 5px 5px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {background-color: #ddd;}

        .dropdown:hover .dropdown-content {display: block;}

        .dropdown:hover .dropbtn {background-color: #005ce6}
    </style>
</head>
<body>
<div class="container-fluid">
  <?php
  $name = "To Do";
  include "templates/header.php";
  ?>
    <div class="row mt-4 ml-2 mr-2">
        <div class="col-2">
            <?php //include 'templates/sidebar.php';?>
        </div>
        <div class="col-8">
            <?php include "templates/navbar.php"; ?>
            <div class="container">
                <div class="row justify-content-between">
                    <?php if (isset($reiter)): ?>
                    <?php foreach($reiter as $item):?>
                        <div class="col card">
                            <div class="card-header">
                                <div class="container" style="padding-left: 2px;">
                                    <div class="row">
                                        <div class="col-11"><strong><?php echo $item['name']; ?></strong></div>
                                        <div class="col-1"></div>
                                    </div>
                                </div>
                                
                            </div>
                            <?php
                                $aufgaben_model = new \App\Models\AufgabenModel();
                                $aufgaben_of_reiter = $aufgaben_model->get_aufgaben_of_reiter($item['id']);
                            ?>
                            <ul class="list-group">
                                <?php foreach($aufgaben_of_reiter as $aufgabe):?>
                                    <li class="list-group-item" style="padding-left: 2px; padding-right: 5px;">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-9"><?php echo $aufgabe['name']; ?></div>
                                                <div class="col-3">
                                                    <?php 
                                                        $mitglieder_model = new \App\Models\MitgliederModel();
                                                        $assigned_mitglieder = $aufgaben_model->get_assigned_mitglieder($aufgabe['id']);
                                                        echo("<div class=\"dropdown\">");
                                                        echo("<button class=\"dropbtn\">zuständig</button>");
                                                        echo("<div class=\"dropdown-content\">");
                                                        foreach ($assigned_mitglieder as $mitglied_id) {
                                                            echo("<a>");
                                                            echo($mitglieder_model->get_user($mitglied_id)['username']. " ");
                                                            echo("</a>");
                                                        }
                                                        echo("</div>");
                                                        echo("</div>");
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    <?php endforeach;?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>

</div>
</body>
</html>