<?php
require_once __DIR__ . '/../middlewares/auth.php';
require_once __DIR__ . '/../middlewares/permissao.php';

somenteEmpresa();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
    <title>Dashboard</title>
    <style>
        body {
            background-color: #f5f7fa;
        }

        .card-dashboard {
            border-radius: 18px;
            transition: all 0.2s ease;
        }

        .card-dashboard:hover {
            transform: translateY(-5px);
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

<body>
    <div class="topbar d-flex justify-content-between align-items-center px-3 text-white">
        <strong>📊 Dashboard</strong>
        <div class="dropdown">
            <button class="btn text-white dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle" style="font-size: 20px;"></i>
                <span><?= $_SESSION['usuario_nome'] ?? 'Usuário' ?></span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end">

                <li>
                    <a class="dropdown-item text-primary" href="index.php?action=home">
                        <i class="bi bi-house"></i> Home
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="container d-flex flex-column justify-content-center p-3">
        <h3 class="mb-3 text-center">Sistema Comércio</h3>
        <hr>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card bg-success text-white p-4 text-center shadow border-0 card-dashboard">
                    <h5>Total Hoje</h5>

                    <h3>
                        R$ <?= number_format($totalHoje['total'] ?? 0, 2, ',', '.') ?>
                    </h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-primary text-white p-4 text-center shadow border-0 card-dashboard">
                    <h5>Total Mês</h5>

                    <h3>
                        R$ <?= number_format($totalMes['total'] ?? 0, 2, ',', '.') ?>
                    </h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-warning p-4 text-center shadow border-0 card-dashboard">

                    <h5>Produto Mais Vendido</h5>

                    <?php if (!empty($produtoTop)): ?>

                        <h4><?= $produtoTop['nome'] ?></h4>

                        <small>
                            <?= $produtoTop['total'] ?> vendas
                        </small>

                    <?php else: ?>

                        <p>Nenhuma venda ainda</p>

                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>