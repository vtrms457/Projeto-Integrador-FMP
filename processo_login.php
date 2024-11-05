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

    // Verifica se o email e a senha não estão vazios
    if (empty($email) || empty($senha)) {
        echo "Por favor, preencha todos os campos!";
        exit;
    }

    // Conexão com o banco de dados
    $servername = "localhost"; // Servidor do banco de dados
    $username = "root"; // Usuário do banco de dados
    $password = ""; // Senha do banco de dados
    $dbname = "projeto"; // Nome do banco de dados

    // Cria a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão com o banco de dados
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Prepara a consulta SQL para evitar SQL Injection
    $stmt = $conn->prepare("SELECT id, senha, tipo FROM usuarios WHERE email = ?");
    if (!$stmt) {
        die('Erro ao preparar a consulta: ' . $conn->error); // Se houver erro ao preparar a consulta
    }

    // Bind dos parâmetros
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verifica se o email existe no banco de dados
    if ($stmt->num_rows > 0) {
        // Vincula os resultados
        $stmt->bind_result($usuario_id, $senha_hash, $tipo_usuario);
        $stmt->fetch();

        // Verifica a senha usando password_verify
        if (password_verify($senha, $senha_hash)) {
            // A senha está correta, inicia a sessão
            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['tipo_usuario'] = $tipo_usuario; // Armazena o tipo do usuário (aluno ou administrador)
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
