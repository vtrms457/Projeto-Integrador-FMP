<?php

include 'conexao.php';

$feedback = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $senha = $_POST['senha'];

    $sql = "SELECT senha, tipo_usuario FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($senha, $row['senha'])) {
            $_SESSION['email'] = $email;
            $_SESSION['tipo_usuario'] = $row['tipo_usuario'];
            header("Location: gerenciamento.php");
            exit();
        } else {
            $feedback = "Senha incorreta.";
        }
    } else {
        $feedback = "Email não encontrado.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
        <h1>PlusVagas</h1>
        <nav>
            <a href="index.php">Index</a>    
            <a href="cadastro.php">Registrar</a>
        </nav>
</header>

    <form action="" method="POST">
        <h2>Login</h2>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        
        <button type="submit">Entrar</button>
    </form>

    <div class="feedback">
        <?php if ($feedback) echo $feedback; ?>
    </div>

    <footer>
        <p>&copy; 2024 PlusVagas. Todos os direitos reservados.</p>
    </footer>
    
</body>
</html>
