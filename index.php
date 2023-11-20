<?php
session_start();
//For test purpose
//$_SESSION['username']="user1";
require_once('connect.php');
require_once('helpers.php');
global $bdd;
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/style.min.css">
        <title>Home</title>
    </head>
    <body>
    <?php
    require_once('header.php');
    ?>
    <section class="titre"><h1>Liste des pokemons</h1></section>
    <main>
    
<?php
displayPokemons();
// Utilisez une liste pour afficher les pokemons
    // Sélectionnez le nom, le numéro et l'image de la table pokemon
    // Utilisez une jointure pour obtenir les types associés à chaque Pokémon

    // Fermeture de la connexion à la base de données
    $bdd = null;
    ?>
  </main>
  </body>
</html>
<?php

function displayPokemons(){
   global $bdd;
    // $query = 'SELECT pokemon.pokemonID ,pokemon.name, pokemon.number, pokemon.picture, GROUP_CONCAT(types.name) AS typeNames
    //           FROM pokemon
    //           JOIN pokemontype ON pokemon.pokemonID = pokemontype.pokemonID
    //           JOIN types ON pokemontype.typeID = types.typeID
    //           GROUP BY pokemon.pokemonID';
    $query = 'SELECT pokemon.pokemonID, pokemon.name, pokemon.number, pokemon.picture, GROUP_CONCAT(types.name) AS typeNames
          FROM pokemon
          JOIN pokemontype ON pokemon.pokemonID = pokemontype.pokemonID
          JOIN types ON pokemontype.typeID = types.typeID
          GROUP BY pokemon.pokemonID';


foreach ($bdd->query($query) as $row) {
    $checked = evaluateFavorite($row['pokemonID']);
    
    $types = explode(',', $row['typeNames']); // Sépare les types par une virgule
    $typeClasses = array_map('strtolower', $types); // Convertit les types en minuscules

    echo
        '<div class="container">';
    
    // Afficher l'image, le numéro et le nom du Pokémon
    echo '<img class="imagePokemon" src="' . $row["picture"] . '" alt="image du pokemon">';
    echo '<p class="number">' . $row["number"] . '</p>';
    echo '<p class="name"><a class="nameLink" href="detail.php?id=' . $row["pokemonID"] . '">' . $row["name"] . '</a></p>';

    // Afficher les types avec les styles distincts pour chaque type
    echo '<div class="types">';
    foreach ($types as $type) {
        echo '<p class="' . strtolower($type) . '">' . $type . '</p>';
    }
    echo '</div>';

    // Afficher la partie pour le cœur (favori)
    echo '<div class="heart">';
    echo '<form action="favoritesManager.php" method="GET">';
    echo '<input type="hidden" name="pokemonId" value="' . $row['pokemonID'] . '"/>';
    echo '<input onChange="submit()" type="checkbox" id="heart' . $row['pokemonID'] . '" '.$checked.'/>';
    echo '<label for="heart' . $row['pokemonID'] . '"></label>';
    echo '</form>';
    echo '</div>';

    echo '</div>';
}



}
function evaluateFavorite($pokemonId):string{
    if(!checkLogin())
        return "";
    $userId=-1;
    try{
        $userId = getUserId($_SESSION['username']);
    }
    catch(Exception $e){
        $e->getMessage();
    }

    return isFavorite($pokemonId,$userId)? "checked":"";
}






