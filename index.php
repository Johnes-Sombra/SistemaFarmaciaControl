<?php
// Inclui os arquivos necessários para funcionamento da página
require_once 'config/database.php';  // Conexão com o banco de dados
require_once 'includes/header.php';   // Cabeçalho da página
?>

<div class="container mt-4">
    <div class="row">
        <!-- Painel de Remédios Populares -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Remédios Populares</h5>
                </div>
                <div class="card-body">
                    <?php
                    // Consulta SQL para buscar os 5 medicamentos mais vendidos
                    // Utiliza JOIN para relacionar medicamentos com itens de venda
                    $sql = "SELECT m.nome, COUNT(iv.id) as total_vendas 
                            FROM medicamentos m 
                            LEFT JOIN itens_venda iv ON m.id = iv.medicamento_id 
                            GROUP BY m.id 
                            ORDER BY total_vendas DESC 
                            LIMIT 5";
                    $stmt = $conn->query($sql);
                    $remedios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Loop para exibir cada medicamento com seu total de vendas
                    foreach ($remedios as $remedio) {
                        echo "<div class='d-flex justify-content-between align-items-center mb-2'>";
                        echo "<span>{$remedio['nome']}</span>";
                        echo "<span class='badge bg-primary'>{$remedio['total_vendas']}</span>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Painel de Laboratórios Populares -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">Laboratórios Populares</h5>
                </div>
                <div class="card-body">
                    <?php
                    $sql = "SELECT l.nome, COUNT(iv.id) as total_vendas 
                            FROM laboratorios l 
                            JOIN medicamentos m ON l.id = m.laboratorio_id 
                            LEFT JOIN itens_venda iv ON m.id = iv.medicamento_id 
                            GROUP BY l.id 
                            ORDER BY total_vendas DESC 
                            LIMIT 5";
                    $stmt = $conn->query($sql);
                    $laboratorios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($laboratorios as $lab) {
                        echo "<div class='d-flex justify-content-between align-items-center mb-2'>";
                        echo "<span>{$lab['nome']}</span>";
                        echo "<span class='badge bg-success'>{$lab['total_vendas']}</span>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Painel de Estoque Baixo -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">Estoque Baixo</h5>
                </div>
                <div class="card-body">
                    <?php
                    $sql = "SELECT nome, quantidade_estoque 
                            FROM medicamentos 
                            WHERE quantidade_estoque < 10 
                            ORDER BY quantidade_estoque ASC";
                    $stmt = $conn->query($sql);
                    $estoque_baixo = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($estoque_baixo as $item) {
                        echo "<div class='d-flex justify-content-between align-items-center mb-2'>";
                        echo "<span>{$item['nome']}</span>";
                        echo "<span class='badge bg-danger'>{$item['quantidade_estoque']}</span>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Botões de Ação Rápida -->
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <a href="pages/venda.php" class="btn btn-primary w-100">
                <i class="fas fa-shopping-cart"></i> Nova Venda
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="pages/cadastro_medicamento.php" class="btn btn-success w-100">
                <i class="fas fa-pills"></i> Cadastrar Medicamento
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="pages/cadastro_laboratorio.php" class="btn btn-info w-100">
                <i class="fas fa-flask"></i> Cadastrar Laboratório
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="pages/cadastro_fornecedor.php" class="btn btn-warning w-100">
                <i class="fas fa-truck"></i> Cadastrar Fornecedor
            </a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>