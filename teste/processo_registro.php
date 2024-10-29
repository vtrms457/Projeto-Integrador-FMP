<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $data_cadastro = date('Y-m-d H:i:s');

    // Verificar se o e-mail é de aluno ou administrador
    if (preg_match('/@aluno\.com$/', $email)) {
        $tipo = 'aluno';
    } elseif (preg_match('/@gmail\.com$/', $email)) {
        $tipo = 'administrador';
    } else {
        header("Location: registro.php?error=Email inválido para cadastro.");
        exit;
    }

    // Verifica se o email já está cadastrado
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: registro.php?error=Este email já está cadastrado.");
        exit;
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo, data_cadastro) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nome, $email, $senha, $tipo, $data_cadastro);

        if ($stmt->execute()) {
            header("Location: login.php?success=Conta criada com sucesso.");
            exit;
        } else {
            header("Location: registro.php?error=Erro ao criar conta.");
            exit;
        }
    }
    $stmt->close();
}
$conn->close();
?>
