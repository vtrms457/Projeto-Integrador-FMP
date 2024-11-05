<?php
session_start(); // Inicia a sessão

// Verifica se o usuário já está logado
if (isset($_SESSION['usuario_id']) && $_SESSION['tipo'] == 'administrador') {
    header("Location: admin_dashboard.php"); // Redireciona para o painel do administrador
    exit;
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Conexão com o banco de dados
    $servername = "localhost"; // Altere para o seu servidor
    $username = "root"; // Altere para o seu usuário do banco de dados
    $password = ""; // Altere para a sua senha do banco de dados
    $dbname = "projeto"; // Nome do seu banco de dados

    // Cria a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepara a consulta SQL para evitar SQL Injection
    $stmt = $conn->prepare("SELECT id, senha, tipo FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verifica se o email existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($usuario_id, $senha_hash, $tipo_usuario);
        $stmt->fetch();

        // Verifica se é um administrador e a senha
        if ($tipo_usuario == 'administrador' && password_verify($senha, $senha_hash)) {
            // A senha está correta e o usuário é um administrador
            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['tipo'] = $tipo_usuario; // Guarda o tipo de usuário
            header("Location: admin_dashboard.php"); // Redireciona para o painel de administração
            exit;
        } else {
            echo "Email ou senha incorretos, ou não é um administrador.";
        }
    } else {
        echo "Email não encontrado.";
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
    <title>Login Administrador</title>
</head>
<body>

    <h2>Login Administrador</h2>
    <form action="admin_login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>

</body>
</html>
