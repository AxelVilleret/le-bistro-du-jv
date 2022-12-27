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

$req = $Connect->prepare('SELECT * FROM jeux INNER JOIN reservations WHERE jeux.jeu = reservations.jeu AND reservations.id = ? ORDER BY reservations.rendu ASC');
$req->execute(array($_SESSION['id']));

// on fait une jointure pour les noms des jeux à la fois présents dans les tables réservations et jeux afin de récupérer pour chaque jeu sa fiche
require('Autres/header.php');
?>

<body>
  <main>
    <h1>
      <i class="fas fa-history h1-icon"></i>
      <span>réservations</span>
      <hr color="black">
    </h1>

    <?php if ($req->rowCount() > 0) { ?>
      <table border=1 frame=void rules=rows>
        <thead>
          <th>Nom</th>
          <th>Jeu</th>
          <th>Console</th>
          <th>Genre</th>
          <th>Date de réservation</th>
          <th>Date de retour</th>
        </thead>
        <tbody>
          <?php while ($fiches = $req->fetch()) { ?>
            <tr>
              <?php $fiches['jeu'] = str_replace("_", " ", $fiches['jeu']); ?>
              <td class="better1"><?= $fiches['jeu'] ?></td>
              <?php $fiches['jeu'] = str_replace(" ", "_", $fiches['jeu']); ?>
              <?php $console = str_replace(" ", "_", $fiches['console']); ?>
              <td><img class=<?= $console ?> src="Jaquettes/<?= $fiches['jeu'] ?>.jpg" alt=" Jaquette <?= $fiches['jeu'] ?>"></td>
              <td class="better1"><?= $fiches['console'] ?></td>
              <td class="better1"><?= $fiches['genre'] ?></td>
              <td class="better1">
                <?php if ($fiches['rendu'] == 0) {
                  if (temps_ecoule($fiches['date']) / 30 <= 1) { ?>
                    <font color="green"><strong><?php $date = str_replace("-", "/", $fiches['date']);
                                                echo $date; ?></strong><br>(En cours)</font>
                  <?php } else { ?>
                    <font color="red"><strong><?php $date = str_replace("-", "/", $fiches['date']);
                                              echo $date; ?></strong><br>(En retard)</font>
                  <?php }
                } else { ?>
                  <strong><?php $date = str_replace("-", "/", $fiches['date']);
                          echo $date; ?></strong><br>(Terminée)
                <?php } ?>
              </td>
              <td class="better1">
                <?php if ($fiches['rendu'] == 0) {
                  if (temps_ecoule($fiches['date']) / 30 <= 1) { ?>
                    <font color="green"><strong><?php $date = str_replace("-", "/", date('d-m-Y', strtotime($fiches['date'] . ' + 30 days')));
                                                echo $date; ?></strong><br>(En cours)</font>
                  <?php } else { ?>
                    <font color="red"><strong><?php $date = str_replace("-", "/", date('d-m-Y', strtotime($fiches['date'] . ' + 30 days')));
                                              echo $date; ?></strong><br>(En retard)</font>
                  <?php }
                } else { ?>
                  <strong><?php $date = str_replace("-", "/", date('d-m-Y', strtotime($fiches['date'] . ' + 30 days')));
                          echo $date; ?></strong><br>(Terminée)
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <h3>Lorsque vous aurez réservé des jeux, ces derniers apparaitront ici !</h3>
    <?php } ?>
  </main>
</body>

</html>