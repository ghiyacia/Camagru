<?php

require_once("../model/db_user_action.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $regex_password = "#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$#";
    $regex_email = "#^([\w._-]+)([@])([A-Za-z0-9._-]+){2,}([.])([a-zA-Z]){2,4}$#";
    $regex_nam = "#([A-Za-z]){2,50}$#";
    if (isset($_POST['submit'])) {
        $lastname = htmlspecialchars($_POST['lastname']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $password_confirm = htmlspecialchars($_POST['password_confirm']);
        if (
            empty($lastname) || empty($firstname) || empty($pseudo) ||
            empty($email) || empty($password) || empty($password_confirm)
        ) {
            $message = "Tous les champs doivent être remplis";
        } else if (!preg_match($regex_nam, $lastname)) {
            $message = "Le nom contient un caractère non valide";
        } else if (!preg_match($regex_nam, $firstname)) {
            $message = "Le prénom contient un caractère non valide";
        } else if (!preg_match($regex_nam, $pseudo)) {
            $message = "Le pseudo contient un caractère non valide";
        } else if (!preg_match($regex_email, $email)) {
            $message = "L'adresse Mail n'est pas valide";
        } else if (!preg_match($regex_password, $password_confirm)) {
            $message = "Votre mot de passe doit contenir 8 a 15 caractères maximum,au moins 1 majuscule et minuscule, 1 chiffre et 1 l'un de ces caractères -+!*$@%_ ";
        } else if ($password != $password_confirm) {
            $message = "le mot de passe ne correspond pas";
        } else if (mail_verif($email) != 0) {
            $message = 'le mail et déjà prie';
        } else if (pseudo_verif($pseudo) != 0) {
            $message = "le pseudo existe déjà";
        } else {
            $key_mail = md5(uniqid(mt_rand()));
            $password = sha1($password);
            db_add_user($pseudo, $lastname, $firstname, $email, $password, $key_mail);
            confirm_mail($email, $key_mail, $pseudo);
            $message = "Merci de votre inscription !!! Un mail vous a ete envoyer pour activer votre boite mail!!!!!!!!!!!!!!!!";
        }
    } else {
        $message = "le formulaire est vide";
    }
}
