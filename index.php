<?php
session_id();
session_start();
//On definit le titre
$titrePrincipal = "Accueil";

$nav_en_cours = 'Index';


// On inclut le header
@include_once "includes/header.php";
// On inclut la navbar
@include_once "includes/navbar.php";


//On écrit le contenu de la page
?>


<section>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 col-sm-10">
        <img class="background ms-9 w-50 h-100" src="./photos/table.jpg" alt="table de restaurant">
      </div>
      <div class="home text-sm-center text-xs-center item">
        <h1 class="h1-index text-md-end text-sm-center me-8">Du mardi au samedi:</h1>
        <h1 class="h1-index2 text-md-end text-sm-center me-8">De 12h à 15h et 19h à 22h</h1>
        <button type="button" class="btn btn-danger mx-auto ms-9 p-3 mb-5"><a href="reservation.php" class="btn-contact">Reserver une table</a></button>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-4 col-md-5 item mt-6 ">
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="photos/boeuf.jpg" class="d-block w-100" alt="boeuf">
            </div>
            <div class="carousel-item">
              <img src="photos/cochon.jpg" class="d-block w-100" alt="cochon">
            </div>
            <div class="carousel-item">
              <img src="photos/tartare.jpg" class="d-block w-100" alt="tartare">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>

      <div class="col-sm-4 col-md-5 item">
        <h2 class="title-section p-4 border-top border-start border-danger mt-6" id="A_propos">Le mot du chef...</h2>
        <p class="text-home ps-4">At vero eos et accusamus et iusto odio dignissimos ducimus</p>
        <p class="text-home  ps-4">qui blanditiis praesentium voluptatum deleniti atque corrupti quos</p>
        <p class="text-home  ps-4">dolores et quas molestias excepturi sint occaecati cupiditate non provident.</p>
        <p class="text-home ps-4">Est eaque nemo et molestiae ullam qui quia similique. Vel maxime omnis aut earum.</p>

      </div>
    </div>
  </div>
  </div>
  </div>
</section>

<--! GALERIE PHOTO MODIFIABLE -->
  <?php

  //ON va chercher les images dans la base
  //On se connecte à la base
  require "includes/connect.php";

  //On écrit la requête
  $sql = "SELECT image FROM galerie";

  //On execute la requête
  $requete = $db->query($sql);

  //On recupère les données
  $images = $requete->fetchAll();
  $chemin = "/uploads/" . $images;
  //$newfilename = __DIR__ . "/uploads/$newname.$extension";


  //On écrit le contenu de la page

  ?>

  <h1 class="galerie text-warning text-center pt-5 mb-5">Galerie photo</h1>

  <section class="mb-6">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-8 col-sm-10">

          <?php
          var_dump($images); ?>


          <?php echo '<img src="uploads/' . $images["image"] . '"/>';

          ?>

          <?php echo '<img src="uploads/' . $images[0]["image"] . '"/>';

          ?>




        </div>
      </div>
    </div>


  </section>



  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-sm-4 col-md-5 item mt-6 ">
          <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="" class="d-block w-100" alt="">
              </div>
              <div class="carousel-item">
                <img src="" class="d-block w-100" alt="">
              </div>
              <div class="carousel-item">
                <img src="" class="d-block w-100" alt="">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
  </section>



  <section>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-12 col-sm-4">
          <img class="imgIndex mt-8 mb-6 border border-info" src="photos/restaurantvue.jpg" alt="restaurant">
        </div>
      </div>
    </div>
  </section>

  <?php
  // On inclut le footer
  @include_once "includes/footer.php";
  ?>