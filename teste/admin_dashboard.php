<?php
session_start();
require_once 'db.php';

// Verifica se o usuário está logado e é um administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'administrador') {
    header("Location: login.php");
    exit;
}

// Função para liberar vaga
if (isset($_GET['liberar_vaga'])) {
    $vaga_id = intval($_GET['liberar_vaga']);
    $stmt = $conn->prepare("UPDATE vagas SET status = 'disponivel', usuario_id = NULL WHERE id = ?");
    $stmt->bind_param("i", $vaga_id);
    $stmt->execute();
    $stmt->close();
}

// Adicionar uma nova vaga
if (isset($_POST['add_vaga'])) {
    $numero_vaga = intval($_POST['numero_vaga']);
    $stmt = $conn->prepare("INSERT INTO vagas (numero, status) VALUES (?, 'disponivel')");
    $stmt->bind_param("i", $numero_vaga);
    $stmt->execute();
    $stmt->close();
}

// Excluir uma vaga
if (isset($_GET['excluir_vaga'])) {
    $vaga_id = intval($_GET['excluir_vaga']);
    $stmt = $conn->prepare("DELETE FROM vagas WHERE id = ?");
    $stmt->bind_param("i", $vaga_id);
    $stmt->execute();
    $stmt->close();
}

// Consulta para obter as vagas e os usuários
$sql = "SELECT v.id, v.numero, v.status, u.nome AS usuario_nome 
        FROM vagas v 
        LEFT JOIN usuarios u ON v.usuario_id = u.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Mapa de Vagas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="dashboard">
            <h2>Mapa de Vagas</h2>
            <table>
                <tr>
                    <th>Número da Vaga</th>
                    <th>Status</th>
                    <th>Reservado por</th>
                    <th>Ações</th>
                </tr>
                <?php 
                // Garante que existam 20 vagas
                for ($i = 1; $i <= 20; $i++): 
                    // Verifica se a vaga existe na base de dados
                    $vaga = null;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row['numero'] == $i) {
                                $vaga = $row;
                                break;
                            }
                        }
                    }
                    
                    // Se a vaga não existir, cria uma vaga vazia
                    if ($vaga === null) {
                        $vaga = ['id' => null, 'numero' => $i, 'status' => 'disponivel', 'usuario_nome' => null];
                    }
                ?>
                    <tr>
                        <td><?php echo $vaga['numero']; ?></td>
                        <td><?php echo $vaga['status'] === 'disponivel' ? 'Disponível' : 'Ocupada'; ?></td>
                        <td><?php echo $vaga['usuario_nome'] ? $vaga['usuario_nome'] : 'N/A'; ?></td>
                        <td>
                            <?php if ($vaga['status'] === 'ocupada'): ?>
                                <a href="?liberar_vaga=<?php echo $vaga['id']; ?>" onclick="return confirm('Tem certeza que deseja liberar esta vaga?');">Liberar</a>
                            <?php else: ?>
                                <a href="?excluir_vaga=<?php echo $vaga['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta vaga?');">Excluir</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endfor; ?>
            </table>

            <h3>Adicionar Nova Vaga</h3>
            <form action="" method="POST">
                <input type="number" name="numero_vaga" placeholder="Número da Vaga" required>
                <button type="submit" name="add_vaga">Adicionar Vaga</button>
            </form>
        </section>
    </main>

    <footer>
        <p>© 2024 Sistema de Estacionamento. Todos os direitos reservados.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
