<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION == NULL) {
    header("location:../index.php");
}
$id_user_img  = 0;
if ($_SESSION != NULL) {
    $id_user_img = htmlspecialchars($_SESSION['id_user']);
}
if ($_SESSION == NULL) {
    header('location:../index.php');
}
require_once('../model/db_user_action.php');
if (isset($_POST['sup_img'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['sup_img'])) {
            $src_img = htmlspecialchars($_POST['src_img']);
            if (empty($src_img)) {
                $message = "L'image na pas été supprimer";
            } else {
                $res = sup_img($src_img);
                if ($res != NULL) {
                    $message = "votre photo a été supprimer";
                    header("locatio:../capture.php");
                } else {
                    $message = "votre photo na pas été supprimer";
                }
            }
        }
    }
} else {
    if (isset($_POST['imageData'])) {
        $id = htmlspecialchars($_SESSION['id_user']);
        $image = htmlspecialchars($_POST['imageData']);
        db_img_insert($image, $id);
        $result = db_img_insert($image, $id);
    }
}
$imag = recup_img($id_user_img);
$imge = $imag->fetchAll();
