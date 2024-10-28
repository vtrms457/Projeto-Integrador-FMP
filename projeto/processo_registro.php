<?php
session_start(); // Inicia a sessão

// Verifica se o usuário já está logado


include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; // Captura a senha do POST
    $tipo = '';
    $data_cadastro = date('Y-m-d H:i:s');

    if (strpos($email, '@aluno') !== false) {
        $tipo = 'aluno';
    } elseif (strpos($email, '@gmail.com') !== false) {
        $tipo = 'administrador';
    } else {
        echo "Email inválido para cadastro. Use @aluno ou @gmail.com";
        exit;
    }

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Erro na preparação da declaração: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Este email já está cadastrado.";
    } else {
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo, data_cadastro) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die("Erro na preparação da declaração: " . $conn->error);
        }

        // Verifica se a senha criptografada está sendo passada corretamente
        $stmt->bind_param("sssss", $nome, $email, $senha_hash, $tipo, $data_cadastro);

        if ($stmt->execute()) {
            echo "Conta criada com sucesso!";
            header("Location: login.html");
            exit;
        } else {
            echo "Erro ao criar conta: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>
