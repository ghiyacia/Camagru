<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(E_ALL ^ E_NOTICE);
$bdd = new PDO('mysql:host=localhost;charset=utf8', 'root', '');

$table_drop = "DROP DATABASE IF EXISTS camagru";

$base = "CREATE DATABASE IF NOT EXISTS camagru CHARACTER SET  'utf8' COLLATE = utf8_general_ci";
try {
    $bdd->prepare($base)->execute();
    echo ('base de donnees cree ');
} catch (PDOException $ex) {
    echo "erreur mysql", $ex->getMessage(), "<br/>";
}

try {

    var_dump($bdd->prepare("USE camagru;")->execute());
    // var_dump($gg);

} catch (PDOException $ex) {
    echo "erreur mysql", $ex->getMessage(), "<br/>";
}


//
////creation de la table users
//
$table_drop = "DROP TABLE IF EXISTS users";
$table = "CREATE TABLE IF NOT EXISTS users (
        id_user TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        pseudo varchar(50) NOT NULL,
        firstname varchar(50) NOT NULL,
        lastname varchar(50) NOT NULL,
        mail varchar(50) NOT NULL,
        key_mail varchar(70) NOT NULL,
        password varchar(70) NOT NULL,
        code_reset_password varchar(255) DEFAULT NULL,
        activ_compt tinyint(1)  DEFAULT '0',
        mail_comment tinyint(1)  DEFAULT '1'
        )ENGINE=InnoDB ";
try {
    $bdd->prepare($table_drop)->execute();
    $gg = $bdd->prepare($table)->execute();
    var_dump($gg);
    echo "Creation de la table users </br>";
} catch (PDOException $ex) {
    echo "erreur dans la requette sql", $ex->getMessage(), "<br/>";
}

// // 
// ////creation de la table IMAGE
// //

$table_drop = "DROP TABLE IF EXISTS images";
$table = "CREATE TABLE IF NOT EXISTS images ( 
        id_image TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        id_user TINYINT UNSIGNED NOT NULL,
        chemin longblob NOT NULL,
        FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
        )ENGINE=InnoDB ";
try {
    $gg = $bdd->prepare($table)->execute();
    var_dump($gg);
    echo "Creation de la table IMAGE </br>";
} catch (PDOException $ex) {
    echo "erreur dans la requette sql", $ex->getMessage(), "<br/>";
}



// 
//// creation de la table COMMENT
//

$table_drop = "DROP TABLE IF EXISTS comment";
$table = "CREATE TABLE IF NOT EXISTS comments (
        id_comment TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        id_user TINYINT UNSIGNED NOT NULL,
        id_image TINYINT UNSIGNED NOT NULL,
        comment VARCHAR(255) NOT NULL,
        FOREIGN KEY (id_user) REFERENCES users(id_user)ON DELETE CASCADE,
        FOREIGN KEY (id_image) REFERENCES images(id_image) ON DELETE CASCADE
        )ENGINE=InnoDB ";
try {
    $gg = $bdd->prepare($table)->execute();
    var_dump($gg);
    echo "Creation de la table Comment </br>";
} catch (PDOException $ex) {
    echo "erreur dans la requette sql", $ex->getMessage(), "<br/>";
}


// // 
// //// Creation de la table likes
// //

$table_drop = "DROP TABLE IF EXISTS likes";
$table = "CREATE TABLE IF NOT EXISTS likes (
    id_like TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_image TINYINT UNSIGNED NOT NULL,
    id_user TINYINT UNSIGNED NOT NULL,
    FOREIGN KEY (id_image) REFERENCES images(id_image) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id_user)
    )ENGINE=InnoDB ";
try {
    $gg = $bdd->prepare($table)->execute();
    var_dump($gg);
    echo "Creation de la table Likes </br>";
} catch (PDOException $ex) {
    echo "erreur dans la requette sql", $ex->getMessage(), "<br/>";
}

$bdd = NULL; //fermer la connexion a la base de donnees
