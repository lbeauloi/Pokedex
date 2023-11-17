<?php
//check if connected -->
require_once('helpers.php');
require_once('connect.php');
global $bdd;

session_start();
$_SESSION['username']="user1";
if (!checkLogin()) {
    header('location: login.php');
    exit();
}

$username = $_SESSION['username'];
$pokemonId = $_GET['pokemonId'] ?? -1;
checkFavorite($pokemonId,$username);
function checkFavorite($pokemonId, $username)
{
    global $bdd;
    try{
        $userID = getUserId($username);
        $query = "SELECT favoriteID FROM pokedex.favorites WHERE userID = '$userID' AND pokemonId='$pokemonId';";
        $res = $bdd->query($query);

        switch ($res->rowCount()) {
            case 0:
                $resFavorite = addFavorite($userID, $pokemonId);
                break;
            case 1:
            default :
                $resFavorite = removeFavorite($userID, $pokemonId);
                break;
        }
    }

    catch(Exception $e) {
        $resFavorite= $e->getMessage();
    }

    echo $resFavorite;
    echo'<button><a href="index.php">Home</a></button>';

}

function addFavorite($userID, $pokemonId)
{
    global $bdd;
    $pokemon = array();
    try{
        $pokemon = getPokemonById($pokemonId);
        $insert = "INSERT INTO pokedex.favorites (pokemonID,userID) VALUES($pokemonId,$userID)";
        $res = $bdd->exec($insert);
    }
    catch(Exception $e) {
        $res = $e->getMessage();
    }

    return $res === 1 ? '<p> Pokemon '.$pokemon['name'].' is correctly added to your favorites.</p>' :
        (gettype($res) === 'string'? $res : '<p> Exception has occurred, ' . $pokemon['name'] . ' not added to your favorites.</p>');
}

function removeFavorite($userID, $pokemonId)
{
    global $bdd;
    try{
        $pokemon = getPokemonById($pokemonId);
        $delete = "DELETE FROM pokedex.favorites WHERE userID = $userID AND pokemonId=$pokemonId;";
        $res = $bdd->exec($delete);
    }
    catch(Exception $e) {
        $res = $e->getMessage();
    }

    return ($res === 1) ? '<p> Pokemon '.$pokemon['name'].' is correctly removed from your favorites.</p>' :
        (typeof($res) === 'string'? $res : '<p> Exception has occurred, ' . $pokemon['name'] . ' not removed from your favorites.</p>');
}

function getPokemonById($pokemonId) : array
{
    global $bdd;
    $query = "SELECT * FROM pokedex.pokemon WHERE pokemonID = $pokemonId;";
    $res = $bdd->query($query);

    if ($res->rowCount() === 1) {
        $row = $res->fetch();
        return array(
            "name" => $row['name'],
            "number" => $row['number']
        );
    }
return throw new Exception('Invalid pokemonId');
}

function getUserId($username): int
{
    global $bdd;
    $query = "SELECT UserID FROM pokedex.users WHERE username = '$username'";
    $res = $bdd->query($query);

    if ($res->rowCount() === 1) {
        $row = $res->fetch();
        return $row['UserID'];
    }

    return throw new Exception('Invalid login');
}

