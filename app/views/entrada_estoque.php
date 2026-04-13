<?php
require_once __DIR__ . '/../middlewares/auth.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
    <title>Entrada Estoque</title>
</head>

<body>
    <div class="dropdown">
        <button class="btn btn-dark text-white d-flex align-items-center gap-2 dropdown-toggle" type="button" data-bs-toggle="dropdown">

            <i class="bi bi-person-circle" style="font-size: 20px;"></i>

            <span><?= $_SESSION['usuario_nome'] ?? 'Usuário' ?></span>

        </button>

        <ul class="dropdown-menu dropdown-menu-end">

            <li>
                <a class="dropdown-item" href="index.php?action=perfil">
                    <i class="bi bi-person"></i> Perfil
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="index.php?action=alterar_senha">
                    <i class="bi bi-key"></i> Alterar senha
                </a>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <a class="dropdown-item text-danger" href="index.php?action=logout" onclick="return confirm('Tem certeza que deseja sair?')">
                    <i class="bi bi-box-arrow-right"></i> Sair
                </a>
            </li>

        </ul>
    </div>
    <div class="container">

        <h2 class="mb-4">Entrada de Estoque</h2>

        <div class="d-grid gap-2 d-md-flex mb-3">

            <a class="btn btn-primary" href="index.php">Home</a>
            <a class="btn btn-success" href="index.php?action=vendas">Venda</a>
            <a class="btn btn-warning" href="index.php?action=historico">Histórico</a>
            <a class="btn btn-dark" href="index.php?action=dashboard">Dashboard</a>
            <a class="btn btn-info" href="index.php?action=entrada">Estoque</a>

        </div>

        <hr>

        <form method="POST" action="index.php?action=adicionar_estoque" class="row g-3">

            <div class="col-md-4">
                <label>Código ou descrição</label>
                <input type="text" name="codigo" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label>Produto</label>
                <input type="text" id="nome_produto" class="form-control" readonly>
            </div>

            <div class="col-md-4">
                <label>Estoque atual</label>
                <input type="text" id="estoque_produto" class="form-control" readonly>
            </div>

            <div class="col-md-4">
                <label>Quantidade</label>
                <input type="number" name="quantidade" class="form-control" required>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-success w-100">
                    Adicionar Estoque
                </button>
            </div>
        </form>
    </div>

    <script  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
        document.addEventListener("DOMContentLoaded", function() {

            const inputCodigo = document.querySelector('[name="codigo"]');
            const nomeProduto = document.getElementById('nome_produto');
            const estoqueProduto = document.getElementById('estoque_produto');

            let timer;

            inputCodigo.addEventListener('keyup', function() {

                clearTimeout(timer);

                let codigo = this.value;

                timer = setTimeout(async () => {

                    if (!codigo || codigo.length < 3) {
                        nomeProduto.value = '';
                        estoqueProduto.value = '';
                        return;
                    }

                    try {
                        const res = await fetch('index.php?action=buscarProduto&busca=' + encodeURIComponent(codigo));
                        const produtos = await res.json();

                        if (produtos.length > 0) {
                            nomeProduto.value = produtos[0].nome;
                            estoqueProduto.value = produtos[0].quantidade;
                        } else {
                            nomeProduto.value = 'Produto não encontrado';
                            estoqueProduto.value = '';
                        }

                    } catch (e) {
                        console.log("ERRO:", e);
                    }

                }, 300);

            });

        });
    </script>
</body>

</html>