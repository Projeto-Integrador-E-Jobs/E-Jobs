CREATE TABLE IF NOT EXISTS candidatura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    candidato_id INT NOT NULL,
    vaga_id INT NOT NULL,
    data_candidatura DATETIME NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'PENDENTE',
    FOREIGN KEY (candidato_id) REFERENCES usuario(id),
    FOREIGN KEY (vaga_id) REFERENCES vaga(id),
    UNIQUE KEY unique_candidatura (candidato_id, vaga_id)
); 
