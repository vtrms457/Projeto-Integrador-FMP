<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root"; // Nome de usuário padrão no XAMPP
$password = ""; // Senha vazia para o XAMPP
$dbname = "projeto"; // Nome do banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Receber dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografa a senha

// Insere os dados no banco
$sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

if ($conn->query($sql) === TRUE) {
    echo "Conta criada com sucesso! <a href='login.html'>Faça login</a>";
} else {
    echo "Erro ao criar conta: " . $conn->error;
}

$conn->close();
?>
