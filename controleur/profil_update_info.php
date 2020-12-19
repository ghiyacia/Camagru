<?php
if (!isset($_SESSION)) {
  session_start();
}

if ($_SESSION == NULL) {
  header('location:../index.php');
}
require_once("../model/db_user_action.php");


$regex_password = "#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$#";
$regex_email = "#^([\w._-]+)([@])([A-Za-z0-9._-]+){2,}([.])([a-zA-Z]){2,4}$#";
$regex_nam = "#([A-Za-z]){2,50}$#";

if (isset($_POST['send_update_pseudo'])) {
  $id_user = $_SESSION['id_user'];

  if (isset($_POST['send_update_pseudo'])) {
    $pseudo = htmlspecialchars($_POST['pseudo_update']);

    if (empty($pseudo)) {
      $message = "Le champ pseudo est vide";
    } else if (!preg_match($regex_nam, $pseudo)) {
      $message = "le pseudo n'est pas valide";
    } else if (pseudo_verif($pseudo) != 0) {
      $message = "le pseudo et déja utiiser";
    } else {
      $message = update_pseudo($id_user, $pseudo);
      $_SESSION['pseudo'] = $pseudo;
    }
  } else {
    $message = "Le champ pseudo doit être remplis";
  }
} else if (isset($_POST['send_update_mail'])) {
  $id_user = $_SESSION['id_user'];
  if (isset($_POST['send_update_mail'])) {
    $email = htmlspecialchars($_POST['email_update']);
    $email_confirm = htmlspecialchars($_POST['email_update_confirm']);
    if (empty($email) ||  empty($email_confirm)) {
      $message = "L'un des champs  mail et vide";
    } else if (!preg_match($regex_email, $email)) {
      $message = "Le mail n'est pas valide";
    } else if (!preg_match($regex_email, $email_confirm)) {
      $message = "Le mail n'est pas valide";
    } else if ($email != $email_confirm) {
      $message = "Les deux mails ne sont pas pareils";
    } else if (mail_verif($email) != 0) {
      $message = "Le mail est déja utiiser";
    } else {
      $message = update_mail($id_user, $email);
      $_SESSION['mail'] = $email;
    }
  } else {
    $message = "Le champs mail doit être remplis";
  }
} else if (isset($_POST['send_update_password'])) {
  $id_user = $_SESSION['id_user'];
  if (isset($_POST['send_update_password'])) {
    $password = htmlspecialchars($_POST['password_update']);
    $password_confirm = htmlspecialchars($_POST['password_update_confirm']);
    if (empty($password) || empty($password_confirm)) {
      $message = "L'un des champs password et vide";
    } else if ($password != $password_confirm) {
      $message = "Les deux mot de passe ne sont pas pareils";
    } else if (!preg_match($regex_password, $password)) {
      $message = "Votre mot de passe doit contenir 8 a 15 caractères maximum,au moins 1 majuscule et minuscule, 1 chiffre et 1 l'un de ces caractères -+!*$@%_ ";
    } else if (!preg_match($regex_password, $password_confirm)) {
      $message = "Le password n'est pas valide";
    } else {
      $password = sha1($password);
      $message = update_password($id_user, $password);
    }
  } else {
    $message = "Le champs password doit être remplis";
  }
}
