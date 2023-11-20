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

function displayPokemons()
{
    // Utilisez une liste pour afficher les pokemons
    // Sélectionnez le nom, le numéro et l'image de la table pokemon
    // Utilisez une jointure pour obtenir les types associés à chaque Pokémon

    global $bdd;
    $query = getPokemonQuery();

    foreach ($bdd->query($query) as $row) {
        // Pour chaque enregistrement, afficher une entrée de liste
        $checked = evaluateFavorite($row['pokemonID']);
        $pokemonHtml = pokemonHtml($row["picture"],$row["number"], $row["pokemonID"], $row["name"],$row["typeNames"],$checked);
        echo $pokemonHtml;
    }

}







