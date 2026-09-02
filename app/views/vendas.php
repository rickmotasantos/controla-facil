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


    <!-- =====================================================
         TOPBAR
    ====================================================== -->

    <div class="topbar d-flex justify-content-between align-items-center px-3 text-white">

        <strong>

            <i class="bi bi-cash-coin"></i>

            Vendas

        </strong>


        <div class="dropdown">

            <button class="btn text-white dropdown-toggle"
                data-bs-toggle="dropdown">

                <i class="bi bi-person-circle"
                    style="font-size: 20px;">
                </i>

                <span>
                    <?= $_SESSION['usuario_nome'] ?? 'Usuário' ?>
                </span>

            </button>


            <ul class="dropdown-menu dropdown-menu-end">


                <?php if ($_SESSION['tipo'] === 'funcionario'): ?>

                    <li>

                        <a class="dropdown-item text-danger"
                            href="index.php?action=logout">

                            <i class="bi bi-box-arrow-right"></i>

                            Sair

                        </a>

                    </li>


                <?php else: ?>


                    <li>

                        <a class="dropdown-item text-primary text-center"
                            href="index.php?action=home">

                            <i class="bi bi-house"></i>

                            Home

                        </a>

                    </li>


                    <li>

                        <a class="dropdown-item text-danger text-center"
                            href="index.php?action=logout">

                            <i class="bi bi-box-arrow-right"></i>

                            Sair

                        </a>

                    </li>


                <?php endif; ?>


            </ul>

        </div>

    </div>



    <!-- =====================================================
         IMAGEM
    ====================================================== -->

    <div class="d-flex justify-content-center align-items-center">

        <img style="height: 250px; width: 100%; object-fit: cover;" src="<?= htmlspecialchars($imagemFundo); ?>"
            class="img-fluid">

    </div>



    <div class="container py-3">


        <h3 class="text-center m-3">
            Sistema de Comércio
        </h3>


        <hr>



        <!-- =====================================================
             TÍTULO
        ====================================================== -->

        <div class="d-flex justify-content-between align-items-center mb-0">

            <h5 class="m-0">
                Nova Venda
            </h5>


            <?php if ($_SESSION['tipo'] === 'empresa'): ?>

                <button type="button"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEntradaProduto">

                    <i class="bi bi-plus-circle"></i>

                    Dar entrada

                </button>

            <?php endif; ?>

        </div>



        <!-- =====================================================
             MODAL ENTRADA DE PRODUTO
        ====================================================== -->

        <div class="modal fade"
            id="modalEntradaProduto"
            tabindex="-1">


            <div class="modal-dialog">

                <div class="modal-content">


                    <div class="modal-header">

                        <h5 class="modal-title">
                            Dar Entrada no produto
                        </h5>


                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>

                    </div>



                    <form action="index.php?action=salvarEntradaRapida"
                        method="post">


                        <div class="modal-body">


                            <div class="mb-3 position-relative">


                                <label for="busca_produto_entrada">
                                    Produto
                                </label>


                                <input type="text"
                                    class="form-control"
                                    id="busca_produto_entrada"
                                    placeholder="Digite o produto"
                                    autocomplete="off"
                                    required>


                                <input type="hidden"
                                    name="produto_id"
                                    id="produto_id_entrada">


                                <div id="resultado_busca_entrada"
                                    class="list-group mt-2 shadow position-absolute w-100"
                                    style="z-index: 1050;">
                                </div>


                            </div>



                            <div class="mb-3">

                                <label for="quantidade_entrada">
                                    Quantidade
                                </label>


                                <input type="number"
                                    id="quantidade_entrada"
                                    class="form-control"
                                    name="quantidade"
                                    min="0.001"
                                    step="0.001"
                                    required>

                            </div>


                        </div>



                        <div class="modal-footer">

                            <button type="submit"
                                class="btn btn-success">

                                Salvar entrada

                            </button>

                        </div>


                    </form>


                </div>

            </div>

        </div>



        <!-- =====================================================
             MENSAGEM
        ====================================================== -->

        <?php if (!empty($_SESSION['msg'])): ?>


            <div class="alert alert-<?= $_SESSION['msg_tipo'] ?? 'success' ?> mt-3">

                <?= $_SESSION['msg']; ?>

            </div>


            <?php

            unset($_SESSION['msg']);

            unset($_SESSION['msg_tipo']);

            ?>

        <?php endif; ?>



        <!-- =====================================================
             FORMULÁRIO ADICIONAR PRODUTO
        ====================================================== -->

        <form id="formCarrinho"
            method="post"
            action="index.php?action=addCarrinho"
            class="row g-2 align-items-end">


            <input type="hidden"
                name="produto_id"
                id="produto_id">



            <div class="col-12 col-md-5 position-relative">


                <input type="text"
                    id="busca_produto"
                    class="form-control"
                    placeholder="Digite o código ou nome"
                    autofocus
                    autocomplete="off"
                    required>


                <div id="resultado_busca"
                    class="list-group mt-2 shadow position-absolute w-100"
                    style="z-index:999;">
                </div>


            </div>



            <div class="col-6 col-md-3">


                <label id="lblQuantidade"></label>


                <input type="number"
                    id="quantidade"
                    name="quantidade"
                    class="form-control"
                    min="1"
                    step="1"
                    placeholder="Quantidade"
                    required>


            </div>



            <div class="col-6 col-md-2">


                <button class="btn btn-primary w-100">

                    Adicionar

                </button>


            </div>


        </form>



        <hr>



        <!-- =====================================================
             CARRINHO
        ====================================================== -->

        <h5>
            Carrinho
        </h5>


        <ul class="list-group">


            <?php

            $total = 0;


            if (!empty($_SESSION['carrinho'])):


                foreach ($_SESSION['carrinho'] as $index => $item):


                    $subtotal =
                        $item['preco'] *
                        $item['quantidade'];


                    $total += $subtotal;

            ?>


                    <li class="list-group-item d-flex flex-wrap justify-content-between align-items-center">


                        <div class="fw-semibold">


                            <?= htmlspecialchars($item['nome']) ?>


                            <br>


                            <div class="text-muted">


                                <?php

                                $unidade =
                                    $item['unidade_medida'] == 'KG'
                                        ? 'kg'
                                        : 'un';

                                ?>


                                Qtd:

                                <?= number_format(
                                    $item['quantidade'],
                                    $item['unidade_medida'] == 'KG'
                                        ? 3
                                        : 0,
                                    ',',
                                    '.'
                                ) ?>

                                <?= $unidade ?>


                            </div>


                        </div>



                        <a href="index.php?action=removerCarrinho&index=<?= $index ?>"
                            class="btn btn-danger btn-sm">

                            X

                        </a>


                    </li>


            <?php

                endforeach;

            endif;

            ?>


        </ul>



        <!-- =====================================================
             TOTAL
        ====================================================== -->

        <div class="mt-3 p-3 bg-light rounded shadow-sm">


            <h4 class="m-0 text-end">

                Total:

                R$

                <?= number_format($total, 2, ',', '.') ?>


            </h4>


        </div>



        <!-- =====================================================
             FORM FINALIZAR VENDA
        ====================================================== -->

        <form method="post"
            action="index.php?action=finalizarCarrinho"
            class="mt-3"
            id="formFinalizarVenda">


            <!-- VALORES DO PAGAMENTO COMBINADO -->

            <input type="hidden"
                name="valor_dinheiro_combinado"
                id="valor_dinheiro_combinado"
                value="0">


            <input type="hidden"
                name="valor_cartao_combinado"
                id="valor_cartao_combinado"
                value="0">


            <input type="hidden"
                name="valor_pix_combinado"
                id="valor_pix_combinado"
                value="0">



            <div class="row g-2 align-items-end">


                <!-- =================================================
                     FORMA DE PAGAMENTO
                ================================================== -->

                <div class="col-12 col-md-3">


                    <select id="forma_pagamento"
                        name="forma_pagamento"
                        class="form-control"
                        required>


                        <option value="">
                            Selecione a forma de pagamento
                        </option>


                        <option value="dinheiro">
                            Dinheiro
                        </option>


                        <option value="cartao">
                            Cartão
                        </option>


                        <option value="pix">
                            Pix
                        </option>


                        <option value="combinado">
                            Combinado
                        </option>


                    </select>


                </div>



                <!-- =================================================
                     PRECISA DE TROCO
                ================================================== -->

                <div class="col-md-3"
                    id="campo_precisa_troco"
                    style="display:none;">


                    <select id="precisa_troco"
                        class="form-control">


                        <option value="nao">
                            Sem troco
                        </option>


                        <option value="sim">
                            Precisa de troco
                        </option>


                    </select>


                </div>



                <!-- =================================================
                     VALOR RECEBIDO
                ================================================== -->

                <div class="col-md-4"
                    id="campo_dinheiro"
                    style="display:none;">


                    <input type="number"
                        step="0.01"
                        id="valor_recebido"
                        name="valor_recebido"
                        class="form-control"
                        placeholder="Valor recebido">


                </div>



                <!-- =================================================
                     TROCO
                ================================================== -->

                <div class="col-md-4"
                    id="campo_troco"
                    style="display:none;">


                    <h5>
                        Troco:
                    </h5>


                    <h4 id="troco"
                        class="text-success">

                        R$ 0,00

                    </h4>


                </div>



                <!-- =================================================
                     BOTÃO FINALIZAR
                ================================================== -->

                <div class="col-md-4">


                    <button type="submit"
                        id="btnFinalizarVenda"
                        class="btn btn-success w-100"
                        <?= empty($_SESSION['carrinho']) ? 'disabled' : '' ?>>


                        Finalizar Venda


                    </button>


                </div>


            </div>


        </form>


    </div>



    <!-- ==========================================================
         MODAL PAGAMENTO COMBINADO
    =========================================================== -->

    <div class="modal fade"
        id="modalPagamentoCombinado"
        tabindex="-1"
        aria-labelledby="modalPagamentoCombinadoLabel"
        aria-hidden="true">


        <div class="modal-dialog">


            <div class="modal-content">


                <!-- CABEÇALHO -->

                <div class="modal-header">


                    <h5 class="modal-title fw-bold"
                        id="modalPagamentoCombinadoLabel">


                        <i class="bi bi-wallet-fill"></i>

                        Pagamento Combinado


                    </h5>


                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Fechar">
                    </button>


                </div>



                <!-- CORPO -->

                <div class="modal-body">


                    <!-- =================================================
                         TOTAL DA VENDA
                    ================================================== -->

                    <div class="alert alert-primary text-center mb-4">


                        <div class="fw-bold">

                            TOTAL DA VENDA

                        </div>


                        <div class="fs-2 fw-bold">

                            R$

                            <span id="totalVendaModal">

                                <?= number_format($total, 2, ',', '.') ?>

                            </span>

                        </div>


                    </div>



                    <!-- =================================================
                         DINHEIRO
                    ================================================== -->

                    <div class="mb-3">


                        <label for="valor_dinheiro"
                            class="form-label fw-bold">


                            <i class="bi bi-cash-stack"></i>

                            Dinheiro


                        </label>


                        <input type="number"
                            step="0.01"
                            min="0"
                            id="valor_dinheiro"
                            class="form-control"
                            value="0.00">


                    </div>



                    <!-- =================================================
                         CARTÃO
                    ================================================== -->

                    <div class="mb-3">


                        <label for="valor_cartao"
                            class="form-label fw-bold">


                            <i class="bi bi-credit-card-fill"></i>

                            Cartão


                        </label>


                        <input type="number"
                            step="0.01"
                            min="0"
                            id="valor_cartao"
                            class="form-control"
                            value="0.00">


                    </div>



                    <!-- =================================================
                         PIX
                    ================================================== -->

                    <div class="mb-3">


                        <label for="valor_pix"
                            class="form-label fw-bold">


                            <i class="bi bi-qr-code"></i>

                            Pix


                        </label>


                        <input type="number"
                            step="0.01"
                            min="0"
                            id="valor_pix"
                            class="form-control"
                            value="0.00">


                    </div>



                    <hr>



                    <!-- =================================================
                         TOTAL INFORMADO
                    ================================================== -->

                    <div class="d-flex justify-content-between fw-bold fs-5">


                        <span>
                            Total informado:
                        </span>


                        <span>

                            R$

                            <span id="totalCombinado">
                                0,00
                            </span>

                        </span>


                    </div>



                    <!-- =================================================
                         RESTANTE
                    ================================================== -->

                    <div class="d-flex justify-content-between mt-2">


                        <span>
                            Restante:
                        </span>


                        <span id="valorRestante"
                            class="fw-bold text-danger">


                            R$

                            <?= number_format($total, 2, ',', '.') ?>


                        </span>


                    </div>



                    <!-- =================================================
                         ALERTA
                    ================================================== -->

                    <div id="alertaPagamento"
                        class="alert alert-danger mt-3 d-none">


                        Os valores informados precisam ser iguais ao total da venda.


                    </div>


                </div>



                <!-- RODAPÉ -->

                <div class="modal-footer">


                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">


                        Cancelar


                    </button>



                    <button type="button"
                        id="confirmarPagamentoCombinado"
                        class="btn btn-primary">


                        <i class="bi bi-check-circle-fill"></i>

                        Confirmar Pagamento


                    </button>


                </div>


            </div>


        </div>


    </div>



    <!-- ==========================================================
         BOOTSTRAP JS
    =========================================================== -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>



    <!-- ==========================================================
         JAVASCRIPT
    =========================================================== -->

    <script>

        document.addEventListener("DOMContentLoaded", function () {


            // =====================================================
            // BUSCA DE PRODUTOS
            // =====================================================

            const input =
                document.getElementById("busca_produto");


            const resultado =
                document.getElementById("resultado_busca");


            const produtoId =
                document.getElementById("produto_id");


            const qtd =
                document.getElementById("quantidade");


            const formCarrinho =
                document.getElementById("formCarrinho");


            const lblQuantidade =
                document.getElementById("lblQuantidade");



            // =====================================================
            // ENTER NA BUSCA
            // =====================================================

            input.addEventListener("keydown", async function (e) {


                if (e.key !== "Enter")
                    return;


                e.preventDefault();


                const busca =
                    input.value;


                const res =
                    await fetch(
                        "index.php?action=buscarProduto&busca=" +
                        encodeURIComponent(busca)
                    );


                const produtos =
                    await res.json();



                if (produtos.length === 1) {


                    const p =
                        produtos[0];


                    produtoId.value =
                        p.id;


                    input.value =
                        p.nome;


                    resultado.innerHTML =
                        "";


                    if (p.unidade_medida === "KG") {


                        lblQuantidade.innerText =
                            "Peso (Kg)";


                        qtd.step =
                            "0.001";


                        qtd.min =
                            "0.001";


                        qtd.placeholder =
                            "Ex.: 0.350";


                    } else {


                        lblQuantidade.innerText =
                            "Quantidade";


                        qtd.step =
                            "1";


                        qtd.min =
                            "1";


                        qtd.placeholder =
                            "Ex.: 2";


                    }


                    qtd.value =
                        "";


                    qtd.focus();


                }


            });



            // =====================================================
            // BUSCA ENQUANTO DIGITA
            // =====================================================

            input.addEventListener("keyup", async function () {


                let busca =
                    input.value;


                if (busca.length < 2) {


                    resultado.innerHTML =
                        "";


                    return;

                }


                const res =
                    await fetch(
                        "index.php?action=buscarProduto&busca=" +
                        encodeURIComponent(busca)
                    );


                const produtos =
                    await res.json();


                resultado.innerHTML =
                    "";


                produtos.forEach(function (p) {


                    const item =
                        document.createElement("div");


                    item.className =
                        "list-group-item list-group-item-action";


                    item.innerHTML =
                        p.codigo +
                        " - " +
                        p.nome +
                        " - R$ " +
                        p.preco;


                    item.onclick =
                        function () {


                            produtoId.value =
                                p.id;


                            input.value =
                                p.nome;


                            resultado.innerHTML =
                                "";


                            if (p.unidade_medida === "KG") {


                                lblQuantidade.innerText =
                                    "Peso (Kg)";


                                qtd.step =
                                    "0.001";


                                qtd.min =
                                    "0.001";


                                qtd.placeholder =
                                    "Ex.: 0.350";


                            } else {


                                lblQuantidade.innerText =
                                    "Quantidade";


                                qtd.step =
                                    "1";


                                qtd.min =
                                    "1";


                                qtd.placeholder =
                                    "Ex.: 2";


                            }


                            qtd.value =
                                "";


                            qtd.focus();


                        };


                    resultado.appendChild(item);


                });


            });



            // =====================================================
            // ENTER NA QUANTIDADE
            // =====================================================

            qtd.addEventListener("keydown", function (e) {


                if (e.key !== "Enter")
                    return;


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



            // =====================================================
            // PAGAMENTO
            // =====================================================

            const formaPagamento =
                document.getElementById("forma_pagamento");


            const precisaTroco =
                document.getElementById("precisa_troco");


            const campoPrecisaTroco =
                document.getElementById("campo_precisa_troco");


            const campoDinheiro =
                document.getElementById("campo_dinheiro");


            const campoTroco =
                document.getElementById("campo_troco");


            const valorRecebido =
                document.getElementById("valor_recebido");


            const troco =
                document.getElementById("troco");



            // TOTAL DA VENDA

            const totalVenda =
                <?= $total ?>;



            // =====================================================
            // MODAL PAGAMENTO COMBINADO
            // =====================================================

            const modalElement =
                document.getElementById(
                    "modalPagamentoCombinado"
                );


            const modalPagamento =
                new bootstrap.Modal(
                    modalElement
                );


            const totalVendaModal =
                document.getElementById(
                    "totalVendaModal"
                );


            const valorDinheiro =
                document.getElementById(
                    "valor_dinheiro"
                );


            const valorCartao =
                document.getElementById(
                    "valor_cartao"
                );


            const valorPix =
                document.getElementById(
                    "valor_pix"
                );


            const totalCombinado =
                document.getElementById(
                    "totalCombinado"
                );


            const valorRestante =
                document.getElementById(
                    "valorRestante"
                );


            const alertaPagamento =
                document.getElementById(
                    "alertaPagamento"
                );


            const confirmarPagamento =
                document.getElementById(
                    "confirmarPagamentoCombinado"
                );


            // =====================================================
            // INPUTS HIDDEN
            // =====================================================

            const hiddenDinheiro =
                document.getElementById(
                    "valor_dinheiro_combinado"
                );


            const hiddenCartao =
                document.getElementById(
                    "valor_cartao_combinado"
                );


            const hiddenPix =
                document.getElementById(
                    "valor_pix_combinado"
                );



            // CONTROLE

            let pagamentoCombinadoConfirmado =
                false;



            // =====================================================
            // ALTERAR FORMA DE PAGAMENTO
            // =====================================================

            formaPagamento.addEventListener(
                "change",
                function () {


                    // =============================================
                    // COMBINADO
                    // =============================================

                    if (this.value === "combinado") {


                        pagamentoCombinadoConfirmado =
                            false;


                        // Mostra novamente o total

                        totalVendaModal.textContent =
                            totalVenda.toLocaleString(
                                "pt-BR",
                                {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }
                            );


                        // Zera os campos

                        valorDinheiro.value =
                            "0.00";


                        valorCartao.value =
                            "0.00";


                        valorPix.value =
                            "0.00";


                        alertaPagamento.classList.add(
                            "d-none"
                        );


                        calcularTotalCombinado();


                        modalPagamento.show();


                        return;

                    }



                    // =============================================
                    // DINHEIRO
                    // =============================================

                    if (this.value === "dinheiro") {


                        campoPrecisaTroco.style.display =
                            "block";


                        if (precisaTroco.value === "sim") {


                            campoDinheiro.style.display =
                                "block";


                            campoTroco.style.display =
                                "block";


                        } else {


                            campoDinheiro.style.display =
                                "none";


                            campoTroco.style.display =
                                "none";


                        }


                    }


                    // =============================================
                    // CARTÃO / PIX
                    // =============================================

                    else {


                        campoPrecisaTroco.style.display =
                            "none";


                        campoDinheiro.style.display =
                            "none";


                        campoTroco.style.display =
                            "none";


                    }


                }
            );



            // =====================================================
            // TROCO
            // =====================================================

            precisaTroco.addEventListener(
                "change",
                function () {


                    if (this.value === "sim") {


                        campoDinheiro.style.display =
                            "block";


                        campoTroco.style.display =
                            "block";


                    } else {


                        campoDinheiro.style.display =
                            "none";


                        campoTroco.style.display =
                            "none";


                        valorRecebido.value =
                            "";


                        troco.innerHTML =
                            "R$ 0,00";


                    }


                }
            );



            // =====================================================
            // CALCULAR TROCO
            // =====================================================

            valorRecebido.addEventListener(
                "input",
                function () {


                    let recebido =
                        parseFloat(this.value) || 0;


                    let valorTroco =
                        recebido - totalVenda;


                    if (recebido < totalVenda) {


                        troco.innerHTML =
                            "Valor insuficiente";


                        troco.classList.remove(
                            "text-success"
                        );


                        troco.classList.add(
                            "text-danger"
                        );


                    } else {


                        troco.innerHTML =
                            "R$ " +
                            valorTroco
                                .toFixed(2)
                                .replace(".", ",");


                        troco.classList.remove(
                            "text-danger"
                        );


                        troco.classList.add(
                            "text-success"
                        );


                    }


                }
            );



            // =====================================================
            // CALCULAR COMBINADO
            // =====================================================

            function calcularTotalCombinado() {


                const dinheiro =
                    parseFloat(
                        valorDinheiro.value
                    ) || 0;


                const cartao =
                    parseFloat(
                        valorCartao.value
                    ) || 0;


                const pix =
                    parseFloat(
                        valorPix.value
                    ) || 0;


                const totalInformado =
                    dinheiro +
                    cartao +
                    pix;


                const restante =
                    totalVenda -
                    totalInformado;



                // =============================================
                // TOTAL INFORMADO
                // =============================================

                totalCombinado.textContent =
                    totalInformado.toLocaleString(
                        "pt-BR",
                        {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }
                    );



                // =============================================
                // RESTANTE
                // =============================================

                if (restante > 0.01) {


                    valorRestante.textContent =
                        "R$ " +
                        restante.toLocaleString(
                            "pt-BR",
                            {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }
                        );


                    valorRestante.classList.remove(
                        "text-success"
                    );


                    valorRestante.classList.add(
                        "text-danger"
                    );


                } else {


                    valorRestante.textContent =
                        "R$ 0,00";


                    valorRestante.classList.remove(
                        "text-danger"
                    );


                    valorRestante.classList.add(
                        "text-success"
                    );


                }


                return totalInformado;

            }



            // =====================================================
            // ATUALIZAR AO DIGITAR
            // =====================================================

            valorDinheiro.addEventListener(
                "input",
                calcularTotalCombinado
            );


            valorCartao.addEventListener(
                "input",
                calcularTotalCombinado
            );


            valorPix.addEventListener(
                "input",
                calcularTotalCombinado
            );



            // =====================================================
            // CONFIRMAR PAGAMENTO
            // =====================================================

            confirmarPagamento.addEventListener(
                "click",
                function () {


                    const totalInformado =
                        calcularTotalCombinado();



                    // =============================================
                    // VALOR INCORRETO
                    // =============================================

                    if (
                        Math.abs(
                            totalInformado -
                            totalVenda
                        ) > 0.01
                    ) {


                        alertaPagamento.classList.remove(
                            "d-none"
                        );


                        return;

                    }



                    // =============================================
                    // VALOR CORRETO
                    // =============================================

                    alertaPagamento.classList.add(
                        "d-none"
                    );



                    // Guarda os valores

                    hiddenDinheiro.value =
                        parseFloat(
                            valorDinheiro.value
                        ) || 0;


                    hiddenCartao.value =
                        parseFloat(
                            valorCartao.value
                        ) || 0;


                    hiddenPix.value =
                        parseFloat(
                            valorPix.value
                        ) || 0;



                    pagamentoCombinadoConfirmado =
                        true;



                    modalPagamento.hide();


                }
            );



            // =====================================================
            // FINALIZAR VENDA
            // =====================================================

            const formFinalizarVenda =
                document.getElementById(
                    "formFinalizarVenda"
                );



            formFinalizarVenda.addEventListener(
                "submit",
                function (e) {


                    if (
                        formaPagamento.value ===
                            "combinado" &&
                        !pagamentoCombinadoConfirmado
                    ) {


                        e.preventDefault();


                        modalPagamento.show();


                    }


                }
            );



            // =====================================================
            // REMOVER ALERTA
            // =====================================================

            setTimeout(
                function () {


                    const alert =
                        document.querySelector(
                            ".alert"
                        );


                    if (alert)
                        alert.remove();


                },
                3000
            );


        });

    </script>


</body>

</html>