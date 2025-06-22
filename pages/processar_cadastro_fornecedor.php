<?php
// Inclui arquivo de conexão com o banco de dados
require_once '../config/database.php';

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validação do CNPJ: remove caracteres não numéricos e verifica o tamanho
        $cnpj = preg_replace('/[^0-9]/', '', $_POST['cnpj']);
        if (strlen($cnpj) !== 14) {
            throw new Exception('CNPJ inválido');
        }

        // Validação do e-mail usando filtro nativo do PHP
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('E-mail inválido');
        }

        // Validação do prazo de entrega: converte para inteiro e verifica se é positivo
        $prazo_entrega = intval($_POST['prazo_entrega']);
        if ($prazo_entrega < 1) {
            throw new Exception('Prazo de entrega deve ser maior que zero');
        }

        // Prepara a query SQL usando prepared statements para evitar SQL Injection
        $stmt = $conn->prepare("INSERT INTO fornecedores (nome, cnpj, telefone, email, endereco, contato, prazo_entrega) 
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        // Executa a query com os valores validados
        $stmt->execute([
            $_POST['nome'],
            $cnpj,
            $_POST['telefone'],
            $_POST['email'],
            $_POST['endereco'],
            $_POST['contato'],
            $prazo_entrega
        ]);

        // Redireciona com mensagem de sucesso
        header('Location: cadastro_fornecedor.php?success=1');
        exit();
    } catch (PDOException $e) {
        // Tratamento de erro específico para problemas com o banco de dados
        header('Location: cadastro_fornecedor.php?error=' . urlencode('Erro ao cadastrar fornecedor: ' . $e->getMessage()));
        exit();
    } catch (Exception $e) {
        // Tratamento de erro para validações
        header('Location: cadastro_fornecedor.php?error=' . urlencode($e->getMessage()));
        exit();
    }
}

// Se não for POST, redireciona para o formulário
header('Location: cadastro_fornecedor.php');