<?php

require_once 'conexao.php';

$mensagem = "";

// Verifica se o usuário já está logado
if (isset($_SESSION['usuario_id'])) {
    header("Location: perfil.php"); // Redireciona para a tela de perfil se já estiver logado
    exit;
}

// Verifica se o formulário foi enviado (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara a consulta SQL para evitar SQL Injection
    $stmt = $conn->prepare("SELECT id, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verifica se o email existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($usuario_id, $senha_hash);
        $stmt->fetch();

        // Verifica a senha
        if (password_verify($senha, $senha_hash)) {
            // A senha está correta, inicia a sessão
            $_SESSION['usuario_id'] = $usuario_id;

            echo "<script>
            alert('Sessão iniciada.');
            window.location.href = 'perfil.php';
            </script>";

            exit;
        } else {
            $mensagem = "Senha incorreta.";
        }
    } else {
        $mensagem = "Email incorreto.";
    }

    // Fecha a conexão
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Estacionamento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
            <li><a href="index.php">Início</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="cadastro.php">Criar Conta</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="vagas.php">Vagas</a></li>
                <li><a href="suspensao.php">Suspensão</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="login">
            <h2>Login</h2>
            <form action="" method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit">Entrar</button>
            </form>
            <p>Ainda não tem uma conta? <a href="cadastro.php">Clique aqui para criar uma!</a></p> <!-- Link para registro -->
        </section>
    </main>

    <?php if ($mensagem): ?>
    <div>
        <?php echo $mensagem; ?>
    </div>
    <?php endif; ?>

    <footer>
        <p>© 2024 Sistema de Estacionamento. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
