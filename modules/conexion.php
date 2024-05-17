<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "u663024938_johanrengifo";
$password = "#g3e#*B7pF";
$dbname = "u663024938_egocentricasdb";

// Establecer la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>
