<?php
//check if connected -->
require_once('helpers.php');
require_once('connect.php');
//Établir la connexion à la base de données.
$bdd = connectDB();

//Démarrer la session PHP pour maintenir l'état de l'utilisateur entre les requêtes.
session_start();
//$_SESSION['username']="user1"; TESTING!!!!
if (!checkLogin()) {
    //rediriger vers la page login
    header('location: login.php');
    //arrêter l'exécution dus cript 
    exit();
}

//récupérer le username 
$username = $_SESSION['username'];
//récupérer l'ID du pokémon à partir des  paramètres de requête ou utilise -1 par défaut s'il est absent
$pokemonId = $_GET['pokemonId'] ?? -1;

try {
    $userID = getUserId($username);

    if (isFavorite($pokemonId, $userID)) {
        removeFavorite($userID, $pokemonId);
    } else {
        addFavorite($userID, $pokemonId);
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} catch (Exception $e) {
    echo '<script type="text/javascript"> alert("something went wrong, please try again"); 
    window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
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
    //eécuter la requête pour obtenir les info du pokémon
    $res = $bdd->query($query);

    if ($res->rowCount() === 1) {
        //récupérer la première ligne du résultat
        $row = $res->fetch();
        return array(
            "name" => $row['name'],
            "number" => $row['number']
        );
    }
    throw new Exception('Invalid pokemonId');
}
