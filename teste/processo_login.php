<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Validação do e-mail: permitindo apenas e-mails que terminam com @aluno.com ou @admin.com
    if (!preg_match('/@aluno\.com$/', $email) && !preg_match('/@admin\.com$/', $email)) {
        header("Location: login.php?error=Apenas e-mails de aluno ou admin são permitidos.");
        exit;
    }

    $stmt = $conn->prepare("SELECT id, senha, tipo FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($usuario_id, $senha_hash, $tipo);
        $stmt->fetch();

        if (password_verify($senha, $senha_hash)) {
            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['tipo_usuario'] = $tipo;
            // Redireciona para o dashboard correto com base no tipo de usuário
            if ($tipo === 'administrador') {
                header("Location: admin_dashboard.php"); // Verifique se este arquivo existe
            } else {
                header("Location: aluno_dashboard.php"); // Verifique se este arquivo existe
            }
            exit;
        } else {
            header("Location: login.php?error=Senha incorreta.");
            exit;
        }
    } else {
        header("Location: login.php?error=Email não encontrado.");
        exit;
    }

    $stmt->close();
}
$conn->close();
?>
