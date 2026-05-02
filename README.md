# 🏪 Sistema de Comércio (SaaS Local)

## 🎯 Sobre o Projeto

Sistema web desenvolvido para pequenos comércios, com foco em controle de vendas, estoque e gestão por empresa.

Ideal para:

* Padarias
* Mercados
* Lojas de bairro
* Petshops
* Materiais de construção

---

## 🚀 Objetivo

Ajudar comerciantes a:

* Controlar vendas em tempo real
* Gerenciar estoque automaticamente
* Evitar perdas e erros manuais
* Acompanhar desempenho do negócio

---

## 🧱 Tecnologias Utilizadas

* PHP (PDO)
* MySQL
* HTML, CSS, Bootstrap
* JavaScript
* Git e GitHub

---

## 🔐 Autenticação e Controle de Acesso

* Sistema de login com senha criptografada (`password_hash`)
* Controle de acesso por tipo:

  * Admin
  * Empresa
* Bloqueio de empresas (suspenso/inadimplente)
* Sessões protegidas

---

## 🏢 Multiempresa (SaaS Ready)

* Cada empresa possui seus próprios dados
* Isolamento por `empresa_id`
* Admin pode gerenciar todas as empresas

---

## 📌 Funcionalidades

### 💰 Vendas (PDV)

* Carrinho de compras
* Registro de vendas
* Baixa automática no estoque
* Controle de formas de pagamento

---

### 📦 Estoque

* Cadastro de produtos
* Controle de quantidade
* Entrada e saída manual
* Indicador visual:

  * 🔴 Sem estoque
  * 🟡 Estoque baixo
  * 🟢 Estoque normal

---

### 🛒 Carrinho

* Adição de produtos
* Atualização de quantidade
* Remoção de itens
* Finalização com transação segura (PDO Transaction)

---

### 📊 Dashboard

* Total de vendas do dia
* Total de vendas do mês
* Produto mais vendido

---

### 📒 Histórico de Vendas

* Listagem de vendas por empresa
* Detalhes das transações

---

## 🗄️ Banco de Dados

### produtos

* id
* nome
* preco
* quantidade
* codigo
* empresa_id

### usuarios

* id
* nome
* senha
* tipo
* empresa_id

### empresas

* id
* nome
* status

### vendas

* id
* total
* forma_pagamento
* empresa_id
* created_at

### itens_venda

* id
* venda_id
* produto_id
* quantidade
* preco
* empresa_id

---

## 🗂️ Estrutura do Projeto

/app
 /controllers
 /models
 /views

/config
/public

---

## 🔐 Segurança

* PDO com prepared statements
* Proteção contra SQL Injection
* Controle de sessão
* Validação de acesso por usuário
* Transações no fechamento de vendas (integridade de dados)

---

## 🚀 Como Executar

1. Clone o projeto:

```bash
git clone https://github.com/seu-usuario/sistema-comercio.git
```

2. Configure o ambiente (XAMPP ou Laragon)

3. Configure o banco:

* Crie o banco
* Importe `/database/schema.sql`

4. Configure o `.env`:

```env
DB_HOST=127.0.0.1
DB_NAME=seu_banco
DB_USER=root
DB_PASS=
```

5. Acesse:

```
http://localhost/sistema-comercio/public
```

---

## 📌 Status

✅ Pronto para uso local
🚀 Preparado para evolução SaaS

---

## 💡 Próximas Melhorias

* Cadastro de clientes
* Controle de fiado
* Relatórios avançados
* API REST
* Integração com WhatsApp
* Deploy online (multiempresa real)

---

## 👨‍💻 Autor

Desenvolvido por **Ricardo Mota**

---

## 📄 Licença

MIT
