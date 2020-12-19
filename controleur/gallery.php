<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once('../model/db_user_action.php');

$bdd = db_connexion();
$photos_par_page = 6;
$photos_totales =  rec_nb_id();
$pages_totales = ceil($photos_totales / $photos_par_page);
if (isset($_GET['page']) and !empty($_GET['page']) and $_GET['page'] > 0 and $_GET['page'] <= $pages_totales) {
  $_GET['page'] = intval($_GET['page']);
  $page_courante = $_GET['page'];
} else {
  $page_courante = 1;
}

$depart = ($page_courante - 1) * $photos_par_page;
$phot = img_rec_db($depart, $photos_par_page);
$pho = $phot->fetchAll();
//------------------------like------------------//
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['like']) && isset($_POST['id_img_gal'])) {
    $id_img_gal = htmlspecialchars($_POST['id_img_gal']);

    if (empty($id_img_gal)) {
      $message = "Une erreur est survenue veuillez réessayer plus tard ";
    } else {
      $id_user = $_SESSION['id_user'];
      $message = like_dislike($id_img_gal, $id_user);
    }
  }
}
//-----------------add comment------------///
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['btn_comment']) && isset($_POST['input_comment']) && isset($_POST['id_img_gal'])) {
    $id_img_gal = htmlspecialchars($_POST['id_img_gal']);
    $comment = htmlspecialchars($_POST['input_comment']);

    if (empty($id_img_gal)) {
      $message = "Une erreur est survenue veuillez réessayer plus tard ";
    } else if (empty($comment)) {
      $message = "Vous deverz écrire un commentaire";
    } else {
      $id_user = $_SESSION['id_user'];
      $message = comment_add($id_img_gal, $id_user, $comment);
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['id_comment_gal']) && isset($_POST['btn_comment_del'])) {

    $id_com_gal = htmlspecialchars($_POST['id_comment_gal']);

    if (empty($id_com_gal)) {
      $message = "un probleme et survenue";
    } else {
      $id_user = $_SESSION['id_user'];
      $message = del_comment($id_user, $id_com_gal);
    }
  }
}
