<?php
//inclure la bibliothèque Dotenv pour la gestion des variables d'envirronement
require 'vendor/autoload.php';

//charger les varaibales d'envirronement à partir du fichier .env dans le répertoire courant
Dotenv\Dotenv::createUnsafeImmutable(__DIR__)->load();
//appeler la focntion connectDB pour établir la connexion à la db
$bdd = connectDB();
//fonction pour établir la connexion
function connectDB()
{
    try {
        //créer une nouvelle instance de PDOO pour la connexion à la db
        $bdd = new PDO('mysql:host=' . $_ENV["HOST"] . ';dbname=' . $_ENV["DBNAME"] . ';charset=utf8', $_ENV["USER"], $_ENV["PASSWORD"]);
        //retourner l'objet PDO resprésentant la connexion à la db
        return $bdd;
    } catch (Exception $e) {
        //en cas d'erreur, afficher un message d'erreur ry arrêter l'exécution du script 
        die('Erreur : ' . $e->getMessage());
    }
}
