<?php
$servername = "localhost";
$dbuser = "root"; 
$dbpass = "";
$dbname = "dataset";

// Create connection
$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
