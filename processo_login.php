<?php
session_start(); // Inicia a sessão

// Verifica se o usuário já está logado
if (isset($_SESSION['usuario_id'])) {
    header("Location: processo_perfil.php"); // Redireciona para a tela de perfil se já estiver logado
    exit;
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
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
            header("Location: perfil.html"); // Redireciona para a tela de perfil após login
            exit;
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Email não encontrado.";
    }

    // Fecha a conexão
    $stmt->close();
    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
?>
