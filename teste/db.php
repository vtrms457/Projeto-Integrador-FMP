<?php
$servername = "localhost";
$username = "root";  
$password = "";     
$dbname = "projeto"; 

// Cria uma nova conexão
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>