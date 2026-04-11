# 🏪 Sistema de Comércio Local

## 🎯 Sobre o Projeto

Este projeto consiste no desenvolvimento de um sistema web simples para pequenos comércios, com o objetivo de facilitar o controle de vendas, estoque e clientes.

O sistema foi pensado para atender negócios como:

* Padarias
* Sacolões
* Petshops
* Lojas de bairro
* Materiais de construção

---

## 🚀 Objetivo

Ajudar pequenos comerciantes a:

* Organizar vendas
* Controlar estoque
* Gerenciar clientes
* Evitar prejuízos
* Acompanhar lucros

---

## 🧱 Tecnologias Utilizadas

* PHP (Backend)
* MySQL (Banco de dados)
* HTML, CSS e Bootstrap (Frontend)
* Git e GitHub (Versionamento)

---

## 📌 Funcionalidades

### 💰 Vendas (PDV)

* Registro de vendas
* Cálculo automático de valores
* Formas de pagamento (dinheiro, cartão, fiado)

---

### 📦 Estoque

* Cadastro de produtos
* Controle de quantidade
* Baixa automática após venda
* Alerta de estoque baixo

---

### 👤 Clientes

* Cadastro de clientes
* Histórico de compras

---

### 📒 Controle de Fiado

* Registro de vendas pendentes
* Controle de pagamentos
* Lista de clientes devedores

---

### 📊 Relatórios

* Total de vendas por dia/mês
* Produtos mais vendidos
* Controle de caixa

---

## 🗄️ Banco de Dados

### Tabela: produtos

* id
* nome
* preco
* quantidade
* created_at

### Tabela: clientes

* id
* nome
* telefone

### Tabela: vendas

* id
* total
* forma_pagamento
* data

### Tabela: itens_venda

* id
* venda_id
* produto_id
* quantidade
* preco

### Tabela: fiado

* id
* cliente_id
* valor
* pago
* data

---

## 🗂️ Estrutura do Projeto

/app
  /controllers
  /models
  /views

/config
/routes
/public
/database
/docs

---

## 🔐 Segurança

* Uso de `PDO` para conexão com banco
* Proteção contra SQL Injection
* Estrutura preparada para autenticação futura

---

## 📅 Roadmap de Desenvolvimento

### Fase 1

* Cadastro de produtos
* Listagem de produtos

### Fase 2

* Tela de vendas (PDV)
* Registro de vendas

### Fase 3

* Controle automático de estoque

### Fase 4

* Cadastro de clientes
* Sistema de fiado

### Fase 5

* Relatórios e melhorias

---

## 🚀 Como Executar o Projeto

1. Clone o repositório:

```bash
git clone https://github.com/seu-usuario/sistema-comercio.git
```

2. Configure o ambiente:

* Instale XAMPP ou similar
* Inicie Apache e MySQL

3. Configure o banco:

* Crie o banco `sistema_comercio`
* Importe o arquivo `/database/schema.sql`

4. Configure a conexão:

* Edite `/config/database.php`

5. Acesse no navegador:

```bash
http://localhost/sistema-comercio/public
```

---

## 💡 Melhorias Futuras

* Sistema de login (usuários)
* Dashboard com gráficos
* Backup automático
* Sistema online (SaaS)
* Integração com WhatsApp

---

## 📌 Status do Projeto

🚧 Em desenvolvimento

---

## 👨‍💻 Autor

Desenvolvido por [SEU NOME]

---

## 📄 Licença

Este projeto está sob a licença MIT.
