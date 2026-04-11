<?php
require_once __DIR__ . '/../middlewares/auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
    <title>Nova Venda</title>
</head>

<body>

    <div class="bg-dark text-white position-fixed top-0 start-0 w-100 d-flex align-items-center" style="height: 60px; z-index:1000;">
        <div class="container d-flex align-items-center justify-content-between py-2">
            <div></div>

            <div class="text-center text-white fw-bold d-flex align-items-center gap-1">
                <div>Usuário:</div><?= $_SESSION['usuario_nome'] ?? 'Usuario:' ?>
            </div>

            <div>
                <a href="index.php?action=logout" onclick="return confirm('Tem certeza que deseja') " class="btn btn-outline-danger">
                    Sair
                </a>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 80px;">

        <h3 class="mb-3 text-center text-md-start">Sistema Comércio</h3>

        <div class="d-grid gap-2 d-md-flex mb-3">

            <a class="btn btn-primary" href="index.php">Home</a>
            <a class="btn btn-success" href="index.php?action=vendas">Venda</a>
            <a class="btn btn-warning" href="index.php?action=historico">Histórico</a>
            <a class="btn btn-dark" href="index.php?action=dashboard">Dashboard</a>
            <a class="btn btn-info" href="index.php?action=entrada">Estoque</a>

        </div>

        <hr>

        <h2 class="mb-4">Nova Venda</h2>

        <?php if (!empty($_SESSION['msg'])): ?>

            <div class="alert alert-<?= $_SESSION['msg_tipo'] ?? 'success' ?> mt-3">
                <?= $_SESSION['msg']; ?>
            </div>

            <?php unset($_SESSION['msg']);
            unset($_SESSION['msg_tipo']);
            ?>
        <?php endif; ?>

        <form method="post" action="index.php?action=addCarrinho" class="row g-3">

            <input type="hidden" name="produto_id" id="produto_id">

            <div class="col-md-4">
                <input type="text" id="busca_produto" class="form-control" placeholder="Digite código ou nome">

                <div id="resultado_busca" class="list-group mt-2"></div>
            </div>

            <div class="col-md-3">
                <input type="number" name="quantidade" class="form-control" min="1" required>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100">Adicionar</button>
            </div>

        </form>

        <h3>Carrinho</h3>

        <ul class="list-group">

            <?php
            $total = 0;

            if (!empty($_SESSION['carrinho'])):
                foreach ($_SESSION['carrinho'] as $index => $item):
                    $subtotal = $item['preco'] * $item['quantidade'];
                    $total += $subtotal;
            ?>

                    <li class="list-group-item d-flex justify-content-between align-items-center">

                        <div>
                            <?= $item['nome'] ?> <br>
                            Qtd: <?= $item['quantidade'] ?> |
                            R$ <?= number_format($subtotal, 2, ',', '.') ?>
                        </div>

                        <a href="index.php?action=removerCarrinho&index=<?= $index ?>"
                            class="btn btn-danger btn-sm">X</a>
                    </li>

            <?php endforeach;
            endif; ?>

        </ul>

        <form method="post" action="index.php?action=finalizarCarrinho" class="mt-3">

            <div class="row">

                <div class="col-md-4">

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

        <h4 class="mt-3">
            Total: R$<?= number_format($total, 2, ',', '.') ?>
        </h4>

    </div>

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
    </script>
</body>

</html>