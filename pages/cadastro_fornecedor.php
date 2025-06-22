<?php
require_once '../config/database.php';
require_once '../includes/header.php';
?>

<div class="container mt-4">
    <h2>Cadastro de Fornecedor</h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success" role="alert">
            Fornecedor cadastrado com sucesso!
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <form action="processar_cadastro_fornecedor.php" method="POST" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nome" class="form-label">Nome do Fornecedor</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
                <div class="invalid-feedback">Por favor, informe o nome do fornecedor.</div>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="cnpj" class="form-label">CNPJ</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" required>
                <div class="invalid-feedback">Por favor, informe o CNPJ do fornecedor.</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" required>
                <div class="invalid-feedback">Por favor, informe o telefone do fornecedor.</div>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div class="invalid-feedback">Por favor, informe um e-mail válido.</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <textarea class="form-control" id="endereco" name="endereco" rows="2" required></textarea>
                <div class="invalid-feedback">Por favor, informe o endereço do fornecedor.</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="contato" class="form-label">Nome do Contato</label>
                <input type="text" class="form-control" id="contato" name="contato" required>
                <div class="invalid-feedback">Por favor, informe o nome do contato.</div>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="prazo_entrega" class="form-label">Prazo de Entrega (dias)</label>
                <input type="number" class="form-control" id="prazo_entrega" name="prazo_entrega" required min="1">
                <div class="invalid-feedback">Por favor, informe o prazo de entrega.</div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar Fornecedor</button>
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