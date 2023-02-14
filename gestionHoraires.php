<?php


session_start();
//On definit le titre
$titrePrincipal = "Gestion des horaires";

$nav_en_cours = 'gestionHoraires';
//On vérifie si le formulaire a été envoyé
if (!empty($_POST)) {
  //Le formulaire a été envoyé
  //On vérifie que TOUS les champs sont remplis

  if (
    isset(
      $_POST["jour"],
      $_POST["heure_debut_midi"],
      $_POST["heure_fin_midi"],
      $_POST["heure_debut_soir"],
      $_POST["heure_fin_soir"]
    )
    && !empty($_POST["jour"])
  ) {
    //Le formulaire est complet

    $jour = ($_POST["jour"]);
    $heure_debut_midi = ($_POST["heure_debut_midi"]);
    $heure_fin_midi = ($_POST["heure_fin_midi"]);
    $heure_debut_soir = ($_POST["heure_debut_soir"]);
    $heure_fin_soir = ($_POST["heure_fin_soir"]);

    if ($_POST["fermeture"] ===  NULL) {
      $fermeture = 0;
    } else {
      ($fermeture = 1);
    }

    //On enregistre en bdd

    require_once "includes/connect.php";

    $sql = "UPDATE `horaires` SET `heure_debut_midi`=:heure_debut_midi,`heure_fin_midi`=:heure_fin_midi,`heure_debut_soir`=:heure_debut_soir,`heure_fin_soir`=:heure_fin_soir,`fermeture`=:fermeture WHERE `jour` = :jour";

    $query = $db->prepare($sql);

    $query->bindValue(":jour", $jour, PDO::PARAM_STR);
    $query->bindValue(":heure_debut_midi", $heure_debut_midi, PDO::PARAM_STR);
    $query->bindValue(":heure_fin_midi", $heure_fin_midi, PDO::PARAM_STR);
    $query->bindValue(":heure_debut_soir", $heure_debut_soir, PDO::PARAM_STR);
    $query->bindValue(":heure_fin_soir", $heure_fin_soir, PDO::PARAM_STR);
    $query->bindValue(":fermeture", $fermeture, PDO::PARAM_BOOL);


    if (!$query->execute()) {
      $_SESSION["error"] = [];
      $_SESSION["error"] = ["Une erreur s'est produite !"];
    }
  }
}

//On inclut le header
include "includes/header.php";

//On inclut la navbar
include_once "includes/navbar.php";

//On écrit le contenu de la page

?>
<div class="container-fluid">
  <div class="row justify-content-center">

    <h1 class="inscription-title text-center pt-5">Gestion des horaires</h1>
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
          <div class="col-auto">
            <select class="form-select text-secondary mt-5" id="autoSizingSelect" name="jour">
              <option selected>Jour de la semaine</option>
              <option value="Lundi">Lundi</option>
              <option value="Mardi">Mardi</option>
              <option value="Mercredi">Mercredi</option>
              <option value="Jeudi">Jeudi</option>
              <option value="Vendredi">Vendredi</option>
              <option value="Samedi">Samedi</option>
              <option value="Dimanche">Dimanche</option>
            </select>
          </div>
        </div>
        <div class="m-4 ">
          <p class="text-info">De :</p>
          <select class="form-select text-secondary" name="heure_debut_midi" aria-label="Default select example">

            <option selected>Selectionnez une heure de début pour le service de midi</option>
            <option value="Fermé">Fermé</option>
            <option value="11h45">11h45</option>
            <option value="12h">12h</option>
            <option value="12h15">12h15</option>
            <option value="12h30">12h30</option>
          </select>
        </div>

        <div class="m-4 ">
          <p class="text-info">À :</p>
          <select class="form-select text-secondary" name="heure_fin_midi" aria-label="Default select example">
            <option selected>Selectionnez une heure de fin pour le service de midi</option>
            <option value="Fermé">Fermé</option>
            <option value="14h30">14h30</option>
            <option value="14h45">14h45</option>
            <option value="15h">15h</option>
            <option value="15h15">15h15</option>
            <option value="15h30">15h30</option>
          </select>
        </div>
        <div class="m-4 ">
          <p class="text-info">Et de :</p>
          <select class="form-select text-secondary" name="heure_debut_soir" aria-label="Default select example">
            <option selected>Selectionnez une heure de début pour le service du soir</option>
            <option value="Fermé">Fermé</option>
            <option value="18h30">18h30</option>
            <option value="18h45">18h45</option>
            <option value="19h">19h</option>
            <option value="19h15">19h15</option>
            <option value="19h30">19h30</option>
          </select>
        </div>
        <div class="m-4 ">
          <p class="text-info">À :</p>
          <select class="form-select text-secondary" name="heure_fin_soir" aria-label="Default select example">
            <option selected>Selectionnez une heure de fin pour le service du soir</option>
            <option value="Fermé">Fermé</option>
            <option value="21h30">21h30</option>
            <option value="22h">22h</option>
            <option value="22h15">22h15</option>
            <option value="22h30">22h30</option>

          </select>
        </div>
        <div class="form text-center text-secondary form-check">
          <input class="form-check-input" name="fermeture" type="checkbox" id="gridCheck" value="1">
          <label class="form-check-label" for="gridCheck">
            Jour de fermeture
          </label>
          <p>(Ce jour sera marqué comme fermé.)</p>
        </div>

        <div class="text-center pt-5">
          <button type="submit" class="button btn btn-danger text-light mb-7" value="ajouter">Ajouter un horaire</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
//ON va chercher les horaires dans la base
//On se connecte à la base
require "includes/connect.php";

//On écrit la requête
$sql = "SELECT * FROM horaires";

//On execute la requête
$requete = $db->query($sql);

//On recupère les données
$horaires = $requete->fetchAll();


//On écrit le contenu de la page

?>

<h1 class="titleListPatients text-warning text-center pt-5 mb-5">Horaires</h1>

<section class="mb-6">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8 col-sm-10 table-responsive">
        <table class="table table-warning table-striped">
          <thead>
            <tr>
              <th></th>
              <th scope="col p-2" class="text-danger text-center ">Jour</th>
              <th scope="col p-2" class="text-danger text-center">Heure de début midi</th>
              <th scope="col p-2" class="text-danger text-center">Heure de fin midi</th>
              <th scope="col p-2" class="text-danger text-center">Heure de début soir</th>
              <th scope="col p-2" class="text-danger text-center">Heure de fin soir</th>
              <th scope="col p-2" class="text-danger text-center"></th>
            </tr>
          </thead>
          <?php foreach ($horaires as $horaire) : ?>
            <tbody>
              <tr>
                <th scope="row"></th>
                <td class="text-center"><?= strip_tags($horaire["jour"]) ?></td>
                <td class="text-center"><?= strip_tags($horaire["heure_debut_midi"]) ?></td>
                <td class="text-center"><?= strip_tags($horaire["heure_fin_midi"]) ?></td>
                <td class="text-center"><?= strip_tags($horaire["heure_debut_soir"]) ?></td>
                <td class="text-center"><?= strip_tags($horaire["heure_fin_soir"]) ?></td>
                <td class="text-center"><?php if ($horaire["fermeture"] == 1) {
                                          echo "Fermé";
                                        }
                                        ?></td>
              </tr>
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