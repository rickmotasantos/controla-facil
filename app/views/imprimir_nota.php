<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Nota da Venda</title>

    <style>
        body {
            font-family: monospace;
            width: 280px;
            margin: auto;
            font-size: 14px;
            color: #000;
        }

        h2,
        p {
            text-align: center;
            margin: 5px 0;
        }

        .linha {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .item {
            margin-bottom: 10px;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }

        .info {
            font-size: 13px;
        }

        @media print {

            body {
                width: 100%;
            }

        }
    </style>
</head>

<body>
    <h2>Empresa XYZ</h2>

    <p class="info">Rua Exemplo, 123 - RJ</p>
    <p class="info">Telefone: (21) 1234-5678</p>
    <p class="info">CNPJ: 12.345.678/0001-90</p>

    <div class="linha"></div>

    <p>
        Venda N.
        <?= $itens[0]['venda_id'] ?>
    </p>

    <p>
        Data:
        <?= date('d/m/Y H:i:s', strtotime($itens[0]['data'])); ?>
    </p>

    <div class="linha"></div>

    <?php
        $total = 0;

        foreach($itens as $item):
            $subtotal = $item['preco'] * $item['quantidade'];
            $total += $subtotal;
            ?>
            <div class="item">
                <?= $item['nome']; ?>

                <?=  $item['quantidade'] ?> x
                R$ <?= number_format($item['preco'], 2, ',', '.'); ?>

                <br>
                Subtotal: R$ <?= number_format($subtotal, 2, ',', '.'); ?>
            </div>
        <?php endforeach; ?>

        <div class="linha"></div>

        <div class="total">
            Total: R$ <?= number_format($total, 2, ',', '.'); ?>
        </div>

        <div class="linha"></div>

        <p>Forma de Pagamento: <?= ucfirst($itens[0]['forma_pagamento']) ?></p>

        <div class="linha"></div>

        <p>Obrigado pela preferência!</p>

    <script>
        window.onload = function() {

            window.print();

            window.onafterprint = function() {
                window.location.href = "index.php?action=vendas";
            }
        }
    </script>

</body>

</html>