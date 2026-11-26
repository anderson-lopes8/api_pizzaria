CREATE DATABASE apipizzaria;
USE pizzaria;

CREATE TABLE pizzas (
idPizza INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(50) NOT NULL UNIQUE,
ingredientes VARCHAR(255) NOT NULL,
valor DECIMAL(10, 2) NOT NULL
);

INSERT INTO pizzas (nome, ingredientes, valor) VALUES
('Calabresa', 'Mussarela, calabresa fatiada e cebola', 45.50),
('Mussarela', 'Mussarela e molho de tomate', 40.00),
('Frango com Catupiry', 'Frango desfiado, catupiry e mussarela', 52.90),
('Portuguesa', 'Mussarela, presunto, ovo, ervilha, cebola e calabresa', 62.90),
('Moda do Juca', 'Mussarela, peito de peru, palmito, alho poró e alcaparras', 72.50),
('Matafome', 'Mussarela, ovo, tomate, cebola e calabresa', 72.50),
('Alho' , 'Queijo, ovo, molho de  tomate, cebola', 53.00);

SELECT * FROM pizzas