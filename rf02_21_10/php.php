<?php
session_start(); // Inicia a sessão

$host = 'localhost'; // Endereço do servidor
$db = 'rf02'; // Nome do seu banco de dados
$user = 'root'; // Usuário do banco de dados
$pass = ''; // Senha do banco de dados

// Conexão com o banco de dados
$conn = new mysqli($host, $user, $pass, $db);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $senha = $_POST['senha'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Validação simples
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email inválido.");
    }

    if (strlen($senha) < 6) {
        die("A senha deve ter pelo menos 6 caracteres.");
    }

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

    // Insere o novo usuário no banco de dados
    $sql = "INSERT INTO usuarios (email, senha, tipo_usuario) VALUES ('$email', '$senha_hash', '$tipo_usuario')";

    if ($conn->query($sql) === TRUE) {
        // Armazena o email e tipo de usuário na sessão
        $_SESSION['email'] = $email;
        $_SESSION['tipo_usuario'] = $tipo_usuario;

        // Define um cookie
        setcookie("user_email", $email, time() + (86400 * 30), "/"); // Expira em 30 dias
        echo "Conta criada!";

    }else{
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }

        // Envio de email de confirmação
        //$to = $email;
        //$subject = "Confirmação de Registro";
        //$message = "Obrigado por se registrar! Sua conta foi criada com sucesso.";
        //$headers = "From: noreply@seusite.com";

        //if (mail($to, $subject, $message, $headers)) {
        //    echo "Conta criada com sucesso! Um email de confirmação foi enviado.";
        //} else {
        //    echo "Conta criada, mas houve um problema ao enviar o email de confirmação.";
        //}

}

// Fecha a conexão
$conn->close();
?>
