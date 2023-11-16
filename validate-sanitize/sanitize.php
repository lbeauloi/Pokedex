<?php
require('./connect.php');
global $bdd;


function getErrors()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $emailErr = empty($_POST["email"]) ? "* Email is required" : (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? "*Invalid email" : "");
        $passwordErr =  empty($_POST["password"]) ? "* Password is required" : "";
        $passwordConfirmErr = empty($_POST["password"]) ? "* Password is required" : "";
        return array(
            "email" => $emailErr,
            "password" => $passwordErr,
            "password2" => $passwordConfirmErr

        );
    }
}
    
    // $add = 'INSERT INTO users (username,password ) VALUES("' . $_POST['email'] . '","' . $_POST['password'] . '")';
    // $nb = $bdd->exec($add);
    // header('Location: login.php');
    // exit;



// trouver ce qui egalise les 2 passwords via une methode, le stocker dans une fonction qu'on appellera plus haut dans $passwordErr
//dans cette fonction il faudra return true si egale et false si pas égal 