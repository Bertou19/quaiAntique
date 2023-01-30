<?php

session_id();
session_start();

$nav_en_cours = 'inscriptionAdmin';

//On vérifie si le formulaire a été envoyé
if (!empty($_POST)) {
  //Le formulaire a été envoyé
  //On vérifie que TOUS les champs sont remplis
  if (
    isset($_POST["email"], $_POST["password"])
    && !empty($_POST["email"]) && !empty($_POST["password"])
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

          //On enregistre en bdd
          require_once "includes/connect.php";


          $sql = "INSERT INTO user (`email`,`password`, `roles`, `allergie_ble`, `allergie_arachides`,`allergie_crustaces`,`allergie_oeufs`, `allergie_lait`, `nb_convives`) VALUES
(:email, '$password','admin', 0, 0,0,0,0,0)";

          $query = $db->prepare($sql);

          $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);


          if ($query->execute()) {
            $_SESSION["success"] = [];
            $_SESSION["success"] = ["Vous vous êtes inscrit(e) avec succès !"];

            //On recupère l'id de l'utilisateur
            $id = $db->lastInsertId();

            //On connectera l'utilisateur

            $_SESSION["admin"] = [
              "id" => $id,
              "email" => $_POST["email"],
              "roles" => "admin",

            ];

            //On redirige vers la page de profil
            header("Location: profilAdmin.php");
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

    <h1 class="inscription-title text-center pt-5">M'inscrire (admin)</h1>
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
          <label for="exampleInputEmail1" class="form-label"></label>
          <input type="text" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
        </div>
        <div class="w-50 w-2 pt-2">
          <label for="exampleInputPassword1" class="form-label"></label>
          <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe">
        </div>

        <div class="text-center pt-5">
          <button type="submit" class="button btn btn-danger text-light mb-7">Inscription</button>
        </div>
      </form>
    </div>
  </div>
</div>


<?php
// On inclut le footer
@include_once "includes/footer.php";
?>