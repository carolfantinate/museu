<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "museu";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificando se os dados vieram corretamente do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $data_nasc = $_POST["data_nasc"];
    $data_adms = $_POST["data_adms"];

    // Preparar a query
    $sql = "INSERT INTO funcionario (nome, cpf, data_nasc, data_adms)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $cpf, $data_nasc, $data_adms);

    if ($stmt->execute()) {
        // Volta para admin.php com alerta de sucesso
        echo "<script>
                alert('Funcionário cadastrado com sucesso!');
                window.location.href = 'admin.php';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao cadastrar funcionário.');
                window.location.href = 'admin.php';
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
