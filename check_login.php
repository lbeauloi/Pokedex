<?php
session_start();

function checkLogin(){

    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = sha1($_POST['password']);

    $bdd = connectDB();
    $req = $bdd->prepare('SELECT * FROM user WHERE username = :username AND password = :password');
    $req->execute(array(
        'username' => $username,
        'password' => $password
    ));

    $data = $req->fetch();

}

if ($data) {
    $_SESSION['username'] = $username;
    header('Location: index.php');
    exit();
} 
else {
    header('Location: login.php');
}

?>