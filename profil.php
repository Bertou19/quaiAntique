<?php

session_start();

$nav_en_cours = 'profil';

$titrePrincipal  = "Profil";



//On inclut le header
include_once "includes/header.php";
include_once "includes/navbar.php";
//ON ecrit le contenu de la page

?>

<div class="container-fluid">
  <div class="row justify-content-center">

    <h1 class="profil-title text-center mt-6 text-danger ">Mon compte</h1>
    <p class="profil text-center text-danger mt-6">Nom: <?= $_SESSION["user"]["nom"] ?></p>
    <p class="profil text-center text-danger mt-2">Téléphone: <?= $_SESSION["user"]["telephone"] ?></p>
    <p class="profil text-center text-danger mt-2">Adresse e-mail: <?= $_SESSION["user"]["email"] ?></p>
    <p class="profil text-center text-danger mt-2">Nombre de convives (par defaut): <?= $_SESSION["user"]["nb_convives"] ?></p>
    <p class="profil text-center text-danger mt-2">Allergies: <?php if ($_SESSION["user"]["allergie_oeufs"] == 1) {
                                                                echo "Oeufs";
                                                              }
                                                              if ($_SESSION["user"]["allergie_crustaces"] == 1) {
                                                                echo "Crustacés";
                                                              }
                                                              if ($_SESSION["user"]["allergie_arachides"] == 1) {
                                                                echo "Arachides";
                                                              }
                                                              if ($_SESSION["user"]["allergie_ble"] == 1) {
                                                                echo "Blé";
                                                              }
                                                              if ($_SESSION["user"]["allergie_lait"] == 1) {
                                                                echo "Lait";
                                                              }
                                                              ?></p>


    <a href="reservation.php#reservee" class="profil text-center text-info text-decoration-none mt-5 mb-6">
      Reserver une table ? </a>
    <p class="text-center text-secondary"></p>
    <img class="img-profil text-center w-25 h-50 position-absolute opacity-25" src="photos/cuillere.png" alt="cuillere">
  </div>
</div>

<?php
// On inclut le footer
@include_once "includes/footer.php";
?>