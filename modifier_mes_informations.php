<?php
session_start();

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<?php

$Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');

$requser = $Connect->prepare("SELECT * FROM membres WHERE id = ?");
$requser->execute(array($_SESSION['id']));
$user = $requser->fetch();
if (isset($_POST['newprenom']) and !empty($_POST['newprenom']) and $_POST['newprenom'] != $user['prenom']) {
  $newprenom = htmlspecialchars($_POST['newprenom']);
  $insertprenom = $Connect->prepare("UPDATE membres SET prenom = ? WHERE id = ?");
  $insertprenom->execute(array($newprenom, $_SESSION['id']));
  header('Location: mon_compte.php');
}
if (isset($_POST['newnom']) and !empty($_POST['newnom']) and $_POST['newnom'] != $user['nom']) {
  $newnom = htmlspecialchars($_POST['newnom']);
  $insertnom = $Connect->prepare("UPDATE membres SET nom = ? WHERE id = ?");
  $insertnom->execute(array($newnom, $_SESSION['id']));
  header('Location: mon_compte.php');
}
if (isset($_POST['newmail1']) and !empty($_POST['newmail1']) and isset($_POST['newmail2']) and !empty($_POST['newmail2'])) {
  $mail1 = htmlspecialchars($_POST['newmail1']);
  $mail2 = htmlspecialchars($_POST['newmail2']);
  if ($mail1 == $mail2) {
    $insertmail = $Connect->prepare("UPDATE membres SET email = ? WHERE id = ?");
    $insertmail->execute(array($mdp1, $_SESSION['id']));
    header('Location: mon_compte.php');
  } else {
    $msg = "Attention à bien renseigner 2 fois le même email !";
  }
}
if (isset($_POST['ancienmdp']) and !empty($_POST['ancienmdp']) and isset($_POST['nouveaumdp']) and !empty($_POST['nouveaumdp'])) {
  $uppercase = preg_match('@[A-Z]@', $_POST['nouveaumdp']);
  $lowercase = preg_match('@[a-z]@', $_POST['nouveaumdp']);
  $number = preg_match('@[0-9]@', $_POST['nouveaumdp']);
  $mdp1 = sha1($_POST['ancienmdp']);
  $mdp2 = sha1($_POST['nouveaumdp']);
  if ($mdp1 == $_SESSION['mdp']) {
    if ($uppercase and $lowercase and $number) {
      $insertmdp = $Connect->prepare("UPDATE membres SET motdepasse = ? WHERE id = ?");
      $insertmdp->execute(array($mdp2, $_SESSION['id']));
      header('Location: mon_compte.php');
    } else {
      $msg = "Votre mot de passe doit contenir au moins 1 majuscule, 1 minuscule et 1 chiffre !";
    }
  } else {
    $msg = "Attention à bien renseigner votre ancien mot de passe !";
  }
}

// on modifie les informations souhaitées par l'utlisateur uniquement

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Modifier mes informations - Le bistro du JV</title>
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
      <i class="fas fa-user-edit h1-icon"></i>
      <span>Modifier mes informations</span>
      <hr color="black">
    </h1>
    <div align="center">
      <form method="POST" action="" enctype="multipart/form-data">
        <label for="prenom">Prénom</label><br><br>
        <input class="input" type="text" placeholder="Prénom" id="prenom" name="newprenom" value="<?php echo $user['prenom']; ?>" />
        <br><br>
        <label for="nom">Nom</label><br><br>
        <input class="input" type="text" placeholder="Nom" id="nom" name="newnom" value="<?php echo $user['nom']; ?>" />
        <br><br>
        <label for="email">Email</label><br><br>
        <input class="input" type="email" placeholder="Email" id="email" name="newmail1" />
        <br><br>
        <label for="email2">Confirmez votre email</label><br><br>
        <input class="input" type="email" placeholder="Confirmez votre email" id="email2" name="newmail2" />
        <br><br>
        <label for="mdp">Ancien mot de passe</label><br><br>
        <input class="input" type="password" placeholder="Ancien mot de passe" id="mdp" name="ancienmdp" minlength="8" maxlength="255" />
        <br><br>
        <label for="mdp2">Nouveau mot de passe</label><br><br>
        <input class="input" type="password" placeholder="Nouveau mot de passe" id="mdp2" name="nouveaumdp" minlength="8" maxlength="255" />
        <br><br>
        <input class="submit font-effect-neon" type="submit" name="forminscription" value="Mettre à jour" />
      </form>
      <br><br>
      <?php if (isset($msg)) {
        echo '<font color="red">' . $msg . "</font>";
      } ?>
    </div>
  </main>
</body>

</html>