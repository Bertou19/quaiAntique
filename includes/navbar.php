<body onload="afficheDate();">

  <nav class="navbar navbar-expand-lg bg-success p-5">
    <div class="container-fluid">
      <a href="index.php" class="navbar-brand p-0 me-0">

        <h2 class="navbarTitle">Quai Antique</h2>

      </a>
      <button class="navbar-toggler navbar-toggler-right text-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
        </svg>
      </button>

      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

        <div class="offcanvas-header">

          <h5 class="offcanvas-title mt-2" id="offcanvasNavbarLabel">Quai Antique</h5>
          <h3 class="offcanvasSecondTitle position-absolute mt-9 ms-7 text-success mb-7">Restaurant gastronomique</h3>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li <?php if ($nav_en_cours == 'CarteEtMenus') {
                  echo 'id = "en_cours"';
                } ?> class="nav-item">
              <a href="carteEtMenus.php" class="nav-link text-info">Carte</a>
            </li>

            <?php if (isset($_SESSION["admin"])) : ?>
              <li <?php if ($nav_en_cours == 'profilAdmin') {
                    echo 'id = "en_cours"';
                  } ?> class="nav-item">
                <a href="profilAdmin.php" class="nav-link ">Compte admin</a>
              </li>

            <?php else : ?>

              <li <?php if ($nav_en_cours == 'Contact') {
                    echo 'id = "en_cours"';
                  } ?> class="nav-item">
                <a href="contact.php" class="nav-link text-info ">Contact</a>
              </li>
              <li <?php if ($nav_en_cours == 'reservation') {
                    echo 'id = "en_cours"';
                  } ?> class="nav-item">
                <a href="reservation.php" class="nav-link text-danger ">Réserver</a>
              </li>

            <?php endif; ?>

            <?php if (isset($_SESSION["user"])) : ?>
              <li <?php if ($nav_en_cours == 'profil') {
                    echo 'id = "en_cours"';
                  } ?> class="nav-item">
                <a href="profil.php" class="nav-link ">Mon compte</a>
              </li>
            <?php endif; ?>

            <?php if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) : ?>

              <li class="nav-item" <?php if ($nav_en_cours == 'connexion') {
                                      echo 'id = "en_cours"';
                                    } ?>>
                <a href="connexion.php" class="nav-link text-info ">Se connecter</a>
              </li>
            <?php else : ?>

              <li class="nav-item" <?php if ($nav_en_cours == 'deconnexion') {
                                      echo 'id = "en_cours"';
                                    } ?>>
                <a href="deconnexion.php" class="nav-link text-info">Se deconnecter</a>
              </li>
            <?php endif; ?>

          </ul>
          <img class="chef-offcanvas d-lg-none" src="photos/chef.png" alt="chef">
        </div>
      </div>
    </div>
  </nav>