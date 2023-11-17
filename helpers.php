<?php

require_once('connect.php');

function checkLogin()
{
    $isLogged = true;
    if (!isset($_SESSION['username'])) {
        $isLogged =  false;
    }
    return $isLogged;
}

function isFavorite($pokemonId, $userID)
{
    global $bdd;
    $query = "SELECT favoriteID FROM pokedex.favorites WHERE userID = '$userID' AND pokemonId='$pokemonId';";
    $res = $bdd->query($query);
    return $res->rowCount() === 1;
}

function getUserId($username): int
{
    global $bdd;
    $query = "SELECT UserID FROM pokedex.users WHERE username = '$username'";
    $res = $bdd->query($query);

    if ($res->rowCount() === 1) {
        $row = $res->fetch();
        return $row['UserID'];
    }

    return throw new Exception('Invalid login');
}
