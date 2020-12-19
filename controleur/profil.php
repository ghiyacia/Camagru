<?php
if (!isset($_SESSION)) {
  session_start();
}
if ($_SESSION == NULL) {
  header('location:../index.php');
}

require_once('../model/db_user_action.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['submit_notif_active']) && isset($_POST['id_notif'])) {
    $notif = htmlspecialchars($_POST['id_notif']);

    if (empty($notif)) {
      $message = "le bouton le marche pas";
    } else {
      $id_user = $_SESSION['id_user'];
      $messagee = desactive_notif_mail($id_user);
    }
  }
}
$id_user = $_SESSION['id_user'];
$src_img = recup_photo_user($id_user);
$couleur = tofinf_info($id_user);
