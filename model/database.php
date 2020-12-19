<?php

function db_connexion()
{
  try {
    $bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', '');
    return ($bdd);
  } catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
    return NULL;
  }
}
