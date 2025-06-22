<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare("INSERT INTO medicamentos (nome, laboratorio_id, fornecedor_id, preco_custo, 
            preco_venda, quantidade_estoque, data_validade, descricao) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            
        $stmt->execute([
            $_POST['nome'],
            $_POST['laboratorio_id'],
            $_POST['fornecedor_id'],
            $_POST['preco_custo'],
            $_POST['preco_venda'],
            $_POST['quantidade_estoque'],
            $_POST['data_validade'],
            $_POST['descricao'] ?? null
        ]);

        header('Location: cadastro_medicamento.php?success=1');
        exit();
    } catch (PDOException $e) {
        header('Location: cadastro_medicamento.php?error=' . urlencode('Erro ao cadastrar medicamento: ' . $e->getMessage()));
        exit();
    }
}

header('Location: cadastro_medicamento.php');