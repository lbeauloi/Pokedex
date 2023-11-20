<?php
require_once('connect.php');
require_once('helpers.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.min.css">
    <title>Details</title>
</head>
<body>
<?php
require_once('header.php');

global $bdd;

// Vérifiez si l'ID est défini dans l'URL
if (isset($_GET['id'])) {
    // Utilisez la fonction htmlspecialchars pour éviter les attaques par injection SQL
    $pokemonID = htmlspecialchars($_GET['id']);

    // Sélectionnez le nom, le numéro et l'image de la table pokemon pour le Pokémon spécifique
    // Utilisez une jointure pour obtenir les types associés à ce Pokémon
    $query = "SELECT pokemon.*, GROUP_CONCAT(types.name) AS typeNames
              FROM pokemon
              JOIN pokemontype ON pokemon.pokemonID = pokemontype.pokemonID
              JOIN types ON pokemontype.typeID = types.typeID
              WHERE pokemon.pokemonID = :pokemonID
              GROUP BY pokemon.pokemonID";

    // Utilisez une requête préparée pour éviter les attaques par injection SQL
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':pokemonID', $pokemonID, PDO::PARAM_INT);
    $stmt->execute();

    // Récupérez les détails du Pokémon spécifique
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Affichez les détails du Pokémon
    echo '
    <div class="containerDetail">
        <div class="details">';
    echo '<p class="nameDetail">' . $row["name"] . '</p>';
    // Afficher les types avec les styles distincts pour chaque type
    echo '<div class="typesDetail">';
    $types = explode(',', $row['typeNames']); // Sépare les types par une virgule
    foreach ($types as $type) {
        echo '<p class="' . strtolower($type) . '">' . $type . '</p>';
    }
    echo '</div>';
    echo '<p>HP: ' . $row["healthPoints"] . '</p>';
    echo '<p>Attack Damages: ' . $row["attackDamages"] . '</p>';
    echo '<p>Defense Points: ' . $row["defensePoints"] . '</p>';
    echo '<p>Specific Defense: ' . $row["specificDefense"] . '</p>';
    echo '<p>Specific Attack: ' . $row["specificAttack"] . '</p>';
    echo '<p>Speed: ' . $row["speed"] . '</p>';
    echo '
        </div>

        <div class="imagePhoto">
            <p class="numberDetail">' . $row["number"] . '</p>
            <img src="' . $row["picture"] . '" alt="image du pokemon">
        </div>
    </div>';

    // Afficher les évolutions précédentes
    $queryPrevEvo = "SELECT pokemon.name, pokemon.picture
                     FROM pokemon
                     JOIN pokemonpreviousevolution ON pokemon.pokemonID = pokemonpreviousevolution.previousEvolutionID
                     WHERE pokemonpreviousevolution.pokemonID = :pokemonID";

    $stmtPrevEvo = $bdd->prepare($queryPrevEvo);
    $stmtPrevEvo->bindParam(':pokemonID', $pokemonID, PDO::PARAM_INT);
    $stmtPrevEvo->execute();
    echo '<div class="evolutions">';
        echo '<div class="prevEvolutions">';
        while ($prevEvo = $stmtPrevEvo->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="prevEvo">';
            echo '<p class="titreEvo">Previous evolution</p>';
            echo '<p class="nameDetail">' . $prevEvo["name"] . '</p>';
            echo '<img src="' . $prevEvo["picture"] . '" alt="image de l\'évolution précédente">';
            echo '</div>';
        }
        echo '</div>';

        // Afficher les évolutions futures
        $queryFutureEvo = "SELECT pokemon.name, pokemon.picture
                        FROM pokemon
                        JOIN pokemonfutureevolution ON pokemon.pokemonID = pokemonfutureevolution.futureEvolution
                        WHERE pokemonfutureevolution.pokemonID = :pokemonID";

        $stmtFutureEvo = $bdd->prepare($queryFutureEvo);
        $stmtFutureEvo->bindParam(':pokemonID', $pokemonID, PDO::PARAM_INT);
        $stmtFutureEvo->execute();

        echo '<div class="futureEvolutions">';
        while ($futureEvo = $stmtFutureEvo->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="futureEvo">';
            echo '<p class="titreEvo">Future evolution</p>';
            echo '<p class="nameDetail">' . $futureEvo["name"] . '</p>';
            echo '<img src="' . $futureEvo["picture"] . '" alt="image de l\'évolution future">';
            echo '</div>';
        }
        echo '</div>';
    echo '</div>';
    // Fermeture de la connexion à la base de données
    $bdd = null;
}
?>
</body>
</html>
