<?php
session_id();
session_start();

$nav_en_cours = 'CarteEtMenus';

//On definit le titre
$titrePrincipal = "Carte et menus";


//ON va chercher la carte dans la base

require_once "includes/connect.php";
//On écrit la requête
$sql = "SELECT * FROM carte";

//On execute la requête
$requete = $db->query($sql);

//On recupère les données
$cartes = $requete->fetchAll();
$chemin = "/uploads/" . $cartes[0];

// On inclut le header
@include_once "includes/header.php";
// On inclut la navbar
@include_once "includes/navbar.php";

?>




<section>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-sm-6 col-md-12">

        <?= '<embed width="1000" height="1000" class="carte mt-4 border border-info " src="uploads/' . $cartes[0]["nom_fichier"] . '"/>' ?>

      </div>
    </div>
  </div>
</section>

<?php

// On inclut le footer
@include_once "includes/footer.php";
?>