<?php
include 'config.php'; // Ensure this points to the correct path of your config.php

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
echo "Connected successfully";
?>
