<?php

session_id();
session_start();

$nav_en_cours = 'inscription';

//On vérifie si le formulaire a été envoyé
if (!empty($_POST)) {
  //Le formulaire a été envoyé
  //On vérifie que TOUS les champs sont remplis
  if (
    isset($_POST["nom"], $_POST["telephone"], $_POST["email"], $_POST["password"], $_POST["nb_convives"])
    && !empty($_POST["telephone"]) && !empty($_POST["nom"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["nb_convives"])
  ) {
    //Le formulaire est complet
    // On récupère les données en les protégeant
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $_SESSION["error"] = [];
      $_SESSION["error"] = ["Veuillez entrer un email valide"];
    } else {
      // Vérifier que le mot de passe fait au moins 8 caractères
      if (strlen($_POST["password"]) < 8) {
        $_SESSION["error"] = [];
        $_SESSION["error"] = ["Veuillez entrer un mot de passe d'au moins 8 caractères"];
      } else {

        if (strlen($_POST["telephone"]) < 10) {
          $_SESSION["error"] = [];
          $_SESSION["error"] = ["Veuillez entrer un numero de téléphone d'au moins 10 chiffres"];
        } else {

          // Verifier si l'adresse mail existe déjà en bdd

          require_once "includes/connect.php";

          $email = ($_POST["email"]);
          $sql = "SELECT * FROM user WHERE email='$email'";
          $query = $db->prepare($sql);
          $query->execute();
          $user = $query->fetch();
          if ($user) {
            //L'adresse email existe :
            $_SESSION["error"] = [];
            $_SESSION["error"] = ["Veuillez choisir une autre adresse mail"];
          } else {
            //L'adresse email n'existe pas 

            //On va hasher le mot de passe
            $password = password_hash($_POST["password"], PASSWORD_ARGON2ID);
            $nom = ($_POST["nom"]);
            $telephone = ($_POST["telephone"]);
            $allergie_oeufs = ($_POST["allergie_oeufs"]);
            $allergie_lait = ($_POST["allergie_lait"]);
            $allergie_crustaces = ($_POST["allergie_crustaces"]);
            $allergie_arachides = ($_POST["allergie_arachides"]);
            $allergie_ble = ($_POST["allergie_ble"]);
            $nb_convives = ($_POST["nb_convives"]);

            //On enregistre en bdd
            require_once "includes/connect.php";


            $sql = "INSERT INTO user (`nom`,`email`,`telephone`,`password`, `roles`, `allergie_ble`, `allergie_arachides`,`allergie_crustaces`,`allergie_oeufs`, `allergie_lait`, `nb_convives`) VALUES
(:nom,:email,:telephone, '$password','user', :allergie_ble, :allergie_arachides,:allergie_crustaces,:allergie_oeufs,:allergie_lait,:nb_convives)";

            $query = $db->prepare($sql);

            $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
            $query->bindValue(":nom", $nom, PDO::PARAM_STR);
            $query->bindValue(":telephone", $telephone, PDO::PARAM_STR);
            $query->bindValue(":allergie_oeufs", $allergie_oeufs, PDO::PARAM_BOOL);
            $query->bindValue(":allergie_lait", $allergie_lait, PDO::PARAM_BOOL);
            $query->bindValue(":allergie_crustaces", $allergie_crustaces, PDO::PARAM_BOOL);
            $query->bindValue(":allergie_arachides", $allergie_arachides, PDO::PARAM_BOOL);
            $query->bindValue(":allergie_ble", $allergie_ble, PDO::PARAM_BOOL);
            $query->bindValue(":nb_convives", $nb_convives, PDO::PARAM_INT);

            if ($query->execute()) {
              $_SESSION["success"] = [];
              $_SESSION["success"] = ["Vous vous êtes inscrit(e) avec succès !"];

              //On recupère l'id de l'utilisateur
              $id = $db->lastInsertId();

              //On connectera l'utilisateur

              $_SESSION["user"] = [
                "id" => $id,
                "nom" => $_POST["nom"],
                "email" => $_POST["email"],
                "telephone" => $user["telephone"],
                "roles" => "user",
                "allergie_oeufs" => $_POST["allergie_oeufs"],
                "allergie_lait" => $_POST["allergie_lait"],
                "allergie_crustaces" => $_POST["allergie_crustaces"],
                "allergie_arachides" => $_POST["allergie_arachides"],
                "allergie_ble" => $_POST["allergie_ble"],
                "nb_convives" => $_POST["nb_convives"]
              ];

              //On redirige vers la page de profil
              header("Location: profil.php");
            }
          }
        }
      }
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

    <h1 class="inscription-title text-center pt-5">M'inscrire</h1>
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
          <label for="nom" class="form-label"></label>
          <input type="text" class="form-control" placeholder="Nom" aria-label="nom" name="nom">
        </div>
        <div class="pt-2">
          <label for="exampleInputEmail1" class="form-label"></label>
          <input type="text" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
        </div>
        <div class="w-50 w-2 pt-2">
          <label for="exampleInputPassword1" class="form-label"></label>
          <input type="text" name="telephone" class="form-control" id="exampleInputPassword1" placeholder="Telephone" required>
          <div class="w-50 w-2 pt-2">
            <label for="exampleInputPassword1" class="form-label"></label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe">
          </div>
          <div class="form text-secondary m-4">
            <label for="exampleFormControlInput1" class="form-label">Avez-vous des allergies?</label>
            <div class="form text-secondary form-check form-check-inline">
              <input class="form-check-input" name="allergie_oeufs" type="checkbox" id="gridCheck" value="1">
              <label class="form-check-label" for="gridCheck">
                Oeufs
              </label>
            </div>
            <div class="form text-secondary form-check form-check-inline">
              <input class="form-check-input" name="allergie_arachides" type="checkbox" id="gridCheck" value="1">
              <label class="form-check-label" for="gridCheck">
                Arachides
              </label>
            </div>
            <div class="form text-secondary form-check form-check-inline">
              <input class="form-check-input" name="allergie_lait" type="checkbox" id="gridCheck" value="1">
              <label class="form-check-label" for="gridCheck">
                Lait
              </label>
            </div>
            <div class="form text-secondary form-check form-check-inline">
              <input class="form-check-input" name="allergie_crustaces" type="checkbox" id="gridCheck" value="1">
              <label class="form-check-label" for="gridCheck">
                Crustacés
              </label>
            </div>
            <div class="form text-secondary form-check form-check-inline">
              <input class="form-check-input" name="allergie_ble" type="checkbox" id="gridCheck" value="1">
              <label class="form-check-label" for="gridCheck">
                Blé
              </label>
            </div>
            <div class="m-4 ">
              <select class="form-select text-secondary" name="nb_convives" aria-label="Default select example">
                <option selected>Selectionnez le nombre de convives</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
              </select>
              <p class="parenthese text-secondary text-center m-2">(Il vous sera attribué par defaut)</p>
            </div>
            <div class="text-center pt-5">
              <button type="submit" class="button btn btn-lg btn-danger text-light mb-7">Inscription</button>
            </div>
      </form>
    </div>
  </div>
</div>

<?php
// On inclut le footer
@include_once "includes/footer.php";
?>