<div class="footer-clean">
  <footer>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-sm-4 col-md-3 item">
          <h3>A propos</h3>
          <ul>
            <li><a href="politique_de_confidentialité.php">Politique de confidentialité</a></li>
            <li><a href="mentions_legales.php">Mentions légales</a></li>
            <li><a href="index.php#A_propos">Histoire du restaurant</a></li>
          </ul>
        </div>
        <div class="col-sm-4 col-md-3 item">
          <h3>Adresse</h3>
          <ul>
            <li><a href="#">56, Av des serviettes</a></li>
            <li><a href="#">12890 CHAMBERY</a></li>
            <li><a href="#">0097676797</a></li>
            <li><a href="#">arnaudmichant@gmail.com</a></li>
          </ul>
        </div>

        <?php

        require_once "connect.php";

        $sql = "SELECT * FROM horaires";

        //On execute la requête
        $requete = $db->query($sql);

        //On recupère les données
        $horaires = $requete->fetchAll();

        ?>


        <div class="col-sm-4 col-md-3 item">
          <h3>Horaires de service</h3>

          <table class="table text-success">
            <thead>
              <tr>
                <th></th>
                <th scope="col p-2" class="text-danger text-center "></th>
                <th scope="col p-2" class="text-danger text-center"></th>
                <th scope="col p-2" class="text-danger text-center"></th>
                <th scope="col p-2" class="text-danger text-center"></th>
                <th scope="col p-2" class="text-danger text-center"></th>
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
                                            echo "";
                                          }
                                          ?></td>
                </tr>
              </tbody>
            <?php endforeach; ?>
          </table>

        </div>
        <div class="col-lg-3 item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-instagram"></i></a>
          <p class="copyright">Quai Antique © 2023</p>
        </div>
      </div>
    </div>
  </footer>
</div>

<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/script.js"></script>
<script src="https://kit.fontawesome.com/b4a9f9c0a2.js" crossorigin="anonymous"></script>

</body>

</html>