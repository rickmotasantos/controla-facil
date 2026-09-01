<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Nota da Venda</title>

    <style>
        body {
            font-family: monospace;
            margin: 0;
            padding: 0;
            color: #000;
            font-size: 13px;
            background: #fff;
        }

        .nota {
            width: 80mm;
            margin: auto;
            padding: 2mm;
            box-sizing: border-box;
            background: #fff;
        }

        .center {
            text-align: center;
        }

        .center h2 {
            font-size: 18px;
            margin: 0 0 5px 0;
        }

        .info {
            margin: 1px 0;
            font-size: 12px;
        }

        .linha {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .topo-info {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }

        .item {
            margin-bottom: 10px;
        }

        .produto {
            font-weight: bold;
            text-transform: uppercase;
            word-break: break-word;
            margin-bottom: 3px;
        }

        .detalhes {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }

        .total {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 12px 0;
        }

        .pagamento {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }

        .rodape {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
        }

        @media print {

            @page {
                size: 80mm auto;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
                background: #fff;
            }

            .nota {
                width: 80mm;
                max-width: 80mm;
                padding: 2mm;
                margin: 0;
            }
        }
    </style>

</head>

<body>

<div class="nota">

    <!-- DADOS DA EMPRESA -->

    <div class="center">

        <!-- NOME FANTASIA -->
        <h2>
            <?= htmlspecialchars(
                !empty($empresa['nome_fantasia'])
                    ? $empresa['nome_fantasia']
                    : $empresa['nome']
            ); ?>
        </h2>

        <!-- RAZÃO SOCIAL -->
        <?php if (!empty($empresa['razao_social'])): ?>

            <p class="info">
                <?= htmlspecialchars($empresa['razao_social']); ?>
            </p>

        <?php endif; ?>


        <!-- CPF / CNPJ -->
        <?php if (!empty($empresa['documento'])): ?>

            <p class="info">
                CNPJ/CPF: <?= htmlspecialchars($empresa['documento']); ?>
            </p>

        <?php endif; ?>


        <!-- ENDEREÇO -->
        <?php if (!empty($empresa['endereco'])): ?>

            <p class="info">
                <?= htmlspecialchars($empresa['endereco']); ?>
            </p>

        <?php endif; ?>


        <!-- CEP -->
        <?php if (!empty($empresa['cep'])): ?>

            <p class="info">
                CEP: <?= htmlspecialchars($empresa['cep']); ?>
            </p>

        <?php endif; ?>


        <!-- TELEFONE -->
        <?php if (!empty($empresa['telefone'])): ?>

            <p class="info">
                Tel/WhatsApp: <?= htmlspecialchars($empresa['telefone']); ?>
            </p>

        <?php endif; ?>


        <!-- E-MAIL -->
        <?php if (!empty($empresa['email'])): ?>

            <p class="info">
                <?= htmlspecialchars($empresa['email']); ?>
            </p>

        <?php endif; ?>

    </div>


    <div class="linha"></div>


    <!-- INFORMAÇÕES DA VENDA -->

    <div class="topo-info">

        <span>
            Venda: #<?= $itens[0]['venda_id'] ?>
        </span>

        <span>
            <?= date('d/m/Y H:i', strtotime($itens[0]['data'])); ?>
        </span>

    </div>


    <div class="linha"></div>


    <!-- PRODUTOS -->

    <?php

    $total = 0;

    foreach ($itens as $item):

        $subtotal = $item['preco'] * $item['quantidade'];

        $total += $subtotal;

    ?>

        <div class="item">

            <div class="produto">

                <?= strtoupper(
                    htmlspecialchars($item['nome'])
                ); ?>

            </div>


            <div class="detalhes">

                <span>

                    <?= $item['quantidade'] ?> x

                    R$
                    <?= number_format(
                        $item['preco'],
                        2,
                        ',',
                        '.'
                    ); ?>

                </span>


                <span>

                    R$
                    <?= number_format(
                        $subtotal,
                        2,
                        ',',
                        '.'
                    ); ?>

                </span>

            </div>

        </div>

    <?php endforeach; ?>


    <div class="linha"></div>


    <!-- TOTAL -->

    <div class="total">

        TOTAL

        <br>

        R$
        <?= number_format(
            $total,
            2,
            ',',
            '.'
        ); ?>

    </div>


    <div class="linha"></div>


    <!-- PAGAMENTO -->

    <div class="pagamento">

        Pagamento:

        <?= strtoupper(
            htmlspecialchars(
                $itens[0]['forma_pagamento']
            )
        ); ?>

    </div>


    <div class="linha"></div>


    <!-- RODAPÉ -->

    <div class="rodape">

        Obrigado pela preferência!

        <br>

        Volte sempre!

    </div>

</div>


<script>

    window.onload = function() {

        window.print();

    };

    window.onafterprint = function() {

        window.location.href =
            "index.php?action=vendas";

    };

</script>

</body>

</html>