<?php
session_start();
require('Autres/fonctions.php');

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<?php

if (isset($_GET['reserv'])) {
  if (isset($_SESSION['panier1']) and $_SESSION['panier1'] != "") {
    $Connect = dbConnect();
    $req1 = $Connect->prepare('INSERT INTO reservations(id, jeu, date, rendu) VALUES (?,?,?,?)');
    $req1->execute(array($_SESSION['id'], $_SESSION['panier1'], date("d-m-Y"), 0));
    $req2 = $Connect->prepare('SELECT stock FROM jeux WHERE jeu= ?');
    $req2->execute(array($_SESSION['panier1']));
    $stock = $req2->fetch();
    $stock['stock'] -= 1;
    $req3 = $Connect->prepare('UPDATE jeux SET stock = ? WHERE jeu = ?');
    $req3->execute(array($stock['stock'], $_SESSION['panier1']));
    unset($_SESSION['panier1']);
    $_SESSION['reservations'] += 1;
  }
  if (isset($_SESSION['panier2']) and $_SESSION['panier2'] != "") {
    $Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');
    $req1 = $Connect->prepare('INSERT INTO reservations(id, jeu, date, rendu) VALUES (?,?,?,?)');
    $req1->execute(array($_SESSION['id'], $_SESSION['panier2'], date("d-m-Y"), 0));
    $req2 = $Connect->prepare('SELECT stock FROM jeux WHERE jeu= ?');
    $req2->execute(array($_SESSION['panier2']));
    $stock = $req2->fetch();
    $stock['stock'] -= 1;
    $req3 = $Connect->prepare('UPDATE jeux SET stock = ? WHERE jeu = ?');
    $req3->execute(array($stock['stock'], $_SESSION['panier2']));
    unset($_SESSION['panier2']);
    $_SESSION['reservations'] += 1;
  }
  if (isset($_SESSION['panier3']) and $_SESSION['panier3'] != "") {
    $Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');
    $req1 = $Connect->prepare('INSERT INTO reservations(id, jeu, date, rendu) VALUES (?,?,?,?)');
    $req1->execute(array($_SESSION['id'], $_SESSION['panier3'], date("d-m-Y"), 0));
    $req2 = $Connect->prepare('SELECT stock FROM jeux WHERE jeu= ?');
    $req2->execute(array($_SESSION['panier3']));
    $stock = $req2->fetch();
    $stock['stock'] -= 1;
    $req3 = $Connect->prepare('UPDATE jeux SET stock = ? WHERE jeu = ?');
    $req3->execute(array($stock['stock'], $_SESSION['panier3']));
    unset($_SESSION['panier3']);
    $_SESSION['reservations'] += 1;
  }
  unset($_SESSION['panier']);
  $_SESSION['nb_articles'] = 0;
  $_SESSION['panier'] = taille_panier($_SESSION['id']);
  init_panier($_SESSION['panier']);
  header("Location: accueil.php");
}

// pour chaque élément qui était dans le panier, on créé une réservation dans la table réservations pour l'utilisateur connecté
// pour chaque jeu ainsi réservé, on décrémente son stock dans la table jeux
// on réinitialise le panier en conséquence comme si l'utlisateur venait de se connecter après avoir détruit les variables de session associées au panier
require('Autres/header.php');
?>

<body>
  <main>
    <br>
    <?php if (($_SESSION['nb_articles']) == 1) { ?>
      <font color="red">Confirmez-vous la réservation de ce jeu ? (Cette action est irréversible et entrainera l'ajout de ce jeu à vos trois réservations mensuelles.)<br>En cliquant vous vous engagez à nous retourner ce jeu sous 30 jours à compter d'aujourd'hui !</font>
    <?php } else { ?>
      <font color="red">Confirmez-vous la réservation de ces jeux ? (Cette action est irréversible et entrainera l'ajout de ces jeux à vos trois réservations mensuelles.)<br>En cliquant vous vous engagez à nous retourner ces jeux sous 30 jours à compter d'aujourd'hui !</font>
    <?php } ?>
    <br><br>
    <form method="GET" action="">
      <input class="submit font-effect-neon" type="submit" name="reserv" value="Réserver" />
    </form>
  </main>
</body>

</html>