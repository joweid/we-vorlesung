<ul class="list-group">
    <li class="list-group-item list-group-item-action"><a class="text-decoration-none text-dark" href="/we-vorlesung/ci/public/">Login</a></li>
    <li class="list-group-item list-group-item-action"><a class="text-decoration-none <?php if($name!="Projekte"){echo("text-dark");} ?>" href="/we-vorlesung/ci/public/projekte">Projekte</a></li>
    <?php if(isset($_SESSION['chosen_projekt'])): ?>
    <li class="list-group-item list-group-item-action"><a class="text-decoration-none <?php if($name!="To Do"){echo("text-dark");} ?>" href="/we-vorlesung/ci/public/todos"><?php $projekt_model = new \App\Models\ProjektModel(); echo($projekt_model->get_projekt($_SESSION['chosen_projekt'])['name']); ?></a></li>
    <?php endif; ?>
    <?php if(isset($_SESSION['chosen_projekt'])): ?>
        <li class="list-group-item-action list-group-item w-75" style="margin-left: 25%"><a class="text-decoration-none <?php if($name!="Reiter"){echo("text-dark");} ?>" href="/we-vorlesung/ci/public/reiter">Reiter</a></li>
    <?php endif; ?>
    <?php if(isset($_SESSION['chosen_projekt'])): ?>
        <li class="list-group-item-action list-group-item w-75" style="margin-left: 25%"><a class="text-decoration-none <?php if($name!="Aufgaben"){echo("text-dark");} ?>" href="/we-vorlesung/ci/public/aufgaben">Aufgaben</a></li>
    <?php endif; ?>
    <?php if(isset($_SESSION['chosen_projekt'])): ?>
        <li class="list-group-item-action list-group-item w-75" style="margin-left: 25%"><a class="text-decoration-none <?php if($name!="Mitglieder"){echo("text-dark");} ?>" href="/we-vorlesung/ci/public/mitglieder">Mitglieder</a></li>
    <?php endif; ?>
</ul>
