<?php
require_once("connect.php");
global $pdd;

//check for connection
        // not connected -_> alert and button to redirect vers login
        // If connected -> display favorites
