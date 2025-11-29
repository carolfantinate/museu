<?php
session_start();
include "conexao.php";

$cpf = $_POST['cpf'];

// Consulta no banco
$stmt = $conn->prepare("SELECT * FROM funcionario WHERE cpf = ?");
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['cpf_func'] = $cpf; 
    header("Location: func.php");
    exit();
} else {
    echo "<p>CPF não encontrado.</p>";
}
?>
