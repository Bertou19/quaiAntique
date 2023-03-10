<?php
session_id();
session_start();

$nav_en_cours = 'Contact';

//On definit le titre
$titrePrincipal = "Formulaire de contact";


// On inclut le header
@include_once "includes/header.php";
// On inclut la navbar
@include_once "includes/navbar.php";

?>

<div class="container">
  <div class="row">
    <div class="col-12 text-md-center">
      <h1 class="title-form pt-5 text-md-center text-xs-center">Formulaire de contact</h1>

    </div>
  </div>
</div>

<section>
  <form class="border border-warning rounded-5 " id="my-form" action="https://formspree.io/f/mbjbkrbw" method="POST">
    <div class="form mb-1 p-5 text-center">
      <label for="exampleFormControlInput1" class="form-label text-warning">E-mail</label>
      <input name="email" type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
    </div>
    <div class="form mb-2 p-2 text-center">
      <label for="exampleFormControlTextarea1" class="form-label text-warning">Message</label>
      <textarea name="message" class="form-control" id="exampleFormControlTextarea1" rows="3" type="text"></textarea>
      <button class="btn btn-lg btn-danger button text-light mt-2" id="my-form-button">Envoyer</button>
      <p id="my-form-status"></p>
    </div>
  </form>
</section>

<?php

// On inclut le footer
@include_once "includes/footer.php";
?>