<?php
require('./connect.php');
global $bdd;


//vérifier si la reqête http est bien de type post
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2'])) {

    //vérifier récupérer les données du form 
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmpassword =  $_POST['password2'];
    //appeler fonction get_error et stocker le tableau dans la variable
    $errors = get_error();

    //si aucune erreur de validation -> fonction has_error return false
    if (has_error($errors) == false) {   // la meme chose que si j'écirs if (!has_errors) == false)



        //crypter mot de passe avant de le stocker dans la db
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $add = "INSERT INTO users (username, Password, roleID) VALUES ('$username', '$hash', 1)";
        $nb = $bdd->prepare($add);
        //eécuter la requête d'insertion
        $nb->execute();
        //rediriger vers la page login
        header('Location: login.php');
        //arreter l'exécution du script
        exit;
    }
}


function get_error()
{
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2'])) {

        //vérifier récupérer les données du form 
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmpassword =  $_POST['password2'];
        $passwordlen = strlen($password);
        $min = 7;
        //validation des champs du form
        $usernameErr = empty($username) ? "* Email is required" : (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL) ? "*Invalid email" : "");
        $passwordErr =  empty($password) ? "* Password is required" : ($passwordlen < $min ? "*Password should have min 7 characters" : "");
        $passwordConfirmErr = empty($confirmpassword) ? "* Password is required" : ($password != $confirmpassword ? "*password doesn't match" : "");

        //si erreurs de validation, retounrer un tableau d'erreurs 
        return array(
            "username" => $usernameErr,
            "password" => $passwordErr,
            "password2" => $passwordConfirmErr

        );
    }
    return array();
}


//y a-il des erreurs?
function has_error($errors)
{
    foreach ($errors as $error) {
        //si oui return true
        if (!empty($error)) {
            return true;
        }
    }
    //si aucune erreur trouvée, return false
    return false;
}


//function pour display erros
function display_error($property)
{
    //récupérer le tableau d'erreurs et le sotcker dans une variable
    $arrayErrors = get_error();
    //vérifier si la clé du tablleau existe avec la méthode array_key_exists qui entre en paramètre le spropriété et le tableau
    if (array_key_exists($property, $arrayErrors)) {
        //aller chercher les données du tableau à display
        $userError = $arrayErrors[$property];
        //l'afficher
        echo $userError;
    }
}
