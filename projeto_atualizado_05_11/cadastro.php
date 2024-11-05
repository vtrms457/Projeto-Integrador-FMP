<?php

include 'conexao.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; // Captura a senha do POST
    $tipo = '';
    $data_cadastro = date('Y-m-d H:i:s');

    if (strpos($email, '@aluno.fmpsc.edu.br') !== false) {
        $tipo = 'aluno';
    } elseif (strpos($email, '@fmpsc.edu.br') !== false) {
        $tipo = 'administrador';
    } else {
        $mensagem = "Email inválido para cadastro. Use @aluno.fmpsc.edu.br ou @fmpsc.edu.br";
        exit;
    }

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Erro na preparação da declaração: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $mensagem = "Este email já está cadastrado.";
    } else {
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo, data_cadastro) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die("Erro na preparação da declaração: " . $conn->error);
        }

        // Verifica se a senha criptografada está sendo passada corretamente
        $stmt->bind_param("sssss", $nome, $email, $senha_hash, $tipo, $data_cadastro);

        if ($stmt->execute()) {
            echo "<script>
            alert('Conta criada, por favor faça login.');
            window.location.href = 'login.php';
            </script>";
            exit;
        } else {
            $mensagem = "Erro ao criar conta: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Sistema de Estacionamento</title>
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
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="registro">
            <h2>Criar Conta</h2>
            <form action="" method="POST">
                <input type="text" name="nome" placeholder="Nome Completo" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit">Registrar</button>
            </form>
        </section>
    </main>

    <footer>
        <p>© 2024 Sistema de Estacionamento. Todos os direitos reservados.</p>
    </footer>
</body>
</html>