<?php
require('./connect.php');
global $bdd;


//vérifier si la reqête http est bien de type post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //récupérer les données du form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['password2'];
    $passwordlen = strlen($password);
    $min = 7;

    //validation des champs du form
    $usernameErr = empty($username) ? "* Email is required" : (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL) ? "*Invalid email" : "");
    $passwordErr =  empty($password) ? "* Password is required" : ($passwordlen < $min ? "*Password should have min 7 characters" : "");
    $passwordConfirmErr = empty($confirmpassword) ? "* Password is required" : ($password != $confirmpassword ? "*password doesn't match" : "");

    //si aucune erreur de validation 
    if (empty($usernameErr) && empty($passwordErr) && empty($passwordConfirmErr)) {

        //crypter mot de passe avant de le stocker dans la db
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $add = "INSERT INTO users (username, Password) VALUES ('$username', '$hash')";
        $nb = $bdd->prepare($add);
        //eécuter la requête d'insertion
        $nb->execute();
        //rediriger vers la page login
        header('Location: login.php');
        //arreter l'exécution du script
        exit;
    }
    //si erreurs de validation, retounrer un tableau d'erreurs 
    return array(
        "username" => $usernameErr,
        "password" => $passwordErr,
        "password2" => $passwordConfirmErr

    );
}
