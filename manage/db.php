<?php
// Database configuration
$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "Iris@244#";
$dbName     = "fixer";

$db = new mysqli('localhost','root','Iris@244#','fixer');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>