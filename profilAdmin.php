<?php
session_id();
session_start();

$nav_en_cours = 'profilAdmin';

$title = "Profil admin";
//On inclut le header
include_once "includes/header.php";
include_once "includes/navbar.php";
//ON ecrit le contenu de la page

?>

<div class="container-fluid">
  <div class="row justify-content-center">

    <h1 class="profil-title text-center mt-6 text-danger ">Compte administrateur</h1>
    <p class="profil text-center text-danger mt-4">Adresse e-mail: <?= $_SESSION["admin"]["email"] ?></p>

    <p class="profil text-center text-danger mt-2">
      <a href="gestionCarteEtMenus.php" class="profil text-center text-info text-decoration-none mt-4 mb-5">
        Gestion de la carte et des menus</a>
      <a href="gestionGalerie.php" class="nav-link text-info">Gestion de la galerie</a>
      <a href="gestionHoraires.php" class="nav-link text-info">Gestion des horaires</a>
    <p class="text-center text-secondary"></p>
    <img class="img-profil text-center w-25 h-25" src="photos/cuillere.png" alt="cuillere">
  </div>
</div>
<?php
// On inclut le footer
@include_once "includes/footer.php";
?>