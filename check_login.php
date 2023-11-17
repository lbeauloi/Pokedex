<?php
//démarrer la session
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    //récupérer les données du form
    $username = $_POST['username'];
    //utiliser la fonction de hachage sha1 pour sécuriser le mot de passe
    $password = sha1($_POST['password']);

    //appeler la fonction de connection a la db
    $bdd = connectDB();
    //prépaer la requête sql pour récupérer un utilisateur avce username et le password
    $req = $bdd->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
    //exécuter la requête en fournissant les valeurs des paramètres
    $req->execute(array(
        'username' => $username,
        'password' => $password
    ));

    //récupérer les résultats de la requête
    $data = $req->fetch();
}

//si données on été récupérées (= si le user existe dans la db)
if ($data) {
    //stocker le username dans la session
    $_SESSION['username'] = $username;
    //rediriger vers la page d'acceuil 
    header('Location: index.php');
    //arreter l'exécuter du script
    exit();
}
//si aucune donnée n'est récupérée (= user n'existe pas dans la db)
else {
    //rediriger vares la page login
    header('Location: login.php');
}
