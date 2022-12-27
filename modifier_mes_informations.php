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
require('Autres/header.php');
?>
<body>
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