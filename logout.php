<?php
// Set the maximum lifetime of a session to 1000 seconds
ini_set('session.gc_maxlifetime', 1);

// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Destroy the session
session_destroy();

// Redirect the user to the login page
header('Location: login.php');
exit;

?>