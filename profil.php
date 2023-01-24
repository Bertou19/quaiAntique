<?php
session_id();
session_start();

$nav_en_cours = 'profil';

$title = "Profil";
//On inclut le header
include_once "includes/header.php";
include_once "includes/navbar.php";
//ON ecrit le contenu de la page

?>

<div class="container-fluid">
  <div class="row justify-content-center">

    <h1 class="profil-title text-center mt-6 text-danger ">Mon compte</h1>
    <p class="profil text-center text-danger mt-4">Adresse e-mail: <?= $_SESSION["user"]["email"] ?></p>
    <p class="profil text-center text-danger mt-2">Nombre de convives (par defaut): <?= $_SESSION["user"]["nb_convives"] ?></p>
    <a href="reservation.php#reservee" class="profil text-center text-danger text-decoration-none mt-4 mb-5">
      Reserver une table ? </a>
    <p class="text-center text-secondary"></p>
    <img class="img-profil text-center w-25 h-25" src="photos/cuillere.png" alt="cuillere">
  </div>
</div>
<?php
// On inclut le footer
@include_once "includes/footer.php";
?>