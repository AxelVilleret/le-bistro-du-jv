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

if (empty($_GET['console'][0]) and empty($_GET['console'][1]) and empty($_GET['console'][2])) {
  $jeux = $Connect->prepare('SELECT * FROM jeux WHERE genre = ? or genre = ? or genre = ? or genre = ? or genre = ? or genre = ? ORDER BY jeu ASC');
  $jeux->execute(array($_GET['genre'][0], $_GET['genre'][1], $_GET['genre'][2], $_GET['genre'][3], $_GET['genre'][4], $_GET['genre'][5],));
  $filtre = "";
  for ($i = 0; $i < 6; $i++) {
    if ($filtre == "") {
      $filtre = $filtre . $_GET['genre'][$i];
    } else {
      if (!empty($_GET['genre'][$i])) {
        $filtre = $filtre . ' / ' . $_GET['genre'][$i];
      }
    }
  }
}

// ce filtre s'applique si l'utilisateur n'a sélectionné que des genres dans son filtre 
// on créé ensuite une chaine de caractères contenant la liste des filtres sélectionnés

elseif (empty($_GET['genre'][0]) and empty($_GET['genre'][1]) and empty($_GET['genre'][2])) {
  $jeux = $Connect->prepare('SELECT * FROM jeux WHERE console = ? or console = ? or console = ? ORDER BY jeu ASC');
  $jeux->execute(array($_GET['console'][0], $_GET['console'][1], $_GET['console'][2]));
  $filtre = "";
  for ($i = 0; $i < 3; $i++) {
    if ($filtre == "") {
      $filtre = $filtre . $_GET['console'][$i];
    } else {
      if (!empty($_GET['console'][$i])) {
        $filtre = $filtre . ' / ' . $_GET['console'][$i];
      }
    }
  }
}

// ce filtre s'applique si l'utilisateur n'a sélectionné que des consoles dans son filtre 
// on créé ensuite une chaine de caractères contenant la liste des filtres sélectionnés

else {
  $jeux = $Connect->prepare('SELECT * FROM jeux WHERE (console = ? or console = ? or console = ?) and (genre = ? or genre = ? or genre = ? or genre = ? or genre = ? or genre = ?) ORDER BY jeu ASC');
  $jeux->execute(array($_GET['console'][0], $_GET['console'][1], $_GET['console'][2], $_GET['genre'][0], $_GET['genre'][1], $_GET['genre'][2], $_GET['genre'][3], $_GET['genre'][4], $_GET['genre'][5]));
  $filtre = "";
  for ($i = 0; $i < 3; $i++) {
    if ($filtre == "") {
      $filtre = $filtre . $_GET['console'][$i];
    } else {
      if (!empty($_GET['console'][$i])) {
        $filtre = $filtre . ' / ' . $_GET['console'][$i];
      }
    }
  }
  for ($i = 0; $i < 6; $i++) {
    if ($filtre == "") {
      $filtre = $filtre . $_GET['genre'][$i];
    } else {
      if (!empty($_GET['genre'][$i])) {
        $filtre = $filtre . ' / ' . $_GET['genre'][$i];
      }
    }
  }
}

// ce filtre s'applique si l'utilisateur a sélectionné à la fois des genres et des consoles dans son filtre. Le filtre est légèrement différent pour améliorer la pertinence des résultats.
// on créé ensuite une chaine de caractères contenant la liste des filtres sélectionnés

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
      <i class="fas fa-sort-amount-down h1-icon"></i>
      <span>résultat(s) pour "<?= $filtre ?>"</span>
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
      <h3>Nous sommes désolés mais aucun jeu ne correspond à votre recherche !</h3>
    <?php } ?>
  </main>
</body>

</html>