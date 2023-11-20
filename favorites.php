<?php
//démrrer la session PHP pour maintenir l'état de l'utilisateur entre les requêtes.
session_start();
require_once('connect.php');
require_once('helpers.php');
//$_SESSION['username']="user1"; TESTING!!!!
if (!checkLogin()) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté.
    header('location: login.php');
    // Arrêter l'exécution du script pour éviter toute exécution supplémentaire.
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
        try {
            // Récupérer l'ID de l'utilisateur en utilisant le nom d'utilisateur de la session.
            $userID = getUserId($_SESSION['username']);
            // Appeller une fonction pour afficher les favoris de l'utilisateur.
            displayFavorites($userID);
        } catch (Exception $e) {
            // Capturer les éventuelles exceptions et récupère le message d'erreur (bien que non utilisé ici).
            $e->getMessage();
        }
        ?>
    </main>
</body>

</html>

<?php
// Récuperer à nouveau l'ID de l'utilisateur (redondant, déjà fait ci-dessus).
$userId = getUserId($_SESSION['username']);

function displayFavorites($userId): void
{
    // Récupérer les favoris de l'utilisateur en fonction de son ID.
    $favorites = getFavoritesById($userId);
    foreach ($favorites as $fav) {
        // Pour chaque enregistrement, afficher une entrée de liste
        $checked = evaluateFavorite($fav['pokemonID']);
        $types = explode(',', $fav['typeNames']);
        $pokemonHtml = pokemonHtml($fav["picture"], $fav["number"], $fav["pokemonID"], $fav["name"], $types, $checked);
        // Afficher le HTML généré pour chaque Pokémon.
        echo $pokemonHtml;
    }
}

function getFavoritesById($userId)
{
    // Utiliser la connexion à la base de données globale
    global $bdd;
    //Requête SQL pour récupérer les Pokémon favoris de l'utilisateur
    $query = "SELECT pokemon.pokemonID ,pokemon.name, pokemon.number, pokemon.picture, GROUP_CONCAT(types.name) AS typeNames
              FROM pokemon
              JOIN pokemontype ON pokemon.pokemonID = pokemontype.pokemonID
              JOIN types ON pokemontype.typeID = types.typeID
              WHERE pokemon.pokemonID in (SELECT pokemonID FROM favorites WHERE userID = $userId)
              GROUP BY pokemon.pokemonID";

    // Exécuter la requête et retourne le résultat
    return $bdd->query($query);
}
