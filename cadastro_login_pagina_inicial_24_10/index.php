<?php

include 'conexao.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Vagas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <h1>PlusVagas</h1>
        <nav>
            <a href="login.php">Login</a>
            <a href="cadastro.php">Registrar</a>
        </nav>
    </header>

    <div class="container">
        <h2>Vagas Disponíveis</h2>
        <div class="map">
            Mapa das Vagas em Tempo Real
        </div>
    </div>

    <footer>
        <p>&copy; 2024 PlusVagas. Todos os direitos reservados.</p>
    </footer>

</body>
</html>
