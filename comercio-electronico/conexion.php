<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "TIENDA2";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>