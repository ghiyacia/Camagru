<?php
    require_once("../controleur/password_oublier.php"); 
    require_once("header.php");
    if (isset($_GET['code_verif']) || isset($_GET['mail']))
    {
        $code = htmlspecialchars($_GET['code_verif']);
        $mail =  htmlspecialchars($_GET['mail']);
    echo"<h2>Changer votre mot de passe </h2>";

    echo "<div id='Formulaire_password_oublier' class='row'>";
        echo "<div class='col'>";
            echo "<form id='formulaire_password_oublier' method='POST' ".$_SERVER['PHP_SELF']."?code_verif=".$code."&mail=".$mail.">";
                    echo "<label for='password_reset'>Mot de passe</label>: <br /><input type='password' placeholder='Mot de passe' id='password_reset' name='password_reset' value='' /><br />";
                    echo"<label for='password_reset1'>Confirmer mot de passe</label> : <br /><input type='password' placeholder='Mot de passe' id='password_reset1' name='password_reset1' value='' />";
                    echo "<br /> <input classe = 'send' type='submit'  id='submit_password_oublier' name='submit_password_oublier' value='envoyer' />";
            echo "</form>";
       echo "</div>";
    echo "</div>";
    }
    echo "<div id = 'co'>";

    if (isset($message))
    {
        echo '<font color="red">' . $message . "</font>";
    }
     require_once("footer.php");

    echo"</div>";

    
     require_once("footer.php");
