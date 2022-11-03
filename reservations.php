<?php
session_start();

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<?php

function compare($date)
{
  $date_compare1 = date("d-m-Y h:i:s a", strtotime(date("d-m-Y")));

  $date_compare2 = date("d-m-Y h:i:s a", strtotime($date));

  $difference = strtotime($date_compare1) - strtotime($date_compare2);
  $difference = $difference / (60 * 60 * 24 * 30);

  return $difference;
}

// fonction qui retourne le nombre de mois écoulés depuis la réservation d'un jeu

$Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');

$req = $Connect->prepare('SELECT * FROM jeux INNER JOIN reservations WHERE jeux.jeu = reservations.jeu AND reservations.id = ? ORDER BY reservations.rendu ASC');
$req->execute(array($_SESSION['id']));

// on fait une jointure pour les noms des jeux à la fois présents dans les tables réservations et jeux afin de récupérer pour chaque jeu sa fiche

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Historique des réservations - Le bistro du JV</title>
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
      <i class="fas fa-history h1-icon"></i>
      <span>réservations</span>
      <hr color="black">
    </h1>

    <?php if ($req->rowCount() > 0) { ?>
      <table border=1 frame=void rules=rows>
        <thead>
          <th>Nom</th>
          <th>Jeu</th>
          <th>Console</th>
          <th>Genre</th>
          <th>Date de réservation</th>
          <th>Date de retour</th>
        </thead>
        <tbody>
          <?php while ($fiches = $req->fetch()) { ?>
            <tr>
              <?php $fiches['jeu'] = str_replace("_", " ", $fiches['jeu']); ?>
              <td class="better1"><?= $fiches['jeu'] ?></td>
              <?php $fiches['jeu'] = str_replace(" ", "_", $fiches['jeu']); ?>
              <?php $console = str_replace(" ", "_", $fiches['console']); ?>
              <td><img class=<?= $console ?> src="Jaquettes/<?= $fiches['jeu'] ?>.jpg" alt=" Jaquette <?= $fiches['jeu'] ?>"></td>
              <td class="better1"><?= $fiches['console'] ?></td>
              <td class="better1"><?= $fiches['genre'] ?></td>
              <td class="better1">
                <?php if ($fiches['rendu'] == 0) {
                  if (compare($fiches['date']) <= 1) { ?>
                    <font color="green"><strong><?php $date = str_replace("-", "/", $fiches['date']);
                                                echo $date; ?></strong><br>(En cours)</font>
                  <?php } else { ?>
                    <font color="red"><strong><?php $date = str_replace("-", "/", $fiches['date']);
                                              echo $date; ?></strong><br>(En retard)</font>
                  <?php }
                } else { ?>
                  <strong><?php $date = str_replace("-", "/", $fiches['date']);
                          echo $date; ?></strong><br>(Terminée)
                <?php } ?>
              </td>
              <td class="better1">
                <?php if ($fiches['rendu'] == 0) {
                  if (compare($fiches['date']) <= 1) { ?>
                    <font color="green"><strong><?php $date = str_replace("-", "/", date('d-m-Y', strtotime($fiches['date'] . ' + 30 days')));
                                                echo $date; ?></strong><br>(En cours)</font>
                  <?php } else { ?>
                    <font color="red"><strong><?php $date = str_replace("-", "/", date('d-m-Y', strtotime($fiches['date'] . ' + 30 days')));
                                              echo $date; ?></strong><br>(En retard)</font>
                  <?php }
                } else { ?>
                  <strong><?php $date = str_replace("-", "/", date('d-m-Y', strtotime($fiches['date'] . ' + 30 days')));
                          echo $date; ?></strong><br>(Terminée)
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <h3>Lorsque vous aurez réservé des jeux, ces derniers apparaitront ici !</h3>
    <?php } ?>
  </main>
</body>

</html>