<?php
session_start();

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<?php
$Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');
if (isset($_POST['forminscription'])) {
  $prenom = htmlspecialchars($_POST['prenom']);
  $nom = htmlspecialchars($_POST['nom']);
  $email = htmlspecialchars($_POST['email']);
  $email2 = htmlspecialchars($_POST['email2']);
  $uppercase = preg_match('@[A-Z]@', $_POST['mdp']);
  $lowercase = preg_match('@[a-z]@', $_POST['mdp']);
  $number = preg_match('@[0-9]@', $_POST['mdp']);
  $mdp = sha1($_POST['mdp']);
  $mdp2 = sha1($_POST['mdp2']);
  if (!empty($_POST['prenom']) and !empty($_POST['nom']) and !empty($_POST['email']) and !empty($_POST['email2']) and !empty($_POST['mdp']) and !empty($_POST['mdp2'])) {
    $prenomlength = strlen($prenom);
    $nomlength = strlen($nom);
    if ($prenomlength <= 255) {
      if ($nomlength <= 255) {
        if ($email == $email2) {
          if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $reqmail = $Connect->prepare("SELECT * FROM membres WHERE email = ?");
            $reqmail->execute(array($email));
            $mailexist = $reqmail->rowCount();
            if ($mailexist == 0) {
              if ($uppercase and $lowercase and $number) {
                if ($mdp == $mdp2) {
                  $insertmbr = $Connect->prepare("INSERT INTO membres(prenom, nom, email, motdepasse) VALUES(?, ?, ?, ?)");
                  $insertmbr->execute(array($prenom, $nom, $email, $mdp));
                  header("Location: inscription_validee.php");
                } else {
                  $erreur = "Attention à bien renseigner 2 fois le même mot de passe !";
                }
              } else {
                $erreur = "Votre mot de passe doit contenir au moins 1 majuscule, 1 minuscule et 1 chiffre !";
              }
            } else {
              $erreur = "Cette adresse email est déjà utilisée !";
            }
          } else {
            $erreur = "Attention à bien renseigner une adresse email valide !";
          }
        } else {
          $erreur = "Attention à bien renseigner 2 fois la même adresse email !";
        }
      } else {
        $erreur = "Attention à la taille de votre nom (moins de 255 caractères) !";
      }
    } else {
      $erreur = "Attention à la taille de votre prenom (moins de 255 caractères) !";
    }
  } else {
    $erreur = "Attention à bien renseigner tous les champs !";
  }
}

// correspond à l'ajout d'un nouveau membre à la base de données après avoir effectué les vérifications sur les informations saisies

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>S'inscrire - Le bistro du JV</title>
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
      <i class="fas fa-file-invoice h1-icon"></i>
      <span>s'inscrire</span>
      <hr color="black">
    </h1>
    <div align="center">
      <form method="POST" action="">
        <label for="prenom">Prénom *</label><br><br>
        <input class="input" type="text" placeholder="Prénom" id="prenom" name="prenom" value="<?php if (isset($prenom)) {
                                                                                                  echo $prenom;
                                                                                                } ?>" />
        <br><br>
        <label for="nom">Nom *</label><br><br>
        <input class="input" type="text" placeholder="Nom" id="nom" name="nom" value="<?php if (isset($nom)) {
                                                                                        echo $nom;
                                                                                      } ?>" />
        <br><br>
        <label for="email">Email *</label><br><br>
        <input class="input" type="email" placeholder="Email" id="email" name="email" value="<?php if (isset($email)) {
                                                                                                echo $email;
                                                                                              } ?>" />
        <br><br>
        <label for="email2">Confirmez votre email *</label><br><br>
        <input class="input" type="email" placeholder="Confirmez votre email" id="email2" name="email2" value="<?php if (isset($email2)) {
                                                                                                                  echo $email2;
                                                                                                                } ?>" />
        <br><br>
        <label for="mdp">Mot de passe (au moins 1 majuscule, 1 minuscule et 1 chiffre) *</label><br><br>
        <input class="input" type="password" placeholder="Mot de passe" id="mdp" name="mdp" minlength="8" maxlength="255" />
        <br><br>
        <label for="mdp2">Confirmez votre mot de passe *</label><br><br>
        <input class="input" type="password" placeholder="Confirmez votre mot de passe" id="mdp2" name="mdp2" minlength="8" maxlength="255" />
        <br><br>
        <input class="submit font-effect-neon" type="submit" name="forminscription" value="S'inscrire" />
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