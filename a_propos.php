<?php
session_start();
require('Autres/fonctions.php');

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}

require('Autres/header.php');
?>

<body>
  <main>
    <h1>
      <i class="fas fa-info-circle h1-icon"></i>
      <span>à propos</span>
      <hr color="black">
    </h1>
    <h2>Une équipe soudée [...]<br></h2>
    <div class="caroussel-images">
      <div id="caroussel">
        <div class="images">
          <img src="caroussel2/boss.jpg">
          <img src="caroussel2/equipe.jpg">
          <img src="caroussel2/ludotheque.jpg">
          <img src="caroussel2/bistro.jpg">

        </div>
      </div>
    </div>
    <h2>[...] pour vous servir avec le sourire !<br></h2>
    <br>
    <hr color="black">
    <br>
    <h2>Un succès fulgurant [...]<br></h2>
    <table border=1 frame=void rules=rows align="center">
      <tr>
        <td class="infos">Julien Chièze</td>
        <td class="infos"><img class="profil" src="Profils/julien.jpg" alt="Julien.jpg"></td>
        <td class="infos"><a href="https://www.facebook.com/julienchieze" target="_blank"><i class="fab fa-facebook-square"></i></a> <a href="https://twitter.com/JulienChieze" target="_blank"><i class="fab fa-twitter-square"></i></a> <a href="https://www.youtube.com/c/JulienChi%C3%A8ze/featured" target="_blank"><i class="fab fa-youtube-square"></i></a></td>
        <td class="infos">La référence du JV sur YouTube<br>Fondateur et directeur du Bistro du JV</td>
      </tr>
      <tr>
        <td class="infos">Axel Villeret</td>
        <td class="infos"><img class="profil" src="Profils/axel.jpg" alt="Julien.jpg"></td>
        <td class="infos"><a href="https://www.facebook.com/axelvilleret/" target="_blank"><i class="fab fa-facebook-square"></i></a> <a href="https://twitter.com/AxelVilleret" target="_blank"><i class="fab fa-twitter-square"></i></a> <a href="https://www.linkedin.com/in/axel-villeret-95574b1a7/" target="_blank"><i class="fab fa-linkedin"></i></a></td>
        <td class="infos">Étudiant à l'ENSIM au talent très prometteur<br>Développeur du site du Bistro du JV</td>
      </tr>
    </table>
    <h2>[...] qui n'aurait pas été possible sans ces 2 génies !<br></h2>
  </main>
</body>

</html>