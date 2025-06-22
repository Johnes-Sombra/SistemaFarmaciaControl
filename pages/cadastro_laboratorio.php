<?php
// Inclui os arquivos necessários para conexão com banco de dados e cabeçalho da página
require_once '../config/database.php';
require_once '../includes/header.php';
?>

<!-- Container principal do formulário de cadastro -->
<div class="container mt-4">
    <h2>Cadastro de Laboratório</h2>
    
    <!-- Sistema de feedback para o usuário -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success" role="alert">
            Laboratório cadastrado com sucesso!
        </div>
    <?php endif; ?>

    <!-- Exibição de mensagens de erro -->
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($_GET['error']); // Proteção contra XSS ?>
        </div>
    <?php endif; ?>

    <!-- Formulário de cadastro com validação Bootstrap -->
    <form action="processar_cadastro_laboratorio.php" method="POST" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nome" class="form-label">Nome do Laboratório</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
                <div class="invalid-feedback">Por favor, informe o nome do laboratório.</div>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="cnpj" class="form-label">CNPJ</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" required>
                <div class="invalid-feedback">Por favor, informe o CNPJ do laboratório.</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" required>
                <div class="invalid-feedback">Por favor, informe o telefone do laboratório.</div>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div class="invalid-feedback">Por favor, informe um e-mail válido.</div>
            </div>
        </div>

        <div class="mb-3">
            <label for="endereco" class="form-label">Endereço</label>
            <textarea class="form-control" id="endereco" name="endereco" rows="2" required></textarea>
            <div class="invalid-feedback">Por favor, informe o endereço do laboratório.</div>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar Laboratório</button>
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