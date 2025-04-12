use ejobs;
CREATE TABLE tipo_usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255)
);

CREATE TABLE estado (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    sigla CHAR(2)
);


CREATE TABLE usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    email VARCHAR(255),
    senha VARCHAR(255),
    documento VARCHAR(255),
    descricao TEXT,
    estado_id INT,
    cidade VARCHAR(100),
    end_logradouro VARCHAR(100),
    end_bairro VARCHAR(100),
    end_numero VARCHAR(100),
    end_complemento VARCHAR(100),
    telefone VARCHAR(20),
    status ENUM('Ativo', 'Inativo'),
    tipo_usuario_id INT,
    FOREIGN KEY (tipo_usuario_id) REFERENCES tipo_usuario(id),
    FOREIGN KEY (estado_id) REFERENCES estado(id)
);

CREATE TABLE cargos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255)
);

CREATE TABLE vaga (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255),
    modalidade ENUM('HOME_OFFICE', 'PRESENCIAL', 'HIBRIDO'),
    horario ENUM('40h', 'PRESENCIAL', 'HIBRIDO'),
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

INSERT INTO estado (nome, sigla) VALUES
('Acre', 'AC'),
('Alagoas', 'AL'),
('Amapá', 'AP'),
('Amazonas', 'AM'),
('Bahia', 'BA'),
('Ceará', 'CE'),
('Distrito Federal', 'DF'),
('Espírito Santo', 'ES'),
('Goiás', 'GO'),
('Maranhão', 'MA'),
('Mato Grosso', 'MT'),
('Mato Grosso do Sul', 'MS'),
('Minas Gerais', 'MG'),
('Pará', 'PA'),
('Paraíba', 'PB'),
('Paraná', 'PR'),
('Pernambuco', 'PE'),
('Piauí', 'PI'),
('Rio de Janeiro', 'RJ'),
('Rio Grande do Norte', 'RN'),
('Rio Grande do Sul', 'RS'),
('Rondônia', 'RO'),
('Roraima', 'RR'),
('Santa Catarina', 'SC'),
('São Paulo', 'SP'),
('Sergipe', 'SE'),
('Tocantins', 'TO');

INSERT INTO tipo_usuario (nome) VALUES
('USUARIO'),
('ADMINISTRADOR'),
('EMPRESA');

INSERT INTO cargo (nome) VALUES 
('Desenvolvedor Backend'),
('Designer UI/UX'),
('Analista de Dados');

INSERT INTO usuario (nome, email, senha, documento, descricao, estado_id, cidade, end_logradouro, end_bairro, end_numero, end_complemento, telefone, status, tipo_usuario_id) VALUES 
('João da Silva', 'joao@email.com', '$2y$10$9H8nNzW7tM7cGhy6r59gYuKuflEGKzKGOMPv86yUhJbySUNnnY42y', '123.456.789-00',
 'Candidato com experiência em TI', 1, 'São Paulo', 'Rua A', 'Centro', '123', 'Apto 12', '(11)99999-9999', 'Ativo', 1),
('Empresa XYZ', 'contato@xyz.com', '$2y$10$PrnFrYArQJto/SlnMTFTpOSDKU9XS5PfeHHUvJlzMxeJH5KdnI/Sm', '12.345.678/0001-99',
 'Empresa de tecnologia', 2, 'Belo Horizonte', 'Av. Brasil', 'Funcionários', '500', 'Sala 10', '(31)98888-8888', 'Ativo', 2),
('Maria Admin', 'admin@maria.com', '$2y$10$9H8nNzW7tM7cGhy6r59gYuKuflEGKzKGOMPv86yUhJbySUNnnY42y', '987.654.321-00',
 'Administrador do sistema', 3, 'Rio de Janeiro', 'Rua das Laranjeiras', 'Centro', '200', '', '(21)97777-7777', 'Ativo', 3);


