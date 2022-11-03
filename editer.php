<?php
session_start();

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<?php

if (isset($_GET['choice1'])) {
  $_SESSION['choice1'] = $_GET['choice1'];
  header("Location: editer(1).php");
}

// si l'administrateur a choisi l'action qu'il souhaite éxecuter, on le redirige vers la page editer(1).php

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Éditer - Le bistro du JV</title>
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
      <i class="fas fa-edit h1-icon"></i>
      <span>éditer</span>
      <hr color="black">
    </h1>
    <form method="GET" action="">
      <ul>
        <li>
          <legend>Que souhaitez-vous faire ?</legend>
        </li><br>
        <ul>
          <li><label class="custom-radio" for="add"><input type="radio" id="add" name="choice1" value="add"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Ajouter une nouvelle fiche de jeu</label></li>
          <li><label class="custom-radio" for="modifier"><input type="radio" id="modifier" name="choice1" value="modifier"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Modifier ou supprimer une fiche de jeu existante</label></li>
          <li><label class="custom-radio" for="terminer"><input type="radio" id="terminer" name="choice1" value="terminer"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Terminer une ou plusieurs réservation(s)</label></li>
          <li><label class="custom-radio" for="modifier_classiques"><input type="radio" id="modifier_classiques" name="choice1" value="modifier_classiques"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Éditer le filtre "Classiques"</label></li>
          <li><label class="custom-radio" for="modifier_les_mieux_notes"><input type="radio" id="modifier_les_mieux_notes" name="choice1" value="modifier_les_mieux_notes"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Éditer le filtre "Les mieux notés"</label></li>
          <li><label class="custom-radio" for="modifier_jeux_du_moment"><input type="radio" id="modifier_jeux_du_moment" name="choice1" value="modifier_jeux_du_moment"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Éditer le filtre "Jeux du moment"</label></li>
        </ul><br>
        <button type="submit" class="submit font-effect-neon" name="valid1" value="valid1" style="margin-left: 2rem;">Valider</button>
    </form>
  </main>
</body>

</html>