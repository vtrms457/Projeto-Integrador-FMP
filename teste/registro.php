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
                <li><a href="login.php">Login</a></li> <!-- Certifique-se que esta página é login.php -->
                <li><a href="registro.php">Criar Conta</a></li> <!-- Certifique-se que esta página é registro.php -->
            </ul>
        </nav>
    </header>

    <main>
        <section class="registro">
            <h2>Criar Conta</h2>
            <form action="processo_registro.php" method="POST">
                <input type="text" name="nome" placeholder="Nome Completo" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit">Registrar</button>
            </form>
            <p class="error-message" style="color: red;">
                <?php 
                    if (isset($_GET['error'])) {
                        echo htmlspecialchars($_GET['error']);
                    }
                ?>
            </p>
            <p class="success-message" style="color: green;">
                <?php 
                    if (isset($_GET['success'])) {
                        echo htmlspecialchars($_GET['success']);
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
