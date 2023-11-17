<?php
require 'connect.php';
require 'header.php';
$bdd = connectDB();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>index</title>
    <link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
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
        echo 
        '<div>
            <p class="number">' . $row["number"] . '</p>
            <p class="name"><a href="detail.php?id=' . $row["pokemonID"] . '">' . $row["name"] . '</a></p>
            <div class="types"><p class="types">' . str_replace(",", '</p><p class="types">', $row["typeNames"]) . '</p></div>
            <img src="' . $row["picture"] . '" alt="image du pokemon">
        </div>';
    }
    
    // Fermeture de la connexion à la base de données
    $bdd = null;
    ?>
  </body>
</html>






