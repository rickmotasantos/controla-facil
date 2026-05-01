<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
    <title>Cadastrar Produtos</title>
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
    </style>
</head>

<body>
    <div class="topbar d-flex justify-content-between align-items-center px-3 text-white">
        <strong>📦 Novo Produto</strong>
        <div class="dropdown">
            <button class="btn text-white dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle" style="font-size: 20px;"></i>
                <span><?= $_SESSION['usuario_nome'] ?? 'Usuário' ?></span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item text-danger" href="index.php?action=home">
                        <i class="bi bi-box-arrow-right"></i> Home
                    </a>
                </li>

            </ul>
        </div>
    </div>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm p-4 card-form">
                <h5 class="mb-4 text-center">Cadastrar Produtos</h5>
                <form method="post" action="index.php?action=salvar" class="row g-2 mb-4">

                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                        <input type="text" name="codigo" class="form-control" placeholder="Código" required>
                    </div>

                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                        <input type="text" name="nome" class="form-control" placeholder="Nome" required>
                    </div>

                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                        <input type="number" step="0.01" name="preco" class="form-control" placeholder="Preço" required>
                    </div>

                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="bi bi-plus"></i></span>
                        <input type="number" name="quantidade" class="form-control" placeholder="Qtd" required>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-success w-100">Salvar</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>