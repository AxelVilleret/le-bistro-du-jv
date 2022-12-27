<?php
session_start();
require('Autres/fonctions.php');

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<?php

if (isset($_GET['choice2'])) {
  $_SESSION['choice2'] = $_GET['choice2'];
  header("Location: editer(2).php");
}

// si le choix de l'administrateur est d'ajouter une nouvelle fiche de jeu, on le redirige vers une nouvelle page

?>

<?php

$Connect = dbConnect();
$query = $Connect->query('SELECT * FROM jeux ORDER BY jeu ASC');
$count = 0;

if (isset($_GET['valider1'])) {
  $query3 = $Connect->query('DELETE FROM classiques');
  $query4 = $Connect->query('SELECT * FROM jeux');
  $count = $query4->rowCount();
  for ($i = 1; $i <= $count; $i++) {
    if (isset($_GET['jeux'][$i])) {
      $query5 = $Connect->prepare('INSERT INTO classiques VALUES (?)');
      $query5->execute(array($_GET['jeux'][$i]));
    }
  }
  header('Location: editer.php');
}

// mise à jour du filtre classiques avec les checkbox des jeux cochées par l'administrateur

if (isset($_GET['valider2'])) {
  $query3 = $Connect->query('DELETE FROM les_mieux_notes');
  $query4 = $Connect->query('SELECT * FROM jeux');
  $count = $query4->rowCount();
  for ($i = 1; $i <= $count; $i++) {
    if (isset($_GET['jeux'][$i])) {
      $query5 = $Connect->prepare('INSERT INTO les_mieux_notes VALUES (?)');
      $query5->execute(array($_GET['jeux'][$i]));
    }
  }
  header('Location: editer.php');
}

// mise à jour du filtre les mieux notés avec les checkbox des jeux cochées par l'administrateur

if (isset($_GET['valider3'])) {
  $query3 = $Connect->query('DELETE FROM jeux_du_moment');
  $query4 = $Connect->query('SELECT * FROM jeux');
  $count = $query4->rowCount();
  for ($i = 1; $i <= $count; $i++) {
    if (isset($_GET['jeux'][$i])) {
      $query5 = $Connect->prepare('INSERT INTO jeux_du_moment VALUES (?)');
      $query5->execute(array($_GET['jeux'][$i]));
    }
  }
  header('Location: editer.php');
}

// mise à jour du filtre jeux du moment avec les checkbox des jeux cochées par l'administrateur

if (isset($_GET['valider4'])) {
  for ($i = 1; $i <= 3; $i++) {
    if (isset($_GET['res'][$i])) {
      $query3 = $Connect->prepare('UPDATE reservations SET rendu = ? WHERE numero = ?');
      $query3->execute(array(1, $_GET['res'][$i]));
      $query4 = $Connect->prepare('SELECT jeu FROM reservations WHERE numero = ?');
      $query4->execute(array($_GET['res'][$i]));
      $infos = $query4->fetch();
      $query5 = $Connect->prepare('SELECT stock FROM jeux WHERE jeu = ?');
      $query5->execute(array($infos['jeu']));
      $infos2 = $query5->fetch();
      $infos2['stock'] += 1;
      $query6 = $Connect->prepare('UPDATE jeux SET stock = ? WHERE jeu = ?');
      $query6->execute(array($infos2['stock'], $infos['jeu']));
    }
  }
  header('Location: editer.php');
}

// l'administrateur a choisi de terminer une ou plusieurs réservations, on va mettre à jour la table reservations en conséquence et réincrémenter les stocks des jeux correspondants

if (isset($_POST['valider6'])) {
  $nom = str_replace(' ', '_', htmlspecialchars($_POST['nom']));
  $console = htmlspecialchars($_POST['console']);
  $genre = htmlspecialchars($_POST['genre']);
  $description = htmlspecialchars($_POST['description']);
  if (!empty($_POST['nom']) and !empty($_POST['console']) and !empty($_POST['genre']) and !empty($_POST['description']) and !empty($_POST['stock'])) {
    if (strlen($nom) <= 255) {
      if (strlen($console) <= 255) {
        if (strlen($genre) <= 255) {
          $insertgame = $Connect->prepare("UPDATE jeux SET console = ?, genre = ?, description = ?, stock = ? WHERE jeu = ?");
          $insertgame->execute(array($console, $genre, $description, $_POST['stock'], $nom));
          header("Location: editer.php");
        } else {
          $erreur = "Attention à la taille du nom du genre (moins de 255 caractères) !";
        }
      } else {
        $erreur = "Attention à la taille du nom de la console (moins de 255 caractères) !";
      }
    } else {
      $erreur = "Attention à la taille du nom du jeu (moins de 255 caractères) !";
    }
  } else {
    $erreur = "Attention à bien renseigner tous les champs !";
  }
}

// on met à jour la table jeux pour le jeu souhaité 

if (isset($_GET['supprimer'])) {
  $query3 = $Connect->prepare('DELETE FROM jeux WHERE jeu = ?');
  $query3->execute(array($_GET['choix_jeu']));
  $query4 = $Connect->prepare('DELETE FROM reservations WHERE jeu = ?');
  $query4->execute(array($_GET['choix_jeu']));
  $query5 = $Connect->prepare('DELETE FROM classiques WHERE jeu = ?');
  $query5->execute(array($_GET['choix_jeu']));
  $query6 = $Connect->prepare('DELETE FROM jeux_du_moment WHERE jeu = ?');
  $query6->execute(array($_GET['choix_jeu']));
  $query7 = $Connect->prepare('DELETE FROM les_mieux_notes WHERE jeu = ?');
  $query7->execute(array($_GET['choix_jeu']));
  header('Location: editer.php');
}

// on supprime le jeu souhaité de la table jeux mais aussi de toutes les autres tables dans lesquelles se dernier se trouve
require('Autres/header.php');
?>

<body>
  <main>
    <?php if ($_SESSION['choice1'] == "add") { ?>
      <h1>
        <i class="fas fa-edit h1-icon"></i>
        <span>ajouter une nouvelle fiche de jeu</span>
        <hr color="black">
      </h1>
      <form method="GET" action="">
        <ul>
          <li>
            <legend>Le jeu que vous souhaitez ajouter est-il déjà disponible ?</legend>
          </li><br>
          <ul>
            <li><label class="custom-radio" for="oui"><input type="radio" id="oui" name="choice2" value="oui"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Oui</label></li>
            <li><label class="custom-radio" for="non"><input type="radio" id="non" name="choice2" value="non"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Non</label></li>
          </ul><br>
          <button type="submit" class="submit font-effect-neon" name="valid2" value="valid2" style="margin-left: 2rem;">Valider</button>
      </form>


    <?php } elseif ($_SESSION['choice1'] == "modifier") { ?>
      <h1>
        <i class="fas fa-edit h1-icon"></i>
        <span>modifier ou supprimer une fiche de jeu existante</span>
        <hr color="black">
      </h1>
      <?php if (!isset($_GET['choix_jeu'])) { ?>
        <?php $jeux = $Connect->query('SELECT jeu FROM jeux'); ?>
        <form method="get">
          <ul>
            <?php while ($fiches = $jeux->fetch()) { ?>
              <li><label class="custom-radio" for="<?= $fiches['jeu'] ?>"><input type="radio" id="<?= $fiches['jeu'] ?>" name="choix_jeu" value="<?= $fiches['jeu'] ?>"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> <?= str_replace('_', ' ', $fiches['jeu']) ?></label></li>
            <?php } ?>
          </ul>
          <br><button type="submit" class="submit font-effect-neon" name="valider5" value="valider" style="margin-left: 2rem;">Modifier</button>
          <button type="submit" class="submit font-effect-neon" name="supprimer" value="supprimer" style="margin-left: 2rem;">Supprimer</button>
        </form>

      <?php } else { ?>
        <?php $jeu = $Connect->prepare('SELECT * FROM jeux WHERE jeu = ?');
        $jeu->execute(array($_GET['choix_jeu']));
        $fiche = $jeu->fetch(); ?>
        <div align="center">
          <form method="POST" action="">
            <label for="nom">Nom du jeu</label><br><br>
            <input class="input" type="text" value="<?= $fiche['jeu'] ?>" id="nom" name="nom" readOnly="readOnly" />
            <br><br>
            <label for="console">Console</label><br><br>
            <select name="console" class="input" id="console">
              <option value="Xbox One" <?php if ($fiche['console'] == "Xbox One") { ?> selected <?php } ?>>Xbox One</option>
              <option value="PlayStation 4" <?php if ($fiche['console'] == "PlayStation 4") { ?> selected <?php } ?>>PlayStation 4</option>
              <option value="Nintendo Switch" <?php if ($fiche['console'] == "Nintendo Switch") { ?> selected <?php } ?>>Nintendo Switch</option>
            </select>
            <br><br>
            <label for="genre">Genre</label><br><br>
            <select name="genre" class="input" id="genre">
              <option value="Aventure" <?php if ($fiche['genre'] == "Aventure") { ?> selected <?php } ?>>Aventure</option>
              <option value="Combat" <?php if ($fiche['genre'] == "Combat") { ?> selected <?php } ?>>Combat</option>
              <option value="Course" <?php if ($fiche['genre'] == "Course") { ?> selected <?php } ?>>Course</option>
              <option value="Plates-formes" <?php if ($fiche['genre'] == "Plates-formes") { ?> selected <?php } ?>>Plates-formes</option>
              <option value="Simulation" <?php if ($fiche['genre'] == "Simulation") { ?> selected <?php } ?>>Simulation</option>
              <option value="Tir à la première personne" <?php if ($fiche['genre'] == "Tir à la première personne") { ?> selected <?php } ?>>Tir à la première personne</option>
            </select>
            <br><br>
            <label for="description">Description</label><br><br>
            <textarea type="text" class="textarea" id="description" rows="10" cols="35" placeholder="[Copier-coller la description depuis JeuxVidéos.com.]" name="description"><?= $fiche['description'] ?></textarea>
            <br><br>
            <label for="stock">Stock</label><br><br>
            <input class="input" type="number" placeholder="Stock" id="stock" value="<?= $fiche['stock'] ?>" name="stock" min="0" />
            <br><br>
            <input class="submit font-effect-neon" type="submit" name="valider6" value="Enregistrer" />
          </form>
          <br><br>
          <?php
          if (isset($erreur)) {
            echo '<font color="red">' . $erreur . "</font>";
          }
          ?>
        </div>
      <?php } ?>

    <?php } elseif ($_SESSION['choice1'] == "terminer") { ?>
      <h1>
        <i class="fas fa-edit h1-icon"></i>
        <span>terminer une ou plusieurs réservation(s)</span>
        <hr color="black">
      </h1>
      <form method="get" align='center'>
        <input class="searchbar" type="search" name="membre" placeholder="Rechercher un client..." />
        <button class="button" type="submit" value="Valider">
          <i class="fas fa-search button-icon font-effect-neon"></i>
        </button>
      </form>
      <br>
      <?php if (isset($_GET['membre']) and !empty($_GET['membre'])) {
        $s = $_GET['membre'];
        $clients = $Connect->query('SELECT id FROM membres WHERE id LIKE "%' . $s . '%" OR prenom LIKE "%' . $s . '%" OR nom LIKE "%' . $s . '%"');
        if ($clients->rowCount() > 0) { ?>
          <form method="get" action="">
            <?php while ($fiches = $clients->fetch()) {
              $reservations = $Connect->prepare('SELECT * FROM reservations WHERE id = ? and rendu = ? ORDER BY numero ASC');
              $reservations->execute(array($fiches['id'], 0)); ?>
              <ul>
                <?php while ($fiches2 = $reservations->fetch()) {
                  $count += 1; ?>
                  <li><label class="custom-checkbox" for="<?= $fiches2['numero'] ?>"><input type="checkbox" id="<?= $fiches2['numero'] ?>" name="res[<?= $count ?>]" value="<?= $fiches2['numero'] ?>"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> réservation n°<?= $fiches2['numero'] ?> - <?= str_replace('_', ' ', $fiches2['jeu']) ?></label></li>
                <?php } ?>
              </ul>
            <?php } ?>
            <br><button type="submit" class="submit font-effect-neon" name="valider4" value="valider" style="margin-left: 2rem;">Valider</button>
          </form>
        <?php } else { ?>
          <h3>Aucune réservation ne correspond à votre recherche.</h3>
      <?php }
      } ?>

    <?php } elseif ($_SESSION['choice1'] == "modifier_classiques") { ?>
      <h1>
        <i class="fas fa-edit h1-icon"></i>
        <span>éditer le filtre "classiques"</span>
        <hr color="black">
      </h1>
      <form method="GET" action="">
        <ul>
          <?php while ($fiches = $query->fetch()) {
            $query2 = $Connect->prepare('SELECT * from classiques WHERE jeu = ?');
            $query2->execute(array($fiches['jeu']));
            $count += 1;
            if ($query2->rowCount() == 0) { ?>
              <li><label class="custom-checkbox" for="<?= $fiches['jeu'] ?>"><input type="checkbox" id="<?= $fiches['jeu'] ?>" name="jeux[<?= $count ?>]" value="<?= $fiches['jeu'] ?>"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> <?= str_replace('_', ' ', $fiches['jeu']) ?></label></li>
            <?php } else { ?>
              <li><label class="custom-checkbox" for="<?= $fiches['jeu'] ?>"><input type="checkbox" id="<?= $fiches['jeu'] ?>" checked="checked" name="jeux[<?= $count ?>]" value="<?= $fiches['jeu'] ?>"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> <?= str_replace('_', ' ', $fiches['jeu']) ?></label></li>
            <?php } ?>
          <?php } ?>
        </ul>
        <button type="submit" class="submit font-effect-neon" name="valider1" value="valider" style="margin-left: 2rem;">Valider</button>
      </form>
    <?php } elseif ($_SESSION['choice1'] == "modifier_les_mieux_notes") { ?>
      <h1>
        <i class="fas fa-edit h1-icon"></i>
        <span>éditer le filtre "les mieux notés"</span>
        <hr color="black">
      </h1>
      <form method="GET" action="">
        <ul>
          <?php while ($fiches = $query->fetch()) {
            $query2 = $Connect->prepare('SELECT * from les_mieux_notes WHERE jeu = ?');
            $query2->execute(array($fiches['jeu']));
            $count += 1;
            if ($query2->rowCount() == 0) { ?>
              <li><label class="custom-checkbox" for="<?= $fiches['jeu'] ?>"><input type="checkbox" id="<?= $fiches['jeu'] ?>" name="jeux[<?= $count ?>]" value="<?= $fiches['jeu'] ?>"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> <?= str_replace('_', ' ', $fiches['jeu']) ?></label></li>
            <?php } else { ?>
              <li><label class="custom-checkbox" for="<?= $fiches['jeu'] ?>"><input type="checkbox" id="<?= $fiches['jeu'] ?>" checked="checked" name="jeux[<?= $count ?>]" value="<?= $fiches['jeu'] ?>"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> <?= str_replace('_', ' ', $fiches['jeu']) ?></label></li>
            <?php } ?>
          <?php } ?>
        </ul>
        <button type="submit" class="submit font-effect-neon" name="valider2" value="valider" style="margin-left: 2rem;">Valider</button>
      </form>
    <?php } else { ?>
      <h1>
        <i class="fas fa-edit h1-icon"></i>
        <span>éditer le filtre "jeux du moment"</span>
        <hr color="black">
      </h1>
      <form method="GET" action="">
        <ul>
          <?php while ($fiches = $query->fetch()) {
            $query2 = $Connect->prepare('SELECT * from jeux_du_moment WHERE jeu = ?');
            $query2->execute(array($fiches['jeu']));
            $count += 1;
            if ($query2->rowCount() == 0) { ?>
              <li><label class="custom-checkbox" for="<?= $fiches['jeu'] ?>"><input type="checkbox" id="<?= $fiches['jeu'] ?>" name="jeux[<?= $count ?>]" value="<?= $fiches['jeu'] ?>"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> <?= str_replace('_', ' ', $fiches['jeu']) ?></label></li>
            <?php } else { ?>
              <li><label class="custom-checkbox" for="<?= $fiches['jeu'] ?>"><input type="checkbox" id="<?= $fiches['jeu'] ?>" checked="checked" name="jeux[<?= $count ?>]" value="<?= $fiches['jeu'] ?>"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> <?= str_replace('_', ' ', $fiches['jeu']) ?></label></li>
            <?php } ?>
          <?php } ?>
        </ul>
        <button type="submit" class="submit font-effect-neon" name="valider3" value="valider" style="margin-left: 2rem;">Valider</button>
      </form>
    <?php } ?>
  </main>
</body>

</html>