<?php
// Definição das constantes de conexão com o banco de dados
// HOST: endereço do servidor MySQL (localhost para servidor local)
define('DB_HOST', 'localhost');
// USER: nome do usuário do banco de dados
define('DB_USER', 'root');
// PASS: senha do usuário (vazio para configuração padrão do XAMPP)
define('DB_PASS', '');
// NAME: nome do banco de dados da aplicação
define('DB_NAME', 'banco_farmacia');

try {
    // Criação da conexão PDO com o banco de dados MySQL
    // PDO é uma classe PHP para acesso a diferentes tipos de bancos de dados
    $conn = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        // Configura a conexão para usar UTF-8
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    // Configura o PDO para lançar exceções em caso de erros
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Em caso de erro na conexão, exibe a mensagem e encerra a aplicação
    echo 'Erro na conexão: ' . $e->getMessage();
    exit();
}