<?php
session_start();
require('Autres/fonctions.php');

if (isset($_GET['s']) and !empty($_GET['s'])) {
  $_SESSION['s'] = $_GET['s'];
  header("Location: resultats_recherche.php");
}
?>

<?php

if (isset($_GET['choice1'])) {
  $_SESSION['choice1'] = $_GET['choice1'];
  header("Location: editer(1).php");
}

// si l'administrateur a choisi l'action qu'il souhaite éxecuter, on le redirige vers la page editer(1).php
require('Autres/header.php');
?>

<body>
  <main>
    <h1>
      <i class="fas fa-edit h1-icon"></i>
      <span>éditer</span>
      <hr color="black">
    </h1>
    <form method="GET" action="">
      <ul>
        <li>
          <legend>Que souhaitez-vous faire ?</legend>
        </li><br>
        <ul>
          <li><label class="custom-radio" for="add"><input type="radio" id="add" name="choice1" value="add"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Ajouter une nouvelle fiche de jeu</label></li>
          <li><label class="custom-radio" for="modifier"><input type="radio" id="modifier" name="choice1" value="modifier"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Modifier ou supprimer une fiche de jeu existante</label></li>
          <li><label class="custom-radio" for="terminer"><input type="radio" id="terminer" name="choice1" value="terminer"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Terminer une ou plusieurs réservation(s)</label></li>
          <li><label class="custom-radio" for="modifier_classiques"><input type="radio" id="modifier_classiques" name="choice1" value="modifier_classiques"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Éditer le filtre "Classiques"</label></li>
          <li><label class="custom-radio" for="modifier_les_mieux_notes"><input type="radio" id="modifier_les_mieux_notes" name="choice1" value="modifier_les_mieux_notes"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Éditer le filtre "Les mieux notés"</label></li>
          <li><label class="custom-radio" for="modifier_jeux_du_moment"><input type="radio" id="modifier_jeux_du_moment" name="choice1" value="modifier_jeux_du_moment"><i class="fas fa-toggle-off unchecked"></i><i class="fas fa-toggle-on checked"></i> Éditer le filtre "Jeux du moment"</label></li>
        </ul><br>
        <button type="submit" class="submit font-effect-neon" name="valid1" value="valid1" style="margin-left: 2rem;">Valider</button>
    </form>
  </main>
</body>

</html>