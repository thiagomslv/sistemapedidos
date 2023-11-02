<h1 align=center>Sistema de gerenciamento de pedidos e análise de clientes</h1>

## 1 - Sobre

Muitas vezes empreendedores tem dificuldade em gerenciar pedidos e saber onde exatamente existe maior demanda de clientes. O sistema de gerenciamento de pedidos vem para resover essa demanda. Com ele, é possível cadastrar novos pedidos, listar os pedidos já cadastrados no sistema, exportar esses pedidos para uma planilha no formato do excel (.xlsx) e fechar pedidos que já foram entregues.

O sistema tem um módulo de análise de clientes. Com ele, é possível visualizar onde os pedidos em um determinado período foram feitos e gerar um mapa de calor para determinar em quais localidades há maior demanda.

## 2 - Tecnologias

- Laravel
- JavaScript
- CSS
- Leaflet
- Banco de dados relacional

## 3 - Como rodar o projeto

```
1. Faça o clone do repositório com o Git.
$ git clone https://github.com/thiagomslv/sistemapedidos.git

2. Crie um arquivo .env utilizando como modelo o arquivo .env.example

3. Configure a conexão com um banco de dados relacional dentro do arquivo .env

4. Abra o terminal na pasta do arquivo e use o composer para baixar as dependências do projeto.
composer update

5. Com a conexão do banco feita, execute as migrations para criação das tabelas.
php artisan migrate

6. Execute o servidor de desenvolvimento.
php artisan serve

7. Acesse a URL disponibilizada pelo servidor de desenvolvimento em http://127.0.0.1:8000
```

<p align="center">De <a href="https://www.linkedin.com/in/thiagomslv/">Thiago Marques</a> para o mundo!</p>