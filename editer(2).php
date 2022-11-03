<?php
session_start();

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<?php

$Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');

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

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Éditer - Le bistro du JV</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rancho&effect=neon" />
  <link rel="stylesheet" href="css/general.css" />
  <link rel="stylesheet" href="css/navbar1.css" />
  <link rel="stylesheet" href="css/navbar2.css" />
  <link rel="stylesheet" href="css/accueil.css" />
  <link rel="stylesheet" href="css/affichages.css" />
  <link rel="stylesheet" href="css/formulaires.css" />
  <script src="https://kit.fontawesome.com/03959c15b4.js" crossorigin="anonymous"></script>
  <link rel="icon" type="image/png" href="favicon_package_v0.16/favicon-32x32.png">
</head>

<body>
  <header>
    <nav class="navbar1 font-effect-neon">
      <div class="navbar1-menu">
        <a href="accueil.php" class="logo1">
          <i class="fas fa-gamepad navbar1-icon"></i>
          <span class="navbar1-title">le bistro du jv</span>
        </a>
        <form method="get">
          <input class="searchbar" type="search" name="s" placeholder="Rechercher..." />
          <button class="button" type="submit" value="Valider">
            <i class="fas fa-search button-icon font-effect-neon"></i>
          </button>
        </form>
        <div>
          <?php
          if (!isset($_SESSION['id'])) {
          ?>
            <a href="se_connecter.php" class="navbar1-link">
              <i class="far fa-user navbar1-icon"></i>
              <span class="navbar1-title">se connecter</span>
            </a>
            <a href="s'inscrire.php" class="navbar1-link">
              <i class="fas fa-file-invoice navbar1-icon"></i>
              <span class="navbar1-title">s'inscrire</span>
            </a>
          <?php
          } else {
          ?>
            <a href="mon_panier.php" class="navbar1-link">
              <i class="fas fa-shopping-cart navbar1-icon"></i>
              <span class="navbar1-title">mon panier (<?= $_SESSION['nb_articles'] ?>)</span>
            </a>
            <a href="reservations.php" class="navbar1-link">
              <i class="fas fa-history navbar1-icon"></i>
              <span class="navbar1-title">mes réservations (<?= $_SESSION['reservations'] ?>)</span>
            </a>
            <?php if ($_SESSION['id'] != 0) { ?>
              <a href="mon_compte.php" class="navbar1-link">
                <i class="fas fa-user navbar1-icon"></i>
                <span class="navbar1-title">mon compte</span>
              </a>
            <?php } else { ?>
              <a href="editer.php" class="navbar1-link">
                <i class="fas fa-edit navbar1-icon"></i>
                <span class="navbar1-title">éditer</span>
              </a>
            <?php } ?>
            <a href="se_deconnecter.php" class="navbar1-link">
              <i class="fas fa-user-alt-slash navbar1-icon"></i>
              <span class="navbar1-title">se déconnecter</span>
            </a>
          <?php
          }
          ?>
        </div>
      </div>
    </nav>
    <nav class="navbar2 font-effect-neon">
      <ul class="navbar2-menu">
        <li class="logo2">
          <span class="navbar2-link">
            <span class="navbar2-title">chercher par...</span>
            <i class="fas fa-sliders-h navbar2-icon"></i>
          </span>
        </li>
        <li class="navbar2-item">
          <a href="les_mieux_notes.php" class="navbar2-link">
            <i class="fas fa-star navbar2-icon"></i>
            <span class="navbar2-title">les mieux notés</span>
          </a>
        </li>
        <li class="navbar2-item">
          <a href="jeux_du_moment.php" class="navbar2-link">
            <i class="fas fa-heart navbar2-icon"></i>
            <span class="navbar2-title">jeux du moment</span>
          </a>
        </li>
        <li class="navbar2-item">
          <a href="a_venir.php" class="navbar2-link">
            <i class="fas fa-burn navbar2-icon"></i>
            <span class="navbar2-title">à venir</span>
          </a>
        </li>
        <li class="navbar2-item">
          <a href="classiques.php" class="navbar2-link">
            <i class="fas fa-thumbs-up navbar2-icon"></i>
            <span class="navbar2-title">classiques</span>
          </a>
        </li>
        <li class="navbar2-item">
          <a href="personnaliser.php" class="navbar2-link">
            <i class="fas fa-sort-amount-down navbar2-icon"></i>
            <span class="navbar2-title">personnaliser...</span>
          </a>
        </li>
        <li class="navbar2-item">
          <a href="a_propos.php" class="navbar2-link">
            <i class="fas fa-info-circle navbar2-icon"></i>
            <span class="navbar2-title">à propos</span>
          </a>
        </li>
      </ul>
    </nav>
  </header>
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