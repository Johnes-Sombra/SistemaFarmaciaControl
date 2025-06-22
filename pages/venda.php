<?php
require_once '../config/database.php';
require_once '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <!-- Lado Esquerdo - Pesquisa e Lista de Medicamentos -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pesquisar Medicamentos</h5>
                </div>
                <div class="card-body">
                    <input type="text" id="pesquisaMedicamento" class="form-control mb-3" placeholder="Digite o nome do medicamento...">
                    <div id="listaMedicamentos" class="list-group">
                        <?php
                        $sql = "SELECT id, nome, preco_venda, quantidade_estoque FROM medicamentos ORDER BY nome";
                        $stmt = $conn->query($sql);
                        while ($row = $stmt->fetch()) {
                            echo "<a href='#' class='list-group-item list-group-item-action' 
                                    data-id='{$row['id']}' 
                                    data-nome='{$row['nome']}' 
                                    data-preco='{$row['preco_venda']}' 
                                    data-estoque='{$row['quantidade_estoque']}'>
                                    {$row['nome']} - R$ {$row['preco_venda']} 
                                    (Estoque: {$row['quantidade_estoque']})
                                 </a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lado Direito - Formulário de Venda -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Registrar Venda</h5>
                </div>
                <div class="card-body">
                    <form id="formVenda" action="processar_venda.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Medicamento Selecionado</label>
                            <input type="text" id="medicamentoNome" class="form-control" readonly>
                            <input type="hidden" id="medicamentoId" name="medicamento_id">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Preço Unitário</label>
                            <input type="text" id="precoUnitario" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantidade Disponível</label>
                            <input type="text" id="quantidadeEstoque" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantidade</label>
                            <input type="number" id="quantidade" name="quantidade" class="form-control" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total</label>
                            <input type="text" id="total" class="form-control" readonly>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Registrar Venda
                            </button>
                            <button type="button" class="btn btn-secondary" id="btnCancelar">
                                <i class="fas fa-times"></i> Cancelar Venda
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Pesquisa de medicamentos
    $("#pesquisaMedicamento").on("keyup", function() {
        var valor = $(this).val().toLowerCase();
        $("#listaMedicamentos a").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1)
        });
    });

    // Seleção de medicamento
    $("#listaMedicamentos a").click(function(e) {
        e.preventDefault();
        $("#medicamentoId").val($(this).data("id"));
        $("#medicamentoNome").val($(this).data("nome"));
        $("#precoUnitario").val($(this).data("preco"));
        $("#quantidadeEstoque").val($(this).data("estoque"));
        $("#quantidade").val(1);
        calcularTotal();
    });

    // Cálculo do total
    $("#quantidade").on("input", function() {
        calcularTotal();
    });

    function calcularTotal() {
        var quantidade = $("#quantidade").val();
        var preco = $("#precoUnitario").val();
        var total = quantidade * preco;
        $("#total").val(total.toFixed(2));
    }

    // Cancelar venda
    $("#btnCancelar").click(function() {
        $("#formVenda")[0].reset();
        $("#total").val("");
    });

    // Validação do formulário
    $("#formVenda").submit(function(e) {
        var quantidade = parseInt($("#quantidade").val());
        var estoque = parseInt($("#quantidadeEstoque").val());
        
        if (quantidade > estoque) {
            e.preventDefault();
            alert("Quantidade solicitada maior que o estoque disponível!");
        }
    });
});
</script>

<?php require_once '../includes/footer.php'; ?>