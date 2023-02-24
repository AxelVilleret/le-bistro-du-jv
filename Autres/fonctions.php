<?php

/**
 * Fonction de connexion à la base de données
 * @return PDO  
 * 
 */
function dbConnect() // user : epiz_33272024 pass : OMyvTZhcR3Zv6s host : sql105.epizy.com dbname : epiz_33272024_le_bistro_du_jv
{
  $host = 'localhost';
  $dbname = 'le_bistro_du_jv';
  $user = 'root';
  $pass = '';
  $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $user, $pass);
  return $db;
}

function panier_plein($panier)
{
  $plein = 0;
  if ($panier == 1) {
    if ($_SESSION['panier1'] != "") {
      $plein = 1;
    }
  }
  if ($panier == 2) {
    if ($_SESSION['panier1'] != "" and $_SESSION['panier2'] != "") {
      $plein = 1;
    }
  }
  if ($panier == 3) {
    if ($_SESSION['panier1'] != "" and $_SESSION['panier2'] != "" and $_SESSION['panier3'] != "") {
      $plein = 1;
    }
  }
  return $plein;
}

/**
 * Fonction qui ajoute un jeu dans un panier
 * @param string $jeu 
 * @param int $panier 
 */
function ajouter_panier($jeu, $panier)
{
  if ($panier == 1) {
    if ($_SESSION['panier1'] == "") {
      $_SESSION['panier1'] = $jeu;
    }
  }
  if ($panier == 2) {
    if ($_SESSION['panier1'] == "") {
      $_SESSION['panier1'] = $jeu;
    } elseif ($_SESSION['panier2'] == "") {
      $_SESSION['panier2'] = $jeu;
    }
  }
  if ($panier == 3) {
    if ($_SESSION['panier1'] == "") {
      $_SESSION['panier1'] = $jeu;
    } elseif ($_SESSION['panier2'] == "") {
      $_SESSION['panier2'] = $jeu;
    } elseif ($_SESSION['panier3'] == "") {
      $_SESSION['panier3'] = $jeu;
    }
  }
}

function init_panier($panier)
{
  if ($panier == 1) {
    $_SESSION['panier1'] = "";
  }
  if ($panier == 2) {
    $_SESSION['panier1'] = "";
    $_SESSION['panier2'] = "";
  }
  if ($panier == 3) {
    $_SESSION['panier1'] = "";
    $_SESSION['panier2'] = "";
    $_SESSION['panier3'] = "";
  }
}

function taille_panier($id)
{
  $panier = 3;
  $Connect = dbConnect();
  $req = $Connect->prepare('SELECT rendu FROM reservations WHERE id= ?');
  $req->execute(array($id));
  while ($rendu = $req->fetch()) {
    if ($rendu['rendu'] == 0) {
      $panier -= 1;
    }
  }
  return $panier;
}

/**
 * Fonction qui retourne le nombre de jours écoulés depuis une date
 * @param string $date Date à comparer
 * @return int Nombre de jours écoulés
 * 
 */
function temps_ecoule($date)
{
  $date_compare1 = date("d-m-Y h:i:s a", strtotime(date("d-m-Y")));

  $date_compare2 = date("d-m-Y h:i:s a", strtotime($date));

  $difference = strtotime($date_compare1) - strtotime($date_compare2);
  $difference = $difference / (60 * 60 * 24);

  return $difference;
}
