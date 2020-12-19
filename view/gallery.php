<?php
require_once('../controleur/gallery.php');
if ($_SESSION == NULL) {
    header("Location:gallery1.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title> <?php ?> </title>
    <link rel="stylesheet" href="../public/style.css" />
    <link rel="stylesheet" href="../public/bootstrap.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body style="background-color: #222 ">
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
    <!-- //////////img galerie/////////// -->
    <?php
    foreach ($pho as $img) {
    ?>
        <div class=galerie-user>
            <div id='galerie-user'>
                <img id='img-galerie' src=<?= $img[1] ?> alt='image'>
            </div>
            <div id='like-comment'>
                <?php
                $id_image = $img[0];
                $couleur = like_inf_info($id_user, $id_image);
                $nb = like_photo($img[0]);
                $style = "";
                if ($couleur == 1) {
                    $style = "background: red;width:50%;";
                } else {
                    $style = "background: #375a7f;width:50%;";
                }
                echo "<form action='gallery.php' method='POST' id = 'form_like'>";
                echo "<input type='hidden' id = 'id_img_gal' name = 'id_img_gal' value = $img[0] >";
                echo "<button id='like-me' class='btn btn-primary btn-lg' style=''" . $style . " class='btn_del' type='submit' name = 'like' >J'aime</button>";
                echo "</form>";

                echo "<h1 id = 'mes-com'>COMMENTAIRE<h1>";
                $cm = comment_recup($img[0]);
                echo "<div id='comment-photo'> " . $cm . "</div>";
                echo "<form action='gallery.php' method='POST' id = 'form_comment'>";
                echo "<textarea class='form-control' id='exampleTextarea'  name = 'input_comment' placeholder = 'votre commentaire'></textarea>";
                echo "<input type='hidden' id = 'id_img_gal' name = 'id_img_gal' value = $img[0] ><br />";
                echo "<button  id='post_bt' class='btn btn-primary btn-lg' type='submit' name = 'btn_comment' style='display:block;'>Poster</button>";
                echo "</form>";
                echo "</div>";
                ?>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="page">
        <?php
        if (isset($message)) {
            echo '<font color="red">' . $message . "</font><br />";
        }
        for ($i = 1; $i <= $pages_totales; $i++) {
            if ($i == $page_courante) {
                echo $i . ' ';
            } else {
                echo '<a href="gallery.php?page=' . $i . '">' . $i . '</a> ';
            }
        }
        ?>
    </div>

</body>

</html>