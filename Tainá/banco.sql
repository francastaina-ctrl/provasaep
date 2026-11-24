CREATE DATABASE IF NOT EXISTS saep CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE saep;

-- Tabela de Utilizadores (Autenticação)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

-- Tabela de Tutores (Com CPF encriptado para conformidade com a LGPD)
CREATE TABLE IF NOT EXISTS tutores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARBINARY(255) NOT NULL,
    telefone VARCHAR(20) NOT NULL
);

-- Tabela de Pets (Vinculados a um Tutor)
CREATE TABLE IF NOT EXISTS pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    especie VARCHAR(50) NOT NULL,
    raca VARCHAR(50),
    idade INT,
    tutor_id INT NOT NULL,
    FOREIGN KEY (tutor_id) REFERENCES tutores(id) ON DELETE CASCADE
);

-- Tabela de Agendamentos
CREATE TABLE IF NOT EXISTS agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT NOT NULL,
    data_agendamento DATE NOT NULL,
    horario TIME NOT NULL,
    motivo TEXT NOT NULL,
    FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE
);

-- Inserir dados de teste (Utilizador padrão e Tutor com CPF encriptado)
INSERT INTO usuarios (nome, email, senha) VALUES 
('Ana Silva', 'ana@clinica.com', '123456');

INSERT INTO tutores (nome, cpf, telefone) VALUES 
('Carlos Souza', AES_ENCRYPT('123.456.789-00', 'chave_secreta_lgpd'), '(11) 98888-7777'),
('Mariana Costa', AES_ENCRYPT('987.654.321-11', 'chave_secreta_lgpd'), '(11) 99999-6666');

INSERT INTO pets (nome, especie, raca, idade, tutor_id) VALUES 
('Rex', 'Cão', 'Labrador', 3, 1),
('Mimi', 'Gato', 'Siamês', 2, 2);

INSERT INTO agendamentos (pet_id, data_agendamento, horario, motivo) VALUES 
(1, '2026-06-10', '14:00:00', 'Vacinação anual'),
(2, '2026-06-11', '10:30:00', 'Consulta de rotina');