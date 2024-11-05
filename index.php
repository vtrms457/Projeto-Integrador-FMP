<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projeto"; // Nome do seu banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta os usuários
$sql = "SELECT id, nome, email, tipo FROM usuarios";
$result = $conn->query($sql);

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Usuários - Sistema de Estacionamento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="login.html">Login</a></li>
                <li><a href="registro.html">Criar Conta</a></li>
                <li><a href="perfil.html">Perfil</a></li>
                <li><a href="vagas.html">Vagas</a></li>
                <li><a href="admin_dashboard.php">Administração</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Gestão de Usuários</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verifica se existem usuários
                if ($result->num_rows > 0) {
                    // Exibe os usuários
                    while($row = $result->fetch_assoc()) {
                        // Exibe o status do usuário
                        $status = $row['tipo'] == 'suspenso' ? 'Suspenso' : 'Ativo';
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nome'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $status . "</td>";
                        echo "<td>";
                        // Exibe o link de suspensão apenas para usuários ativos
                        if ($row['tipo'] != 'suspenso') {
                            echo "<a href='suspender_usuario.php?id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que deseja suspender este usuário?\")'>Suspender</a>";
                        } else {
                            echo "Suspenso";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum usuário encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>© 2024 Sistema de Estacionamento. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
