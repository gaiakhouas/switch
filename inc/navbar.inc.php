<?php // header eureka - Basedocs 11/04/2020 - GKH 
?>
<nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-white">
  <a class="navbar-brand" href="index.php"><strong>Switch</strong></a>
  <button id="navbar-toggler" class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    Menu <span id="navbar-toggler-icon" class="navbar-toggler-icon "></span>
  </button>
  <div class="collapse navbar-collapse" id="menu">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="">Qui sommes nous ?</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?action=contact">Contact</a>
      </li>
    </ul>
    <?= $room->headerChange(); ?>
  </div>
  <?php // $search->headerChange(); 
  ?>
</nav>