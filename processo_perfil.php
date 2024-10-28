<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Sistema de Estacionamento</title>
    <link rel="stylesheet" href="style01.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="inicio.html">Início</a></li>
                <li><a href="vagas.html">Vagas</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="perfil">
            <h2>Perfil do Usuário</h2>
            <div id="dados-usuario">
                <p><strong>Nome:</strong></p>
                <p><strong>Email:</strong></p>
                <p><strong>Telefone:</strong></p>
                <?php if ($foto_perfil): ?>
                    <img src="<?php echo htmlspecialchars($foto_perfil); ?>" alt="Foto de Perfil">
                <?php endif; ?>
            </div>

            <!-- Formulário para editar perfil -->
            <h3>Editar Perfil</h3>
            <form action="editar_perfil.php" method="post" enctype="multipart/form-data">
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone">

                <label for="foto_perfil">Foto de Perfil:</label>
                <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*">

                <button type="submit">Salvar Alterações</button>
            </form>

            <!-- Formulário de registro de veículo -->
            <section class="registrar-veiculo">
                <h2>Registrar Veículo</h2>
                <form action="processo_registra_veiculo.php" method="POST">
                    <input type="text" name="placa" placeholder="Placa" required>
                    <input type="text" name="marca" placeholder="Marca" required>
                    <input type="text" name="cor" placeholder="Cor" required>
                    <select name="tipo" required>
                        <option value="carro">Carro</option>
                        <option value="moto">Moto</option>
                    </select>
                    <button type="submit">Registrar Veículo</button>
                </form>
            </section>
        </section>
    </main>

    <footer>
        <p>© 2024 Sistema de Estacionamento. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
