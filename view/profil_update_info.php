<?php
require_once("../controleur/profil_update_info.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title> <?php ?> </title>
    <link rel="stylesheet" href="../public/styleform.css" />
    <link rel="stylesheet" href="../public/bootstrap.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- ///////////NAV///////////// -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="navbar-brand" href="#">Camagru</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="../index.php">Accueil <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../view/inscription.php">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../view/profil.php">Profil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../view/gallery.php">Galerie</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php if (isset($_SESSION['id_user'])) {
                                                if ($_SESSION['id_user'] != NULL) {
                                                    echo "../model/session.php";
                                                }
                                            } else {
                                                echo "../view/connexion.php";
                                            } ?>">
                    <?php if (isset($_SESSION['id_user'])) {
                        if ($_SESSION['id_user'] != NULL) {
                            echo "Déconnexion";
                        }
                    } else {
                        echo "Connexion";
                    } ?></a>
            </li>
        </ul>
    </nav>

    <!-- ///////////FORM////////////// -->

    <div id='form-contain' style='margin-top:4%'>
        <h2 id="co">Modifier mes information</h2>
        <form id="formulaire_update_pseudo" method="POST" action="profil_update_info.php">
            <div class="input-container">
                <i class="fa fa-user icon"></i>
                <input class="input-field" type="text" placeholder="Pseudo" id="pseudo_update" name="pseudo_update" value="" />
            </div>
            <input class="btn" type="submit" id="lien_res" name="send_update_pseudo" value="Modifier" />
        </form>
        <form id="formulaire_update_mail" method="POST" action="profil_update_info.php">
            <div class="input-container" style='margin-top:1em;'>
                <i class="fa fa-envelope icon"></i>
                <input class="input-field" type="email" placeholder="Email" id="email_update" name="email_update" value="" />
            </div>
            <div class="input-container">
                <i class="fa fa-envelope icon"></i>
                <input class="input-field" type="email" placeholder="Confirmer l'email" name="email_update_confirm" value="" />
            </div>
            <input id="lien_res" class="btn" type="submit" id="send_update_mail" name="send_update_mail" value="Modifier" />
        </form>
        <form id="formulaire_update_password" method="POST" action="profil_update_info.php">
            <div class="input-container" style='margin-top:1em;'>
                <i class="fa fa-key icon"></i>
                <input class="input-field" type="password" placeholder="Password" id="password_update" name="password_update" value="" />
            </div>
            <div class="input-container">
                <i class="fa fa-key icon"></i>
                <input class="input-field" type="password" placeholder="Password" id="password_update_confirm" name="password_update_confirm" value="" />
            </div>
            <input class="btn" type="submit" id="lien_res" name="send_update_password" value="Modifier">
        </form>

        <div id="erreur">
            <?php
            if (isset($message)) {
                echo '<font color="red">' . $message . "</font>";
            }
            ?>
        </div>
    </div>
    <!-- ////////footer///////// -->
    <footer class="page-footer font-small mdb-color lighten-3 pt-4" style="margin-top: 30em;">
        <div class="footer-copyright text-center py-3" style="color: white; margin-top: 1em;">© 2019 Copyright:Ghiyacia
        </div>
    </footer>
</body>

</html>