<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Nota da Venda</title>

    <style>
        body {
            font-family: monospace;
            width: 300px;
            margin: auto;
            color: #000;
            font-size: 13px;
            padding: 10px;
        }

        .center {
            text-align: center;
        }

        h2 {
            margin: 0;
            font-size: 20px;
        }

        .info {
            margin: 2px 0;
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
            margin-bottom: 12px;
        }

        .produto {
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .detalhes {
            display: flex;
            justify-content: space-between;
        }

        .subtotal {
            text-align: right;
            margin-top: 2px;
        }

        .total {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0;
        }

        .pagamento {
            text-align: center;
            font-size: 14px;
            margin-top: 10px;
        }

        .rodape {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
        }

        @media print {

            body {
                width: 100%;
                padding: 0;
            }

        }
    </style>
</head>

<body>

    <div class="center">
        <h2>EMPRESA XYZ</h2>

        <p class="info">Rua Exemplo, 123 - RJ</p>
        <p class="info">(21) 91234-5678</p>
        <p class="info">CNPJ: 12.345.678/0001-90</p>
    </div>

    <div class="linha"></div>

    <div class="topo-info">
        <span>Venda: #<?= $itens[0]['venda_id'] ?></span>

        <span>
            <?= date('d/m/Y H:i', strtotime($itens[0]['data'])); ?>
        </span>
    </div>

    <div class="linha"></div>

    <?php
    $total = 0;

    foreach ($itens as $item):

        $subtotal = $item['preco'] * $item['quantidade'];
        $total += $subtotal;
    ?>

        <div class="item">

            <div class="produto">
                <?= strtoupper($item['nome']); ?>
            </div>

            <div class="detalhes">
                <span>
                    <?= $item['quantidade'] ?> x
                    R$ <?= number_format($item['preco'], 2, ',', '.'); ?>
                </span>

                <span>
                    R$ <?= number_format($subtotal, 2, ',', '.'); ?>
                </span>
            </div>

        </div>

    <?php endforeach; ?>

    <div class="linha"></div>

    <div class="total">
        TOTAL
        <br>
        R$ <?= number_format($total, 2, ',', '.'); ?>
    </div>

    <div class="linha"></div>

    <div class="pagamento">
        Pagamento:
        <?= strtoupper($itens[0]['forma_pagamento']); ?>
    </div>

    <div class="linha"></div>

    <div class="rodape">
        Obrigado pela preferência!
        <br>
        Volte sempre 😊
    </div>

    <script>

        window.onload = function () {

            window.print();

            window.onafterprint = function () {

                window.location.href = "index.php?action=vendas";

            }

        }

    </script>

</body>

</html>