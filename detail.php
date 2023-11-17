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
    ?>
    </body>
    </html>
<?php
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
            <div class=containerDetail>
                <div class="details">
                    <p class="nameDetail">' . $row["name"] . '</p>
                    <div class="typesDetail"><p class="typesDetail">' . str_replace(",", '</p><p class="typesDetail">', $row["typeNames"]) . '</p></div>
                    <p>HP: ' . $row["healthPoints"] . '</p>
                    <p>Attack Damages: ' . $row["attackDamages"] . '</p>
                    <p>Defense Points: ' . $row["defensePoints"] . '</p>
                    <p>Specific Defense: ' . $row["specificDefense"] . '</p>
                    <p>Specific Attack: ' . $row["specificAttack"] . '</p>
                    <p>Speed: ' . $row["speed"] . '</p>
                </div>
            
                <div class="imagePhoto">
                    <p class="numberDetail">' . $row["number"] . '</p>
                    <img src="' . $row["picture"] . '" alt="image du pokemon">
                </div>
            </div>';
   

// Fermeture de la connexion à la base de données
$bdd = null;
}
?>
