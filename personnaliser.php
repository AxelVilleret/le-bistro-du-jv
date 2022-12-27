<?php
session_start();
require('Autres/fonctions.php');

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<?php

if (isset($_GET['filtrer'])) {
  header("Location: resultats_filtre.php");
}

// si l'utilisateur a validé son filtre, on le redirige vers la page de résultats du filtre
require('Autres/header.php');
?>
<body>
  <main>
    <h1>
      <i class="fas fa-sort-amount-down h1-icon"></i>
      <span>personnaliser...</span>
      <hr color="black">
    </h1>
    <form method="GET" action="resultats_filtre.php">
      <ul>
        <li>
          <legend>Consoles :</legend>
        </li><br>
        <ul>
          <li><label class="custom-checkbox" for="xbox"><input type="hidden" name="console[0]" value=""><input type="checkbox" id="xbox" name="console[0]" value="Xbox One"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Xbox One</label></li>
          <li><label class="custom-checkbox" for="play"><input type="hidden" name="console[1]" value=""><input type="checkbox" id="play" name="console[1]" value="PlayStation 4"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> PlayStation 4</label></li>
          <li><label class="custom-checkbox" for="switch"><input type="hidden" name="console[2]" value=""><input type="checkbox" id="switch" name="console[2]" value="Nintendo Switch"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Nintendo Switch</label></li>
        </ul><br>
        <li>
          <legend>Genres :</legend>
        </li><br>
        <ul>
          <li><label class="custom-checkbox" for="aventure"><input type="hidden" name="genre[0]" value=""><input type="checkbox" id="aventure" name="genre[0]" value="Aventure"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Aventure</label></li>
          <li><label class="custom-checkbox" for="combat"><input type="hidden" name="genre[1]" value=""><input type="checkbox" id="combat" name="genre[1]" value="Combat"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Combat</label></li>
          <li><label class="custom-checkbox" for="course"><input type="hidden" name="genre[2]" value=""><input type="checkbox" id="course" name="genre[2]" value="Course"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Course</label></li>
          <li><label class="custom-checkbox" for="plates-formes"><input type="hidden" name="genre[3]" value=""><input type="checkbox" id="plates-formes" name="genre[3]" value="Plates-formes"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Plates-formes</label></li>
          <li><label class="custom-checkbox" for="simulation"><input type="hidden" name="genre[4]" value=""><input type="checkbox" id="simulation" name="genre[4]" value="Simulation"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Simulation</label></li>
          <li><label class="custom-checkbox" for="tir"><input type="hidden" name="genre[5]" value=""><input type="checkbox" id="tir" name="genre[5]" value="Tir à la première personne"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Tir à la première personne</label></li>
        </ul>
      </ul><br>
      <button type="submit" class="submit font-effect-neon" name="filtrer" value="filtre" style="margin-left: 2rem;">Appliquer ces filtres</button>
    </form>
  </main>
</body>

</html>