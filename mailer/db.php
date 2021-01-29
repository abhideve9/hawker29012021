<?php
// Database configuration
$dbHost     = "localhost";
$dbUsername = "fixer";
$dbPassword = "g^sK8YN26PKkkZ@8";
$dbName     = "fixer";

$db = new mysqli('localhost','fixer','g^sK8YN26PKkkZ@8','fixer');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>