<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION != NULL) {
    header("location:../index.php");
}
require_once('../model/db_user_action.php');
if (isset($_GET['code_verif']) || isset($_GET['mail'])) {
    $regex_password = "#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$#";
    $code = htmlspecialchars($_GET['code_verif']);
    $mail =  htmlspecialchars($_GET['mail']);
    if (empty($code) && empty($mail)) {
        $message = 'URL Invalide videw';
    } else if (!verif_code($code, $mail))
        $message = 'URL Invalide existe pas';
    else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['submit_password_oublier'])) {
                $password = htmlspecialchars($_POST['password_reset']);
                $password1 = htmlspecialchars($_POST['password_reset1']);

                if (empty($password) || empty($password1))
                    $message = "Les deux champs doive être remplis";
                else if (!preg_match($regex_password, $password))
                    $message = "Votre mot de passe doit contenir 8 a 15 caractères maximum,au moins 1 majuscule et minuscule, 1 chiffre et 1 l'un de ces caractères -+!*$@%_ ";
                else if ($password != $password1)
                    $message = "Le mot de passe n'est pas le même";
                else if (reset_password_by_mail($password, $mail)) {
                    $message = 'Le password a ete changer';
                    header("location:../view/confirm_password_chand.php?password_ok=" . urlencode($message));
                } else
                    $message = 'Une Erreur est survenue ';
            } else {
                $message = 'URL Invalide';
            }
        }
    }
} else {
    $message = 'URL Invalide le code ou le mail ne corresponde pas';
}
