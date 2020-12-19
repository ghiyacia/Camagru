<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION) {
    header("location:profil.php");
}
require_once("../controleur/inscription.php");
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
    <div id='form-contain'>
        <div class="titre">
            <h2>Inscription</h2>
        </div>
        <div id="formm_inscription" class="col">

            <form id="formulaire_inscription" method="POST" action="">

                <div class="input-container">
                    <i class="fa fa-user icon"></i>
                    <input class="input-field" type="text" placeholder="Nom" name="lastname">
                </div>

                <div class="input-container">
                    <i class="fa fa-user icon"></i>
                    <input class="input-field" type="text" placeholder="Prénom" name="firstname">
                </div>

                <div class="input-container">
                    <i class="fa fa-user icon"></i>
                    <input class="input-field" type="text" placeholder="Pseudo" name="pseudo">
                </div>

                <div class="input-container">
                    <i class="fa fa-envelope icon"></i>
                    <input class="input-field" type="text" placeholder="Email" name="email">
                </div>

                <div class="input-container">
                    <i class="fa fa-key icon"></i>
                    <input class="input-field" type="password" placeholder="Mot de passe" name="password">
                </div>

                <div class="input-container">
                    <i class="fa fa-key icon"></i>
                    <input class="input-field" type="password" placeholder="Confirmer le mot de passe" name="password_confirm">
                </div>

                <input class="btn" type="submit" id="lien_res" name="submit" value="VALIDER!" />
                <button id="valider_incription" type="" class="btn"> <a id="lien_res" href="connexion.php">CONNEXION</a></button>
                <div id="erreur">
                    <?php
                    if (isset($message)) {
                        echo '<font color="red">' . $message . "</font>";
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
    <!-- ////////footer///////// -->
    <footer class="page-footer font-small mdb-color lighten-3 pt-4" style="margin-top: 30em;">
        <div class="footer-copyright text-center py-3" style="color: white; margin-top: 1em;">© 2019 Copyright:Ghiyacia
        </div>
    </footer>
</body>

</html>