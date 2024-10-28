<?php
$servername = "localhost";
$username = "root"; // Usuário padrão do XAMPP
$password = ""; // Senha em branco para o XAMPP
$dbname = "projeto"; // Nome do banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Consulta para buscar status das vagas
$sql = "SELECT id, status, proprietario FROM vagas";
$result = $conn->query($sql);

$vagas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $vagas[] = $row;
    }
}

echo json_encode($vagas); // Retorna os dados em JSON
$conn->close();
?>
