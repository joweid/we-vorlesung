<div class="mb-2">
<nav class="navbar navbar-expand-lg navbar-light bg-light mt-2 rounded" style="padding-left: 10px; padding-right: 10px">
  <a class="navbar-brand font-weight-bold" style="font-weight: bold">Aufgabenplaner</a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/we-vorlesung/ci/public/projekte">Projekte</a>
      </li>
      <?php if(isset($_SESSION['chosen_projekt'])): ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php $projekt_model = new \App\Models\ProjektModel(); echo($projekt_model->get_projekt($_SESSION['chosen_projekt'])['name']); ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?php base_url() ?>/we-vorlesung/ci/public/todos">Aktuelles Projekt</a>
              <a class="dropdown-item" href="<?php base_url() ?>/we-vorlesung/ci/public/reiter">Reiter</a>
              <a class="dropdown-item" href="<?php base_url() ?>/we-vorlesung/ci/public/aufgaben">Aufgaben</a>
              <a class="dropdown-item" href="<?php base_url() ?>/we-vorlesung/ci/public/mitglieder">Mitglieder</a>
            </div>
        </li>
      <?php endif;?>
    </ul>
  </div>
  <a class="btn btn-sm btn-dark" style="font-weight: bold;" href="<?php base_url() ?>/we-vorlesung/ci/public/logout">Logout</a>
</nav>
</div>