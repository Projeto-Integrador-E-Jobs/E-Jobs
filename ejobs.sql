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

CREATE TABLE cargo (
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
    FOREIGN KEY (cargos_id) REFERENCES cargo(id)
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