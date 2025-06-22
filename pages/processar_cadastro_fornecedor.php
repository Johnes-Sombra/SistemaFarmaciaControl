<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validar CNPJ
        $cnpj = preg_replace('/[^0-9]/', '', $_POST['cnpj']);
        if (strlen($cnpj) !== 14) {
            throw new Exception('CNPJ inválido');
        }

        // Validar e-mail
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('E-mail inválido');
        }

        // Validar prazo de entrega
        $prazo_entrega = intval($_POST['prazo_entrega']);
        if ($prazo_entrega < 1) {
            throw new Exception('Prazo de entrega deve ser maior que zero');
        }

        $stmt = $conn->prepare("INSERT INTO fornecedores (nome, cnpj, telefone, email, endereco, contato, prazo_entrega) 
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $_POST['nome'],
            $cnpj,
            $_POST['telefone'],
            $_POST['email'],
            $_POST['endereco'],
            $_POST['contato'],
            $prazo_entrega
        ]);

        header('Location: cadastro_fornecedor.php?success=1');
        exit();
    } catch (PDOException $e) {
        header('Location: cadastro_fornecedor.php?error=' . urlencode('Erro ao cadastrar fornecedor: ' . $e->getMessage()));
        exit();
    } catch (Exception $e) {
        header('Location: cadastro_fornecedor.php?error=' . urlencode($e->getMessage()));
        exit();
    }
}

header('Location: cadastro_fornecedor.php');