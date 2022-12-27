<?php
session_start();
require('Autres/fonctions.php');

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<?php

$Connect = dbConnect();

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
require('Autres/header.php');
?>
<body>
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