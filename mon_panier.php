<?php
session_start();
require('Autres/fonctions.php');

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<?php

if (isset($_GET['del1'])) {
  $_SESSION['panier1'] = "";
  $_SESSION['nb_articles'] -= 1;
  header("Location: mon_panier.php");
}

if (isset($_GET['del2'])) {
  $_SESSION['panier2'] = "";
  $_SESSION['nb_articles'] -= 1;
  header("Location: mon_panier.php");
}

if (isset($_GET['del3'])) {
  $_SESSION['panier3'] = "";
  $_SESSION['nb_articles'] -= 1;
  header("Location: mon_panier.php");
}

// si l'utilisateur a appuyé sur l'un des boutons pour retirer un jeu du panier, on le retire et on le redirige vers cette même page

?>

<?php

$Connect = dbConnect();

if (isset($_SESSION['panier1']) and $_SESSION['panier1'] != "") {
  $jeu1 = $Connect->prepare("SELECT * FROM jeux WHERE jeu = ?");
  $jeu1->execute(array($_SESSION['panier1']));
  $fichejeu1 = $jeu1->fetch();
}

if (isset($_SESSION['panier2']) and $_SESSION['panier2'] != "") {
  $jeu2 = $Connect->prepare("SELECT * FROM jeux WHERE jeu = ?");
  $jeu2->execute(array($_SESSION['panier2']));
  $fichejeu2 = $jeu2->fetch();
}

if (isset($_SESSION['panier3']) and $_SESSION['panier3'] != "") {
  $jeu3 = $Connect->prepare("SELECT * FROM jeux WHERE jeu = ?");
  $jeu3->execute(array($_SESSION['panier3']));
  $fichejeu3 = $jeu3->fetch();
}

// on vérifie s'il y a des jeux dans le panier et on récupère leurs informations dans la table jeux si c'est le cas
require('Autres/header.php');
?>
<body>
  <main>
    <h1>
      <i class="fas fa-shopping-cart h1-icon"></i>
      <span>mon panier</span>
      <hr color="black">
    </h1>

    <?php if (!isset($jeu1) and !isset($jeu2) and !isset($jeu3)) { ?>
      <h3>Vous n'avez pas encore ajouté de jeu à votre panier !</h3>
    <?php } else { ?>
      <table border=1 frame=void rules=rows>
        <thead>
          <th>Nom</th>
          <th>Jeu</th>
          <th>Console</th>
          <th>Genre</th>
          <th>Description</th>
          <th>Date de retour</th>
        </thead>
        <tbody>
          <?php if (isset($jeu1)) { ?>
            <tr>
              <?php $fichejeu1['jeu'] = str_replace("_", " ", $fichejeu1['jeu']); ?>
              <td class="better1"><?= $fichejeu1['jeu'] ?></td>
              <?php $fichejeu1['jeu'] = str_replace(" ", "_", $fichejeu1['jeu']); ?>
              <?php $console = str_replace(" ", "_", $fichejeu1['console']); ?>
              <td><img class=<?= $console ?> src="Jaquettes/<?= $fichejeu1['jeu'] ?>.jpg" alt=" Jaquette <?= $fichejeu1['jeu'] ?>"></td>
              <td class="better1"><?= $fichejeu1['console'] ?></td>
              <td class="better1"><?= $fichejeu1['genre'] ?></td>
              <td class="better2"><?= $fichejeu1['description'] ?></td>
              <td class="better1">
                <font color="red"><strong><?php $date = str_replace("-", "/", date('d-m-Y', strtotime(' + 30 days')));
                                          echo $date; ?></strong></font><br><br>
                <form method="GET" action="">
                  <button class="button-link font-effect-neon" type="submit" name="del1" value=<?= $fichejeu1['jeu'] ?>>
                    <i class="fas fa-trash button-link-icon"></i>
                  </button>
                </form>
              </td>
            </tr>
          <?php }
          if (isset($jeu2)) { ?>
            <tr>
              <?php $fichejeu2['jeu'] = str_replace("_", " ", $fichejeu2['jeu']); ?>
              <td class="better1"><?= $fichejeu2['jeu'] ?></td>
              <?php $fichejeu2['jeu'] = str_replace(" ", "_", $fichejeu2['jeu']); ?>
              <?php $console = str_replace(" ", "_", $fichejeu2['console']); ?>
              <td><img class=<?= $console ?> src="Jaquettes/<?= $fichejeu2['jeu'] ?>.jpg" alt=" Jaquette <?= $fichejeu2['jeu'] ?>"></td>
              <td class="better1"><?= $fichejeu2['console'] ?></td>
              <td class="better1"><?= $fichejeu2['genre'] ?></td>
              <td class="better2"><?= $fichejeu2['description'] ?></td>
              <td class="better1">
                <font color="red"><strong><?php $date = str_replace("-", "/", date('d-m-Y', strtotime(' + 30 days')));
                                          echo $date; ?></strong></font><br><br>
                <form method="GET" action="">
                  <button class="button-link font-effect-neon" type="submit" name="del2" value=<?= $fichejeu2['jeu'] ?>>
                    <i class="fas fa-trash button-link-icon"></i>
                  </button>
                </form>
              </td>
            </tr>
          <?php }
          if (isset($jeu3)) { ?>
            <tr>
              <?php $fichejeu3['jeu'] = str_replace("_", " ", $fichejeu3['jeu']); ?>
              <td class="better1"><?= $fichejeu3['jeu'] ?></td>
              <?php $fichejeu3['jeu'] = str_replace(" ", "_", $fichejeu3['jeu']); ?>
              <?php $console = str_replace(" ", "_", $fichejeu3['console']); ?>
              <td><img class=<?= $console ?> src="Jaquettes/<?= $fichejeu3['jeu'] ?>.jpg" alt=" Jaquette <?= $fichejeu3['jeu'] ?>"></td>
              <td class="better1"><?= $fichejeu3['console'] ?></td>
              <td class="better1"><?= $fichejeu3['genre'] ?></td>
              <td class="better2"><?= $fichejeu3['description'] ?></td>
              <td class="better1">
                <font color="red"><strong><?php $date = str_replace("-", "/", date('d-m-Y', strtotime(' + 30 days')));
                                          echo $date; ?></strong></font><br><br>
                <form method="GET" action="">
                  <button class="button-link font-effect-neon" type="submit" name="del3" value=<?= $fichejeu3['jeu'] ?>>
                    <i class="fas fa-trash button-link-icon"></i>
                  </button>
                </form>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <br>
      <div align="center">
        <a href="panier_valide.php">
          <button class="submit font-effect-neon">
            Valider mon panier
          </button>
        </a>
      </div>
    <?php } ?>
  </main>
</body>

</html>