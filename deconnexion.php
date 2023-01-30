<?php
session_id();
session_start();

$nav_en_cours = 'deconnexion';


if (isset($_SESSION["user"])) {
  unset($_SESSION["user"]);
}

if (isset($_SESSION["admin"])) {
  unset($_SESSION["admin"]);
}



header("Location: index.php");
exit;


//On supprime les variables