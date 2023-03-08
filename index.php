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
      <div class=" col-12">
        <img class="background" src="./photos/dessertChocolat.jpg" alt="dessert">
      </div>
      <div class="home">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 text-center">
              <h1 class="h1-index me-8 text-lg-end text-md-center text-sm-center text-info">Et iusto odio dignissimos ducimus.</h1>
              <div class="col-md-6">
                <button type="button" class="btn-index btn btn-lg btn-danger ms-md-4 ms-lg-4 ms-sm-5 p-3 mb-3 shadow-lg"><a href="reservation.php" class="btn-contact">Reserver une table</a></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-4 col-md-7 item">
        <h2 class="title-section p-4 border-top border-start border-danger mt-6" id="A_propos">Une explosion en bouche !</h2>
        <p class="text-info ps-4">At vero eos et accusamus et iusto odio dignissimos ducimus</p>
        <p class="text-info  ps-4">qui blanditiis praesentium voluptatum deleniti atque corrupti quos</p>
        <p class="text-info  ps-4">dolores et quas molestias excepturi sint occaecati cupiditate non provident.</p>
        <p class="text-info ps-4 mb-4">Est eaque nemo et molestiae ullam qui quia similique. Vel maxime omnis aut earum.</p>
      </div>
</section>

<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-4 col-md-5 item mt-6 ">
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="photos/personnel.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="photos/restaurant.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="photos/plateau.jpg" class="d-block w-100" alt="...">
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
        <p class="text-info ps-4">At vero eos et accusamus et iusto odio dignissimos ducimus</p>
        <p class="text-info  ps-4">qui blanditiis praesentium voluptatum deleniti atque corrupti quos</p>
        <p class="text-info  ps-4">dolores et quas molestias excepturi sint occaecati cupiditate non provident.</p>
        <p class="text-info ps-4 mb-6">Est eaque nemo et molestiae ullam qui quia similique. Vel maxime omnis aut earum.</p>
      </div>
    </div>
  </div>
</section>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-sm-4 col-md-6 mt-4 ">
      <p class="text-galerie text-danger ps-4 mb-5">Des mets raffinés...</p>
    </div>
  </div>
</div>
<?php
//GALERIE PHOTO MODIFIABLE 

//ON va chercher les images dans la base
//On se connecte à la base
require "includes/connect.php";

//On écrit la requête
$sql = "SELECT * FROM galerie";

//On execute la requête
$requete = $db->query($sql);

//On recupère les données
$images = $requete->fetchAll();
$chemin = "/uploads/" . $images;
//$newfilename = __DIR__ . "/uploads/$newname.$extension";


//On écrit le contenu de la page

?>

<section>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 col-lg-12 images">
        <?php foreach ($images as $image) : ?>
          <?= '<div id="title-hover">' ?>
          <?= '<div class="col item images">'; ?>

          <?= '<img class="imgGalerie mt-4 border border-info" src="uploads/' . $image["image"] . '" title="' . $image["titre"] . '"/>' ?>
          <?= '</div>'; ?>
          <?= '</div>' ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="">
        <img class="etoiles ms-4 mb-12" src="./photos/etoilesJaunes.png" alt="etoiles">
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-10 text-center">
      <button type="button" class="btn btn-lg btn-danger ms-md-4 ms-lg-4 ms-sm-5 p-3 mb-3"><a href="reservation.php" class="btn-contact">Reserver une table</a></button>
    </div>
  </div>
</div>

<section>
  <div class="container">
    <div class="row justify-content-center">
</section>

<section>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-11 col-sm-4 text-center">
        <p class="text-img-resto ps-4 mb-5 mt-6 text-info">Est eaque nemo et molestiae ullam qui quia similique. Vel maxime omnis aut earum.</p>
        <img class="imgIndex  mb-6 ms-lg-10 border border-info" src="photos/restaurantvue.jpg" alt="restaurant">
      </div>
    </div>
  </div>
</section>

<?php
// On inclut le footer
@include_once "includes/footer.php";
?>