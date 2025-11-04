<?php
$mysqli = new mysqli("localhost", "ciuser", "museumkb", "museum_db");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
echo "Database connection successful!";
?>
