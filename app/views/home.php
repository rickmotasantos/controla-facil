<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
    <title>ControlaFácil</title>
    <style>
        body {
            background-color: #f5f7fa;
        }

        .logo {
            max-width: 180px;
        }

        .card-menu {
            border-radius: 15px;
            text-align: center;
            padding: 20px;
            transition: 0.2s;
        }

        .card-menu:hover {
            transform: scale(1.03);
        }

        .icon {
            font-size: 30px;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="row g-3">
            <div class="d-flex justify-content-around align-items-center mb-4">
                <div class="text-center mb-4">
                    <img src="/public/assets/logo.png" alt="" class="logo mb-2">
                    <h4 class="fw-bold text-primary">ControlaFácil</h4>
                    <small class="text-muted"> Seu estoque na palma da mão</small>
                </div>
                <div >
                    <a href="index.php?action=logout"
                        class="btn btn-light rounded-circle shadow-sm"
                        style="width:40px; height:40px;"
                        onclick="return confirm('Deseja sair?')">

                        <i class="bi bi-power"></i>

                    </a>
                </div>
            </div>

            <div class="col-6">
                <a href="index.php?action=estoque" class="text-decoration-none">
                    <div class="card card-menu shadow-sm">
                        <div class="icon text-warning">📦</div>
                        <div>Estoque</div>
                    </div>
                </a>
            </div>

            <div class="col-6">
                <a href="index.php?action=vendas" class="text-decoration-none">
                    <div class="card card-menu shadow-sm">
                        <div class="icon text-danger">💰</div>
                        <div>Vendas</div>
                    </div>
                </a>
            </div>

            <div class="col-6">
                <a href="index.php?action=historico" class="text-decoration-none">
                    <div class="card card-menu shadow-sm">
                        <div class="icon text-danger">📈</div>
                        <div>Histórico</div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="index.php?action=entrada" class="text-decoration-none">
                    <div class="card card-menu shadow-sm">
                        <div class="icon text-danger">📦➕</div>
                        <div>Entrada de Estoque</div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="index.php?action=dashboard" class="text-decoration-none">
                    <div class="card card-menu shadow-sm">
                        <div class="icon text-danger">📊</div>
                        <div>Dashboard</div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="index.php?action=cadastrar_produto" class="text-decoration-none">
                    <div class="card card-menu shadow-sm">
                        <div class="icon text-danger">➕</div>
                        <div>cadastrar Produto</div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <?php if (($_SESSION['tipo'] ?? '') === 'admin'): ?>
                    <a class="text-decoration-none" href="index.php?action=admin_dashboard">
                        <div class="card card-menu shadow-sm">
                            <div class="icon text-danger">⚙️ <i class="bi bi-shield"></i></div>
                            <div>Administração</div>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>