<?php
$servername = "localhost";
$username = "u581098102_connecteasy";
$password = "hTt5O&y9T7^";
$database = "u581098102_connecteasy";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
