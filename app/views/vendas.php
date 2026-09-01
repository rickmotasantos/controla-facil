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
        <strong><i class="bi bi-cash-coin"></i> Vendas</strong>
        <div class="dropdown">
            <button class="btn text-white dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle" style="font-size: 20px;"></i>
                <span><?= $_SESSION['usuario_nome'] ?? 'Usuário' ?></span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end">

                <?php if ($_SESSION['tipo'] === 'funcionario'): ?>

                    <li>
                        <a class="dropdown-item text-danger" href="index.php?action=logout">
                            <i class="bi bi-box-arrow-right"></i> Sair
                        </a>
                    </li>

                <?php else: ?>

                    <li>
                        <a class="dropdown-item text-primary text-center" href="index.php?action=home">
                            <i class="bi bi-house"></i> Home
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item text-danger text-center" href="index.php?action=logout">
                            <i class="bi bi-box-arrow-right"></i> Sair
                        </a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center w-100">
        <img src="<?= htmlspecialchars($imagemFundo); ?>" class="img-fluid w-100">
    </div>
    <div class="container py-3">
        <h3 class="text-center m-3">Sistema de Comércio</h3>

        <hr>

        <div class="d-flex justify-content-between align-items-center mb-0">
            <h5 class="m-0">Nova Venda</h5>
            <?php if ($_SESSION['tipo'] === 'empresa'): ?>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalEntradaProduto">
                    <i class="bi bi-plus-circle"></i> Dar entrada
                </button>
            <?php endif; ?>
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
                                    style="z-index: 1050;;">
                                </div>
                            </div>

                            <div class="mb-3 ">
                                <label for="form-control">Quantidade</label>
                                <input type="number" id="quantidade_entrada" class="form-control" name="quantidade" min="0.001" step="0.001" required>
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

        <form id="formCarrinho" method="post" action="index.php?action=addCarrinho" class="row g-2 align-items-end">

            <input type="hidden" name="produto_id" id="produto_id">

            <div class="col-12 col-md-5 position-relative">
                <input type="text" id="busca_produto" class="form-control" placeholder="Digite o código ou nome" autofocus autocomplete="off" required>

                <div id="resultado_busca" class="list-group mt-2 shadow position-absolute w-100" style="z-index:999;"></div>
            </div>

            <div class="col-6 col-md-3">
                <label id="lblQuantidade"></label>
                <input type="number" id="quantidade" name="quantidade" class="form-control" min="1" step="1" placeholder="Quantidade" required>

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
                                <?php
                                $unidade = $item['unidade_medida'] == 'KG' ? 'kg' : 'un';
                                ?>

                                Qtd: <?= number_format($item['quantidade'], $item['unidade_medida'] == 'KG' ? 3 : 0, ',', '.') . ' ' . $unidade ?>
                            </div>

                        </div>

                        <a href="index.php?action=removerCarrinho&index=<?= $index ?>"
                            class="btn btn-danger btn-sm">X</a>
                    </li>

            <?php endforeach;
            endif; ?>

        </ul>

        <form method="post" action="index.php?action=finalizarCarrinho" class="mt-3" id="formFinalizarVenda">

            <div class="row g-2 align-items-end">

                <div class="col-12 col-md-3">

                    <select id="forma_pagamento" name="forma_pagamento" class="form-control" required>
                        <option value="">Selecione a forma de pagamento</option>
                        <option value="dinheiro">Dinheiro</option>
                        <option value="cartao">Cartão</option>
                        <option value="pix">Pix</option>
                    </select>
                </div>

                <div class="col-md-3" id="campo_precisa_troco" style="display:none;">
                    <select id="precisa_troco" class="form-control">
                        <option value="nao"> Sem troco</option>
                        <option value="sim">Precisa de troco</option>
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

            // ==========================
            // BUSCA DE PRODUTOS
            // ==========================
            const input = document.getElementById("busca_produto");
            const resultado = document.getElementById("resultado_busca");
            const produtoId = document.getElementById("produto_id");
            const qtd = document.getElementById("quantidade");
            const formCarrinho = document.getElementById("formCarrinho");

            input.addEventListener("keydown", async function(e) {

                if (e.key !== "Enter") return;

                e.preventDefault();

                const busca = input.value;

                const res = await fetch("index.php?action=buscarProduto&busca=" + busca);
                const produtos = await res.json();

                if (produtos.length === 1) {

                    const p = produtos[0];

                    produtoId.value = p.id;
                    input.value = p.nome;
                    resultado.innerHTML = "";

                    if (p.unidade_medida === "KG") {

                        lblQuantidade.innerText = "Peso (Kg)";
                        qtd.step = "0.001";
                        qtd.min = "0.001";
                        qtd.placeholder = "Ex.: 0.350";

                    } else {

                        lblQuantidade.innerText = "Quantidade";
                        qtd.step = "1";
                        qtd.min = "1";
                        qtd.placeholder = "Ex.: 2";

                    }

                    qtd.value = "";
                    qtd.focus();

                }

            });

           input.addEventListener("keyup", async function() {

    let busca = input.value;

    if (busca.length < 2) {
        resultado.innerHTML = "";
        return;
    }

    const res = await fetch(
        "index.php?action=buscarProduto&busca=" + encodeURIComponent(busca)
    );

    const produtos = await res.json();

    resultado.innerHTML = "";

    produtos.forEach(function(p) {

        const item = document.createElement("div");

        item.className = "list-group-item list-group-item-action";

        item.innerHTML =
            p.codigo + " - " + p.nome + " - R$ " + p.preco;

        item.onclick = function() {

            produtoId.value = p.id;
            input.value = p.nome;
            resultado.innerHTML = "";

            if (p.unidade_medida === "KG") {

                lblQuantidade.innerText = "Peso (Kg)";
                qtd.step = "0.001";
                qtd.min = "0.001";
                qtd.placeholder = "Ex.: 0.350";

            } else {

                lblQuantidade.innerText = "Quantidade";
                qtd.step = "1";
                qtd.min = "1";
                qtd.placeholder = "Ex.: 2";

            }

            qtd.value = "";
            qtd.focus();
        };

        resultado.appendChild(item);
    });
});

            qtd.addEventListener("keydown", function(e) {

                if (e.key !== "Enter") return;

                e.preventDefault();

                if (produtoId.value === "") {
                    input.focus();
                    return;
                }

                if (qtd.value === "") {
                    return;
                }

                formCarrinho.submit();
            });


            const formaPagamento = document.getElementById("forma_pagamento");
            const precisaTroco = document.getElementById("precisa_troco");

            const campoPrecisaTroco = document.getElementById("campo_precisa_troco");
            const campoDinheiro = document.getElementById("campo_dinheiro");
            const campoTroco = document.getElementById("campo_troco");

            const valorRecebido = document.getElementById("valor_recebido");
            const troco = document.getElementById("troco");

            const totalVenda = <?= $total ?>;

            formaPagamento.addEventListener("change", function() {

                if (this.value == "dinheiro") {

                    campoPrecisaTroco.style.display = "block";

                    if (precisaTroco.value == "sim") {

                        campoDinheiro.style.display = "block";
                        campoTroco.style.display = "block";

                    } else {

                        campoDinheiro.style.display = "none";
                        campoTroco.style.display = "none";

                    }

                } else {

                    campoPrecisaTroco.style.display = "none";
                    campoDinheiro.style.display = "none";
                    campoTroco.style.display = "none";

                }

            });

            precisaTroco.addEventListener("change", function() {

                if (this.value == "sim") {

                    campoDinheiro.style.display = "block";
                    campoTroco.style.display = "block";

                } else {

                    campoDinheiro.style.display = "none";
                    campoTroco.style.display = "none";
                    valorRecebido.value = "";
                    troco.innerHTML = "R$ 0,00";

                }

            });

            valorRecebido.addEventListener("input", function() {

                let recebido = parseFloat(this.value) || 0;

                let valorTroco = recebido - totalVenda;

                if (recebido < totalVenda) {

                    troco.innerHTML = "Valor insuficiente";
                    troco.classList.remove("text-success");
                    troco.classList.add("text-danger");

                } else {

                    troco.innerHTML = "R$ " + valorTroco.toFixed(2).replace(".", ",");
                    troco.classList.remove("text-danger");
                    troco.classList.add("text-success");

                }

            });
            setTimeout(function() {

                const alert = document.querySelector(".alert");

                if (alert) alert.remove();

            }, 3000);

        });
    </script>

</html>