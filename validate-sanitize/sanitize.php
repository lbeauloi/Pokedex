<?php
require('./connect.php');
global $bdd;


//vérifier si la reqête http est bien de type post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //vérifier récupérer les données du form 
    $username = isset($_POST['username']) ? $_POST['username'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $confirmpassword = isset($_POST['password2']) ? $_POST['confirmpassword'] : "";

    //appeler fonction get_error et stocker le tableau dans la variable
    $errors = get_error($username, $password, $confirmpassword);

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


function get_error($username, $password, $confirmpassword)
{
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


//y a-il des erreurs?
function has_error($errors)
{
    foreach ($errors as $error) {
        //si oui return true
        if (!empty($error)) {
            return true;
        }
        //si non return false
        return false;
    }
}


//a finir pour display errors
function display_error($proprety)
{
}
