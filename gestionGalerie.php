<?php


session_start();
//On definit le titre
$titrePrincipal = "Gestion de la galerie";

$nav_en_cours = 'profilAdmin';

//On vérifie si un fichier a été envoyé
if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
  // On a reçu l'image
  //On procède aux vérifications
  //On vérifie l'extension et le type mime
  $allowed = [
    "jpg" => "image/jpeg",
    "jpeg" => "image/jpeg",
    "png" => "image/png"
  ];

  $filename = $_FILES["image"]["name"];
  $filetype = $_FILES["image"]["type"];
  $filesize = $_FILES["image"]["size"];

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

  if (!move_uploaded_file($_FILES["image"]["tmp_name"], $newfilename)) {
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

      $sql = "INSERT INTO galerie(`image`,`nom`,`chemin`,`titre`) VALUES ('$newname.$extension','$filename','$newfilename','$titre')";

      $query = $db->prepare($sql);

      $query->execute();
    }
  }
}
//ON va chercher les images dans la base

require_once "includes/connect.php";
//On écrit la requête
$sql = "SELECT *  FROM galerie";

//On execute la requête
$requete = $db->query($sql);

//On recupère les données
$images = $requete->fetchAll();
$chemin = "/uploads/" . $images[0];

//On met en place la possibilité de supprimer une photo

if (isset($_POST["delete"])) {
  require_once "includes/connect.php";
  $id = $_POST["id"];
  $chemin = $_POST["path"];


  $sql = "DELETE FROM galerie WHERE id_galerie = $id";
  $query = $db->prepare($sql);
  $query->execute();
  if (file_exists(unlink($chemin)));
}

//On inclut le header
@include_once "includes/header.php";

// On inclut la navbar
@include_once "includes/navbar.php";

//On écrit le contenu de la page

?>

<?php

require_once "includes/connect.php";

$sql = "SELECT * FROM galerie";

//On execute la requête
$requete = $db->query($sql);

//On recupère les données
$images = $requete->fetchAll();

?>

<div class="container-fluid">
  <div class="row justify-content-center">

    <h1 class="profil-title text-center mt-6 text-danger ">Gestion de la galerie photo</h1>

    <form method="post" enctype="multipart/form-data">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-2 col-sm-6">
            <div class="input-group text-center mt-6">
              <label for="fichier"></label>
              <input class="form-control" type="file" name="image" id="fichier">

            </div>
            <div class="input-group text-center mt-4">
              <label for="titre"></label>
              <input class="form-control" type="text" name="titre" id="titre" placeholder="Titre">

            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-lg btn-info mt-3">Enregistrer</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<h1 class="galerie text-warning text-center pt-5 mb-5">Photos</h1>

<section class="mb-6">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8 col-sm-10 table-responsive">
        <table class="table table-warning table-striped">
          <thead>
            <tr>
              <th></th>
              <th scope="col p-2" class="text-danger text-center ">Id</th>
              <th scope="col p-2" class="text-danger text-center">Nom</th>
              <th scope="col p-2" class="text-danger text-center">Titre</th>
              <th scope="col p-2" class="text-danger text-center">Aperçu</th>
              <th scope="col p-2" class="text-danger text-center"></th>
            </tr>
          </thead>

          <?php foreach ($images as $image) : ?>
            <tbody>
              <tr>
                <form action="" method="post">
                  <th scope="row"></th>
                  <td class="text-center"><?= strip_tags($image['id_galerie']) ?></td>
                  <td class="text-center"><?= strip_tags($image['nom']) ?></td>
                  <td class="text-center"><?= strip_tags($image['titre']) ?></td>
                  <td>
                    <div class="text-center">
                      <img class="img-tableau" src="<?php echo "./uploads/" . $image['image']; ?>" width=75 height=50>
                    </div>
                  </td>
                  <td class=" text-center">
                    <input type="hidden" name="id" value="<?php echo $image['id_galerie']; ?>" />
                    <input type="hidden" name="path" value="<?php echo $image['chemin']; ?>" />
                    <input type="submit" name="delete" value="Supprimer" id="" class="btn btn-info" />
                  </td>
                </form>
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