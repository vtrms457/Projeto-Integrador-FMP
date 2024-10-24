<?php

include 'conexao.php';

$feedback = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $senha = $_POST['senha'];
    $tipo_usuario = $_POST['tipo_usuario'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $feedback = "Email inválido.";
    } elseif (strlen($senha) < 6) {
        $feedback = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (email, senha, tipo_usuario) VALUES ('$email', '$senha_hash', '$tipo_usuario')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['email'] = $email;
            $_SESSION['tipo_usuario'] = $tipo_usuario;
            setcookie("user_email", $email, time() + 2592000, "/"); // Expira em 30 dias
            $feedback = "Conta criada!";
        } else {
            $feedback = "Erro: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
<header>
        <h1>PlusVagas</h1>
        <nav>
            <a href="index.php">Index</a>
            <a href="login.php">Login</a>
        </nav>
</header>
    
    <form action="" method="POST">
        <h2>Cadastro</h2>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        
        <label for="tipo_usuario">Tipo de Usuário:</label>
        <select id="tipo_usuario" name="tipo_usuario" required>
            <option value="comum">Comum</option>
            <option value="admin">Administrador</option>
        </select>
        
        <button type="submit">Criar Conta</button>
    </form>

    <div class="feedback">
        <?php if ($feedback) echo $feedback; ?>
    </div>

    <footer>
        <p>&copy; 2024 PlusVagas. Todos os direitos reservados.</p>
    </footer>

</body>
</html>
