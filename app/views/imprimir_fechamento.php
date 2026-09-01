<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Imprimir Fechamento</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background: #f5f5f5;
            color: #000;
            font-family: monospace;
            font-size: 13px;
        }

        .fechamento {
            width: 80mm;
            max-width: 80mm;
            margin: 20px auto;
            padding: 3mm;
            background: #fff;
        }

        .center {
            text-align: center;
        }

        .empresa-nome {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .info {
            margin: 2px 0;
            font-size: 12px;
        }

        .linha {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .titulo {
            text-align: center;
            font-size: 17px;
            font-weight: bold;
            margin: 8px 0;
        }

        .subtitulo {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            margin: 5px 0;
        }

        .dados {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 12px;
            margin: 3px 0;
        }

        .dados span:last-child {
            text-align: right;
        }

        .total-vendas {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin: 10px 0;
        }

        .total-geral {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 12px 0;
        }

        .produto {
            margin-bottom: 8px;
        }

        .produto-nome {
            font-weight: bold;
            text-transform: uppercase;
            word-break: break-word;
            margin-bottom: 2px;
        }

        .produto-info {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }

        .rodape {
            text-align: center;
            font-size: 12px;
            margin-top: 15px;
        }

        /*
        =====================================================
        BOTÃO NA TELA
        =====================================================
        */

        .acoes {
            width: 80mm;
            max-width: 80mm;
            margin: 10px auto;
            display: flex;
            gap: 5px;
        }

        .btn {
            flex: 1;
            padding: 10px;
            border: 0;
            cursor: pointer;
            font-family: monospace;
            font-weight: bold;
            border-radius: 4px;
        }

        .btn-imprimir {
            background: #000;
            color: #fff;
        }

        .btn-voltar {
            background: #ddd;
            color: #000;
        }

        /*
        =====================================================
        RESPONSIVO CELULAR
        =====================================================
        */

        @media screen and (max-width: 600px) {

            body {
                background: #fff;
                font-size: 13px;
            }

            .fechamento {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 15px;
            }

            .acoes {
                width: 100%;
                max-width: 100%;
                padding: 10px;
                margin: 0;
            }

            .empresa-nome {
                font-size: 20px;
            }

            .titulo {
                font-size: 19px;
            }

            .dados {
                font-size: 13px;
            }

            .produto-info {
                font-size: 13px;
            }

            .total-vendas {
                font-size: 25px;
            }

            .total-geral {
                font-size: 28px;
            }
        }

        /*
        =====================================================
        IMPRESSÃO
        =====================================================
        */

        @media print {

            @page {
                size: 80mm auto;
                margin: 0;
            }

            html,
            body {
                width: 80mm;
                margin: 0;
                padding: 0;
                background: #fff;
            }

            .fechamento {
                width: 80mm;
                max-width: 80mm;
                margin: 0;
                padding: 2mm;
            }

            .acoes {
                display: none !important;
            }

            .empresa-nome {
                font-size: 18px;
            }

            .titulo {
                font-size: 16px;
            }

            .total-vendas {
                font-size: 22px;
            }

            .total-geral {
                font-size: 24px;
            }
        }

        @media screen {

            .fechamento,
            .acoes {
                display: none;
            }
        }
    </style>
</head>

<body>

    <?php

    $nomeEmpresa = !empty($empresa['nome_fantasia'])
        ? $empresa['nome_fantasia']
        : ($empresa['nome'] ?? '');

    $dataAtual = new DateTime(
        'now',
        new DateTimeZone('America/Sao_Paulo')
    );

    $totalVendas = (int) ($funcionario['total_vendas'] ?? 0);

    $dinheiro = (float) ($funcionario['dinheiro'] ?? 0);
    $cartao = (float) ($funcionario['cartao'] ?? 0);
    $pix = (float) ($funcionario['pix'] ?? 0);

    $totalGeral = (float) ($funcionario['total'] ?? 0);

    $quantidadeMercadoria = 0;

    foreach (($funcionario['produtos'] ?? []) as $produto) {

        $quantidadeMercadoria +=
            (float) ($produto['quantidade'] ?? 0);
    }

    ?>

    <div class="fechamento">

        <div class="linha"></div>


        <div class="titulo">
            FECHAMENTO DE CAIXA
        </div>


        <div class="linha"></div>


        <div class="dados">

            <span>
                Fechamento:
            </span>

            <span>
                #<?= htmlspecialchars($funcionario['fechamento'] ?? '000') ?>
            </span>

        </div>


        <div class="dados">

            <span>
                Funcionário:
            </span>

            <span>
                <?= htmlspecialchars(
                    $funcionario['nome']
                        ?? $funcionario['usuario_nome']
                        ?? 'Não informado'
                ) ?>
            </span>

        </div>


        <div class="dados">

            <span>
                Data:
            </span>

            <span>
                <?= $dataAtual->format('d/m/Y H:i') ?>
            </span>

        </div>


        <div class="linha"></div>


        <div class="subtitulo">
            TOTAL DE VENDAS
        </div>

        <div class="total-vendas">

            <?= number_format(
                $totalVendas,
                0,
                ',',
                '.'
            ) ?>

        </div>


        <div class="linha"></div>


        <div class="subtitulo">
            FORMAS DE PAGAMENTO
        </div>


        <div class="dados">

            <span>
                DINHEIRO
            </span>

            <span>
                R$
                <?= number_format(
                    $dinheiro,
                    2,
                    ',',
                    '.'
                ) ?>
            </span>

        </div>


        <div class="dados">

            <span>
                CARTÃO
            </span>

            <span>
                R$
                <?= number_format(
                    $cartao,
                    2,
                    ',',
                    '.'
                ) ?>
            </span>

        </div>


        <div class="dados">

            <span>
                PIX
            </span>

            <span>
                R$
                <?= number_format(
                    $pix,
                    2,
                    ',',
                    '.'
                ) ?>
            </span>

        </div>

        <div class="linha"></div>

        <div class="subtitulo">
            MERCADORIAS VENDIDAS
        </div>

        <br>

        <div class="dados">

            <span>
                Quantidade:
            </span>

            <span>
                <?= number_format(
                    $quantidadeMercadoria,
                    0,
                    ',',
                    '.'
                ) ?>
            </span>

        </div>

        <div class="linha"></div>
        <div class="subtitulo">
            TOTAL GERAL
        </div>

        <div class="total-geral">

            R$

            <?= number_format(
                $totalGeral,
                2,
                ',',
                '.'
            ) ?>

        </div>




        <div class="linha"></div>

        <div class="rodape">

            FECHAMENTO DE CAIXA

            <br>

        </div>

    </div>

    <div class="acoes">

        <button
            type="button"
            class="btn btn-voltar"
            onclick="voltar()">

            Voltar

        </button>


        <button
            type="button"
            class="btn btn-imprimir"
            onclick="imprimir()">

            Imprimir

        </button>

    </div>


    <script>
        window.addEventListener('load', function() {

            setTimeout(function() {

                window.print();

            }, 200);

        });

        window.addEventListener('afterprint', function() {

            window.location.href =
                "index.php?action=historico_fechamento_caixa";

        });
    </script>

</body>

</html>