use ejobs;
CREATE TABLE tipo_usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255)
);

CREATE TABLE usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    email VARCHAR(255),
    senha VARCHAR(255),
    documento VARCHAR(255),
    descricao TEXT,
    cidade_id INT,
    end_logradouro VARCHAR(100),
    end_bairro VARCHAR(100),
    end_numero VARCHAR(100),
    telefone VARCHAR(20),
    status ENUM('Ativo', 'Inativo','Pendente'),
    tipo_usuario_id INT,
    FOREIGN KEY (tipo_usuario_id) REFERENCES tipo_usuario(id),
    FOREIGN KEY (cidade_id) REFERENCES cidades(codigo_ibge)
);

CREATE TABLE cargos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255)
);

CREATE TABLE vaga (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255),
    modalidade ENUM('HOME OFFICE', 'PRESENCIAL', 'HIBRIDO'),
    horario ENUM('20h', '30h', '40h', '44h', 'Outros'),
    regime ENUM('CLT', 'PJ', 'ESTÁGIO'),
    salario DECIMAL(10,2),
    descricao TEXT,
    requisitos TEXT,
    empresa_id INT,
    cargos_id INT,
    FOREIGN KEY (empresa_id) REFERENCES usuario(id),
    FOREIGN KEY (cargos_id) REFERENCES cargos(id)
);

CREATE TABLE candidatura (
    id INT PRIMARY KEY AUTO_INCREMENT,
    candidato_id INT,
    vaga_id INT,
    data_candidatura DATETIME,
    status ENUM('EM_ANDAMENTO', 'FINALIZADO'),
    FOREIGN KEY (candidato_id) REFERENCES usuario(id),
    FOREIGN KEY (vaga_id) REFERENCES vaga(id)
);

INSERT INTO tipo_usuario (nome) VALUES
('CANDIDATO'),
('ADMINISTRADOR'),
('EMPRESA');

INSERT INTO cargos (nome) VALUES 
('Desenvolvedor Backend'),
('Designer UI/UX'),
('Analista de Dados');

mysql -u root -p ejobs < estados.sql
mysql -u root -p ejobs < municipios.sql

INSERT INTO usuario (
    nome, email, senha, documento, descricao, cidade_id,
    end_logradouro, end_bairro, end_numero, end_complemento,
    telefone, status, tipo_usuario_id
) VALUES 
('João da Silva', 'joao@email.com', '$2y$10$9H8nNzW7tM7cGhy6r59gYuKuflEGKzKGOMPv86yUhJbySUNnnY42y', '123.456.789-00',
 'Candidato com experiência em TI', 3550308, 'Rua A', 'Centro', '123', 'Apto 12', '(11)99999-9999', 'Ativo', 1),

('Empresa XYZ', 'contato@xyz.com', '$2y$10$PrnFrYArQJto/SlnMTFTpOSDKU9XS5PfeHHUvJlzMxeJH5KdnI/Sm', '12.345.678/0001-99',
 'Empresa de tecnologia', 3106200, 'Av. Brasil', 'Funcionários', '500', 'Sala 10', '(31)98888-8888', 'Ativo', 2),

('Maria Admin', 'admin@maria.com', '$2y$10$9H8nNzW7tM7cGhy6r59gYuKuflEGKzKGOMPv86yUhJbySUNnnY42y', '987.654.321-00',
 'Administrador do sistema', 3304557, 'Rua das Laranjeiras', 'Centro', '200', '', '(21)97777-7777', 'Ativo', 3);

INSERT INTO vaga (titulo, modalidade, horario, regime, salario, descricao, requisitos, empresa_id, cargos_id) VALUES 
('Desenvolvedor PHP Pleno', 'HOME OFFICE', '40h', 'CLT', 5000.00, 'Desenvolvimento de aplicações web em PHP', 'Experiência com Laravel, MySQL, Git', 2, 1),
('Designer UI/UX', 'PRESENCIAL', '40h', 'PJ', 4500.00, 'Criação de interfaces modernas', 'Figma, Adobe XD, criatividade', 2, 2);
