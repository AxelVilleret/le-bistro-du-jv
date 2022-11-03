<?php
session_start();

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<?php
function panier_plein($panier)
{
  $plein = 0;
  if ($panier == 1) {
    if ($_SESSION['panier1'] != "") {
      $plein = 1;
    }
  }
  if ($panier == 2) {
    if ($_SESSION['panier1'] != "" and $_SESSION['panier2'] != "") {
      $plein = 1;
    }
  }
  if ($panier == 3) {
    if ($_SESSION['panier1'] != "" and $_SESSION['panier2'] != "" and $_SESSION['panier3'] != "") {
      $plein = 1;
    }
  }
  return $plein;
}

// fonction retournant 1 si le panier est plein et 0 sinon

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

$Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');

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
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Mon panier - Le bistro du JV</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rancho&effect=neon" />
  <link rel="stylesheet" href="css/general.css" />
  <link rel="stylesheet" href="css/navbar1.css" />
  <link rel="stylesheet" href="css/navbar2.css" />
  <link rel="stylesheet" href="css/accueil.css" />
  <link rel="stylesheet" href="css/affichages.css" />
  <link rel="stylesheet" href="css/formulaires.css" />
  <script src="https://kit.fontawesome.com/03959c15b4.js" crossorigin="anonymous"></script>
  <link rel="icon" type="image/png" href="favicon_package_v0.16/favicon-32x32.png">
</head>

<body>
  <header>
    <nav class="navbar1 font-effect-neon">
      <div class="navbar1-menu">
        <a href="accueil.php" class="logo1">
          <i class="fas fa-gamepad navbar1-icon"></i>
          <span class="navbar1-title">le bistro du jv</span>
        </a>
        <form method="get">
          <input class="searchbar" type="search" name="s" placeholder="Rechercher..." />
          <button class="button" type="submit" value="Valider">
            <i class="fas fa-search button-icon font-effect-neon"></i>
          </button>
        </form>
        <div>
          <?php
          if (!isset($_SESSION['id'])) {
          ?>
            <a href="se_connecter.php" class="navbar1-link">
              <i class="far fa-user navbar1-icon"></i>
              <span class="navbar1-title">se connecter</span>
            </a>
            <a href="s'inscrire.php" class="navbar1-link">
              <i class="fas fa-file-invoice navbar1-icon"></i>
              <span class="navbar1-title">s'inscrire</span>
            </a>
          <?php
          } else {
          ?>
            <a href="mon_panier.php" class="navbar1-link">
              <i class="fas fa-shopping-cart navbar1-icon"></i>
              <span class="navbar1-title">mon panier (<?= $_SESSION['nb_articles'] ?>)</span>
            </a>
            <a href="reservations.php" class="navbar1-link">
              <i class="fas fa-history navbar1-icon"></i>
              <span class="navbar1-title">mes réservations (<?= $_SESSION['reservations'] ?>)</span>
            </a>
            <?php if ($_SESSION['id'] != 0) { ?>
              <a href="mon_compte.php" class="navbar1-link">
                <i class="fas fa-user navbar1-icon"></i>
                <span class="navbar1-title">mon compte</span>
              </a>
            <?php } else { ?>
              <a href="editer.php" class="navbar1-link">
                <i class="fas fa-edit navbar1-icon"></i>
                <span class="navbar1-title">éditer</span>
              </a>
            <?php } ?>
            <a href="se_deconnecter.php" class="navbar1-link">
              <i class="fas fa-user-alt-slash navbar1-icon"></i>
              <span class="navbar1-title">se déconnecter</span>
            </a>
          <?php
          }
          ?>
        </div>
      </div>
    </nav>
    <nav class="navbar2 font-effect-neon">
      <ul class="navbar2-menu">
        <li class="logo2">
          <span class="navbar2-link">
            <span class="navbar2-title">chercher par...</span>
            <i class="fas fa-sliders-h navbar2-icon"></i>
          </span>
        </li>
        <li class="navbar2-item">
          <a href="les_mieux_notes.php" class="navbar2-link">
            <i class="fas fa-star navbar2-icon"></i>
            <span class="navbar2-title">les mieux notés</span>
          </a>
        </li>
        <li class="navbar2-item">
          <a href="jeux_du_moment.php" class="navbar2-link">
            <i class="fas fa-heart navbar2-icon"></i>
            <span class="navbar2-title">jeux du moment</span>
          </a>
        </li>
        <li class="navbar2-item">
          <a href="a_venir.php" class="navbar2-link">
            <i class="fas fa-burn navbar2-icon"></i>
            <span class="navbar2-title">à venir</span>
          </a>
        </li>
        <li class="navbar2-item">
          <a href="classiques.php" class="navbar2-link">
            <i class="fas fa-thumbs-up navbar2-icon"></i>
            <span class="navbar2-title">classiques</span>
          </a>
        </li>
        <li class="navbar2-item">
          <a href="personnaliser.php" class="navbar2-link">
            <i class="fas fa-sort-amount-down navbar2-icon"></i>
            <span class="navbar2-title">personnaliser...</span>
          </a>
        </li>
        <li class="navbar2-item">
          <a href="a_propos.php" class="navbar2-link">
            <i class="fas fa-info-circle navbar2-icon"></i>
            <span class="navbar2-title">à propos</span>
          </a>
        </li>
      </ul>
    </nav>
  </header>

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