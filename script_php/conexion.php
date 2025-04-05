<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "cdental"; // Nombre de la BD

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
