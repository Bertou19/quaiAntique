<?php

session_start();
//On definit le titre
$titrePrincipal = "Gestion de la carte et des menus";

$nav_en_cours = 'profilAdmin';


//On traite le formulaire

//On vérifie si un fichier a été envoyé
if (isset($_FILES["fichier"]) && $_FILES["fichier"]["error"] === 0) {
  // On a reçu le fichier
  //On procède aux vérifications
  //On vérifie l'extension et le type mime
  $allowed = [
    "pdf" => "application/pdf"
  ];

  $filename = $_FILES["fichier"]["name"];
  $filetype = $_FILES["fichier"]["type"];
  $filesize = $_FILES["fichier"]["size"];

  $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
  //On vérifie l'absence de l'extension dans les clefs de $allowed ou l'absence du type mime 
  //dans les valeurs
  if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) {
    //Ici soit l'extension soit le type est incorrect
    die("erreur : format de fichier incorrect");
  }
  //Ici le type est correct
  //On limite à 1Mo
  if ($filesize > 1024 * 1024) {
    die("Fichier trop volumineux");
  }
  // On génère un nom unique
  $newname = md5(uniqid());


  // On génère le chemin complet
  $newfilename = __DIR__ . "/uploads/$newname.$extension";
  //$newfilename = "$newname.$extension";

  if (!move_uploaded_file($_FILES["fichier"]["tmp_name"], $newfilename)) {
    die("L'upload a échoué");
  }
  // On interdit l'exécution du fichier
  chmod($newfilename, 0644);

  if (isset($_POST["titre"]) && !empty($_POST["titre"])) {

    if (strlen($_POST["titre"]) > 40) {
      $_SESSION["error"] = [];
      $_SESSION["error"] = ["Veuillez entrer un titre de moins de 40 caractères"];
    } else {
      $titre = ($_POST["titre"]);

      require_once "includes/connect.php";


      //$sql = "INSERT INTO carte(`titre`,`nom_fichier`) VALUES ('$titre','$newname.$extension')";
      $sql = "UPDATE `carte` SET `titre`= '$titre',`nom_fichier`= '$newname.$extension'";
      $query = $db->prepare($sql);

      if (!$query->execute()) {
        $_SESSION["error"] = [];
        $_SESSION["error"] = ["Une erreur s'est produite !"];
      } else {
        $_SESSION["success"] = [];
        $_SESSION["success"] = ["Le fichier a été enregistré avec succès !"];
      }
    }
  }
}

//On inclut le header
@include_once "includes/header.php";

// On inclut la navbar
@include_once "includes/navbar.php";

//On écrit le contenu de la page

?>
<div class="container-fluid">
  <div class="row justify-content-center">

    <h1 class="profil-title text-center mt-6 text-danger ">Gestion de la carte</h1>
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
    <form method="post" enctype="multipart/form-data">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-2 col-sm-6">
            <div class="input-group text-center mt-4">
              <label for="fichier"></label>
              <input class="form-control" type="file" name="fichier" id="fichier">

            </div>
            <div class="input-group text-center mt-4">
              <label for="titre"></label>
              <input class="form-control" type="text" name="titre" id="titre" placeholder="Titre">

            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-lg btn-info mt-3 mb-5">Enregistrer</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>


<?php
include_once "includes/footer.php";
?>