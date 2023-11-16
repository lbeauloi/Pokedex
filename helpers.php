<?php

function checkLogin(){
    $isLogged = true;
    if (!isset($_SESSION['username'])) {
        $isLogged =  false;
    }
    return $isLogged;
}