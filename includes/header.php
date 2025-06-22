<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Configurações básicas do documento HTML -->
    <meta charset="UTF-8">  <!-- Define a codificação de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Configuração para responsividade -->
    <title>Sistema de Controle de Farmácia</title>

    <!-- Carregamento das bibliotecas JavaScript e CSS -->
    <!-- jQuery é carregado primeiro pois outras bibliotecas dependem dele -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS para estilização e componentes responsivos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JavaScript para funcionalidades interativas -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome para ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Estilos personalizados do sistema -->
    <link href="/SistemaFarmaciaControl/css/style.css" rel="stylesheet">
    <!-- Favicon do site -->
    <link rel="shortcut icon" href="/SistemaFarmaciaControl/favicon.ico" type="image/x-icon">
</head>
<body>
    <!-- Barra de navegação principal -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Logo e nome do sistema -->
            <a class="navbar-brand" href="/">Farmácia Control</a>
            <!-- Botão para menu mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Menu de navegação -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Links para as principais funcionalidades do sistema -->
                    <li class="nav-item">
                        <a class="nav-link" href="/SistemaFarmaciaControl/"><i class="fas fa-home"></i> Início</a>
                    </li>
                    <!-- Outros itens do menu com seus respectivos ícones -->
                    <li class="nav-item">
                        <a class="nav-link" href="/SistemaFarmaciaControl/pages/venda.php"><i class="fas fa-shopping-cart"></i> Vendas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/SistemaFarmaciaControl/pages/cadastro_medicamento.php"><i class="fas fa-pills"></i> Medicamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/SistemaFarmaciaControl/pages/cadastro_laboratorio.php"><i class="fas fa-industry"></i> Laboratórios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/SistemaFarmaciaControl/pages/cadastro_fornecedor.php"><i class="fas fa-truck"></i> Fornecedores</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>