<?php
// Inclui arquivo de conexão com o banco de dados
require_once '../config/database.php';

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Inicia uma transação para garantir a integridade dos dados
        $conn->beginTransaction();

        // Recupera os dados do formulário
        $medicamento_id = $_POST['medicamento_id'];
        $quantidade = $_POST['quantidade'];

        // Busca informações do medicamento no banco de dados
        $stmt = $conn->prepare("SELECT preco_venda, quantidade_estoque FROM medicamentos WHERE id = ?");
        $stmt->execute([$medicamento_id]);
        $medicamento = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o medicamento existe
        if (!$medicamento) {
            throw new Exception('Medicamento não encontrado');
        }

        // Verifica se há estoque suficiente
        if ($quantidade > $medicamento['quantidade_estoque']) {
            throw new Exception('Quantidade insuficiente em estoque');
        }

        // Calcula o valor total da venda
        $preco_unitario = $medicamento['preco_venda'];
        $valor_total = $preco_unitario * $quantidade;

        // Insere o registro da venda
        $stmt = $conn->prepare("INSERT INTO vendas (valor_total, data_venda) VALUES (?, NOW())");
        $stmt->execute([$valor_total]);
        $venda_id = $conn->lastInsertId();

        // Insere os itens da venda
        $stmt = $conn->prepare("INSERT INTO itens_venda (venda_id, medicamento_id, quantidade, preco_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$venda_id, $medicamento_id, $quantidade, $preco_unitario, $valor_total]);

        // Atualiza o estoque do medicamento
        $novo_estoque = $medicamento['quantidade_estoque'] - $quantidade;
        $stmt = $conn->prepare("UPDATE medicamentos SET quantidade_estoque = ? WHERE id = ?");
        $stmt->execute([$novo_estoque, $medicamento_id]);

        // Confirma a transação
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Venda realizada com sucesso']);
        exit();

    } catch (Exception $e) {
        // Em caso de erro, desfaz todas as operações
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit();
    }
}

// Redireciona para a página de vendas se não for uma requisição POST
header('Location: venda.php');