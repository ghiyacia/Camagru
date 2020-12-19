<?php

require_once('../model/db_user_action.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $regex_email = "#^([\w._-]+)([@])([A-Za-z0-9._-]+){2,}([.])([a-zA-Z]){2,4}$#";
    if (isset($_POST['send_recup_password']) and isset($_POST['email'])) {
        $email = htmlspecialchars($_POST['email']);
        if (empty($email)) {
            $message = "Le champ et vide";
        } else if (!preg_match($regex_email, $email)) {
            $message = "L'adresse Mail n'est pas valide";
        } else {
            $message  = reset_password($email);
        }
    } else {
        $message = "Le champ et vide";
    }
}
