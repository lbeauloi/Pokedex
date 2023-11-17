<?php
require 'vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__)->load();

function connectDB() {
    try
    {
        $bdd = new PDO('mysql:host='.$_ENV["HOST"].';dbname='.$_ENV["DBNAME"].';charset=utf8', $_ENV["USER"], $_ENV["PASSWORD"]);
        return $bdd;
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }  
}
?>