<?php
require_once '../config/database.php';
require_once '../includes/header.php';

// Buscar laboratórios para o select
$stmt = $conn->query("SELECT id, nome FROM laboratorios ORDER BY nome");
$laboratorios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar fornecedores para o select
$stmt = $conn->query("SELECT id, nome FROM fornecedores ORDER BY nome");
$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Cadastro de Medicamento</h2>
    <form action="processar_cadastro_medicamento.php" method="POST" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nome" class="form-label">Nome do Medicamento</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
                <div class="invalid-feedback">Por favor, informe o nome do medicamento.</div>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="laboratorio_id" class="form-label">Laboratório</label>
                <select class="form-select" id="laboratorio_id" name="laboratorio_id" required>
                    <option value="">Selecione um laboratório</option>
                    <?php foreach ($laboratorios as $lab): ?>
                        <option value="<?php echo $lab['id']; ?>"><?php echo htmlspecialchars($lab['nome']); ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Por favor, selecione um laboratório.</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="preco_custo" class="form-label">Preço de Custo</label>
                <input type="number" step="0.01" class="form-control" id="preco_custo" name="preco_custo" required>
                <div class="invalid-feedback">Por favor, informe o preço de custo.</div>
            </div>
            
            <div class="col-md-4 mb-3">
                <label for="preco_venda" class="form-label">Preço de Venda</label>
                <input type="number" step="0.01" class="form-control" id="preco_venda" name="preco_venda" required>
                <div class="invalid-feedback">Por favor, informe o preço de venda.</div>
            </div>
            
            <div class="col-md-4 mb-3">
                <label for="quantidade_estoque" class="form-label">Quantidade em Estoque</label>
                <input type="number" class="form-control" id="quantidade_estoque" name="quantidade_estoque" required>
                <div class="invalid-feedback">Por favor, informe a quantidade em estoque.</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="fornecedor_id" class="form-label">Fornecedor</label>
                <select class="form-select" id="fornecedor_id" name="fornecedor_id" required>
                    <option value="">Selecione um fornecedor</option>
                    <?php foreach ($fornecedores as $forn): ?>
                        <option value="<?php echo $forn['id']; ?>"><?php echo htmlspecialchars($forn['nome']); ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Por favor, selecione um fornecedor.</div>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="data_validade" class="form-label">Data de Validade</label>
                <input type="date" class="form-control" id="data_validade" name="data_validade" required>
                <div class="invalid-feedback">Por favor, informe a data de validade.</div>
            </div>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar Medicamento</button>
        <a href="../index.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>

<script>
// Validação do formulário
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.needs-validation');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>

<?php require_once '../includes/footer.php'; ?>