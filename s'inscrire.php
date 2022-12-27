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
require('Autres/header.php');
?>
<body>
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