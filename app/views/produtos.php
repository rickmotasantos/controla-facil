<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
    <title>Produtos</title>
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

</html>

<body>
    <div class="topbar d-flex justify-content-between align-items-center px-3 text-white">
        <strong>📦 Estoque</strong>
        <div class="dropdown">
            <button class="btn text-white dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle" style="font-size: 20px;"></i>
                <span><?= $_SESSION['usuario_nome'] ?? 'Usuário' ?></span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end">

                <li>
                    <a class="dropdown-item" href="index.php?action=alterar_senha">
                        <i class="bi bi-key"></i> Alterar senha
                    </a>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item text-danger" href="index.php?action=home">
                        <i class="bi bi-house"></i> Home
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="container p-2">
        <h3 class="mb-3 text-center">Sistema Comércio</h3>

        <hr>

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-<?= $_SESSION['msg_tipo'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['msg'] ?>
            </div>
        <?php unset($_SESSION['msg'], $_SESSION['msg_tipo']);
        endif; ?>

        <h5 class="mb-3">Lista de Produtos</h5>
        <div class="card shadow-sm mb-3">
            <div class="card-body">

                <h6 class="mb-3 text-muted text-center">Status do Estoque</h6>

                <div class="d-flex flex-wrap gap-3 justify-content-center">

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-danger">&nbsp;&nbsp;</span>
                        <small>Sem estoque</small>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-warning text-dark">&nbsp;&nbsp;</span>
                        <small>Estoque baixo (até 5)</small>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-success">&nbsp;&nbsp;</span>
                        <small>Estoque normal</small>
                    </div>

                </div>

            </div>
        </div>
        <div class="table-responsive m-2">
            <table class="table table-light table-striped table-hover table-bordered text-center">

                <thead class="table-dark">
                    <tr>
                        <th>Cód.</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Qtd</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (empty($produtos)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-box-seam fs-4"></i><br>
                                Nenhum produto cadastrado
                            </td>
                        </tr>

                    <?php else: ?>
                        <?php foreach ($produtos as $p): ?>
                            <tr class="<?php
                                        if ($p['quantidade'] == 0) {
                                            echo 'table-danger';
                                        } elseif ($p['quantidade'] <= 5) {
                                            echo 'table-warning';
                                        } else {
                                            echo 'table-success';
                                        }
                                        ?>">
                                <td data-label="Código"><?= $p['codigo'] ?></td>
                                <td data-label="Nome"><?= $p['nome'] ?></td>
                                <td data-label="Preço">R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                                <td data-label="Qtd"><?= $p['quantidade'] ?></td>
                                <td data-label="Ações" class="text-center">
                                    <a href="index.php?action=editar&id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="index.php?action=excluir&id=<?= $p['id'] ?>"
                                        onclick="return confirm('Tem certeza?')"
                                        class="btn btn-danger btn-sm">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </tbody>

            </table>
        </div>

    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
</script>
<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) alert.remove();
    }, 3000);
</script>