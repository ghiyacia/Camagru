<?php
require_once("../controleur/capture.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title> <?php ?> </title>
    <link rel="stylesheet" href="../public/bootstrap.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/stylecaptur.css" />
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
    <div class="container">

        <!-- ///////////cam///////////// -->
        <div class="camera_btn">
            <div id="cam_div" class="col">
                <video id="video" width="700" height="600"></video>
                <canvas id="canvas" width="700" height="600"></canvas>
            </div>



            <div class='' id="btn">
                <button class="btn btn-primary" onclick='takePicture()' id="capture" class="pics">Prendre une
                    photo</button>
                <button class="btn btn-primary" onclick='deleteFilter()'>Supprimer le filtre</button>
                <button class="btn btn-primary" onclick='clearButton()' id="clear-button" class="btn btn-light">Supprimer la galerie</button>
                <button class="btn btn-primary" onclick='camOn()' id="cam-on-of" class="btn btn-light">Cam
                    on/off</button>


                <div class="custom-file">
                    <label class="custom-file-label" for="inputGroupFile02">telecharger image</label>
                    <input class="input-group-text" type="file" name="file" id="inputGroupFile02">
                </div>
            </div>

            <div class='col' id='filter' style="display:flex;">
                <ul id="photo-montge">
                    <?php

                    $path = "../public/images/filter";
                    $index = 0;
                    $files = scandir($path);
                    foreach ($files as $file) {
                        $fl = explode('.', $file);
                        if ($fl[1] == 'png') {
                            $index++;
                    ?>
                            <li> <img onclick='addFilter(<?= $index ?>)' class='filter' id='<?= $index ?>' src="<?= '../public/images/filter/' . $file ?>" /></li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div id="photos">

        </div>
        <div>
        </div>
    </div>
    </div>
    <div id="co">
        <?php
        if (isset($message)) {
            echo '<font color="red">' . $message . "</font>";
        }
        ?>
    </div>

    <footer class="page-footer font-small mdb-color lighten-3 pt-4" style="">
        <div class="container">
            <div class="row" style='margin-left: 11em;width: 59em;'>

                <div id='carousel-contain' class="">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <div id='image-carousel' class="carousel-inner">
                            <div class="item active">
                                <img src="../public/images/rose.jpg" alt="Los Angeles" style="width:100%;">
                            </div>
                            <?php
                            foreach ($imge as $img) {
                            ?>
                                <div id='image-carousel' class="item">
                                    <img src=<?= $img[0] ?> alt="ma-photo" style="width:100%;">
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>


            </div>
            <div id='copy' class="footer-copyright text-center py-3" style="yexy-align:center;color: white; margin-top: 1em;">© 2019 Copyright:
                Ghiyacia
            </div>
        </div>

    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="application/javascript" src="../js/test11.js"></script>
    </ul>
    </div>
    </div>

</body>

</html>