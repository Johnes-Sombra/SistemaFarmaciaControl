<?php
// Inclui o arquivo de configuração do banco de dados
require_once '../config/database.php';

// Verifica se o formulário foi enviado via método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Prepara a query SQL para inserção de novo medicamento
        // Usando prepared statements para prevenir SQL Injection
        $stmt = $conn->prepare("INSERT INTO medicamentos (nome, laboratorio_id, fornecedor_id, preco_custo, 
            preco_venda, quantidade_estoque, data_validade, descricao) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            
        // Executa a query com os valores do formulário
        // Os valores são passados em um array na mesma ordem dos campos da tabela
        $stmt->execute([
            $_POST['nome'],               // Nome do medicamento
            $_POST['laboratorio_id'],      // ID do laboratório fabricante
            $_POST['fornecedor_id'],       // ID do fornecedor
            $_POST['preco_custo'],         // Preço de custo do medicamento
            $_POST['preco_venda'],         // Preço de venda ao cliente
            $_POST['quantidade_estoque'],   // Quantidade inicial em estoque
            $_POST['data_validade'],       // Data de validade do medicamento
            $_POST['descricao'] ?? null     // Descrição (opcional, pode ser null)
        ]);

        // Redireciona para a página de cadastro com mensagem de sucesso
        header('Location: cadastro_medicamento.php?success=1');
        exit();
    } catch (PDOException $e) {
        // Em caso de erro no banco de dados, redireciona com mensagem de erro
        header('Location: cadastro_medicamento.php?error=' . urlencode('Erro ao cadastrar medicamento: ' . $e->getMessage()));
        exit();
    }
}

// Se a requisição não for POST, redireciona para a página de cadastro
header('Location: cadastro_medicamento.php');