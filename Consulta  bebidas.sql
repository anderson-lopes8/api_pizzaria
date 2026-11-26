CREATE DATABASE bebidas;

USE bebidas;


CREATE TABLE bebidas_ml (
id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100) NOT NULL,
ml INT NOT NULL,
valor DECIMAL(8,2) NOT NULL
);

INSERT INTO bebidas_ml (nome, ml, valor) VALUES
('Coca-Cola', 350, 5.50),
('Pepsi', 350, 5.00),
('Guaraná', 350, 4.50),
('Suco de Laranja', 500, 6.00),
('Água Mineral', 500, 2.50),
('Cerveja Antartica', 350, 4.50),
('Cerveja Brahma', 600, 10.50),
('Cerveja Bohemia', 350, 15.50);


SELECT * FROM bebidas_ml;