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
    //récupérer l'ID de l'utilisateur en utilisant le nom d'utilisateur de la session
    $userID = getUserId($username);
    $resFavorite = isFavorite($pokemonId, $userID) ? removeFavorite($userID, $pokemonId) : addFavorite($userID, $pokemonId);
    //if ok, redirect to loing page
} catch (Exception $e) {
    //Capturer les éventuelles exceptions et récupérer le message d'erreur.
    $resFavorite = $e->getMessage();
}

//afficher le résultat du traitement
echo $resFavorite;
//afficher un bouton de retour à la page d'accueil
echo '<button><a href="index.php">Home</a></button>';


//Fonction pour ajouter un Pokémon aux favoris de l'utilisateur
function addFavorite($userID, $pokemonId): string
{
    global $bdd;
    //Initialiser un tableau pour stocker les données du Pokémon
    $pokemon = array();
    try {
        //récupérer les infos du pokémon par son ID
        $pokemon = getPokemonById($pokemonId);
        $insert = "INSERT INTO pokedex.favorites (pokemonID,userID) VALUES($pokemonId,$userID)";
        //exécuter la requête d'insertion dans le tableau des favoris
        $res = $bdd->exec($insert);
    } catch (Exception $e) {
        //capturer les exceptions et récupérer le message d'erreur
        $res = $e->getMessage();
    }

    return $res === 1 ? '<p> Pokemon ' . $pokemon['name'] . ' is correctly added to your favorites.</p>' : (gettype($res) === 'string' ? $res : '<p> Exception has occurred, ' . $pokemon['name'] . ' not added to your favorites.</p>');
}

// Fonction pour supprimer un Pokémon des favoris de l'utilisateur
function removeFavorite($userID, $pokemonId): string
{
    global $bdd;
    try {
        //récupérer les infos du pokémon par son ID
        $pokemon = getPokemonById($pokemonId);
        $delete = "DELETE FROM pokedex.favorites WHERE userID = $userID AND pokemonId=$pokemonId;";
        //exécuter la requête de suppression de la table des favoris
        $res = $bdd->exec($delete);
    } catch (Exception $e) {
        $res = $e->getMessage();
    }

    return ($res === 1) ? '<p> Pokemon ' . $pokemon['name'] . ' is correctly removed from your favorites.</p>' : (typeof($res) === 'string' ? $res : '<p> Exception has occurred, ' . $pokemon['name'] . ' not removed from your favorites.</p>');
}

//fonction pour obtenir les info d'un pokémon par son ID
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
    //lancer une exception si l'ID du pokémon est invalide
    return throw new Exception('Invalid pokemonId');
}
