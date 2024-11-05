-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS projeto;

USE projeto;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, -- ID do usuário (auto incremento)
  nome VARCHAR(255) NOT NULL,                     -- Nome do usuário
  email VARCHAR(255) NOT NULL UNIQUE,             -- Email único do usuário
  senha VARCHAR(255) NOT NULL,                    -- Senha do usuário (armazenada com hash)
  tipo ENUM('aluno', 'administrador', 'suspenso') NOT NULL DEFAULT 'aluno', -- Tipo de usuário (aluno, administrador ou suspenso)
  data_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Data de cadastro
  telefone VARCHAR(20) DEFAULT NULL,              -- Telefone do usuário
  foto_perfil VARCHAR(255) DEFAULT NULL           -- Foto de perfil do usuário
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela de veículos
CREATE TABLE IF NOT EXISTS veiculos (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, -- ID do veículo (auto incremento)
  usuario_id INT(11) NOT NULL,                    -- ID do usuário (chave estrangeira)
  placa VARCHAR(20) NOT NULL,                     -- Placa do veículo
  marca VARCHAR(50) NOT NULL,                     -- Marca do veículo
  cor VARCHAR(30) NOT NULL,                       -- Cor do veículo
  tipo ENUM('carro', 'moto') NOT NULL,            -- Tipo do veículo (carro ou moto)
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE -- Relacionamento com a tabela de usuários
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela de vagas
CREATE TABLE IF NOT EXISTS vagas (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, -- ID da vaga (auto incremento)
  numero INT(11) NOT NULL,                        -- Número da vaga
  status ENUM('disponivel', 'ocupada') NOT NULL DEFAULT 'disponivel', -- Status da vaga
  veiculo_id INT(11) DEFAULT NULL,                -- ID do veículo (opcional)
  FOREIGN KEY (veiculo_id) REFERENCES veiculos(id) ON DELETE SET NULL -- Relacionamento com a tabela de veículos
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserção de dados iniciais para demonstração

-- Inserção de usuários
INSERT INTO usuarios (nome, email, senha, tipo, data_cadastro, telefone, foto_perfil) VALUES
('Vitor Machado Silva', 'v@aluno.com', '$2y$10$h9.WDXS1lcpUrTzqBlWZmOkjXDBatDrnAwamx0pbVNiZMZClGSZNK', 'aluno', '2024-10-28 12:46:19', '48999206551', 'donwloads/banco.png'),
('Gabriel', 'g@gmail.com', '$2y$10$jFQ42T64nmQ.qnn/.OZ2gOw8fvoO4aI7WHzN4TYnQ/l5qZq8fD6Om', 'administrador', '2024-10-28 13:33:29', NULL, NULL);

-- Inserção de veículos
INSERT INTO veiculos (usuario_id, placa, marca, cor, tipo) VALUES
(1, 'ABC1234', 'Toyota', 'Branco', 'carro'),
(2, 'XYZ5678', 'Honda', 'Preto', 'moto');

-- Inserção de vagas
INSERT INTO vagas (numero, status, veiculo_id) VALUES
(1, 'disponivel', NULL),
(2, 'ocupada', 1); -- Vaga ocupada por um veículo (ID 1)
