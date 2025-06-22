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

        $stmt = $conn->prepare("INSERT INTO laboratorios (nome, cnpj, telefone, email, endereco) VALUES (?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $_POST['nome'],
            $cnpj,
            $_POST['telefone'],
            $_POST['email'],
            $_POST['endereco']
        ]);

        header('Location: cadastro_laboratorio.php?success=1');
        exit();
    } catch (PDOException $e) {
        header('Location: cadastro_laboratorio.php?error=' . urlencode('Erro ao cadastrar laboratório: ' . $e->getMessage()));
        exit();
    } catch (Exception $e) {
        header('Location: cadastro_laboratorio.php?error=' . urlencode($e->getMessage()));
        exit();
    }
}

header('Location: cadastro_laboratorio.php');