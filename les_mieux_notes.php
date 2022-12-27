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

$jeux = $Connect->query('SELECT * FROM les_mieux_notes ORDER BY jeu ASC');

// Comme pour les deux autres filtres prédéfinis, on récupère tous les jeux dans la table et pour chacun d'eux, on fera une deuxième requête pour aller chercher sa fiche dans la tables jeux

if (isset($_GET['add']) and !empty($_GET['add'])) {
  ajouter_panier($_GET['add'], $_SESSION['panier']);
  $_SESSION['nb_articles'] += 1;
  header("Location: mon_panier.php");
}
require('Autres/header.php');
?>
<body>
  <main>
    <h1>
      <i class="fas fa-star h1-icon"></i>
      <span>les mieux notés</span>
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
          <th>Disponibilité</th>
        </thead>
        <tbody>
          <?php while ($fiches = $jeux->fetch()) {
            $query = $Connect->prepare('SELECT * FROM jeux WHERE jeu = ?');
            $query->execute(array($fiches['jeu']));
            $fiches = $query->fetch();
          ?>
            <tr>
              <?php $fiches['jeu'] = str_replace("_", " ", $fiches['jeu']); ?>
              <td class="better1"><?= $fiches['jeu'] ?></td>
              <?php $fiches['jeu'] = str_replace(" ", "_", $fiches['jeu']); ?>
              <?php $console = str_replace(" ", "_", $fiches['console']); ?>
              <td><img class=<?= $console ?> src="Jaquettes/<?= $fiches['jeu'] ?>.jpg" alt=" Jaquette <?= $fiches['jeu'] ?>"></td>
              <td class="better1"><?= $fiches['console'] ?></td>
              <td class="better1"><?= $fiches['genre'] ?></td>
              <td class="better2"><?= $fiches['description'] ?></td>
              <td class="better1">
                <?php if ($fiches['stock'] == 0) {
                  echo '<font color="red">' . "Ce jeu est actuellement indisponible !" . '</font>';
                } else { ?>
                  <?php if (!isset($_SESSION['id'])) { ?>
                    <font color="green"><strong><?= $fiches['stock'] ?></strong> exemplaires restants !</font><br><br>
                    <a href="se_connecter.php">
                      <button class="button-link font-effect-neon">
                        <i class="far fa-user button-link-icon"></i>
                      </button>
                    </a>
                  <?php } else { ?>
                    <?php if ($_SESSION['panier'] == 0) {
                      echo '<font color="red">' . "Vous avez déjà 3 réservations en cours !" . '</font>';
                    } elseif (panier_plein($_SESSION['panier']) == 1) {
                      echo '<font color="red">' . "Votre panier est plein !" . '</font>'; ?><br><br>
                      <a href="mon_panier.php">
                        <button class="button-link font-effect-neon">
                          <i class="fas fa-shopping-cart button-link-icon"></i>
                        </button>
                      </a>
                    <?php } elseif ((isset($_SESSION['panier1']) and $_SESSION['panier1'] == $fiches['jeu']) or (isset($_SESSION['panier2']) and $_SESSION['panier2'] == $fiches['jeu']) or (isset($_SESSION['panier3']) and $_SESSION['panier3'] == $fiches['jeu'])) {
                      echo '<font color="red">' . "Ce jeu est dans votre panier !" . '</font>'; ?>
                    <?php } else { ?>
                      <font color="green"><strong><?= $fiches['stock'] ?></strong> exemplaires restants !</font><br><br>
                      <form method="GET" action="">
                        <button class="button-link font-effect-neon" type="submit" name="add" value=<?= $fiches['jeu'] ?>>
                          <i class="fas fa-cart-plus button-link-icon"></i>
                        </button>
                      </form>
                <?php }
                  }
                } ?>
              </td>
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