<?php
session_id();
session_start();

$nav_en_cours = 'reservation';

//On definit le titre
$titrePrincipal = "Réservation";

//On vérifie si le formulaire a été envoyé
if (!empty($_POST)) {
  //Le formulaire a été envoyé
  //On vérifie que TOUS les champs sont remplis

  if (
    isset(
      $_POST["nom"],
      $_POST["email"],
      $_POST["telephone"],
      $_POST["nb_convives"],
      $_POST["date"],
      $_POST["heure_midi"],
      $_POST["heure_soir"],
      $_POST["service"]
    )
    && !empty($_POST["email"]) && !empty($_POST["telephone"]) && !empty($_POST["nom"])
    && !empty($_POST["nb_convives"]) && !empty($_POST["date"]) && !empty($_POST["service"])
  ) {
    //Vérifier qu'il y ai au moins une heure séléctionnée
    if (empty($_POST["heure_midi"]) && empty($_POST["heure_soir"])) {
      $_SESSION["error"] = [];
      $_SESSION["error"] = ["Veuillez entrer au moins une heure !"];
    } else {

      //Le formulaire est complet

      // Vérifier que le mail est valide
      if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = [];
        $_SESSION["error"] = ["Veuillez entrer un email valide"];
      } else {

        // Vérifier que le numero de telephone fait au moins 10 caractères
        if (strlen($_POST["telephone"]) < 10) {
          $_SESSION["error"] = [];
          $_SESSION["error"] = ["Veuillez entrer un numero de téléphone d'au moins 10 chiffres"];
        } else {

          // Tout est bon , on enregistre les données du formulaire dans des variables
          $nom = ($_POST["nom"]);
          $email = ($_POST["email"]);
          $telephone = ($_POST["telephone"]);
          $nb_convives = ($_POST["nb_convives"]);
          $date = ($_POST["date"]);
          $service = ($_POST["service"]);
          $heure_midi = ($_POST["heure_midi"]);
          $heure_soir = ($_POST["heure_soir"]);
          $allergie_oeufs = ($_POST["allergie_oeufs"]);
          $allergie_lait = ($_POST["allergie_lait"]);
          $allergie_crustaces = ($_POST["allergie_crustaces"]);
          $allergie_arachides = ($_POST["allergie_arachides"]);
          $allergie_ble = ($_POST["allergie_ble"]);

          //On se connecte à la base de données pour vérifier le nombre de convives maximum autorisé
          require "includes/connect.php";

          //On écrit la requête
          $sql_convives_max = "SELECT `nb_convives_max` FROM `tableRestaurant`";

          //On execute la requête
          $requete = $db->query($sql_convives_max);

          //On recupère les données
          $nb_convives_max = $requete->fetchColumn();

          // On transforme le nombre récupéré dans le formulaire en int pour pouvoir le calculer
          $nb_convives = intval($nb_convives);
          //On vérifie que le nombre de convives séléctionné dans le formulaire ne dépasse pas le seuil autorisé
          if ($nb_convives_max <= $nb_convives) {
            $_SESSION["error"] = [];
            $_SESSION["error"] = ["Vous avez séléctionné un nombre trop important de convives pour ce service!"];
          } else {

            //On va chercher le nombre de convives actuel enregistré par rapport à la date et au service déjà enregistrés en bdd
            //POur cela on calcule le nb de convives en additionnant les lignes récupérées

            //On écrit la requête
            $sql = "SELECT SUM(nb_convives) FROM `reservation` WHERE `date`= '$date' AND `service`= '$service'";

            //On execute la requête
            $requete = $db->query($sql);

            //On recupère les données
            $nb_convives_of_date = $requete->fetchColumn();

            // On transforme le nombre récupéré dans la bdd en int pour pouvoir le calculer
            $nb_convives_of_date = intval($nb_convives_of_date);
            var_dump($nb_convives_of_date);

            //On additionne le nombre de convives en bdd et le nombre de convives entré dans le formulaire
            $nb_convives_of_date = $nb_convives_of_date + $nb_convives;

            //On vérifie qu'il y ai encore de la place pour le service et la date séléctionnée par rapport au nombre autorisé
            if ($nb_convives_of_date >= $nb_convives_max) {
              $_SESSION["error"] = [];
              $_SESSION["error"] = ["Il n'y a plus de tables disponibles pour ce service!"];
            } else {
              // Il y a de la place

              //On récupère l'id du "user" connecté
              $user = session_id();

              //On enregistre en bdd
              $sql_insert = "INSERT INTO `reservation` (`nom`,`email`,`telephone`,`nb_convives`,`date`,
                `heure_midi`,`heure_soir`,`service`,`allergie_ble`, `allergie_arachides`,
    `allergie_crustaces`,`allergie_oeufs`, `allergie_lait`, `user_id`) 
    VALUES (:nom,:email,:telephone,:nb_convives,:date,:heure_midi,:heure_soir,:service, :allergie_ble, 
    :allergie_arachides,:allergie_crustaces,:allergie_oeufs,:allergie_lait, '$user')";



              $query = $db->prepare($sql_insert);

              $query->bindValue(":nom", $nom, PDO::PARAM_STR);
              $query->bindValue(":email", $email, PDO::PARAM_STR);
              $query->bindValue(":telephone", $telephone, PDO::PARAM_STR);
              $query->bindValue(":nb_convives", $nb_convives, PDO::PARAM_STR);
              $query->bindValue(":date", $date, PDO::PARAM_STR);
              $query->bindValue(":heure_midi", $heure_midi, PDO::PARAM_STR);
              $query->bindValue(":heure_soir", $heure_soir, PDO::PARAM_STR);
              $query->bindValue(":service", $service, PDO::PARAM_STR);
              $query->bindValue(":allergie_oeufs", $allergie_oeufs, PDO::PARAM_BOOL);
              $query->bindValue(":allergie_lait", $allergie_lait, PDO::PARAM_BOOL);
              $query->bindValue(":allergie_crustaces", $allergie_crustaces, PDO::PARAM_BOOL);
              $query->bindValue(":allergie_arachides", $allergie_arachides, PDO::PARAM_BOOL);
              $query->bindValue(":allergie_ble", $allergie_ble, PDO::PARAM_BOOL);

              if (!$query->execute()) {
                $_SESSION["error"] = [];
                $_SESSION["error"] = ["Une erreur s'est produite !"];
              } else {
                $_SESSION["success"] = [];
                $_SESSION["success"] = ["Votre réservation a été enregistrée avec succès !"];
              }
            }
          }
        }
      }
    }
  }
}

// On inclut le header
@include_once "includes/header.php";
// On inclut la navbar
@include_once "includes/navbar.php";

//On écrit le contenu de la page
?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class=" col-6 ">
      <img class="background" src="./photos/table.jpg" alt="table de restaurant">
    </div>

    <div class="container-fluid">
      <div class="row justify-content-center">
        <h1 class="title-reservation text-center pt-5">Réservation</h1>
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

    <form class="" method="post" action="">
      <div class="container-fluid">
        <div class="row justify-content-center g-5">

          <div class="pt-2 col-md-3">
            <label for="nom" class="form-label"></label>
            <input type="text" class="form-control" aria-label="nom" name="nom" placeholder="Nom" value="<?php if ($_SESSION) {
                                                                                                            echo $_SESSION["user"]["nom"];
                                                                                                          } ?>" required>
          </div>

          <div class="pt-2 col-md-3">
            <label for="exampleInputEmail1" class="form-label"></label>
            <input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" aria-describedby="emailHelp" value="<?php if ($_SESSION) {
                                                                                                                                                    echo $_SESSION["user"]["email"];
                                                                                                                                                  } ?>">
          </div>

          <div class=" pt-2 col-md-3">
            <label for="exampleInputPassword1" class="form-label"></label>
            <input type="text" name="telephone" class="form-control" id="exampleInputPassword1" placeholder="Telephone" value="<?php if ($_SESSION) {
                                                                                                                                  echo $_SESSION["user"]["telephone"];
                                                                                                                                } ?>" required>
          </div>

          <div class="col-md-4">
            <p class="text-secondary text-center mt-3">Combien de convives?</p>
            <label for="exampleInput" class="form-label"></label>
            <input type="number" name="nb_convives" class="form-control" id="exampleInput" value="<?php if ($_SESSION) {
                                                                                                    echo $_SESSION["user"]["nb_convives"];
                                                                                                  } else {
                                                                                                    echo "1";
                                                                                                  } ?>" min="1" max="50" required>
          </div>
          <p class="text-secondary text-center mt-6">Choisissez la date, le service et une heure</p>
          <p class="text-secondary text-center mt-2">(Attention nous sommes fermés les dimanches et lundis)</p>

          <div class="col-md-2">
            <label for="formDate" class="form-label text-secondary"></label>
            <input class="form-control text-secondary mt-4" type="date" value="" min="<?= date('Y-m-d'); ?>" id="dateDuJour" max="2023-07-20" name="date" required>
          </div>


          <div class="col-md-2 ">
            <select class="form-select text-secondary mt-5" id="autoSizingSelect" name="service" onchange="handleChange(this)">
              <option value="midi" data-id="#midi">Midi</option>
              <option value="soir" data-id="#soir">Soir</option>
            </select>
          </div>
          <div class="col-md-2 block ">
            <p class="text-secondary text-center mt-2">Heure midi</p>

            <select class=" form-select text-secondary" id="midi" name="heure_midi">
              <option value=""></option>
              <option value="12:00">12:00</option>
              <option value="12:15">12:15</option>
              <option value="12:30">12:30</option>
              <option value="12:45">12:45</option>
              <option value="13:00">13:00</option>
              <option value="13:15">13:15</option>
              <option value="13:30">13:30</option>
              <option value="13:45">13:45</option>
              <option value="14:00">14:00</option>
            </select>
          </div>

          <div class="col-md-2 block hidden">
            <p class="text-secondary text-center mt-2">Heure soir</p>

            <select class="form-select text-secondary" id="soir" name="heure_soir">
              <option value=""></option>
              <option value="19:00">19:00</option>
              <option value="19:15">19:15</option>
              <option value="19:30">19:30</option>
              <option value="19:45">19:45</option>
              <option value="19:00">20:00</option>
              <option value="20:15">20:15</option>
              <option value="20:30">20:30</option>
              <option value="20:45">20:45</option>
              <option value="21:00">21:00</option>
            </select>
          </div>

          <p class="text-secondary text-center mt-6">Les personnes conviées présentent-elles des allergies?</p>

          <div class="col-auto text-secondary form-check">
            <input class="form-check-input" name="allergie_oeufs" type="checkbox" id="gridCheck" value="1" <?php if ($_SESSION["user"]["allergie_oeufs"] == 1) { ?> checked<?php } ?>>
            <label class="form-check-label" for="gridCheck">
              Oeufs
            </label>
          </div>
          <div class="col-auto text-secondary form-check ">
            <input class="form-check-input" name="allergie_arachides" type="checkbox" id="gridCheck" value="1" <?php if ($_SESSION["user"]["allergie_arachides"] == 1) { ?> checked<?php } ?>>
            <label class="form-check-label" for="gridCheck">
              Arachides
            </label>
          </div>
          <div class="col-auto text-secondary form-check ">
            <input class="form-check-input" name="allergie_lait" type="checkbox" id="gridCheck" value="1" <?php if ($_SESSION["user"]["allergie_lait"] == 1) { ?> checked<?php } ?>>
            <label class="form-check-label" for="gridCheck">
              Lait
            </label>
          </div>
          <div class="col-auto text-secondary form-check ">
            <input class="form-check-input" name="allergie_crustaces" type="checkbox" id="gridCheck" value="1" <?php if ($_SESSION["user"]["allergie_crustaces"] == 1) { ?> checked<?php } ?>>
            <label class="form-check-label" for="gridCheck">
              Crustacés
            </label>
          </div>
          <div class="col-auto text-secondary form-check mb-4">
            <input class="form-check-input" name="allergie_ble" type="checkbox" id="gridCheck" value="1" <?php if ($_SESSION["user"]["allergie_ble"] == 1) { ?> checked<?php } ?>>
            <label class="form-check-label" for="gridCheck">
              Blé
            </label>
          </div>
          <div class="text-center pt-5">
            <button type="submit" class="button btn btn-lg btn-danger text-light mb-5 p-2" value="reserver">Réserver</button>
          </div>
        </div>
      </div>
    </form>
  </div>


  <?php

  // On inclut le footer
  @include_once "includes/footer.php";
  ?>