<?php
require_once __DIR__ . '/../middlewares/auth.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
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
    <div class="topbar d-flex justify-content-between align-items-center px-3 text-white">
        <strong>📈 Histórico</strong>
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
    <div class="container">
        <h3 class="m-3 text-center">Sistema Comércio</h3>
        <hr>

        <h5 class="m-2">Histórico de Vendas</h5>

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
                            <td data-label="Pagamento"><?= ($venda['forma_pagamento']) ?></td>
                            <td data-label="Data"><?= date('d/m/y - H:i:s', strtotime($venda['data'])) ?></td>
                        </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>