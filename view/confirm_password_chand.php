<?php
require_once ("header.php");
if (isset($_GET['password_ok']))
{    
    $message = htmlspecialchars($_GET['password_ok']);
    $mes = 'Le password a ete changer';
    if ($message == $mes)
    {
        echo"<div class = 'row' id='menu_accueil'>";
            echo"<div class='col'>";
                echo"<a href='connexion.php'> <img src='../public/images/signin.png' style = 'height : 500 px; width: 400px;'alt='' ><br /><h1 class = 'id-sng'>Se connecter</h1></a>";
            echo "</div>";
        echo "</div>";
        echo '<font color="red">' . $message . "</font>";
    }
    else
    {
        echo"<div id = 'co'>";

            if (isset($message))
            {
                echo '<font color="red">' . $message . "</font>";
            }
        "</div>";

    }
}
require_once ("footer.php");
