<?php

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
    $query = "SELECT UserID FROM pokedex.users WHERE username = '$username'";
    $res = $bdd->query($query);

    if ($res->rowCount() === 1) {
        $row = $res->fetch();
        return $row['UserID'];
    }

    throw new Exception('Invalid login');
}

function pokemonHtml($picture,$number,$id,$name,$types,$checked) : string{

    return'<div class="container">
                <img class="imagePokemon" src="' . $picture . '" alt="image du pokemon">
                <p class="number">' . $number . '</p>
                <p class="name"><a class="nameLink" href="detail.php?id=' . $id . '">' . $name . '</a></p>
                <div class="types"><p class="types">' . str_replace(",", '</p> <p class="types">', $types)  .  '</p></div>
                

                <div class="heart">
                     <form action="favoritesManager.php" method="GET">
                     <input type="hidden" name="pokemonId" value="' . $id . '"/>
                     <input onChange="submit()" type="checkbox" id="heart' . $id . '" ' . $checked . '/>
                     <label for="heart' . $id . '"></label>
                     </form>
                 </div>
        </div>';
}

function getPokemonQuery():string{

    return 'SELECT pokemon.pokemonID ,pokemon.name, pokemon.number, pokemon.picture, GROUP_CONCAT(types.name) AS typeNames
              FROM pokemon
              JOIN pokemontype ON pokemon.pokemonID = pokemontype.pokemonID
              JOIN types ON pokemontype.typeID = types.typeID
              GROUP BY pokemon.pokemonID';
}

function evaluateFavorite($pokemonId):string{
    if(!checkLogin())
        return "";
    $userId=-1;
    try{
        $userId = getUserId($_SESSION['username']);
    }
    catch(Exception $e){
        echo $e->getMessage();
    }

    return isFavorite($pokemonId,$userId)? "checked":"";
}

