# Sistema de Controle de Farmácia

## Sobre o Projeto

Este é um sistema didático de controle de farmácia desenvolvido em PHP para fins educacionais. O projeto foi criado para demonstrar conceitos básicos de desenvolvimento web e gerenciamento de banco de dados, sem implementar autenticação de usuários para manter o foco no aprendizado das funcionalidades principais.

## Funcionalidades

- Dashboard com informações sobre:
  - Medicamentos populares
  - Laboratórios populares
  - Produtos com estoque baixo (menos de 10 unidades)
- Cadastro e gerenciamento de:
  - Medicamentos
  - Laboratórios
  - Fornecedores
- Sistema de vendas com:
  - Busca de medicamentos
  - Registro de vendas
  - Atualização automática de estoque

## Requisitos

- XAMPP (PHP 7.4 ou superior)
- MySQL/MariaDB
- Navegador web moderno

## Instalação

1. Clone ou baixe este repositório para a pasta `htdocs` do seu XAMPP:
C:\xampp\htdocs\SistemaFarmaciaControl\

2. Importe o banco de dados:
- Abra o phpMyAdmin (http://localhost/phpmyadmin)
- Crie um novo banco de dados chamado `banco_farmacia`
- Importe o arquivo `sql/banco_farmacia.sql`

3. Configure a conexão com o banco de dados:
- Verifique o arquivo `config/database.php`
- Ajuste as credenciais se necessário

## Como Usar

1. Inicie o XAMPP (Apache e MySQL)
2. Acesse o sistema pelo navegador:
http://localhost/SistemaFarmaciaControl/


3. Comece cadastrando:
- Laboratórios
- Fornecedores
- Medicamentos

4. Utilize o sistema de vendas para:
- Buscar medicamentos
- Registrar vendas
- Acompanhar estoque

## Propósito Educacional

Este sistema foi desenvolvido com fins didáticos para demonstrar:
- Operações CRUD em PHP
- Manipulação de banco de dados MySQL
- Desenvolvimento de interfaces com Bootstrap
- Validações de formulários
- Processamento de vendas e controle de estoque

## Observações

- Este é um projeto demonstrativo e não deve ser usado em ambiente de produção
- Não possui sistema de autenticação por ser focado no aprendizado das funcionalidades básicas
- Ideal para estudantes de desenvolvimento web PHP iniciantes e intermediários