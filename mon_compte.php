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

$requser = $Connect->prepare('SELECT * FROM membres WHERE id = ?');
$requser->execute(array($_SESSION['id']));
$userinfo = $requser->fetch();

// on récupère les informations du compte de l'utilisateur
require('Autres/header.php');
?>
<body>
  <main>
    <h1>
      <i class="fas fa-user h1-icon"></i>
      <span>mon compte</span>
      <hr color="black">
    </h1>
    <div align="center">
      <label>N° de client :</label><br><br>
      <input class="input donnees" type="text" name="" value="<?= $userinfo['id'] ?>" readOnly="readOnly" />
      <br><br>
      <label>Prénom :</label><br><br>
      <input class="input donnees" type="text" name="" value="<?= $userinfo['prenom'] ?>" readOnly="readOnly" />
      <br><br>
      <label>Nom :</label><br><br>
      <input class="input donnees" type="text" name="" value="<?= $userinfo['nom'] ?>" readOnly="readOnly" />
      <br><br>
      <label>Email :</label><br><br>
      <input class="input donnees" type="text" name="" value="<?= $userinfo['email'] ?>" readOnly="readOnly" />
      <br><br>
      <a href="modifier_mes_informations.php">
        <button class="submit font-effect-neon">
          Modifier mes informations
        </button>
      </a>
    </div>
  </main>
</body>

</html>