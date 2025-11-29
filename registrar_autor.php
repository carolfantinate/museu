<?php

// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "museu");
if ($conn->connect_error) {
    die("Erro na conexão.");
}

// só recebe POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: func.php');
    exit;
}

// dados recebidos
$nome_autor = trim($_POST['nome_autor'] ?? '');
$data_nasc  = $_POST['data_nasc'] !== '' ? $_POST['data_nasc'] : null;
$data_mort  = $_POST['data_mort'] !== '' ? $_POST['data_mort'] : null;

// validação
if ($nome_autor === '') {
    echo "<script>alert('Preencha o nome do autor.'); window.location='func.php';</script>";
    exit;
}

// Query
$sql = "INSERT INTO autor (nome_autor, data_nasc, data_mort) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "<script>alert('Erro ao cadastrar.'); window.location='func.php';</script>";
    exit;
}

$stmt->bind_param("sss", $nome_autor, $data_nasc, $data_mort);

// executa
if ($stmt->execute()) {
    echo "<script>alert('Autor cadastrado com sucesso!'); window.location='func.php';</script>";
} else {
    echo "<script>alert('Erro ao cadastrar autor.'); window.location='func.php';</script>";
}

$stmt->close();
$conn->close();
?>
