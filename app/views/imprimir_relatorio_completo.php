<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Relatório Completo</title>

    <style>
        * {
            box-sizing: border-box;
        }

        @media screen {
            body {
                visibility: hidden;
            }
        }

        body {
            margin: 0;
            padding: 0;
            background: #f5f5f5;
            color: #000;
            font-family: monospace;
            font-size: 13px;
        }

        .relatorio {
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
            margin: 6px 0;
        }

        .dados {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 12px;
            margin: 4px 0;
        }

        .dados span:last-child {
            text-align: right;
        }

        .total-vendas {
            text-align: center;
            font-size: 23px;
            font-weight: bold;
            margin: 10px 0;
        }

        .total-geral {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            margin: 12px 0;
        }

        .funcionario {
            margin-bottom: 10px;
        }

        .funcionario-nome {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .produto {
            margin: 6px 0;
        }

        .produto-nome {
            font-weight: bold;
            text-transform: uppercase;
            word-break: break-word;
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
        BOTÕES
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
            }

            .relatorio {
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

            .total-vendas {
                font-size: 26px;
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
                visibility: visible;
            }

            .relatorio {
                visibility: visible;
                display: block;
                width: 80mm;
                max-width: 80mm;
                margin: 0;
                padding: 2mm;
            }

            .acoes {
                display: none !important;
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


    $totalDinheiro = (float) ($totalDinheiro ?? 0);

    $totalCartao = (float) ($totalCartao ?? 0);

    $totalPix = (float) ($totalPix ?? 0);

    $totalGeral = (float) ($totalGeral ?? 0);



    $totalVendasGeral = 0;


    $totalMercadorias = 0;



    foreach (($funcionarios ?? []) as $funcionario) {

        $totalVendasGeral +=
            (int) ($funcionario['total_vendas'] ?? 0);


        foreach (($funcionario['produtos'] ?? []) as $produto) {

            $totalMercadorias +=
                (float) ($produto['quantidade'] ?? 0);
        }
    }

    ?>

    <div class="relatorio">


        <div class="linha"></div>


        <div class="titulo">

            RELATÓRIO COMPLETO

        </div>


        <div class="linha"></div>


        <div class="dados">

            <span>
                Caixa:
            </span>

            <span>
                #<?= str_pad(
                        (string) ($caixa_id ?? 1),
                        3,
                        '0',
                        STR_PAD_LEFT
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
                $totalVendasGeral,
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
                    $totalDinheiro,
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
                    $totalCartao,
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
                    $totalPix,
                    2,
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


        <div class="subtitulo">

            MERCADORIAS VENDIDAS

        </div>


        <div class="dados">

            <span>
                Quantidade:
            </span>

            <span>

                <?= number_format(
                    $totalMercadorias,
                    0,
                    ',',
                    '.'
                ) ?>

            </span>

        </div>


        <div class="linha"></div>

        <div class="subtitulo">

            VENDAS POR FUNCIONÁRIO

        </div>


        <?php if (!empty($funcionarios)): ?>

            <?php foreach ($funcionarios as $funcionario): ?>

                <?php

                $nomeFuncionario =
                    $funcionario['nome']
                    ?? $funcionario['usuario_nome']
                    ?? 'Não informado';

                $vendasFuncionario =
                    (int) ($funcionario['total_vendas'] ?? 0);

                $dinheiroFuncionario =
                    (float) ($funcionario['dinheiro'] ?? 0);

                $cartaoFuncionario =
                    (float) ($funcionario['cartao'] ?? 0);

                $pixFuncionario =
                    (float) ($funcionario['pix'] ?? 0);

                $totalFuncionario =
                    (float) ($funcionario['total'] ?? 0);

                ?>

                <div class="funcionario">

                    <div class="funcionario-nome">

                        <?= htmlspecialchars(
                            $nomeFuncionario
                        ) ?>

                    </div>


                    <div class="dados">

                        <span>
                            Vendas:
                        </span>

                        <span>
                            <?= number_format(
                                $vendasFuncionario,
                                0,
                                ',',
                                '.'
                            ) ?>
                        </span>

                    </div>


                    <div class="dados">

                        <span>
                            Dinheiro:
                        </span>

                        <span>

                            R$

                            <?= number_format(
                                $dinheiroFuncionario,
                                2,
                                ',',
                                '.'
                            ) ?>

                        </span>

                    </div>


                    <div class="dados">

                        <span>
                            Cartão:
                        </span>

                        <span>

                            R$

                            <?= number_format(
                                $cartaoFuncionario,
                                2,
                                ',',
                                '.'
                            ) ?>

                        </span>

                    </div>


                    <div class="dados">

                        <span>
                            PIX:
                        </span>

                        <span>

                            R$

                            <?= number_format(
                                $pixFuncionario,
                                2,
                                ',',
                                '.'
                            ) ?>

                        </span>

                    </div>


                    <div class="dados">

                        <span>
                            Total:
                        </span>

                        <span>

                            R$

                            <?= number_format(
                                $totalFuncionario,
                                2,
                                ',',
                                '.'
                            ) ?>

                        </span>

                    </div>


                    <div class="linha"></div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="center">

                    Nenhum funcionário encontrado.

                </div>

            <?php endif; ?>

            <div class="subtitulo">

                RESUMO FINAL

            </div>


            <div class="dados">

                <span>
                    Total de vendas:
                </span>

                <span>
                    <?= number_format(
                        $totalVendasGeral,
                        0,
                        ',',
                        '.'
                    ) ?>
                </span>

            </div>


            <div class="dados">

                <span>
                    Mercadorias:
                </span>

                <span>
                    <?= number_format(
                        $totalMercadorias,
                        0,
                        ',',
                        '.'
                    ) ?>
                </span>

            </div>


            <div class="dados">

                <span>
                    Total recebido:
                </span>

                <span>

                    R$

                    <?= number_format(
                        $totalGeral,
                        2,
                        ',',
                        '.'
                    ) ?>

                </span>

            </div>


            <div class="linha"></div>


            <div class="rodape">

                RELATÓRIO COMPLETO

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

                        }, 100);
                        window.addEventListener('afterprint', function() {

                            window.location.href = 'index.php?action=historico_fechamento_caixa';

                        });

                    });
                </script>

</body>

</html>