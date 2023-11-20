<?php
//check if connected -->
require_once('helpers.php');
require_once('connect.php');
$bdd = connectDB();

session_start();
//$_SESSION['username']="user1"; TESTING!!!!
if (!checkLogin()) {
    header('location: login.php');
    exit();
}

$username = $_SESSION['username'];
$pokemonId = $_GET['pokemonId'] ?? -1;

try {
    $userID = getUserId($username);

    if(isFavorite($pokemonId, $userID)) {
        removeFavorite($userID, $pokemonId);
    }

    else{
        addFavorite($userID, $pokemonId);
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
catch(Exception $e) {
    echo '<script type="text/javascript"> alert("something went wrong, please try again"); 
    window.location.href = "'. $_SERVER['HTTP_REFERER'].'";</script>';
    exit();
}


function addFavorite($userID, $pokemonId): string
{
    global $bdd;

    $insert = "INSERT INTO pokedex.favorites (pokemonID,userID) VALUES($pokemonId,$userID)";
    return $bdd->exec($insert);
}

function removeFavorite($userID, $pokemonId): string
{
    global $bdd;

    $delete = "DELETE FROM pokedex.favorites WHERE userID = $userID AND pokemonId=$pokemonId;";
    return $bdd->exec($delete);
}

/**
 * @throws Exception
 */
function getPokemonById($pokemonId): array
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
    throw new Exception('Invalid pokemonId');
}



