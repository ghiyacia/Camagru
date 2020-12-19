<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title> <?php ?> </title>
    <link rel="stylesheet" href="public/bootstrap.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- ////carousell//// -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body style="background-color: #222;">

    <!-- ///////////NAV///////////// -->
    <p></p>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="margin-top: -1em;">
        <div class="navbar-collapse collapse show" id="navbarColor01" style="">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="navbar-brand" s href="index.php">Camagru</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Accueil<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view/inscription.php">Inscription</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view/profil.php">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view/gallery.php">Galerie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view/capture.php">Photo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php if (isset($_SESSION['id_user'])) {
                                                    if ($_SESSION['id_user'] != NULL) {
                                                        echo "model/session.php";
                                                    }
                                                } else {
                                                    echo "view/connexion.php";
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

    <!-- ///////////GALERIE///////////// -->

    <div class="gg" style="margin-top: 4%;">

        <h2 class="" style="padding: 10px 16px;font-size: 18px;line-height: 1.3333333;border-radius: 6px; background-color:#337ab7;;color:white;width: 43%;text-align: center;margin: -1em auto -1em auto;">
            Venez vous faire tirer le portrait ! </h2> <br /><br />

        <div class="container">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="public/images/carousel/photo1.jpg" alt="Los Angeles" style="width:100%;">
                    </div>

                    <div class="item">
                        <img src="public/images/carousel/photo2.jpg" alt="Chicago" style="width:100%;">
                    </div>

                    <div class="item">
                        <img src="public/images/carousel/photo3.jpg" alt="New york" style="width:100%;">
                    </div>
                </div>

                <!-- Left and right controls -->
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


        <!-- //////bouton /////// -->
        <div style="display: flex;">
            <a style="margin: 3% auto 1% 26%;width: 21%;" class="btn btn-primary btn-lg btn-block" href="view/connexion.php">Se connecter</a>
            <a style="margin: 3% auto 1% -21%;width: 21%;" class="btn btn-primary btn-lg btn-block" href="view/inscription.php">Inscription</a>
        </div>

    </div>
    <!-- ////////footer///////// -->
    <footer class="page-footer font-small mdb-color lighten-3 pt-4" style="margin-top: 12em;">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-12 mb-4">
                    <div class="view overlay z-depth-1-half">
                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(73).jpg" class="img-fluid" alt="">
                        <a href="">
                            <div class="mask rgba-white-light"></div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="view overlay z-depth-1-half">
                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(78).jpg" class="img-fluid" alt="">
                        <a href="">
                            <div class="mask rgba-white-light"></div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="view overlay z-depth-1-half">
                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(79).jpg" class="img-fluid" alt="">
                        <a href="">
                            <div class="mask rgba-white-light"></div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 mb-4">
                    <div class="view overlay z-depth-1-half">
                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(81).jpg" class="img-fluid" alt="">
                        <a href="">
                            <div class="mask rgba-white-light"></div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="view overlay z-depth-1-half">
                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(82).jpg" class="img-fluid" alt="">
                        <a href="">
                            <div class="mask rgba-white-light"></div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="view overlay z-depth-1-half">
                        <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(84).jpg" class="img-fluid" alt="">
                        <a href="">
                            <div class="mask rgba-white-light"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright text-center py-3" style="color: white; margin-top: 1em;">© 2019 Copyright:
            Ghiyacia
        </div>
    </footer>

</body>

</html>