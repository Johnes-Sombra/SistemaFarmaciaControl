<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn->beginTransaction();

        // Inserir a venda
        $medicamento_id = $_POST['medicamento_id'];
        $quantidade = $_POST['quantidade'];

        // Buscar preço do medicamento
        $stmt = $conn->prepare("SELECT preco_venda, quantidade_estoque FROM medicamentos WHERE id = ?");
        $stmt->execute([$medicamento_id]);
        $medicamento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$medicamento) {
            throw new Exception('Medicamento não encontrado');
        }

        if ($quantidade > $medicamento['quantidade_estoque']) {
            throw new Exception('Quantidade insuficiente em estoque');
        }

        $preco_unitario = $medicamento['preco_venda'];
        $valor_total = $preco_unitario * $quantidade;

        // Inserir venda
        $stmt = $conn->prepare("INSERT INTO vendas (valor_total, data_venda) VALUES (?, NOW())");
        $stmt->execute([$valor_total]);
        $venda_id = $conn->lastInsertId();

        // Inserir item da venda
        $stmt = $conn->prepare("INSERT INTO itens_venda (venda_id, medicamento_id, quantidade, preco_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$venda_id, $medicamento_id, $quantidade, $preco_unitario, $valor_total]);

        // Atualizar estoque
        $novo_estoque = $medicamento['quantidade_estoque'] - $quantidade;
        $stmt = $conn->prepare("UPDATE medicamentos SET quantidade_estoque = ? WHERE id = ?");
        $stmt->execute([$novo_estoque, $medicamento_id]);

        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Venda realizada com sucesso']);
        exit();

    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit();
    }
}

header('Location: venda.php');