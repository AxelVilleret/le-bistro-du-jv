<?php
session_start();
require('Autres/fonctions.php');

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<!-- si on détecte une recherche, on redirige l'utilisateur vers la page résultats de recherche -->

<?php
// fonction qui retourne le nombre de jours écoulés depuis une date rentrée

$Connect = dbConnect();
$req1 = $Connect->query('SELECT * FROM a_venir');
while ($fiches = $req1->fetch()) {
  if (temps_ecoule($fiches['sortie']) >= 0) {
    $req2 = $Connect->prepare('DELETE FROM a_venir WHERE jeu = ?');
    $req2->execute(array($fiches['jeu']));
    $req3 = $Connect->prepare('INSERT INTO jeux VALUE (?, ?, ?, ?, ?)');
    $req3->execute(array($fiches['jeu'], $fiches['console'], $fiches['genre'], $fiches['description'], $fiches['stock_prevu']));
  }
}

// on vérifie les dates des jeux de la section à venir et s'il y a des dates passées, on ajoute les jeux correspondant dans la table jeux
require('Autres/header.php');
?>

<body>
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