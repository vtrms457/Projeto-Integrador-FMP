<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$telefone = $_POST['telefone'];
$foto_perfil = null;

if (!empty($_FILES['foto_perfil']['tmp_name'])) {
    $foto_perfil = 'donwloads/' . basename($_FILES['foto_perfil']['name']);
    move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $foto_perfil);
}

$sql = "UPDATE usuarios SET telefone = ?, foto_perfil = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $telefone, $foto_perfil, $usuario_id);

if ($stmt->execute()) {
    echo "Perfil atualizado com sucesso!";
} else {
    echo "Erro ao atualizar perfil: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
