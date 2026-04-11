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
    <div class="bg-dark text-white position-fixed top-0 start-0 w-100 d-flex align-items-center" style="height: 60px; z-index:1000;">
        <div class="container d-flex align-items-center justify-content-between py-2">
            <div></div>

            <div class="text-center text-white fw-bold d-flex align-items-center gap-1">
                <div>Usuário:</div><?= $_SESSION['usuario_nome'] ?? 'Usuario:' ?>
            </div>

            <div>
                <a href="index.php?action=logout" onclick=" return confirm('Tem certeza que deseja Sair?')" class="btn btn-outline-danger">
                    Sair
                </a>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 80px;">

        <h1 class="mb-4">Sistema Comércio</h1>

        <div class="d-grid gap-2 d-md-flex mb-3">

            <a class="btn btn-primary" href="index.php">Home</a>
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

            <div class="col-md-4 text-center">
                <div class="card p-3">
                    <h5>Produto top</h5>
                    <h3><?= $produtoTop['nome'] ?? 'nenhum' ?></h3>
                </div>
            </div>
        </div>
    </div>
</body>

</html>