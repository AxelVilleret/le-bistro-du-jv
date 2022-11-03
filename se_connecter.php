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

// on initialise les variables de session qui vont contenir les jeux ajoutés au panier en fonction de la taille de ce dernier

?>

<?php

$Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');

if (isset($_POST['formconnexion'])) {
  $mailconnect = htmlspecialchars($_POST['mailconnect']);
  $mdpconnect = sha1($_POST['mdpconnect']);
  if (!empty($mailconnect) and !empty($mdpconnect)) {
    $requser = $Connect->prepare("SELECT * FROM membres WHERE email = ? AND motdepasse = ?");
    $requser->execute(array($mailconnect, $mdpconnect));
    $userexist = $requser->rowCount();
    if ($userexist == 1) {
      $userinfo = $requser->fetch();
      $_SESSION['id'] = $userinfo['id'];
      $_SESSION['prenom'] = $userinfo['prenom'];
      $_SESSION['nom'] = $userinfo['nom'];
      $_SESSION['mail'] = $userinfo['mail'];
      $_SESSION['mdp'] = $userinfo['motdepasse'];
      $_SESSION['panier'] = taille_panier($_SESSION['id']);
      init_panier($_SESSION['panier']);
      $_SESSION['reservations'] = 3 - $_SESSION['panier'];
      $_SESSION['nb_articles'] = 0;
      header("Location: accueil.php");
    } else {
      $erreur = "L'email ou le mot de passe n'est pas correct !";
    }
  } else {
    $erreur = "Tous les champs doivent être complétés !";
  }
}

// si l'utlisateur se connecte, on récupère les informations associées à son compte dans des varialbes de session et on initialise son panier en focntion des réservations qu'il a en cours

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Se connecter - Le bistro du JV</title>
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
      <i class="far fa-user h1-icon"></i>
      <span>se connecter</span>
      <hr color="black">
    </h1>
    <div align="center">
      <form method="POST" action="">
        <label for="email">Email</label><br><br>
        <input class="input" type="email" id="email" name="mailconnect" placeholder="Email" />
        <br><br>
        <label for="password">Mot de passe</label><br><br>
        <input class="input" type="password" id="password" name="mdpconnect" placeholder="Mot de passe" minlength="8" maxlength="255" />
        <br><br>
        <input class="submit font-effect-neon" type="submit" name="formconnexion" value="Se connecter" />
        <br><br>
        <a class="log_on-link" href="s'inscrire.php">Pas encore de compte ? Inscrivez-vous en cliquant ici !</a>
      </form>
      <br><br>
      <?php
      if (isset($erreur)) {
        echo '<font color="red">' . $erreur . "</font>";
      }
      ?>
    </div>
  </main>
</body>

</html>