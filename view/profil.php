<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION == NULL) {
    header('location:../index.php');
}
require_once("../controleur/profil.php");
require_once("../controleur/connexion.php");
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body style="background-color:#222">
    <!-- ///////////NAV///////////// -->
    <p></p>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="margin-top: -1em;">
        <div class="navbar-collapse collapse show" id="navbarColor01" style="">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="navbar-brand" s href="../index.php">Camagru</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../index.php">Accueil<span class="sr-only">(current)</span></a>
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
                    <a class="nav-link" href="../view/capture.php">Photo</a>
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
        </div>
    </nav>
    <div id="div_generale" class="col">

        <?php if ($_SESSION != NULL) {
            $photo_base = "../public/images/rose.jpg";
            echo "<div class='card'>";
            if ($src_img == 0) {
                echo "<img src=" . $photo_base . " alt='Ma photo' style='width:100%'>";
            } else {
                echo "<img src=" . $src_img[0] . " alt='Ma photo' style='width:100%'>";
            }
            echo "<h1>" . $_SESSION['pseudo'] . "</h1>";
            echo "<h1>" . $_SESSION['lastname'] . "</h1>";
            echo "<h1>" . $_SESSION['firstname'] . "</h1>";
            echo "<h2>" . $_SESSION['mail'] . "</h2>";

            echo "<p><button id='mon_bouton' style='width:200px';><a id = 'profil_lien'href='../view/capture.php' style='color:withe;'>Prendre une photo</a> </button>" .  " " .
                "<button id='mon_bouton' style='width:200px'><a id = 'profil_lien' href = 'profil_update_info.php'>Modifier le profil</a></button>" . "</p>";

            $style = "";
            if ($couleur == 0) {
                $style = "background: red;";
            } else {
                $style = "background: green;";
            }
            echo "<form id='notif_activ' method='POST'>";
            echo "<input style =''type='hidden' id = 'id_img_gal' name = 'id_notif' value = 1 >";
            echo "<p><input style='width:200px;" . $style . "' id = 'mon_bouton' classe = 'send' type='submit'  name='submit_notif_active' value='Notification' /><p>";
            echo "</form>";


            echo "</div>";
        } ?>
    </div>
    <footer class="page-footer font-small mdb-color lighten-3 pt-4" style="margin-top: 12em;">

        <div class="footer-copyright text-center py-3" style="color: white; margin-top: 1em;">© 2019 Copyright:
            Ghiyacia
        </div>


    </footer>