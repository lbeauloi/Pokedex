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
    <?php require_once('header.php'); ?>
    <section class="titre">
        <h1>Liste des pokemons</h1>
    </section>

    <!-- search bar -->
    <section class="searchBar">
        <form action="" method="get">
            <input type="text" name="search" placeholder="Search..">
            <input type="submit" value="Search">
        </form>
    </section>
    <?php
    // Utilisez une liste pour afficher les pokemons
    // Sélectionnez le nom, le numéro et l'image de la table pokemon
    // Utilisez une jointure pour obtenir les types associés à chaque Pokémon
    // Si la recherche est active, affichez uniquement les pokemons dont le nom contient le texte recherché

    if(isset($_GET['search'])){
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
                echo
                    '<div class="container">
                        <img class="imagePokemon" src="' . $row["picture"] . '" alt="image du pokemon">
                        <p class="number">' . $row["number"] . '</p>
                        <p class="name"><a class="nameLink" href="detail.php?id=' . $row["pokemonID"] . '">' . $row["name"] . '</a></p>
                        <div class="types"><p class="types">' . str_replace(",", '</p> <p class="types">', $row["typeNames"])  .  '</p></div>
                        
        
                        <div class="heart">
                             <form action="favoritesManager.php" method="GET">
                             <input type="hidden" name="pokemonId" value="' . $row['pokemonID'] . '"/>
                             <input onChange="submit()" type="checkbox" id="heart' . $row['pokemonID'] . '" ' . $checked . '/>
                             <label for="heart' . $row['pokemonID'] . '"></label>
                             </form>
        
                         </div>
                </div>';
            }
            echo "</main>";
            }
        }
    ?>
    <main>

    

<?php
// Utilisez une liste pour afficher les pokemons
    // Sélectionnez le nom, le numéro et l'image de la table pokemon
    // Utilisez une jointure pour obtenir les types associés à chaque Pokémon
    // Si la recherche est active, ne pas afficher tous les pokemons

if(!isset($_GET['search'])){
    displayPokemons();
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
    $query = 'SELECT pokemon.pokemonID ,pokemon.name, pokemon.number, pokemon.picture, GROUP_CONCAT(types.name) AS typeNames
              FROM pokemon
              JOIN pokemontype ON pokemon.pokemonID = pokemontype.pokemonID
              JOIN types ON pokemontype.typeID = types.typeID
              GROUP BY pokemon.pokemonID';

    foreach ($bdd->query($query) as $row) {
        // Pour chaque enregistrement, afficher une entrée de liste
        $checked = evaluateFavorite($row['pokemonID']);
        echo
            '<div class="container">
                <img class="imagePokemon" src="' . $row["picture"] . '" alt="image du pokemon">
                <p class="number">' . $row["number"] . '</p>
                <p class="name"><a class="nameLink" href="detail.php?id=' . $row["pokemonID"] . '">' . $row["name"] . '</a></p>
                <div class="types"><p class="types">' . str_replace(",", '</p> <p class="types">', $row["typeNames"])  .  '</p></div>
                

                <div class="heart">
                     <form action="favoritesManager.php" method="GET">
                     <input type="hidden" name="pokemonId" value="' . $row['pokemonID'] . '"/>
                     <input onChange="submit()" type="checkbox" id="heart' . $row['pokemonID'] . '" ' . $checked . '/>
                     <label for="heart' . $row['pokemonID'] . '"></label>
                     </form>

                 </div>
        </div>';
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
?>





