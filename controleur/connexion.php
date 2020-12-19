<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once('../model/db_user_action.php');
$regex_password = "#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$#";
$regex_nam = "#([A-Za-z]){2,50}$#";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (
    isset($_POST['submit_log']) && isset($_POST['pseudo_log'])
    && isset($_POST['password_log'])
  ) {
    $pseudo_log = htmlspecialchars($_POST['pseudo_log']);
    $password_log = htmlspecialchars($_POST['password_log']);
    if (empty($pseudo_log) && empty($password_log)) {
      $message = "Tous les champs doivent être remplis";
    } else if (!preg_match($regex_nam, $pseudo_log)) {
      $message = "Le pseudo contient un caractère nom valide";
    } else if (!preg_match($regex_password, $password_log)) {
      $message = "Votre mot de passe ou le pseudo n'est pas bon ";
    } else {
      $password_log = sha1($password_log);
      $message = connexion_verif($pseudo_log, $password_log);
    }
  } else {
    $message = "Tous les champs doivent être remplis";
  }
}
