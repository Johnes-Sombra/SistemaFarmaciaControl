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

        // Prepara a query SQL usando prepared statements para evitar SQL Injection
        $stmt = $conn->prepare("INSERT INTO laboratorios (nome, cnpj, telefone, email, endereco) VALUES (?, ?, ?, ?, ?)");
        
        // Executa a query com os dados validados
        $stmt->execute([
            $_POST['nome'],
            $cnpj,
            $_POST['telefone'],
            $_POST['email'],
            $_POST['endereco']
        ]);

        // Redireciona com mensagem de sucesso
        header('Location: cadastro_laboratorio.php?success=1');
        exit();
    } catch (PDOException $e) {
        // Tratamento de erro específico para problemas com o banco de dados
        header('Location: cadastro_laboratorio.php?error=' . urlencode('Erro ao cadastrar laboratório: ' . $e->getMessage()));
        exit();
    } catch (Exception $e) {
        // Tratamento de erro para validações
        header('Location: cadastro_laboratorio.php?error=' . urlencode($e->getMessage()));
        exit();
    }
}

// Se não for POST, redireciona para o formulário
header('Location: cadastro_laboratorio.php');