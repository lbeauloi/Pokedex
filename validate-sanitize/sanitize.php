<?php
require('./connect.php');
global $bdd;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $passwordlen = strlen($password);
    $min = 7;
    $emailErr = empty($username) ? "* Email is required" : (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? "*Invalid email" : "");
    $passwordErr =  empty($password) ? "* Password is required" : ($passwordlen < $min ? "*Password should have min 7 characters" : "");
    $passwordConfirmErr = empty($confirmpassword) ? "* Password is required" : ($password != $confirmpassword ? "*password doesn't match" : "");
    return array(
        "email" => $emailErr,
        "password" => $passwordErr,
        "password2" => $passwordConfirmErr

    );

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        if ($password == $confirmpassword) {
            //pour crypter mot de passe avant de le stocker
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $add = "INSERT INTO users (username, Password) VALUES ('.$username.', '.$hash.')";
            $nb = $bdd->prepare($add);
            // header('Location: login.php');
            // exit;

        }
    }
}





// trouver ce qui egalise les 2 passwords via une methode, le stocker dans une fonction qu'on appellera plus haut dans $passwordErr
//dans cette fonction il faudra return true si egale et false si pas égal 



//pour crypter mot de passe avant de le stocker


//Vérifie que le hachage fourni correspond bien au mot de passe fourni. A  mon avis plus utile pour le login
if (password_verify($password, $hash)) {
    echo 'Le mot de passe est valide !';
} else {
    echo 'Le mot de passe est invalide.';
}
