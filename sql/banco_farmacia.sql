-- Criação do Banco de Dados
-- Cria um novo banco de dados e define como atual
CREATE DATABASE banco_farmacia;
USE banco_farmacia;

-- Tabela de Laboratórios
-- Armazena informações dos laboratórios farmacêuticos
CREATE TABLE laboratorios (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Identificador único do laboratório
    nome VARCHAR(100) NOT NULL,         -- Nome do laboratório (obrigatório)
    cnpj VARCHAR(18) UNIQUE,            -- CNPJ único do laboratório
    telefone VARCHAR(15),               -- Número de telefone para contato
    email VARCHAR(100),                 -- Endereço de e-mail
    endereco TEXT,                      -- Endereço completo
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Data e hora de cadastro
);

-- Tabela de Fornecedores
-- Armazena informações dos fornecedores de medicamentos
CREATE TABLE fornecedores (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Identificador único do fornecedor
    nome VARCHAR(100) NOT NULL,         -- Nome do fornecedor (obrigatório)
    cnpj VARCHAR(18) UNIQUE,            -- CNPJ único do fornecedor
    telefone VARCHAR(15),               -- Número de telefone
    email VARCHAR(100),                 -- Endereço de e-mail
    endereco TEXT,                      -- Endereço completo
    contato VARCHAR(100),               -- Nome da pessoa de contato
    prazo_entrega INT,                  -- Prazo de entrega em dias
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Data e hora de cadastro
);

-- Tabela de Medicamentos
-- Cadastro e controle de estoque dos medicamentos
CREATE TABLE medicamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Identificador único do medicamento
    nome VARCHAR(100) NOT NULL,         -- Nome do medicamento (obrigatório)
    descricao TEXT,                     -- Descrição detalhada do medicamento
    laboratorio_id INT,                 -- Referência ao laboratório fabricante
    fornecedor_id INT,                  -- Referência ao fornecedor
    preco_custo DECIMAL(10,2),          -- Preço de compra (2 casas decimais)
    preco_venda DECIMAL(10,2),          -- Preço de venda (2 casas decimais)
    quantidade_estoque INT DEFAULT 0,    -- Quantidade atual em estoque
    quantidade_minima INT DEFAULT 10,    -- Quantidade mínima para alerta
    data_validade DATE,                 -- Data de validade do lote
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Data e hora de cadastro
    FOREIGN KEY (laboratorio_id) REFERENCES laboratorios(id),  -- Relacionamento com laboratórios
    FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id)    -- Relacionamento com fornecedores
);

-- Tabela de Vendas
-- Registro das vendas realizadas
CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Identificador único da venda
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Data e hora da venda
    valor_total DECIMAL(10,2)           -- Valor total da venda
);

-- Tabela de Itens da Venda
-- Detalhamento dos medicamentos incluídos em cada venda
CREATE TABLE itens_venda (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Identificador único do item
    venda_id INT,                      -- Referência à venda
    medicamento_id INT,                -- Referência ao medicamento
    quantidade INT,                    -- Quantidade vendida
    preco_unitario DECIMAL(10,2),      -- Preço unitário no momento da venda
    subtotal DECIMAL(10,2),            -- Valor total do item (quantidade * preço)
    FOREIGN KEY (venda_id) REFERENCES vendas(id),           -- Relacionamento com vendas
    FOREIGN KEY (medicamento_id) REFERENCES medicamentos(id) -- Relacionamento com medicamentos
);