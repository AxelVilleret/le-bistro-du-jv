<?php
session_start();

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<?php

function taille_panier($id)
{
  $panier = 3;
  $Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');
  $req = $Connect->prepare('SELECT rendu FROM reservations WHERE id= ?');
  $req->execute(array($id));
  while ($rendu = $req->fetch()) {
    if ($rendu['rendu'] == 0) {
      $panier -= 1;
    }
  }
  return $panier;
}

function init_panier($panier)
{
  if ($panier == 1) {
    $_SESSION['panier1'] = "";
  }
  if ($panier == 2) {
    $_SESSION['panier1'] = "";
    $_SESSION['panier2'] = "";
  }
  if ($panier == 3) {
    $_SESSION['panier1'] = "";
    $_SESSION['panier2'] = "";
    $_SESSION['panier3'] = "";
  }
}

?>

<?php

if (isset($_GET['reserv'])) {
  if (isset($_SESSION['panier1']) and $_SESSION['panier1'] != "") {
    $Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');
    $req1 = $Connect->prepare('INSERT INTO reservations(id, jeu, date, rendu) VALUES (?,?,?,?)');
    $req1->execute(array($_SESSION['id'], $_SESSION['panier1'], date("d-m-Y"), 0));
    $req2 = $Connect->prepare('SELECT stock FROM jeux WHERE jeu= ?');
    $req2->execute(array($_SESSION['panier1']));
    $stock = $req2->fetch();
    $stock['stock'] -= 1;
    $req3 = $Connect->prepare('UPDATE jeux SET stock = ? WHERE jeu = ?');
    $req3->execute(array($stock['stock'], $_SESSION['panier1']));
    unset($_SESSION['panier1']);
    $_SESSION['reservations'] += 1;
  }
  if (isset($_SESSION['panier2']) and $_SESSION['panier2'] != "") {
    $Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');
    $req1 = $Connect->prepare('INSERT INTO reservations(id, jeu, date, rendu) VALUES (?,?,?,?)');
    $req1->execute(array($_SESSION['id'], $_SESSION['panier2'], date("d-m-Y"), 0));
    $req2 = $Connect->prepare('SELECT stock FROM jeux WHERE jeu= ?');
    $req2->execute(array($_SESSION['panier2']));
    $stock = $req2->fetch();
    $stock['stock'] -= 1;
    $req3 = $Connect->prepare('UPDATE jeux SET stock = ? WHERE jeu = ?');
    $req3->execute(array($stock['stock'], $_SESSION['panier2']));
    unset($_SESSION['panier2']);
    $_SESSION['reservations'] += 1;
  }
  if (isset($_SESSION['panier3']) and $_SESSION['panier3'] != "") {
    $Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');
    $req1 = $Connect->prepare('INSERT INTO reservations(id, jeu, date, rendu) VALUES (?,?,?,?)');
    $req1->execute(array($_SESSION['id'], $_SESSION['panier3'], date("d-m-Y"), 0));
    $req2 = $Connect->prepare('SELECT stock FROM jeux WHERE jeu= ?');
    $req2->execute(array($_SESSION['panier3']));
    $stock = $req2->fetch();
    $stock['stock'] -= 1;
    $req3 = $Connect->prepare('UPDATE jeux SET stock = ? WHERE jeu = ?');
    $req3->execute(array($stock['stock'], $_SESSION['panier3']));
    unset($_SESSION['panier3']);
    $_SESSION['reservations'] += 1;
  }
  unset($_SESSION['panier']);
  $_SESSION['nb_articles'] = 0;
  $_SESSION['panier'] = taille_panier($_SESSION['id']);
  init_panier($_SESSION['panier']);
  header("Location: accueil.php");
}

// pour chaque élément qui était dans le panier, on créé une réservation dans la table réservations pour l'utilisateur connecté
// pour chaque jeu ainsi réservé, on décrémente son stock dans la table jeux
// on réinitialise le panier en conséquence comme si l'utlisateur venait de se connecter après avoir détruit les variables de session associées au panier

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Confirmer la réservation - Le bistro du JV</title>
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
    <br>
    <?php if (($_SESSION['nb_articles']) == 1) { ?>
      <font color="red">Confirmez-vous la réservation de ce jeu ? (Cette action est irréversible et entrainera l'ajout de ce jeu à vos trois réservations mensuelles.)<br>En cliquant vous vous engagez à nous retourner ce jeu sous 30 jours à compter d'aujourd'hui !</font>
    <?php } else { ?>
      <font color="red">Confirmez-vous la réservation de ces jeux ? (Cette action est irréversible et entrainera l'ajout de ces jeux à vos trois réservations mensuelles.)<br>En cliquant vous vous engagez à nous retourner ces jeux sous 30 jours à compter d'aujourd'hui !</font>
    <?php } ?>
    <br><br>
    <form method="GET" action="">
      <input class="submit font-effect-neon" type="submit" name="reserv" value="Réserver" />
    </form>
  </main>
</body>

</html>