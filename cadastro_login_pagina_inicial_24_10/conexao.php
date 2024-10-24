<?php

session_start();

$host = 'localhost';
$database = 'plus_vagas';
$usuario = 'root';
$senha = '';

$conn = new mysqli($host, $usuario, $senha, $database);
if ($conn->connect_error) die("Conexão falhou: " . $conn->connect_error);