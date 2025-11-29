<?php
// ----- CONEXÃO COM O BANCO -----
$conn = new mysqli("localhost", "root", "", "museu");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// ----- PEGAR DADOS DO FORM -----
$nome_obra = $_POST['nome_obra'];
$ano_criacao = !empty($_POST['ano_criacao']) ? $_POST['ano_criacao'] : NULL;
$valor_estimado = !empty($_POST['valor_estimado']) ? $_POST['valor_estimado'] : NULL;
$id_autor = $_POST['id_autor'];
$tipo_obra = $_POST['tipo_obra'];

// ----- INSERIR NO BANCO -----
$sql = "INSERT INTO obras (nome_obra, ano_criacao, valor_estimado, id_autor, tipo_obra) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdis", $nome_obra, $ano_criacao, $valor_estimado, $id_autor, $tipo_obra);

if ($stmt->execute()) {
    echo "<script>
            alert('Obra cadastrada com sucesso!');
            window.location.href = 'func.php';
          </script>";
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>