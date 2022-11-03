<?php
session_start();

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<!-- si on détecte une recherche, on redirige l'utilisateur vers la page résultats de recherche -->

<?php

function compare_jours($date)
{
  $date_compare1 = date("d-m-Y h:i:s a", strtotime(date("d-m-Y")));

  $date_compare2 = date("d-m-Y h:i:s a", strtotime($date));

  $difference = strtotime($date_compare1) - strtotime($date_compare2);
  $difference = $difference / (60 * 60 * 24);

  return $difference;
}

// fonction qui retourne le nombre de jours écoulés depuis une date rentrée

$Connect = new PDO('mysql:host=127.0.0.1;dbname=le_bistro_du_jv;charset=utf8', 'root', '');
$req1 = $Connect->query('SELECT * FROM a_venir');
while ($fiches = $req1->fetch()) {
  if (compare_jours($fiches['sortie']) >= 0) {
    $req2 = $Connect->prepare('DELETE FROM a_venir WHERE jeu = ?');
    $req2->execute(array($fiches['jeu']));
    $req3 = $Connect->prepare('INSERT INTO jeux VALUE (?, ?, ?, ?, ?)');
    $req3->execute(array($fiches['jeu'], $fiches['console'], $fiches['genre'], $fiches['description'], $fiches['stock_prevu']));
  }
}

// on vérifie les dates des jeux de la section à venir et s'il y a des dates passées, on ajoute les jeux correspondant dans la table jeux

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Accueil - Le bistro du JV</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rancho&effect=neon" />
  <link rel="stylesheet" href="css/general.css" />
  <link rel="stylesheet" href="css/navbar1.css" />
  <link rel="stylesheet" href="css/navbar2.css" />
  <link rel="stylesheet" href="css/accueil.css" />
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
      <i class="fas fa-home h1-icon"></i>
      <span>accueil</span>
      <hr color="black">
    </h1>
    <?php if (!isset($_SESSION['id'])) { ?>
      <h2>Notre équipe vous souhaite la bienvenue !<br></h2>
      <h2>Rejoignez nous et venez vous régaler à notre table !<br></h2>
    <?php } else { ?>
      <h2>Bien le bonjour, <?= $_SESSION['prenom'] ?> !<br></h2>
      <h2>Installez vous confortablement et plongez avec nous dans l'univers du JV !<br></h2>
    <?php } ?>
    <div class="caroussel-images">
      <div id="caroussel">
        <div class="images">
          <img src="caroussel1/pokemon.jpg">
          <img src="caroussel1/halo.jpg">
          <img src="caroussel1/fifa.png">
          <img src="caroussel1/cod.jpg">
        </div>
      </div>
    </div>
    <h2>Notre fierté : pouvoir combler votre soif de JV quels que soient vos goûts !<br></h2>
    <br>
    <hr color="black">
    <br>
    <h2>Un autre objectif : partager notre univers !<br></h2>
    <h3>L'Actualité Playstation...<br><br></h3>
    <div class=videos>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/3JPpTHNNdJY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/gddwC_n77Ws" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <br><br>
    <h3>L'Actualité Nintendo...<br><br></h3>
    <div class=videos>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/ciWYO7slpMM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/358px8ygaxs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <br><br>
    <h3>L'Actualité Xbox...<br><br></h3>
    <div class=videos>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/PVncQ53pna0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/TcuZv0GM6g0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <br><br>
    <h3>Des interviews...<br><br></h3>
    <div class=videos>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/3H4CLPsgFOM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/2ObLAzxxzF8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <br><br>
    <h3>Des tests...<br><br></h3>
    <div class=videos>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/ACZrq1IKXls" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/4eV5zLsPeYQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
  </main>
</body>

</html>