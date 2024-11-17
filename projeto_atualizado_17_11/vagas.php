<?php

require_once 'conexao.php';

$mensagem = "";

// Consulta para obter as vagas
$sql = "SELECT * FROM vagas LEFT JOIN veiculos ON vagas.veiculo_id = veiculos.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vagas - Sistema de Estacionamento</title>
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
        <!-- Seção Mapa de Estacionamento -->
        <section class="mapa-estacionamento">
            <h3>Mapa do Estacionamento</h3>
            <div class="estacionamento">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $status = $row['status'];
                        $veiculo = $status == 'ocupada' ? "{$row['placa']} ({$row['marca']})" : "Disponível";
                        $class = $status == 'ocupada' ? 'ocupada' : 'disponivel';
                        echo "<div class='vaga $class'>{$veiculo}</div>";
                    }
                } else {
                    echo "<p>Sem vagas disponíveis.</p>";
                }
                ?>
            </div>
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
