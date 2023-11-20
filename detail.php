<?php
session_start();
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

    // Affichez les détails du Pokémon
    echo displayDetails(getDetails($pokemonID));

   

// Fermeture de la connexion à la base de données
$bdd = null;
}

function getPercentage($value):int{
    return ($value/200)*100;
}

function getDetails($pokemonID){
    global $bdd;

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

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function displayDetails($row):string{
    $id=$row['pokemonID'];
    $checked = evaluateFavorite($row['pokemonID']);
    $health = getPercentage($row['healthPoints']);
    $damages = getPercentage($row['attackDamages']);
    $defense = getPercentage($row['defensePoints']);
    $specAttack = getPercentage($row['specificAttack']);
    $specDefense = getPercentage($row['specificDefense']);
    $speed = getPercentage($row['speed']);
    return '
            <div class=containerDetail>
            <div class="heart">
                     <form action="favoritesManager.php" method="GET">
                     <input type="hidden" name="pokemonId" value="' . $id . '"/>
                     <input onChange="submit()" type="checkbox" id="heart' . $id . '" ' . $checked . '/>
                     <label for="heart' . $id . '"></label>
                     </form>
                 </div>
                <div class="details">
                    <p class="nameDetail">' . $row["name"] . '</p>
                    <div class="typesDetail"><p class="typesDetail">' . str_replace(",", '</p><p class="typesDetail">', $row["typeNames"]) . '</p></div>
                    <div class="healthPoints">
                    <p>HP : '.$row['healthPoints'].' </p>
                    <div class="BarBase">
                      <div class="Progression" style="height:24px;width:' . $health . '%"></div>
                    </div>
                    </div>
                    <div class="damages">
                    <p>Attack Damages : '.$row['attackDamages'].'</p>
                    <div class="BarBase">
                      <div class="Progression" style="height:24px;width:' . $damages . '%"></div>
                    </div>
                    </div>   
                    <div class="defense">
                    <p>Defense Points : '.$row['defensePoints'].'</p>
                    <div class="BarBase">
                      <div class="Progression" style="height:24px;width:' . $defense . '%"></div>
                    </div>
                    </div>  
                    <div class="SpecificDefense">                  
                    <p>Specific Defense : '.$row['specificDefense'].' </p>
                    <div class="BarBase">
                      <div class="Progression" style="height:24px;width:' . $specDefense . '%"></div>
                    </div>
                    </div> 
                    <div class="SpecificAttack">    
                    <p>Specific Attack : '.$row['specificAttack'].' </p>
                    <div class="BarBase">
                      <div class="Progression" style="height:24px;width:' . $specAttack . '%"></div>
                    </div>
                    </div>
                    <div class="speed">    
                    <p>Speed : '.$row['speed'].' </p>
                    <div class="BarBase">
                      <div class="Progression" style="height:24px;width:' . $speed . '%"></div>
                    </div>
                    </div>                
            
                <div class="imagePhoto">
                    <p class="numberDetail">' . $row["number"] . '</p>
                    <img src="' . $row["picture"] . '" alt="image du pokemon">
                </div>
                </div>
            </div>';
}
?>

