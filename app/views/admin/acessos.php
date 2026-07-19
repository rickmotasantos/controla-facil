<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoramento de acessos</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
     <style>
        body {
            background: #f5f7fa;
        }

        .card-painel {
            border: none;
            border-radius: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .08);
        }

        .titulo {
            color: #0d6efd;
            font-weight: bold;
        }

        .table thead {
            background: #0d6efd;
            color: white;
        }

        .badge-online {
            background: #198754;
        }

        .badge-offline {
            background: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-6 px-4 px-md-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="titulo">
                <i class="bi bi-clock-history"></i>
                Monitoramento de Acessos
            </h2>

            <a href="index.php?action=admin_dashboard" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i>
                Voltar
            </a>
        </div>

        <div class="card card-painel">
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>Empresa</th>
                                <th>Usuário</th>
                                <th>Login</th>
                                <th>Logout</th>
                                <th>Tempo</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($acessos as $acesso): ?>

                                <tr>

                                    <td>
                                        <i class="bi bi-shop"></i>
                                        <?= htmlspecialchars($acesso['empresa']) ?>
                                    </td>

                                    <td>
                                        <i class="bi bi-person"></i>
                                        <?= htmlspecialchars($acesso['usuario']) ?>
                                    </td>

                                    <td>
                                        <?= date('d/m/Y H:i', strtotime($acesso['login_em'])) ?>
                                    </td>

                                    <td>
                                        <?php if ($acesso['logout_em']): ?>
                                            <?= date('d/m/Y H:i', strtotime($acesso['logout_em'])) ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?= $acesso['tempo_conectado'] ?? '-' ?>
                                        min
                                    </td>

                                    <td>
                                        <?php if ($acesso['logout_em']): ?>
                                            <span class="badge badge-offline">
                                                Offline
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-online">
                                                Online
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>
        </div>

    </div>
</body>
</html>
<script>
setInterval(function() {
    location.reload();
}, 10000);
</script>