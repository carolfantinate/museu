<?php
// ----- CONEXÃO COM O BANCO -----
$conn = new mysqli("localhost", "root", "", "museu");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
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
            align-items: flex-start;
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
            color: #0f1f1c;
            transition: 0.3s;
        }

        #btn-fechar {
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



        button#registrar {
            background-color: #1d3c37;
            color: #b49a68;
            width: 250px;
            padding: 10px;
            height: 50px;
            font-weight: bold;
            border-radius: 10px;
            font-size: 18px;
            box-shadow: 0px 7px 9px 0px rgba(0, 0, 0, 0.292);
            cursor: pointer;
            border: none;
        }

        button#registrar:hover {
            background-color: #14504a;
            transition: 0.3s;
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
            margin-top: 20px;
        }

        button#sair:hover {
            background-color: #cfcfcf;
            color: #5a5a5a;
            transition: 0.3s;
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
        <h3>Administrador,</h3>
        <h4>Fulano de Tal</h4>

        <h2 id="table-title">Funcionários Registrados</h2>

        <?php
        // ----- LISTAR OS FUNCIONÁRIOS -----
        $sql = "SELECT * FROM funcionario ORDER BY id DESC";
        $result = $conn->query($sql);

        echo "<table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Nascimento</th>
                <th>Admissão</th>
            </tr>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nome']}</td>
                    <td>{$row['cpf']}</td>
                    <td>{$row['data_nasc']}</td>
                    <td>{$row['data_adms']}</td>
                 </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nenhum funcionário cadastrado.</td></tr>";
        }

        echo "</table>";

        $conn->close();
        ?>

        <button id="registrar">Registrar Funcionário</button>
        <button id="sair">Sair</button>

        <form action="cadastro_funcionario.php" method="POST">
            <i class="fa-solid fa-xmark" id="btn-fechar"></i>
            <div>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" required>
            </div>
            <div>
                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" required minlength="14">
            </div>
            <div>
                <label for="data_nasc">Data de Nascimento:</label>
                <input type="date" name="data_nasc" required>
            </div>
            <div>
                <label for="data_adm">Data de Admissão</label>
                <input type="date" name="data_adms" required>
            </div>
            <button type="submit" id="btn-confirmar">Cadastrar</button>
        </form>
    </main>
    <footer>
        <p id="p-footer">© Museu Nacional</p>
    </footer>

    <script>
        const btnRegistrar = document.getElementById("registrar");
        const form = document.querySelector("form");
        const btnFechar = document.getElementById("btn-fechar");
        const btnSair = document.getElementById("sair");

        btnRegistrar.addEventListener("click", () => {
            form.style.display = "flex";
        });

        btnFechar.addEventListener("click", () => {
            form.style.display = "none";
        });

        btnSair.addEventListener("click", () => {
            window.location.href = "index.html";
        });
    </script>
    <script src="https://kit.fontawesome.com/f9c90ebe75.js" crossorigin="anonymous"></script>
</body>

</html>