<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html"); // Redireciona para a página de login se não estiver logado
    exit;
}

include 'db.php'; // Inclui a conexão com o banco de dados

// Obtém o ID do usuário da sessão
$usuario_id = $_SESSION['usuario_id'];

// Prepara a consulta para obter os dados do usuário
$stmt = $conn->prepare("SELECT nome, email FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->bind_result($nome, $email);
$stmt->fetch();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Sistema de Estacionamento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="inicio.html">Início</a></li>
                <li><a href="vagas.html">Vagas</a></li>
                <li><a href="admin.html">Administração</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="perfil">
            <h2>Perfil do Usuário</h2>
            <div id="dados-usuario">
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($nome); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            </div>
        </section>
    </main>

    <footer>
        <p>© 2024 Sistema de Estacionamento. Todos os direitos reservados.</p>
    </footer>
