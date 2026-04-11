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
    <style>
        @media (max-width: 768px) {

            .table thead {
                display: none;
            }

            .table,
            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 12px;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 10px;
                background: #fff;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            }

            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
                border: none;
                border-bottom: 1px solid #eee;
            }

            .table td:last-child {
                border-bottom: none;
            }

            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 50%;
                text-align: left;
                font-weight: bold;
            }

            .acoes-btns {
                display: flex;
                gap: 5px;
            }

            .acoes-btns a {
                flex: 1;
            }
        }
    </style>
    <title>Histórico</title>
</head>

<body>
    <div class="bg-dark text-white position-fixed top-0 start-0 w-100 d-flex align-items-center" style="height: 60px; z-index:1000;">
        <div class="container d-flex align-items-center justify-content-between py-2">
            <div></div>

            <div class="text-center text-white fw-bold d-flex align-items-center gap-1">
                <div>Usuário:</div><?= $_SESSION['usuario_nome'] ?? 'Usuario:' ?>
            </div>

            <div>
                <a href="index.php?action=logout" onclick="return confirm('Tem certeza que deseja sair?')" class="btn btn-outline-danger">
                    Sair
                </a>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top:80px;">

        <h1 class="mb-4">Sistema Comércio</h1>

        <div class="d-grid gap-2 d-md-flex mb-3">

            <a class="btn btn-primary" href="index.php">Home</a>
            <a class="btn btn-success" href="index.php?action=vendas">Venda</a>
            <a class="btn btn-warning" href="index.php?action=historico">Histórico</a>
            <a class="btn btn-dark" href="index.php?action=dashboard">Dashboard</a>
            <a class="btn btn-info" href="index.php?action=entrada">Estoque</a>

        </div>

        <hr>

        <h2 class="mb-4">Histórico de Vendas</h2>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Total</th>
                        <th>Pagamento</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <?php foreach ($vendas as $venda): ?>
                    <tbody>
                        <tr>
                            <td data-label="Total">R$ <?= number_format($venda['total'], 2, ',', '.') ?></td>
                            <td data-label="Pagamento"><?=($venda['forma_pagamento']) ?></td>
                            <td data-label="Data"><?= date('d/m/y - H:i:s', strtotime ($venda['data'])) ?></td>
                        </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>

</html>