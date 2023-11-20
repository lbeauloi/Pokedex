<?php
session_start();
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
    <!-- search bar -->
    <section class="searchBar">
        <form action="" method="get">
            <input type="text" name="search" placeholder="Search..">
            <input type="submit" value="Search">
        </form>
    </section>
    <main>

<?php
// Utilisez une liste pour afficher les pokemons
    // Sélectionnez le nom, le numéro et l'image de la table pokemon
    // Utilisez une jointure pour obtenir les types associés à chaque Pokémon
    // Si la recherche est active, ne pas afficher tous les pokemons

if(!isset($_GET['search'])){
    displayPokemons();
}

else{
        $search = $_GET['search'];
        $query = "SELECT pokemon.pokemonID ,pokemon.name, pokemon.number, pokemon.picture, GROUP_CONCAT(types.name) AS typeNames
                  FROM pokemon
                  JOIN pokemontype ON pokemon.pokemonID = pokemontype.pokemonID
                  JOIN types ON pokemontype.typeID = types.typeID
                  WHERE pokemon.name LIKE '%$search%'
                  GROUP BY pokemon.pokemonID";
        $result = $bdd->query($query);
        $count = $result->rowCount();
        if($count == 0){
            echo "<h2>No result</h2>";
        }
        else{

            echo "<h2>$count result(s)</h2>";
            echo "<main>";
            foreach($result as $row){
                $checked = evaluateFavorite($row['pokemonID']);
                $pokemonHtml = pokemonHtml($row["picture"],$row["number"], $row["pokemonID"], $row["name"],$row["typeNames"],$checked);
                echo $pokemonHtml;        }
    }
}

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
        $pokemonHtml = pokemonHtml($row["picture"], $row["number"], $row["pokemonID"], $row["name"], $row["typeNames"], $checked);
        echo $pokemonHtml;
    }
}







