<?php
session_start();

if (!isset($_SESSION['cpf_func'])) {
    header("Location: login-func.php");
    exit();
}

include "conexao.php";

$cpfLogado = $_SESSION['cpf_func'];

// buscar nome do funcionário
$stmt = $conn->prepare("SELECT nome FROM funcionario WHERE cpf = ?");
$stmt->bind_param("s", $cpfLogado);
$stmt->execute();
$result = $stmt->get_result();

$nomeFuncionario = "Funcionário";

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nomeFuncionario = $row['nome'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Funcionário</title>
    <link rel="stylesheet" href="geral.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Questrial&display=swap');

        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            display: flex;
            flex-direction: column;
            margin: auto;
            width: 50%;
        }

        p {
            color: #1d3c37;
            font-size: 18px;
            text-align: center;
            font-family: "Questrial", sans-serif;
        }

        input {
            background-color: #e9e6e6;
            border: none;
            border-radius: 5px;
            height: 30px;
            padding: 0 5px;
        }

        input:focus {
            outline: none;
        }

        table {
            margin: 0 auto 50px auto;
            width: 100%;
            border: #f7e5c2 2px solid;
            border-collapse: collapse;
        }

        th,
        td {
            border: #f7e5c2 1px solid;
            padding: 10px;
            text-align: center;
            font-family: "Questrial", sans-serif;
        }

        th {
            background-color: #debe82;
        }

        form {
            padding: 30px 30px 15px 30px;
            border-radius: 20px;
            position: relative;
            border: #577570 2px solid;
            flex-direction: column;
            justify-content: center;
            gap: 20px;
            width: 45%;
            margin: 60px auto;
            display: none;
        }

        h3 {
            color: #1d3c37;
            font-family: sans-serif;
            font-size: 25px;
        }

        h4 {
            color: #1d3c37;
            font-family: sans-serif;
            font-size: 20px;
            font-weight: normal;
            margin-top: -20px;
            margin-bottom: 50px;
        }

        #btn-confirmar {
            align-self: flex-end;
            background-color: #577570;
            border-radius: 10px;
            font-weight: bold;
            color: #1d3c37;
            font-size: 18px;
            border: none;
            height: 35px;
            width: 110px;
            cursor: pointer;
        }

        #btn-confirmar:hover {
            background-color: #3e605f;
        }

        #btn-fechar,
        #btn-fechar-autor {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            font-size: 20px;
            color: #1d3c37;
        }

        label {
            font-family: sans-serif;
            margin-right: 5px;
        }

        button#registrar,
        button#registrarAutor {
            background-color: #1d3c37;
            color: #b49a68;
            width: 250px;
            padding: 10px;
            height: 50px;
            font-weight: bold;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            border: none;
            box-shadow: 0px 7px 9px rgba(0, 0, 0, 0.292);
            margin-bottom: 50px;
        }

        button#registrar:hover,
        button#registrarAutor:hover {
            background-color: #14504a;
        }

        button#sair {
            background-color: #e9e6e6;
            color: #7f7f7f;
            width: 100px;
            padding: 10px;
            height: 30px;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            border: none;
        }

        #table-title {
            text-align: center;
            background-color: #debe82;
            font-weight: normal;
            font-family: sans-serif;
            margin: 0;
            padding: 10px;
            font-size: 16px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }
    </style>
</head>

<body>

    <header>
        <div id="header-logo">
            <img src="imgs/logo.png" alt="Logo do Museu Nacional" id="logo">
        </div>
        <div id="header-title">
            <h1>MUSEU NACIONAL</h1>
            <h2 id="subtitle">Arte ao alcance de todos</h2>
        </div>
    </header>

    <main class="container">
        <h3>Funcionário,</h3>
        <h4><?= htmlspecialchars($nomeFuncionario) ?></h4>

        <!-- --------------------------- OBRAS ------------------------------ -->
        <h2 id="table-title">Obras Registradas</h2>

        <?php
        $sql = "SELECT * FROM obras ORDER BY id DESC";
        $result = $conn->query($sql);

        echo "<table>
        <tr>
            <th>ID</th>
            <th>Nome da Obra</th>
            <th>Ano</th>
            <th>Valor</th>
            <th>ID Autor</th>
            <th>Tipo</th>
        </tr>";

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nome_obra']}</td>
                <td>{$row['ano_criacao']}</td>
                <td>" . ($row['valor_estimado'] ?: '—') . "</td>
                <td>{$row['id_autor']}</td>
                <td>{$row['tipo_obra']}</td>
            </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nenhuma obra cadastrada.</td></tr>";
        }
        echo "</table>";
        ?>

        <button id="registrar">Registrar Obra</button>

        <!-- FORM OBRAS -->
        <form id="formObras" action="registrar_obra.php" method="POST">
            <i class="fa-solid fa-xmark" id="btn-fechar"></i>

            <div><label>Nome da Obra:</label><input type="text" name="nome_obra" required></div>
            <div><label>Ano:</label><input type="date" name="ano_criacao"></div>
            <div><label>Valor Estimado:</label><input type="number" step="0.01" name="valor_estimado"></div>
            <div><label>ID Autor:</label><input type="number" name="id_autor" required></div>
            <div><label>Tipo:</label><input type="text" name="tipo_obra" required></div>

            <button type="submit" id="btn-confirmar">Cadastrar</button>
        </form>

        <!-- --------------------------- AUTORES ------------------------------ -->
        <h2 id="table-title">Autores Registrados</h2>

        <?php
        $sqlA = "SELECT * FROM autor ORDER BY id DESC";
        $resultA = $conn->query($sqlA);

        echo "<table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Nascimento</th>
            <th>Morte</th>
        </tr>";

        if ($resultA && $resultA->num_rows > 0) {
            while ($rowA = $resultA->fetch_assoc()) {
                echo "<tr>
                <td>{$rowA['id']}</td>
                <td>{$rowA['nome_autor']}</td>
                <td>" . ($rowA['data_nasc'] ?: '—') . "</td>
                <td>" . ($rowA['data_mort'] ?: '—') . "</td>
            </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nenhum autor cadastrado.</td></tr>";
        }
        echo "</table>";
        ?>

        <button id="registrarAutor">Registrar Autor</button>

        <!-- FORM AUTORES -->
        <form id="formAutores" action="registrar_autor.php" method="POST">
            <i class="fa-solid fa-xmark" id="btn-fechar-autor"></i>

            <div><label>Nome:</label><input type="text" name="nome_autor" required></div>
            <div><label>Nascimento:</label><input type="date" name="data_nasc"></div>
            <div><label>Falecimento:</label><input type="date" name="data_mort"></div>

            <button type="submit" id="btn-confirmar">Cadastrar</button>
        </form>

        <button id="sair">Sair</button>
    </main>

    <footer>
        <p id="p-footer">© Museu Nacional</p>
    </footer>

    <script>
        const formObra = document.getElementById("formObras");
        const formAutor = document.getElementById("formAutores");

        document.getElementById("registrar").onclick = () => formObra.style.display = "flex";
        document.getElementById("registrarAutor").onclick = () => formAutor.style.display = "flex";

        document.getElementById("btn-fechar").onclick = () => formObra.style.display = "none";
        document.getElementById("btn-fechar-autor").onclick = () => formAutor.style.display = "none";

        document.getElementById("sair").onclick = () => window.location.href = "index.html";
    </script>

    <script src="https://kit.fontawesome.com/f9c90ebe75.js" crossorigin="anonymous"></script>

</body>

</html>