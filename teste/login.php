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
                <li><a href="login.php">Login</a></li>
                <li><a href="registro.php">Criar Conta</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="login">
            <h2>Login</h2>
            <form action="processo_login.php" method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit">Entrar</button>
            </form>
            <p class="error-message" style="color: red;">
                <?php 
                    if (isset($_GET['error'])) {
                        echo htmlspecialchars($_GET['error']);
                    }
                ?>
            </p>
        </section>
    </main>

    <footer>
        <p>© 2024 Sistema de Estacionamento. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
