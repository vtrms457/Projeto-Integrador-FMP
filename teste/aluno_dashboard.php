<?php
session_start();
require_once 'db.php';

// Verifica se o usuário está logado e é um aluno
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'aluno') {
    header("Location: login.php");
    exit;
}

// Reservar uma vaga
if (isset($_POST['reservar_vaga'])) {
    $vaga_id = intval($_POST['vaga_id']);
    $usuario_id = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("UPDATE vagas SET status = 'ocupada', usuario_id = ? WHERE id = ? AND status = 'disponivel'");
    $stmt->bind_param("ii", $usuario_id, $vaga_id);
    if ($stmt->execute()) {
        echo "<script>alert('Vaga reservada com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao reservar a vaga.');</script>";
    }
    $stmt->close();
}

// Cadastrar veículo
if (isset($_POST['cadastrar_veiculo'])) {
    $placa = $_POST['placa'];
    $marca = $_POST['marca'];
    $cor = $_POST['cor'];
    $tipo = $_POST['tipo'];
    $usuario_id = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("INSERT INTO veiculos (usuario_id, placa, marca, cor, tipo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $usuario_id, $placa, $marca, $cor, $tipo);
    if ($stmt->execute()) {
        echo "<script>alert('Veículo cadastrado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar o veículo.');</script>";
    }
    $stmt->close();
}

// Consulta para obter as vagas
$sql = "SELECT id, numero, status FROM vagas";
$result_vagas = $conn->query($sql);

// Consulta para obter os veículos do usuário
$sql_veiculos = "SELECT id, placa, marca, cor, tipo FROM veiculos WHERE usuario_id = ?";
$stmt_veiculos = $conn->prepare($sql_veiculos);
$stmt_veiculos->bind_param("i", $_SESSION['usuario_id']);
$stmt_veiculos->execute();
$result_veiculos = $stmt_veiculos->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Aluno - Reservar Vaga</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="aluno_dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="dashboard">
            <h2>Reservar Vaga</h2>
            <h3>Vagas Disponíveis</h3>
            <table>
                <tr>
                    <th>Número da Vaga</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
                <?php while ($vaga = $result_vagas->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $vaga['numero']; ?></td>
                        <td><?php echo $vaga['status'] === 'disponivel' ? 'Disponível' : 'Ocupada'; ?></td>
                        <td>
                            <?php if ($vaga['status'] === 'disponivel'): ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="vaga_id" value="<?php echo $vaga['id']; ?>">
                                    <button type="submit" name="reservar_vaga">Reservar</button>
                                </form>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <h3>Cadastrar Veículo</h3>
            <form action="" method="POST">
                <input type="text" name="placa" placeholder="Placa" required>
                <input type="text" name="marca" placeholder="Marca" required>
                <input type="text" name="cor" placeholder="Cor" required>
                <select name="tipo" required>
                    <option value="carro">Carro</option>
                    <option value="moto">Moto</option>
                </select>
                <button type="submit" name="cadastrar_veiculo">Cadastrar Veículo</button>
            </form>

            <h3>Meus Veículos</h3>
            <table>
                <tr>
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>Cor</th>
                    <th>Tipo</th>
                </tr>
                <?php while ($veiculo = $result_veiculos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $veiculo['placa']; ?></td>
                        <td><?php echo $veiculo['marca']; ?></td>
                        <td><?php echo $veiculo['cor']; ?></td>
                        <td><?php echo $veiculo['tipo']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </section>
    </main>

    <footer>
        <p>© 2024 Sistema de Estacionamento. Todos os direitos reservados.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
$stmt_veiculos->close();
?>
