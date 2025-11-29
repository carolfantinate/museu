<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "museu";

$conn = new mysqli($host, $user, $pass, $db);

// verificação de erro
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
