<?php
session_start();
require_once('connect.php');
require_once('helpers.php');
//$_SESSION['username']="user1"; TESTING!!!!
if (!checkLogin()) {
    header('location: login.php');
    exit();
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/style.min.css">
        <title>Favorites</title>

    </head>
    <body>
    <?php
    require_once('header.php');
    ?>
    <main>
        <?php
    try{
        $userID = getUserId($_SESSION['username']);
        displayFavorites($userID);
    }

    catch(Exception $e) {
        $e->getMessage();
    }
    ?>
    </main>
    </body>
    </html>

<?php

$userId = getUserId($_SESSION['username']);

function displayFavorites($userId):void
{

    $favorites = getFavoritesById($userId);
    foreach ($favorites as $fav) {
        // Pour chaque enregistrement, afficher une entrée de liste
        $checked = evaluateFavorite($fav['pokemonID']);
        $pokemonHtml = pokemonHtml($fav["picture"], $fav["number"], $fav["pokemonID"], $fav["name"], $fav["typeNames"], $checked);
        echo $pokemonHtml;
    }
}

function getFavoritesById($userId)
{
    global $bdd;
    $query = "SELECT pokemon.pokemonID ,pokemon.name, pokemon.number, pokemon.picture, GROUP_CONCAT(types.name) AS typeNames
              FROM pokemon
              JOIN pokemontype ON pokemon.pokemonID = pokemontype.pokemonID
              JOIN types ON pokemontype.typeID = types.typeID
              WHERE pokemon.pokemonID in (SELECT pokemonID FROM favorites WHERE userID = $userId)
              GROUP BY pokemon.pokemonID";

    return $bdd->query($query);

}