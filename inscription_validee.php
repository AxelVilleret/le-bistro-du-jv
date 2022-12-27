<?php
session_start();
require('Autres/fonctions.php');

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
require('Autres/header.php');
?>
<body>
  <main>
    <br>
    <a class="valid-link" href="se_connecter.php">Félicitation, votre compte a bien été créé ! Vous pouvez à présent vous connecter en cliquant ici !</a>
  </main>
</body>

</html>