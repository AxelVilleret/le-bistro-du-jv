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

if (isset($_POST['newgame1'])) {
  $nom = str_replace(' ', '_', htmlspecialchars($_POST['nom']));
  $console = htmlspecialchars($_POST['console']);
  $genre = htmlspecialchars($_POST['genre']);
  $description = htmlspecialchars($_POST['description']);
  if (!empty($_POST['nom']) and !empty($_POST['console']) and !empty($_POST['genre']) and !empty($_POST['description']) and !empty($_POST['stock'])) {
    if (strlen($nom) <= 255) {
      if (strlen($console) <= 255) {
        if (strlen($genre) <= 255) {
          $jeu = $Connect->prepare("SELECT * FROM jeux WHERE jeu = ?");
          $jeu->execute(array($nom));
          $jeuexist = $jeu->rowCount();
          if ($jeuexist == 0) {
            $insertgame = $Connect->prepare("INSERT INTO jeux(jeu, console, genre, description, stock) VALUES(?, ?, ?, ?, ?)");
            $insertgame->execute(array($nom, $console, $genre, $description, $_POST['stock']));
            header("Location: editer.php");
          } else {
            $erreur = "Ce jeu existe déjà !";
          }
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

// correspond à l'insertion d'un nouveau jeu lorsqu'il est déjà disponible en ludothèque

if (isset($_POST['newgame2'])) {
  $date = date('d-m-Y', strtotime($_POST['date']));
  $nom = str_replace(' ', '_', htmlspecialchars($_POST['nom']));
  $console = htmlspecialchars($_POST['console']);
  $genre = htmlspecialchars($_POST['genre']);
  $description = htmlspecialchars($_POST['description']);
  if (!empty($_POST['date']) and !empty($_POST['nom']) and !empty($_POST['console']) and !empty($_POST['genre']) and !empty($_POST['description']) and !empty($_POST['stock'])) {
    if (strlen($nom) <= 255) {
      if (strlen($console) <= 255) {
        if (strlen($genre) <= 255) {
          $jeu = $Connect->prepare("SELECT * FROM jeux WHERE jeu = ?");
          $jeu->execute(array($nom));
          $jeuexist = $jeu->rowCount();
          if ($jeuexist == 0) {
            $insertgame = $Connect->prepare("INSERT INTO a_venir(jeu, console, genre, description, stock_prevu, sortie) VALUES(?, ?, ?, ?, ?, ?)");
            $insertgame->execute(array($nom, $console, $genre, $description, $_POST['stock'], $date));
            header("Location: editer.php");
          } else {
            $erreur = "Ce jeu existe déjà !";
          }
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

// correspond à l'insertion d'un nouveau jeu dans la table à venir
require('Autres/header.php');
?>

<body>
  <main>
    <h1>
      <i class="fas fa-edit h1-icon"></i>
      <span>ajouter une nouvelle fiche de jeu</span>
      <hr color="black">
    </h1>
    <?php if ($_SESSION['choice2'] == "oui") { ?>
      <div align="center">
        <form method="POST" action="">
          <label for="nom">Nom du jeu</label><br><br>
          <input class="input" type="text" value="Nom_(Console)" id="nom" name="nom" />
          <br><br>
          <label for="console">Console</label><br><br>
          <select name="console" class="input" id="console">
            <option value="Xbox One">Xbox One</option>
            <option value="PlayStation 4">PlayStation 4</option>
            <option value="Nintendo Switch">Nintendo Switch</option>
          </select>
          <br><br>
          <label for="genre">Genre</label><br><br>
          <select name="genre" class="input" id="genre">
            <option value="Aventure">Aventure</option>
            <option value="Combat">Combat</option>
            <option value="Course">Course</option>
            <option value="Plates-formes">Plates-formes</option>
            <option value="Simulation">Simulation</option>
            <option value="Tir à la première personne">Tir à la première personne</option>
          </select>
          <br><br>
          <label for="description">Description</label><br><br>
          <textarea type="text" class="textarea" id="description" rows="10" cols="35" placeholder="[Copier-coller la description depuis JeuxVidéos.com.]" name="description"></textarea>
          <br><br>
          <label for="stock">Stock</label><br><br>
          <input class="input" type="number" placeholder="Stock" id="stock" value="5" name="stock" min="0" />
          <br><br>
          <input class="submit font-effect-neon" type="submit" name="newgame1" value="Enregistrer" />
        </form>
        <br><br>
        <?php
        if (isset($erreur)) {
          echo '<font color="red">' . $erreur . "</font>";
        }
        ?>
      </div>
    <?php } else { ?>
      <div align="center">
        <form method="POST" action="">
          <label for="nom">Nom du jeu</label><br><br>
          <input class="input" type="text" value="Nom_(Console)" id="nom" name="nom" />
          <br><br>
          <label for="console">Console</label><br><br>
          <select name="console" class="input" id="console">
            <option value="Xbox One">Xbox One</option>
            <option value="PlayStation 4">PlayStation 4</option>
            <option value="Nintendo Switch">Nintendo Switch</option>
          </select>
          <br><br>
          <label for="genre">Genre</label><br><br>
          <select name="genre" class="input" id="genre">
            <option value="Aventure">Aventure</option>
            <option value="Combat">Combat</option>
            <option value="Course">Course</option>
            <option value="Plates-formes">Plates-formes</option>
            <option value="Simulation">Simulation</option>
            <option value="Tir à la première personne">Tir à la première personne</option>
          </select>
          <br><br>
          <label for="description">Description</label><br><br>
          <textarea type="text" class="textarea" id="description" rows="10" cols="35" placeholder="[Copier-coller la description depuis JeuxVidéos.com.]" name="description"></textarea>
          <br><br>
          <label for="stock">Stock prévu</label><br><br>
          <input class="input" type="number" placeholder="Stock prévu" id="stock" value="5" name="stock" min="0" />
          <br><br>
          <label for="date">Date de sortie</label><br><br>
          <input class="input" type="date" id="date" name="date" min="<?= date('Y-m-d', strtotime(' + 1 days')) ?>" />
          <br><br>
          <input class="submit font-effect-neon" type="submit" name="newgame2" value="Enregistrer" />
        </form>
        <br><br>
        <?php
        if (isset($erreur)) {
          echo '<font color="red">' . $erreur . "</font>";
        }
        ?>
      </div>
    <?php } ?>
  </main>
</body>

</html>