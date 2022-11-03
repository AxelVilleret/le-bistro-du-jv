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

function ajouter_panier($jeu, $panier)
{
  if ($panier == 1) {
    if ($_SESSION['panier1'] == "") {
      $_SESSION['panier1'] = $jeu;
    }
  }
  if ($panier == 2) {
    if ($_SESSION['panier1'] == "") {
      $_SESSION['panier1'] = $jeu;
    } elseif ($_SESSION['panier2'] == "") {
      $_SESSION['panier2'] = $jeu;
    }
  }
  if ($panier == 3) {
    if ($_SESSION['panier1'] == "") {
      $_SESSION['panier1'] = $jeu;
    } elseif ($_SESSION['panier2'] == "") {
      $_SESSION['panier2'] = $jeu;
    } elseif ($_SESSION['panier3'] == "") {
      $_SESSION['panier3'] = $jeu;
    }
  }
}
?>

<?php
$Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');

$jeux = $Connect->query('SELECT * FROM jeux_du_moment ORDER BY jeu ASC');

// Comme pour les deux autres filtres prédéfinis, on récupère tous les jeux dans la table et pour chacun d'eux, on fera une deuxième requête pour aller chercher sa fiche dans la tables jeux

if (isset($_GET['add']) and !empty($_GET['add'])) {
  ajouter_panier($_GET['add'], $_SESSION['panier']);
  $_SESSION['nb_articles'] += 1;
  header("Location: mon_panier.php");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Jeux du moment - Le bistro du JV</title>
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
      <i class="fas fa-heart h1-icon"></i>
      <span>jeux du moment</span>
      <hr color="black">
    </h1>
    <?php if ($jeux->rowCount() > 0) { ?>
      <table border=1 frame=void rules=rows>
        <thead>
          <th>Nom</th>
          <th>Jeu</th>
          <th>Console</th>
          <th>Genre</th>
          <th>Description</th>
          <th>Disponibilité</th>
        </thead>
        <tbody>
          <?php while ($fiches = $jeux->fetch()) {
            $query = $Connect->prepare('SELECT * FROM jeux WHERE jeu = ?');
            $query->execute(array($fiches['jeu']));
            $fiches = $query->fetch();
          ?>
            <tr>
              <?php $fiches['jeu'] = str_replace("_", " ", $fiches['jeu']); ?>
              <td class="better1"><?= $fiches['jeu'] ?></td>
              <?php $fiches['jeu'] = str_replace(" ", "_", $fiches['jeu']); ?>
              <?php $console = str_replace(" ", "_", $fiches['console']); ?>
              <td><img class=<?= $console ?> src="Jaquettes/<?= $fiches['jeu'] ?>.jpg" alt=" Jaquette <?= $fiches['jeu'] ?>"></td>
              <td class="better1"><?= $fiches['console'] ?></td>
              <td class="better1"><?= $fiches['genre'] ?></td>
              <td class="better2"><?= $fiches['description'] ?></td>
              <td class="better1">
                <?php if ($fiches['stock'] == 0) {
                  echo '<font color="red">' . "Ce jeu est actuellement indisponible !" . '</font>';
                } else { ?>
                  <?php if (!isset($_SESSION['id'])) { ?>
                    <font color="green"><strong><?= $fiches['stock'] ?></strong> exemplaires restants !</font><br><br>
                    <a href="se_connecter.php">
                      <button class="button-link font-effect-neon">
                        <i class="far fa-user button-link-icon"></i>
                      </button>
                    </a>
                  <?php } else { ?>
                    <?php if ($_SESSION['panier'] == 0) {
                      echo '<font color="red">' . "Vous avez déjà 3 réservations en cours !" . '</font>';
                    } elseif (panier_plein($_SESSION['panier']) == 1) {
                      echo '<font color="red">' . "Votre panier est plein !" . '</font>'; ?><br><br>
                      <a href="mon_panier.php">
                        <button class="button-link font-effect-neon">
                          <i class="fas fa-shopping-cart button-link-icon"></i>
                        </button>
                      </a>
                    <?php } elseif ((isset($_SESSION['panier1']) and $_SESSION['panier1'] == $fiches['jeu']) or (isset($_SESSION['panier2']) and $_SESSION['panier2'] == $fiches['jeu']) or (isset($_SESSION['panier3']) and $_SESSION['panier3'] == $fiches['jeu'])) {
                      echo '<font color="red">' . "Ce jeu est dans votre panier !" . '</font>'; ?>
                    <?php } else { ?>
                      <font color="green"><strong><?= $fiches['stock'] ?></strong> exemplaires restants !</font><br><br>
                      <form method="GET" action="">
                        <button class="button-link font-effect-neon" type="submit" name="add" value=<?= $fiches['jeu'] ?>>
                          <i class="fas fa-cart-plus button-link-icon"></i>
                        </button>
                      </form>
                <?php }
                  }
                } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <h3>Nous sommes désolés mais aucun jeu ne correspond à cette catégorie !</h3>
    <?php } ?>
  </main>
</body>

</html>