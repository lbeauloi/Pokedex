<?php
//inclure fichier de connexion à la db
require_once('connect.php');

function checkLogin(): bool
{
    $isLogged = true;
    if (!isset($_SESSION['username'])) {
        $isLogged =  false;
    }
    return $isLogged;
}

function isFavorite($pokemonId, $userID): bool
{
    global $bdd;
    //requête SQL pour rechercher le pokémon dnas les favoris du user
    $query = "SELECT favoriteID FROM pokedex.favorites WHERE userID = '$userID' AND pokemonId='$pokemonId';";
    $res = $bdd->query($query);
    return $res->rowCount() === 1;
}

/**
 * @throws Exception
 */
function getUserId($username): int
{
    global $bdd;
    //requête SQL pour récupérer l'ID du user en fonction du nom d'utilisateur
    $query = "SELECT UserID FROM pokedex.users WHERE username = '$username'";
    $res = $bdd->query($query);

    if ($res->rowCount() === 1) {
        $row = $res->fetch();
        return $row['UserID'];
    }

    throw new Exception('Invalid login');
}
function displayType($types){
    $result= ""; 

    foreach ($types as $type) {
        $result =$result . '<p class="' . strtolower($type) . '">' . $type . '</p>';
    }
    return $result;
}; 
//function pour générer le code HTML pour affciher les détails d'un pokémon
function pokemonHtml($picture, $number, $id, $name, $types, $checked): string
{  
    $type= displayType($types);
      return
    '<div class="container">


<img class="imagePokemon" src="' . $picture . '" alt="image du pokemon">
<p class="number">' . $number . '</p>
<p class="name"><a class="nameLink" href="detail.php?id=' . $id . '">' . $name . '</a></p>
<div class="types">'
.$type.

'</div>


<div class="heart">
<form action="favoritesManager.php" method="GET">
<input type="hidden" name="pokemonId" value="' . $id . '"/>
<input onChange="submit()" type="checkbox" id="heart' . $id . '" '.$checked.'/>
<label for="heart' . $id. '"></label>
</form>
</div>

</div>';


}

function getPokemonQuery(): string
{  return "SELECT pokemon.pokemonID, pokemon.name, pokemon.number, pokemon.picture, GROUP_CONCAT(types.name) AS typeNames
    FROM pokemon
    JOIN pokemontype ON pokemon.pokemonID = pokemontype.pokemonID
    JOIN types ON pokemontype.typeID = types.typeID
    GROUP BY pokemon.pokemonID";


}

//focntion pour évaluer si un pokémon est maqrué comme favori pour le user connecté
function evaluateFavorite($pokemonId): string
{
    if (!checkLogin())
        return "";
    $userId = -1;
    try {
        // Obtenir l'ID d'utilisateur en fonction du nom d'utilisateur de la session
        $userId = getUserId($_SESSION['username']);
        $userId = getUserId($_SESSION['username']);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    // Renvoyer "checked" si le Pokémon est favori pour l'utilisateur, sinon une chaîne vide
    return isFavorite($pokemonId, $userId) ? "checked" : "";
}
