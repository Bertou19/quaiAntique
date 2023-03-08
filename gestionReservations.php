<?php
session_start();
//On definit le titre
$titrePrincipal = "Gestion des réservations";

$nav_en_cours = 'profilAdmin';

//On vérifie si le formulaire a été envoyé
if (!empty($_POST)) {
  //Le formulaire a été envoyé
  //On vérifie que TOUS les champs sont remplis
  if (
    isset(
      $_POST["nb_convives_max"]

    )
    && !empty($_POST["nb_convives_max"])
  ) {
    //Le formulaire est complet

    $nb_convives_max = ($_POST["nb_convives_max"]);

    //On enregistre en bdd

    require_once "includes/connect.php";

    $sql = "UPDATE `tableRestaurant` SET `nb_convives_max`=:nb_convives_max";

    $query = $db->prepare($sql);

    $query->bindValue(":nb_convives_max", $nb_convives_max, PDO::PARAM_INT);

    if (!$query->execute()) {
      $_SESSION["error"] = [];
      $_SESSION["error"] = ["Une erreur s'est produite !"];
    } else {
      $_SESSION["success"] = [];
      $_SESSION["success"] = ["La mofification a été enregistrée avec succès!"];
    }
  }
}
//ON va chercher toutes les réservations dans la base
//On se connecte à la base
require "includes/connect.php";

//On écrit la requête
$sql = "SELECT * FROM `reservation` order by id_reservation";

//On execute la requête
$requete = $db->query($sql);

//On recupère les données
$reservations = $requete->fetchAll();

//ON va chercher toutes le nombre de convives max dans la base

//On écrit la requête
$sql = "SELECT * FROM `tableRestaurant`";

//On execute la requête
$requete = $db->query($sql);

//On recupère les données
$tableRestaurants = $requete->fetchAll();

//On met en place la possibilité de supprimer une reservation

if (isset($_POST["delete"])) {
  require_once "includes/connect.php";
  $id = $_POST["id"];

  $sql = "DELETE FROM `reservation` WHERE `reservation`.id_reservation = $id";

  $query = $db->prepare($sql);
  $query->execute();
  // recharger le tableau
  header("Refresh:0");
}

//On inclut le header
include_once "includes/header.php";
include_once "includes/navbar.php";
//ON ecrit le contenu de la page 

?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <h1 class="inscription-title text-center pt-5 mb-6">Gestion des réservations</h1>
    <div class="text-center">
      <?php
      if (isset($_SESSION["success"])) {
        foreach ($_SESSION["success"] as $message) {
      ?>
          <p><?= $message ?></p>
        <?php
        }
        unset($_SESSION["success"]);
      }
      if (isset($_SESSION["error"])) {
        foreach ($_SESSION["error"] as $message) {
        ?>
          <p><?= $message ?></p>
      <?php
        }
        unset($_SESSION["error"]);
      }
      ?>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-4 col-sm-6">
      <form class="" method="post">
        <div class="pt-2">
          <label for="exampleInput" class="form-label"></label>
          <input type="number" name="nb_convives_max" class="form-control" id="exampleInput" placeholder="Modifier le nombre de convives maximum" min="0" max="100">
        </div>
        <div class="text-center pt-5">
          <button type="submit" class="button btn btn-lg btn-danger text-light mb-4">Enregistrer</button>
        </div>
        <?php foreach ($tableRestaurants as $tableRestaurant) : ?>
          <p class="profil text-center text-danger mt-3">Seuil actuel: <?= strip_tags($tableRestaurant["nb_convives_max"]) ?></p>
        <?php endforeach; ?>
      </form>
    </div>
  </div>
</div>

<h1 class="title-reservation text-warning text-center pt-5 mb-5">Réservations enregistrées</h1>

<section class="mb-6">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8 col-sm-10 table-responsive">
        <table class="table table-warning table-striped">
          <thead>
            <tr>
              <th></th>
              <th scope="col p-2" class="text-danger text-center">Id</th>
              <th scope="col p-2" class="text-danger text-center">Nom</th>
              <th scope="col p-2" class="text-danger text-center">Téléphone</th>
              <th scope="col p-2" class="text-danger text-center">E-mail</th>
              <th scope="col p-2" class="text-danger text-center">Date</th>
              <th scope="col p-2" class="text-danger text-center">Service</th>
              <th scope="col p-2" class="text-danger text-center">Nombre de convives</th>
              <th scope="col p-2" class="text-danger text-center"></th>
            </tr>
          </thead>
          <?php foreach ($reservations as $reservation) : ?>
            <tbody>
              <form class="" method="post">
                <tr>
                  <th scope="row"></th>
                  <td class="text-center"><?= $reservation['id_reservation'] ?></td>
                  <td class="text-center"><?= $reservation["nom"] ?></td>
                  <td class="text-center"><?= $reservation["telephone"] ?></td>
                  <td class="text-center"><?= $reservation["email"] ?></td>
                  <td class="text-center"><?= $reservation["date"] ?></td>
                  <td class="text-center"><?= $reservation["service"] ?></td>
                  <td class="text-center"><?= $reservation["nb_convives"] ?></td>
                  <td class=" text-center">
                    <input type="hidden" name="id" value="<?php echo $reservation['id_reservation']; ?>" />
                    <input type="submit" name="delete" value="Supprimer" id="" class="btn btn-info" />
                  </td>
                </tr>
              </form>
            </tbody>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</section>

<?php
// On inclut le footer
@include_once "includes/footer.php";
?>