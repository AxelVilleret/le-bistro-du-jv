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

$jeux = $Connect->query('SELECT * FROM a_venir ORDER BY jeu ASC');
require('Autres/header.php');
?>

<body>
  <main>
    <h1>
      <i class="fas fa-burn h1-icon"></i>
      <span>à venir</span>
      <hr color="black">
    </h1>
    <?php if ($jeux->rowCount() > 0) { ?>
      <table border=1 frame=void rules=rows>
        <thead>
          <th>Nom</th>
          <th>Jeu</th>
          <th>Console</th>
          <th>Genre</th>
          <th>Description</th>
          <th>Disponible le...</th>
        </thead>
        <tbody>
          <?php while ($fiches = $jeux->fetch()) { ?>
            <tr>
              <?php $fiches['jeu'] = str_replace("_", " ", $fiches['jeu']); ?>
              <td class="better1"><?= $fiches['jeu'] ?></td>
              <?php $fiches['jeu'] = str_replace(" ", "_", $fiches['jeu']); ?>
              <?php $console = str_replace(" ", "_", $fiches['console']); ?>
              <td><img class=<?= $console ?> src="Jaquettes/<?= $fiches['jeu'] ?>.jpg" alt=" Jaquette <?= $fiches['jeu'] ?>"></td>
              <td class="better1"><?= $fiches['console'] ?></td>
              <td class="better1"><?= $fiches['genre'] ?></td>
              <td class="better2"><?= $fiches['description'] ?></td>
              <?php $date = str_replace("-", "/", $fiches['sortie']); ?>
              <td class="better1"><?= $date ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <h3>Nous sommes désolés mais aucun jeu ne correspond à cette catégorie !</h3>
    <?php } ?>
  </main>
</body>

</html>