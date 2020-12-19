<?php

require_once('database.php');

function mail_verif($email)
{
    $bdd = db_connexion();
    $req_mail = $bdd->prepare("SELECT * FROM users WHERE mail = ?");
    try {
        $req_mail->execute(array($email));
        $mail_exist = $req_mail->rowCount();
        return $mail_exist;
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('-1');
    }
}

function pseudo_verif($pseudo)
{
    $bdd = db_connexion();
    $req_pseudo = $bdd->prepare("SELECT * FROM users WHERE pseudo = ?");
    try {
        $req_pseudo->execute(array($pseudo));
        $pseudo_exist = $req_pseudo->rowCount();
        return ($pseudo_exist);
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('-1');
    }
}

function db_add_user($pseudo, $lastname, $firstname, $mail, $password, $key_mail)
{

    $bdd = db_connexion();
    $req_ins = $bdd->prepare("INSERT INTO users 
        (pseudo, lastname, firstname, mail, password, key_mail) VALUES (?, ?, ?, ?, ?, ?)");
    try {
        $added_User = $req_ins->execute(array($pseudo, $lastname, $firstname, $mail, $password, $key_mail));
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('-1');
    }
}

function confirm_mail($email, $key_mail, $pseudo)
{
    $envoyeur = "riles42born2code@gmail.com";
    $destinataire = $email;
    $sujet = "Activer votre compte";
    $message =
        "Bonjour " . $pseudo . "L'equipe Camagru vous remercie pour votre inscription.
            Cliquez sur le lien pour valider votre inscription.
            http://localhost:8080/view/activation_compte.php?pseudo="
        . urlencode($pseudo) . "&key_mail=" . urlencode($key_mail);
    $headers = "From:<" . $envoyeur . ">\r\n";
    $envoye = mail($destinataire, $sujet, $message, $headers);
    if ($envoye) {
        return ("Le mail a été envoyé");
    } else {
        delet_user($email, $pseudo);
    }
}

function delet_user($mail, $pseudo)
{
    $bdd = db_connexion();
    try {
        $user_delet = $bdd->prepare('DELETE FROM users $mail = ? AND $pseudo = ?');
        $delet = $user_delet->execute();
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('-1');
    }
}

function mail_valid($pseudo, $key_mail)
{
    $bdd = db_connexion();
    if (
        isset($pseudo, $key_mail) and
        !empty($pseudo) and !empty($key_mail)
    ) {
        $req_user = $bdd->prepare("SELECT * FROM users WHERE pseudo = ? AND key_mail = ?");
        try {
            $req_user->execute(array($pseudo, $key_mail));
            $user_exist = $req_user->rowCount();
        } catch (PDOException $exp) {
            echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
            return ('-1');
        }
        if ($user_exist == 1) {
            $user = $req_user->fetch();
            if ($user['activ_compt'] == 0) {
                $updat_user = $bdd->prepare("UPDATE users SET activ_compt = 1 WHERE pseudo = ? AND key_mail = ?");
                try {
                    $updat_user->execute(array($pseudo, $key_mail));
                    return ("Votre compte a bien été activer");
                } catch (PDOException $exp) {
                    echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
                    return ('-1');
                }
            } else {
                return ("Votre compte a déjà été confirmé");
            }
        } else {
            return ("L'utilisateur n'existe pas");
        }
    }
}

function connexion_verif($pseudo_log, $password_log)
{
    $bdd = db_connexion();
    $req_log = $bdd->prepare("SELECT * FROM users WHERE pseudo = ? AND password = ?  AND activ_compt = 1");
    try {
        $req_log->execute(array($pseudo_log, $password_log));
        $user_log = $req_log->rowCount();
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return (false);
    }
    if ($user_log == 1) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $user_info = $req_log->fetch();
        $_SESSION['id_user'] = $user_info['id_user'];
        $_SESSION['firstname'] = $user_info['firstname'];
        $_SESSION['lastname'] = $user_info['lastname'];
        $_SESSION['pseudo'] = $user_info['pseudo'];
        $_SESSION['mail'] = $user_info['mail'];
        $_SESSION['password'] = $user_info['password'];

        header("Location:../view/profil.php");
    } else {
        $message = "Mauvais pseudo ou mot de passe";
        return ($message);
    }
}

function reset_password($mail_req_pass)
{
    $recupe_code = uniqid('', true);
    $bdd = db_connexion();

    $mail_exist = $bdd->prepare('SELECT * FROM users WHERE mail = ? AND activ_compt = 1');
    try {
        $mail_exist->execute(array($mail_req_pass));
        $mail_exist = $mail_exist->rowCount();
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('-1');
    }
    if ($mail_exist == 0) {
        return ("Le mail n'existe pas");
    } else {
        $recup_info = $bdd->prepare("SELECT * FROM users WHERE mail = ? AND code_reset_password = NULL");
        try {
            $recup_info->execute(array($mail_req_pass));
            $recup_infos = $recup_info->rowCount();
        } catch (PDOException $exp) {
            echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
            return ('-1');
        }

        if ($recup_infos == 1) {
            $rescup_insert = $bdd->prepare('INSERT INTO users (mail, code_reset_password) VALUE (?, ?)');

            try {
                $rescup_insert->execute(array($mail_req_pass, $recupe_code));
                chang_mail_password($mail_req_pass, $recupe_code);
                return ('Un mail vous a été envoyer pour modifier votre mot de passe');
            } catch (PDOException $exp) {
                echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
                return ('-1');
            }
        } else {
            $resc_up_insert = $bdd->prepare('UPDATE users SET code_reset_password = ? WHERE mail = ?');

            try {
                $resc_up_insert->execute(array($recupe_code, $mail_req_pass));
                chang_mail_password($mail_req_pass, $recupe_code);
                return ('Un mail vous a été envoyer pour modifier votre mot de passe');
            } catch (PDOException $exp) {
                echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
                return ('-1');
            }
        }
    }
}




function chang_mail_password($mail, $code)
{

    $envoyeur = "riles42born2code@gmail.com";
    $destinataire = $mail;
    $sujet = "Changer votre mot de passe";
    $message =
        "Bonjour cliquez sur le lien pour modifier vitre mot de passe.
            http://localhost:8080/view/password_oublier.php?code_verif="
        . urlencode($code) . "&mail=" . urlencode($mail);
    $headers = "From:<" . $envoyeur . ">\r\n";
    $envoye = mail($destinataire, $sujet, $message, $headers);
    if ($envoye) {
        return ('Le mail été envoyé.');
    } else {
        return ("L'mail na pas été envoyé.");
    }
}

function verif_code($code, $mail)
{
    $bdd = db_connexion();
    $code_existe = $bdd->prepare('SELECT * FROM users WHERE code_reset_password = ? AND mail = ?');
    try {
        $code_existe->execute(array($code, $mail));
        $code_existe = $code_existe->rowCount();
        return ($code_existe);
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('-1');
    }
}

function reset_password_by_mail($password, $mail)
{
    $bdd = db_connexion();
    $h_password = sha1($password);
    $update_password = $bdd->prepare("UPDATE users SET password = ?  WHERE mail = ? ");
    try {
        $result = $update_password->execute(array($h_password, $mail));
        net_res_pass($mail);
        return ($result);
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('-1');
    }
}

function net_res_pass($mail)
{
    $key_mail = md5(uniqid(mt_rand()));
    $bdd = db_connexion();
    $update_password = $bdd->prepare("UPDATE users SET code_reset_password = ?  WHERE mail = ? ");
    try {
        $result = $update_password->execute(array($key_mail, $mail));
        return "ok";
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('-1');
    }
}


function update_mail($id_user, $email)
{
    $bdd = db_connexion();
    $req_up_mail = $bdd->prepare("UPDATE users SET mail = ? WHERE id_user = ?");
    try {
        $req_up_mail->execute(array($email, $id_user));
        return ("Le mail a été modifier");
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('-1');
    }
}

function update_pseudo($id_user, $pseudo)
{
    $bdd = db_connexion();
    $req_up_pseudo = $bdd->prepare("UPDATE users SET pseudo = ? WHERE id_user = ?");
    try {
        $req_up_pseudo->execute(array($pseudo, $id_user));
        return ("Le pseudo a été modifier");
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('-1');
    }
}

function update_password($id_user, $password)
{
    $bdd = db_connexion();
    $req_up_password = $bdd->prepare("UPDATE users SET password = ? WHERE id_user = ?");
    try {
        $req_up_password->execute(array($password, $id_user));
        return ("Le mot de passe a été modifier");
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('-1');
    }
}

function db_img_insert($img, $id)
{
    $bdd = db_connexion();
    $req_img = $bdd->prepare("INSERT INTO images (id_user, chemin) VALUE (?, ?)");
    try {
        $result = $req_img->execute(array($id, $img));
        return ($result);
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('erreur de requette');
    }
}

function recup_img_gallery()
{
    $bdd = db_connexion();
    try {
        $req_img = $bdd->query('SELECT `chemin` FROM `images` ORDER BY id_image DESC');
        return ($req_img);
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
}

function recup_img($id_user_img)
{
    $bdd = db_connexion();
    try {
        $req_img = $bdd->query("SELECT chemin FROM images WHERE id_user = '$id_user_img'  ORDER BY id_image DESC ");
        return ($req_img);
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
}

function img_rec_db($depart, $photos_par_page)
{
    $bdd = db_connexion();
    try {
        $photos = $bdd->query("SELECT id_image,chemin FROM images ORDER BY id_image DESC LIMIT $depart,$photos_par_page");
        return ($photos);
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
}

function rec_nb_id()
{
    $bdd = db_connexion();

    try {
        $photos_totales_req = $bdd->query('SELECT id_image FROM images');
        $photos_totales = $photos_totales_req->rowCount();
        return ($photos_totales);
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
}

function sup_img($src_img)
{
    $bdd = db_connexion();
    $req_img = $bdd->prepare("DELETE FROM images WHERE chemin = ? ");

    try {
        $req_img->execute(array($src_img));
        $res = $req_img;
        return ($res);
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
}

function like_dislike($id_img, $id_user)
{
    $bdd = db_connexion();
    $req_like = $bdd->prepare("SELECT * FROM likes WHERE id_image = ? AND id_user = ?");
    try {
        $req_like->execute(array($id_img, $id_user));
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
    $res_like = $req_like->rowCount();
    $like_row = $req_like->fetch();
    $id_like = $like_row[0];
    if ($res_like == 0) {
        $req_add = $bdd->prepare("INSERT INTO likes (id_image, id_user) VALUE (?, ?)");
        try {
            $req_add->execute(array($id_img, $id_user));
            return ("Votre like a été ajouter");
        } catch (PDOException $exp) {
            echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
            return ('NULL');
        }
    } else {
        $req_del = $bdd->prepare("DELETE FROM likes WHERE id_like = ?");
        try {
            $req_del->execute(array($id_like));
            return ("Votre like a été enlever");
        } catch (PDOException $exp) {
            echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
            return ('NULL');
        }
    }
}

function  like_photo($id_img)
{
    $bdd = db_connexion();

    $req_like = $bdd->prepare("SELECT * FROM likes WHERE id_image=?");

    try {
        $req_like->execute(array($id_img));
        $req_res = $req_like->rowCount();
        return $req_res;
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
}

function comment_add($id_img_gal, $id_user, $comment)
{
    $bdd = db_connexion();

    $req_comment = $bdd->prepare("INSERT INTO comments (id_user, id_image, comment) VALUE (?, ?, ?)");
    try {
        $req_comment->execute(array($id_user, $id_img_gal, $comment));
        $res_id = recup_users($id_img_gal);
        verif_notif_mail($res_id);
        return ("Votre commentaire a été ajouter");
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
}

function comment_recup($id_img)
{
    $bdd = db_connexion();
    $req_comment = $bdd->prepare("SELECT * FROM comments WHERE id_image = ? ");
    try {
        $req_comment->execute(array($id_img));
        $req_res = $req_comment->fetchAll();
        $un = $req_res;
        foreach ($un as $deux) {
            echo $deux[3];
            echo "<form action='gallery.php' method='POST' id = 'form_del_com'>";
            echo "<input type='hidden' id = 'id_comment_gal' name = 'id_comment_gal' value = $deux[0] >";
            echo "<button class=' del-but' type='submit' name = 'btn_comment_del'  style='width:100%;'>Supprimer</button>";
            echo "</form>";
        }
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
}

function recup_users($id_img_gal)
{
    $bdd = db_connexion();
    $req = $bdd->prepare("SELECT id_image,id_user FROM images WHERE id_image=?");
    try {
        $req->execute(array($id_img_gal));
        $res = $req->fetch();
        return ($res[1]);
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
}
function verif_notif_mail($id_user)
{
    $comment = 1;
    $bdd = db_connexion();
    $req_notif = $bdd->prepare("SELECT id_user FROM users WHERE id_user =? AND mail_comment = ?");
    try {
        $req_notif->execute(array($id_user, $comment));
        $req_res = $req_notif->rowCount();
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
}
function mail_confirm_comment($mail)
{
    $envoyeur = "riles42born2code@gmail.com";
    $destinataire = $mail;
    $sujet = "Commentaire";
    $message = "Bonjour un nouveau commentaire a été ajouter a votre photo";
    $headers = "From:<" . $envoyeur . ">\r\n";
    $envoye = mail($destinataire, $sujet, $message, $headers);
    if ($envoye) {
        return ('Email envoyé');
    } else {
        return ('Email refusé.');
    }
}

function desactive_notif_mail($id_user)
{

    $bdd = db_connexion();
    $req_notif = $bdd->prepare("SELECT mail_comment FROM users WHERE id_user =? AND mail_comment= 1");

    try {
        $req_notif->execute(array($id_user));
        $req_res = $req_notif->rowCount();
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
    if ($req_res == 1) {
        try {
            $req_up = $bdd->prepare("UPDATE users SET mail_comment = 0 WHERE id_user = ?");
            $req_up->execute(array($id_user));
            return ("Notification désactiver");
        } catch (PDOException $exp) {
            echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
            return ('NULL');
        }
    } else {
        $req_up = $bdd->prepare("UPDATE users SET mail_comment = 1 WHERE id_user = ?");
        try {
            $req_up->execute(array($id_user));
            return ("Notification activer");
        } catch (PDOException $exp) {
            echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
            return ('NULL');
        }
    }
}

function img_db_import($img, $id_user)
{
    $bdd = db_connexion();
    $req = $bdd->prepare("INSERT INTO images (chemin,id_user) VALUE (?, ?)");
    try {
        $req->execute(array($img, $id_user));
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
}

function del_comment($id_user, $id_com)
{
    $bdd = db_connexion();

    $req = $bdd->prepare("DELETE FROM comments WHERE id_comment='$id_com'  AND  id_user = '$id_user'");
    $milou = $req->execute();

    $reqq = $bdd->prepare("SELECT id_comment FROM comments WHERE id_comment = ?");

    try {
        $reqq->execute(array($id_com));
        $req_res = $reqq->rowCount();
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }

    if ($req_res == 0) {
        return ("Le commentaire a été supprimer");
    } else
        return ("Vous ne pouvez pas suppprimer le message d'un autre utilisatuer");
}

function recup_photo_user($id_user)
{
    $bdd = db_connexion();

    $req = $bdd->prepare("SELECT chemin FROM images WHERE id_user = ?");

    try {
        $req->execute(array($id_user));

        $req_res = $req->rowCount();
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
    if ($req_res === 0) {
        return (0);
    } else {
        $req_res = $req->fetchAll();
        return ($req_res[0]);
    }
}

function tofinf_info($id_user)
{
    $bdd = db_connexion();
    $req = $bdd->prepare("SELECT * FROM users WHERE id_user = ? AND mail_comment = 1");

    try {
        $req->execute(array($id_user));
        $req_res = $req->rowCount();
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
    if ($req_res == 0) {
        return (0);
    } else {
        return (1);
    }
}

function like_inf_info($id_user, $id_img)
{
    $bdd = db_connexion();
    $req = $bdd->prepare("SELECT * FROM likes WHERE id_user = ? AND id_image = ?");

    try {
        $req->execute(array($id_user, $id_img));
        $req_res = $req->rowCount();
    } catch (PDOException $exp) {
        echo "erreur dans la requette sql", $exp->getMessage(), "<br/>";
        return ('NULL');
    }
    if ($req_res == 0) {
        return (0);
    } else {
        return (1);
    }
}
