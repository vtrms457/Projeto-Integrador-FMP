<?php
// Verifica se o parâmetro ID foi passado na URL
if (isset($_GET['id'])) {
    // Obtém o ID do usuário que será suspenso
    $usuario_id = $_GET['id'];

    // Conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projeto"; // Nome do seu banco de dados

    // Cria a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Atualiza o status do usuário para 'suspenso'
    $sql = "UPDATE usuarios SET tipo = 'suspenso' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);

    if ($stmt->execute()) {
        // Redireciona para a página de administração após a atualização
        header("Location: index.php");  // Redireciona para index.php após a atualização
        exit;
    } else {
        echo "Erro ao suspender o usuário.";
    }

    // Fecha a conexão
    $conn->close();
} else {
    echo "ID do usuário não fornecido.";
}
?>
