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
    <title>Dashboard</title>
</head>

<body>
    <div class="dropdown">
        <button class="btn btn-dark text-white d-flex align-items-center gap-2 dropdown-toggle" type="button" data-bs-toggle="dropdown">

            <i class="bi bi-person-circle" style="font-size: 20px;"></i>

            <span><?= $_SESSION['usuario_nome'] ?? 'Usuário' ?></span>

        </button>

        <ul class="dropdown-menu dropdown-menu-end">

            <li>
                <a class="dropdown-item" href="index.php?action=perfil">
                    <i class="bi bi-person"></i> Perfil
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="index.php?action=alterar_senha">
                    <i class="bi bi-key"></i> Alterar senha
                </a>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <a class="dropdown-item text-danger" href="index.php?action=logout" onclick="return confirm('Tem certeza que deseja sair?')">
                    <i class="bi bi-box-arrow-right"></i> Sair
                </a>
            </li>

        </ul>
    </div>
    <div class="container">

        <h1 class="mb-4">Sistema Comércio</h1>

        <div class="d-grid gap-2 d-md-flex mb-3">

            <a class="btn btn-primary" href="index.php?action=produto">Produto</a>
            <a class="btn btn-success" href="index.php?action=vendas">Venda</a>
            <a class="btn btn-warning" href="index.php?action=historico">Histórico</a>
            <a class="btn btn-dark" href="index.php?action=dashboard">Dashboard</a>
            <a class="btn btn-info" href="index.php?action=entrada">Estoque</a>

        </div>

        <hr>

        <div class="row">

            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <h5>Total Hoje</h5>
                    <h3>R$ <?= $totalHoje['total'] ?? 0 ?></h3>
                </div>
            </div>

            <div class="col-md-4 text-center">
                <div class="card p-3">
                    <h5>Total Mês</h5>
                    <h3>R$ <?= $totalMes['total'] ?? 0 ?></h3>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>