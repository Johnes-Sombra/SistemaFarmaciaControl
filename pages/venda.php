<?php
// Inclui os arquivos necessários para conexão com banco de dados e cabeçalho da página
require_once '../config/database.php';
require_once '../includes/header.php';
?>

<!-- Container principal da página de vendas -->
<div class="container mt-4">
    <!-- Área para exibição de mensagens de feedback ao usuário -->
    <div id="mensagem" class="alert" style="display: none;"></div>
    <div class="row">
        <!-- Seção esquerda - Lista de medicamentos disponíveis -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pesquisar Medicamentos</h5>
                </div>
                <div class="card-body">
                    <!-- Campo de pesquisa para filtrar medicamentos -->
                    <input type="text" id="pesquisaMedicamento" class="form-control mb-3" placeholder="Digite o nome do medicamento...">
                    <!-- Lista de medicamentos carregada do banco de dados -->
                    <div id="listaMedicamentos" class="list-group">
                        <?php
                        // Consulta SQL para buscar todos os medicamentos ordenados por nome
                        $sql = "SELECT id, nome, preco_venda, quantidade_estoque FROM medicamentos ORDER BY nome";
                        $stmt = $conn->query($sql);
                        // Loop para exibir cada medicamento como um item clicável
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

        <!-- Seção direita - Formulário de registro de venda -->
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
                            <a href="../index.php" class="btn btn-secondary">
                                <i class="fas fa-home"></i> Início
                            </a>
                            <button type="button" class="btn btn-danger" id="btnCancelar">
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

    // Seleção de medicamento (usando delegação de eventos)
    $("#listaMedicamentos").on("click", "a", function(e) {
        e.preventDefault();
        $("#medicamentoId").val($(this).data("id"));
        $("#medicamentoNome").val($(this).data("nome"));
        $("#precoUnitario").val($(this).data("preco"));
        $("#quantidadeEstoque").val($(this).data("estoque"));
        $("#quantidade").val(1);
        calcularTotal();
    });

    // Calcular total ao mudar quantidade
    $("#quantidade").on("change keyup", function() {
        calcularTotal();
    });

    function calcularTotal() {
        var quantidade = parseInt($("#quantidade").val()) || 0;
        var precoUnitario = parseFloat($("#precoUnitario").val()) || 0;
        var estoque = parseInt($("#quantidadeEstoque").val()) || 0;

        if (quantidade > estoque) {
            $("#quantidade").val(estoque);
            quantidade = estoque;
            mostrarMensagem("Quantidade ajustada para o máximo disponível em estoque", "warning");
        }

        $("#total").val((quantidade * precoUnitario).toFixed(2));
    }

    // Botão Cancelar
    $("#btnCancelar").click(function() {
        $("#formVenda")[0].reset();
        $("#medicamentoId").val("");
        $("#total").val("");
        mostrarMensagem("", ""); // Limpa mensagens
    });

    // Envio do formulário
    $("#formVenda").submit(function(e) {
        e.preventDefault();
        
        if (!$("#medicamentoId").val()) {
            mostrarMensagem("Selecione um medicamento", "danger");
            return;
        }

        $.ajax({
            url: "processar_venda.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    mostrarMensagem(response.message, "success");
                    $("#formVenda")[0].reset();
                    $("#medicamentoId").val("");
                    $("#total").val("");
                    
                    // Atualizar a lista de medicamentos
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    mostrarMensagem(response.message, "danger");
                }
            },
            error: function() {
                mostrarMensagem("Erro ao processar a venda", "danger");
            }
        });
    });

    function mostrarMensagem(texto, tipo) {
        if (texto) {
            $("#mensagem")
                .removeClass()
                .addClass("alert alert-" + tipo)
                .html(texto)
                .show();
        } else {
            $("#mensagem").hide();
        }
    }
});
</script>

<?php require_once '../includes/footer.php'; ?>