<?php
session_start();
require('Autres/fonctions.php');
$_SESSION = array();
session_destroy();
header("Location: accueil.php");

// la page de déconnexion consiste simplement en la destruction de toutes les variables de sessions de l'utilisateur
