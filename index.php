<?php
session_start();
//For test purpose
//$_SESSION['username']="user1";
require_once('connect.php');
require_once('helpers.php');
require_once('header.php');
$bdd = connectDB();
?>
    <h1>Liste des pokemons</h1>

    <!-- Utilisez une liste pour afficher les pokemons -->
    <?php
    // Sélectionnez le nom, le numéro et l'image de la table pokemon
    // Utilisez une jointure pour obtenir les types associés à chaque Pokémon
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
            <p class="number">' . $row["number"] . '</p>
            <p class="name"><a href="detail.php?id=' . $row["pokemonID"] . '">' . $row["name"] . '</a></p>
            <div class="types"><p class="types">' . str_replace(",", '</p><p class="types">', $row["typeNames"]) . '</p></div>
            <img src="' . $row["picture"] . '" alt="image du pokemon">
                <div>
                     <form action="favoritesManager.php" method="GET">
                     <input type="hidden" name="pokemonId" value="' . $row['pokemonID'] . '"/>
                     <input onChange="submit()" type="checkbox" id="heart' . $row['pokemonID'] . '" '.$checked.'/>
                     <label for="heart' . $row['pokemonID'] . '"></label>
                     </form>

                 </div>
        </div>';
    }

    // Fermeture de la connexion à la base de données
    $bdd = null;
    ?>
  </main>
  </body>
</html>
<?php

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






