<?php
require_once __DIR__ . '/../middlewares/auth.php';
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
    <title>Nova Venda</title>
    <style>
        body {
            background-color: #f5f7fa;
        }

        .card-form {
            border-radius: 15px;
        }

        .form-control {
            height: 50px;
            border-radius: 10px;
        }

        .btn-success {
            height: 50px;
            border-radius: 10px;
            font-weight: 500;
        }

        .topbar {
            background: #0d6efd;
            padding: 10px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="topbar d-flex justify-content-between align-items-center px-3 text-white">
        <strong>💰 Vendas</strong>
        <div class="dropdown">
            <button class="btn text-white dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle" style="font-size: 20px;"></i>
                <span><?= $_SESSION['usuario_nome'] ?? 'Usuário' ?></span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end">

                <li>
                    <a class="dropdown-item text-danger" href="index.php?action=home">
                        <i class="bi bi-house"></i> Home
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="container py-3">
        <h3 class="text-center m-3">Sistema Comércio</h3>

        <hr>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="m-2">Nova Venda</h5>

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalEntradaProduto">
                <i class="bi bi-plus-circle"></i> Dar entrada
            </button>
        </div>

        <div class="modal fade" id="modalEntradaProduto" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Dar Entrada no produto</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>


                    <form action="index.php?action=salvarEntradaRapida" method="post">
                        <div class="modal-body">
                            <div class="mb-3 position-relative">
                                <label for="form-control">Produto</label>
                                <input type="text" class="form-control" id="busca_produto_entrada" placeholder="Digite o produto" autocomplete="off" required>

                                <input type="hidden" name="produto_id" id="produto_id_entrada">

                                <div id="resultado_busca_entrada"
                                    class="list-group mt-2 shadow position-absolute w-100"
                                    style="z-index:999;">
                                </div>
                            </div>

                            <div class="mb-3 ">
                                <label for="form-control">Quantidade</label>
                                <input type="number" class="form-control" name="quantidade" min="1" required>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Salvar entrada</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if (!empty($_SESSION['msg'])): ?>

            <div class="alert alert-<?= $_SESSION['msg_tipo'] ?? 'success' ?> mt-3">
                <?= $_SESSION['msg']; ?>
            </div>

            <?php unset($_SESSION['msg']);
            unset($_SESSION['msg_tipo']);
            ?>
        <?php endif; ?>

        <form method="post" action="index.php?action=addCarrinho" class="row g-2 align-items-end">

            <input type="hidden" name="produto_id" id="produto_id">

            <div class="col-12 col-md-5 position-relative">
                <input type="text" id="busca_produto" class="form-control" placeholder="Digite código ou nome">

                <div id="resultado_busca" class="list-group mt-2 shadow position-absolute w-100"></div>
            </div>

            <div class="col-6 col-md-3">
                <input type="number" name="quantidade" class="form-control" min="1" required>
            </div>

            <div class="col-6 col-md-2">
                <button class="btn btn-primary w-100">Adicionar</button>
            </div>

        </form>

        <hr>

        <h5>Carrinho</h5>

        <ul class="list-group">

            <?php
            $total = 0;

            if (!empty($_SESSION['carrinho'])):
                foreach ($_SESSION['carrinho'] as $index => $item):
                    $subtotal = $item['preco'] * $item['quantidade'];
                    $total += $subtotal;
            ?>

                    <li class="list-group-item d-flex flex-wrap justify-content-between align-items-center">

                        <div class="fw-semibold">
                            <?= $item['nome'] ?> <br>
                            <div class="text-muted">
                                Qtd: <?= $item['quantidade'] ?> |
                                R$ <?= number_format($subtotal, 2, ',', '.') ?>
                            </div>

                        </div>

                        <a href="index.php?action=removerCarrinho&index=<?= $index ?>"
                            class="btn btn-danger btn-sm">X</a>
                    </li>

            <?php endforeach;
            endif; ?>

        </ul>

        <form method="post" action="index.php?action=finalizarCarrinho" class="mt-3">

            <div class="row g-2 align-items-end">

                <div class="col-12 col-md-3">

                    <select name="forma_pagamento" class="form-control" required>
                        <option value="">Selecione a forma de pagamento</option>
                        <option value="dinheiro">Dinheiro</option>
                        <option value="cartao">Cartão</option>
                        <option value="pix">Pix</option>
                    </select>

                </div>

                <div class="col-md-4" id="campo_dinheiro" style="display:none;">
                    <input type="number" step="0.01" id="valor_recebido"
                        name="valor_recebido" class="form-control"
                        placeholder="Valor recebido">
                </div>

                <div class="col-md-4" id="campo_troco" style="display:none;">
                    <h5>Troco:</h5>
                    <h4 id="troco" class="text-success">R$ 0,00</h4>
                </div>

                <div class="col-md-4">
                    <button class="btn btn-success w-100" <?= empty($_SESSION['carrinho']) ? 'disabled' : '' ?>>
                        Finalizar Venda
                    </button>
                </div>
            </div>

        </form>
        <div class="mt-3 p-3 bg-light rounded shadow-sm">
            <h4 class="m-0 text-end">
                Total: R$<?= number_format($total, 2, ',', '.') ?>
            </h4>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const input = document.getElementById('busca_produto');
            const resultado = document.getElementById('resultado_busca');
            const produtoId = document.getElementById('produto_id');

            input.addEventListener('keyup', async function() {

                let busca = input.value;

                if (busca.length < 2) {
                    resultado.innerHTML = '';
                    return;
                }

                const res = await fetch('index.php?action=buscarProduto&busca=' + busca);
                const produtos = await res.json();

                resultado.innerHTML = '';

                produtos.forEach(function(p) {

                    const item = document.createElement('div');
                    item.className = 'list-group-item list-group-item-action';
                    item.innerText = p.codigo + ' - ' + p.nome + ' - R$ ' + p.preco;

                    item.addEventListener('click', function() {
                        console.log("Clicou no produto:", p.id);

                        produtoId.value = p.id;
                        input.value = p.nome;
                        resultado.innerHTML = '';
                    });

                    resultado.appendChild(item);
                });
            });

        });

        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) alert.remove();
        }, 3000);

        document.addEventListener("DOMContentLoaded", function() {

            const formaPagamento = document.querySelector('[name="forma_pagamento"]');
            const campoDinheiro = document.getElementById('campo_dinheiro');
            const campoTroco = document.getElementById('campo_troco');
            const inputValor = document.getElementById('valor_recebido');
            const trocoEl = document.getElementById('troco');

            // MOSTRA / ESCONDE CAMPO
            formaPagamento.addEventListener('change', function() {

                if (this.value === 'dinheiro') {
                    campoDinheiro.style.display = 'block';
                    campoTroco.style.display = 'block';
                } else {
                    campoDinheiro.style.display = 'none';
                    campoTroco.style.display = 'none';
                }
            });

            let totalVenda = <?= $total ?? 0 ?>;

            inputValor.addEventListener('input', function() {

                let valor = parseFloat(this.value) || 0;
                let troco = valor - totalVenda;

                if (valor < totalVenda) {
                    trocoEl.innerText = "Valor insuficiente";
                    trocoEl.classList.remove('text-success');
                    trocoEl.classList.add('text-danger');
                } else {
                    trocoEl.innerText = "R$ " + troco.toFixed(2).replace('.', ',');
                    trocoEl.classList.remove('text-danger');
                    trocoEl.classList.add('text-success');
                }
            });

        });

        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) alert.remove();
        }, 3000);

        document.addEventListener("DOMContentLoaded", function() {

            const inputEntrada = document.getElementById("busca_produto_entrada");
            const resultadoEntrada = document.getElementById("resultado_busca_entrada");
            const produtoIdEntrada = document.getElementById("produto_id_entrada");

            inputEntrada.addEventListener("keyup", async function() {

                let busca = this.value;

                if (busca.length < 2) {
                    resultadoEntrada.innerHTML = "";
                    return;
                }

                const res = await fetch(
                    "index.php?action=buscarProduto&busca=" + busca
                );

                const produtos = await res.json();

                resultadoEntrada.innerHTML = "";

                produtos.forEach(function(p) {

                    const item = document.createElement("div");

                    item.className =
                        "list-group-item list-group-item-action";

                    item.innerText =
                        p.codigo + " - " + p.nome;

                    item.addEventListener("click", function() {

                        inputEntrada.value = p.nome;
                        produtoIdEntrada.value = p.id;
                        resultadoEntrada.innerHTML = "";

                    });

                    resultadoEntrada.appendChild(item);
                });

            });

        });
    </script>

    </scrip>
</body>

</html>