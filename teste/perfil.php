<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$stmt = $conn->prepare("SELECT nome, email FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->bind_result($nome, $email);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Bem-vindo, <?php echo htmlspecialchars($nome); ?></h2>
    </header>
    <main>
        <p>Email: <?php echo htmlspecialchars($email); ?></p>
        <a href="logout.php">Sair</a>
    </main>
</body>
</html>
