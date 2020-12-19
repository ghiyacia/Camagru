<?php
require_once('../model/db_user_action.php');
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
    <div id='form-contain'>
        <h2>L'équipe Camagru vous remercie</h2>

        <div>
            <div>
                <a id="lien_res" class="btn" href="connexion.php">Me connecter</a>
            </div>
        </div>
        <?php
        $pseudo = htmlspecialchars(urldecode($_GET['pseudo']));
        $key_mail = htmlspecialchars(urldecode($_GET['key_mail']));
        $message = mail_valid($pseudo, $key_mail);

        if (isset($message)) {
            echo '<font color="red">' . $message . "</font>";
        }

        ?>
    </div>
    </div>
    <footer class="page-footer font-small mdb-color lighten-3 pt-4" style="margin-top: 30em;">
        <div class="footer-copyright text-center py-3" style="color: white; margin-top: 1em;">© 2019 Copyright:Ghiyacia
        </div>
    </footer>


</body>

</html>