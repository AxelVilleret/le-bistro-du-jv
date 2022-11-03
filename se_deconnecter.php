<?php
session_start();
$_SESSION = array();
session_destroy();
header("Location: accueil.php");

// la page de déconnexion consiste simplement en la destruction de toutes les variables de sessions de l'utilisateur
