<?php


session_start();
//On definit le titre
$titrePrincipal = "Gestion de la galerie";

$nav_en_cours = 'galerie';

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
  chmod($newfilename, 0777);


  require_once "includes/connect.php";

  $sql = "INSERT INTO galerie(`image`) VALUES ('$newname.$extension')";

  $query = $db->prepare($sql);
  $query->execute();
}
//On inclut le header
@include_once "includes/header.php";

// On inclut la navbar
@include_once "includes/navbar.php";

//On écrit le contenu de la page

?>
<div class="container-fluid">
  <div class="row justify-content-center">

    <h1 class="profil-title text-center mt-6 text-danger ">Gestion de la galerie photo</h1>

    <form method="post" enctype="multipart/form-data">

      <div>
        <label for="fichier"></label>
        <input type="file" name="image" id="fichier">
      </div>
      <button type="submit">Envoyer</button>
    </form>
  </div>
</div>


<?php
// On inclut le footer
@include_once "includes/footer.php";
?>