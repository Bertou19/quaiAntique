<?php

session_start();

$nav_en_cours = 'connexion';


/* CONNEXION */

if (isset($_SESSION["user"])) {
  header("Location: index.php");
  exit;
}

// On vérifie si le formulaire a été envoyé
if (!empty($_POST)) {
  //Le formulaire a été envoyé
  //On vérifie que tous les champs requis sont remplis
  if (
    isset($_POST["email"], $_POST["password"])
    && !empty($_POST["email"]) && !empty($_POST["password"])
  ) {
    $_SESSION["error"] = [];
    //On vérifie que l'email en est un
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $_SESSION["error"] = "Veuillez saisir une adresse email valide";
    }
    if ($_SESSION["error"] === []) {
      //On va se connecter à la base de données
      require "includes/connect.php";

      $sql = "SELECT * FROM user WHERE `email` = :email";


      $query = $db->prepare($sql);

      $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);

      $query->execute();

      $user = $query->fetch();


      if (!$user) {
        $_SESSION["error"] = ["L'utilisateur et/ou le mot de passe est incorrect"];
      }
      if (!password_verify($_POST["password"], $user["password"])) {
        $_SESSION["error"] = ["L'utilisateur et/ou le mot de passe est incorrect"];
      }
      //Ici l'utilsateur et le mot de passe sont corrects
      //On va pouvoir "connecter" l'utilisateur


      if ($_SESSION["error"] === []) {
        //On stocke dans $_SESSION les informations de l'utilisateur

        /*$sql = "SELECT * FROM user"; //nb : pourquoi refaire une requete car il y a eu dejà en ligne 32 ????              <= nb =>

        $query = $db->prepare($sql);
        $query->execute();

        $userRoles = $query->fetch();*/
        $userRoles = $user;


        if ($userRoles["roles"] == "user") {

          $_SESSION["user"] = [
            "id" => $user["id_user"],
            "email" => $user["email"],
            "roles" => $user["roles"],
            "allergie_oeufs" => $user["allergie_oeufs"],
            "allergie_lait" => $user["allergie_lait"],
            "allergie_crustaces" => $user["allergie_crustaces"],
            "allergie_arachides" => $user["allergie_arachides"],
            "allergie_ble" => $user["allergie_ble"],
            "nb_convives" => $user["nb_convives"]
          ];


          //On redirige vers la page de profil
          header("Location: profil.php");
        }
        if ($userRoles["roles"] == "admin") {


          $_SESSION["admin"] = [
            "id" => $user["id_user"],
            "email" => $user["email"],
            "roles" => $user["roles"],

          ];

          header("Location: profilAdmin.php");
        }
      }
    }
  }
}

$title = "Connexion";
//On inclut le header
include_once "includes/header.php";
include_once "includes/navbar.php";
?>
<div class="row justify-content-center">

  <h1 class="connexion-title text-center pt-5">Me connecter :</h1>

  <div class="text-center">
    <?php
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
            <button type="submit" class="button btn btn-danger text-light mb-7">Connexion</button>
            <a href="inscription.php"><button type="button" class="button btn btn-danger text-light mb-7">M'inscrire</button></a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
include_once "includes/footer.php";
?>