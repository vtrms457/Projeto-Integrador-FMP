<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$placa = $_POST['placa'];
$marca = $_POST['marca'];
$cor = $_POST['cor'];
$tipo = $_POST['tipo'];

$sql = "INSERT INTO veiculos (usuario_id, placa, marca, cor, tipo) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $usuario_id, $placa, $marca, $cor, $tipo);

if ($stmt->execute()) {
    echo "Veículo registrado com sucesso!";
} else {
    echo "Erro ao registrar veículo: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
