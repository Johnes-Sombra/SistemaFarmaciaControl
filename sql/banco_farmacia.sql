-- Criar o banco de dados
CREATE DATABASE banco_farmacia;
USE banco_farmacia;

-- Tabela de Laboratórios
CREATE TABLE laboratorios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cnpj VARCHAR(18) UNIQUE,
    telefone VARCHAR(15),
    email VARCHAR(100),
    endereco TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Fornecedores
CREATE TABLE fornecedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cnpj VARCHAR(18) UNIQUE,
    telefone VARCHAR(15),
    email VARCHAR(100),
    endereco TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Medicamentos
CREATE TABLE medicamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    laboratorio_id INT,
    fornecedor_id INT,
    preco_custo DECIMAL(10,2),
    preco_venda DECIMAL(10,2),
    quantidade_estoque INT DEFAULT 0,
    quantidade_minima INT DEFAULT 10,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (laboratorio_id) REFERENCES laboratorios(id),
    FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id)
);

-- Tabela de Vendas
CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    valor_total DECIMAL(10,2)
);

-- Tabela de Itens da Venda
CREATE TABLE itens_venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT,
    medicamento_id INT,
    quantidade INT,
    preco_unitario DECIMAL(10,2),
    subtotal DECIMAL(10,2),
    FOREIGN KEY (venda_id) REFERENCES vendas(id),
    FOREIGN KEY (medicamento_id) REFERENCES medicamentos(id)
);