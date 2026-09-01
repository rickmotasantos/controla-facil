<?php
require_once __DIR__ . '/../middlewares/auth.php';
require_once __DIR__ . '/../middlewares/permissao.php';

somenteEmpresa();
?>

<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Funcionários</title>
    <style>
        body {
            background-color: #f5f7fa;
        }

        .topbar {
            background: #0d6efd;
            padding: 10px;
        }

        .card {
            border-radius: 15px;
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
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 10px;
                background: white;
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
                width: 45%;
                text-align: left;
                font-weight: bold;
            }

            .acoes {
                display: flex;
                gap: 5px;
            }

            .acoes a {
                flex: 1;
            }
        }
    </style>
</head>

<body>
    <div class="topbar d-flex justify-content-between align-items-center px-3 text-white">

        <strong>
            <i class="bi bi-people-fill"></i>
            Funcionários
        </strong>

        <div class="dropdown">

            <button
                class="btn text-white dropdown-toggle"
                data-bs-toggle="dropdown">

                <i
                    class="bi bi-person-circle"
                    style="font-size: 20px;">
                </i>

                <span>
                    <?= $_SESSION['usuario_nome'] ?? 'Usuário' ?>
                </span>

            </button>

            <ul class="dropdown-menu dropdown-menu-end">

                <li>
                    <a
                        class="dropdown-item text-primary"
                        href="index.php?action=home">

                        <i class="bi bi-house"></i>
                        Home

                    </a>
                </li>

            </ul>

        </div>

    </div>


    <div class="container py-4">

        <!-- CABEÇALHO -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h3 class="mb-0">

                <i class="bi bi-people text-primary"></i>

                Funcionários

            </h3>

            <a
                href="index.php?action=cadastrar_funcionario"
                class="btn btn-primary">

                <i class="bi bi-person-plus"></i>

                Novo Funcionário

            </a>

        </div>


        <!-- MENSAGEM -->

        <?php if (!empty($_SESSION['msg'])): ?>

            <div class="alert alert-<?= $_SESSION['msg_tipo'] ?? 'info' ?>">

                <?= $_SESSION['msg'] ?>

            </div>

            <?php
            unset($_SESSION['msg']);
            unset($_SESSION['msg_tipo']);
            ?>

        <?php endif; ?>


        <!-- LISTA -->

        <div class="card shadow-sm">

            <div class="card-header bg-primary text-white">

                <i class="bi bi-list"></i>

                Funcionários cadastrados

            </div>

            <div class="card-body">

                <?php if (empty($funcionarios)): ?>

                    <div class="alert alert-info mb-0">

                        <i class="bi bi-info-circle"></i>

                        Nenhum funcionário cadastrado.

                    </div>

                <?php else: ?>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-dark">

                                <tr>

                                    <th>Nome</th>

                                    <th>Tipo</th>

                                    <th class="text-center">
                                        Ações
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($funcionarios as $funcionario): ?>

                                    <tr>

                                        <td data-label="Nome">

                                            <i class="bi bi-person"></i>

                                            <?= htmlspecialchars($funcionario['nome']) ?>

                                        </td>

                                        <td data-label="Tipo">

                                            Funcionário

                                        </td>

                                        <td
                                            data-label="Ações"
                                            class="text-center">

                                            <div class="acoes">

                                                <a
                                                    href="index.php?action=editar_funcionario&id=<?= $funcionario['id'] ?>"
                                                    class="btn btn-warning btn-sm">

                                                    <i class="bi bi-pencil"></i>

                                                    Editar

                                                </a>

                                                <a
                                                    href="index.php?action=excluir_funcionario&id=<?= $funcionario['id'] ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Tem certeza que deseja excluir este funcionário?');">

                                                    <i class="bi bi-trash"></i>

                                                    Excluir

                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>
    <script>
        setTimeout(function() {
                const alert = document.querySelector('.alert');

                if(alert) alert.remove();
        }, 3000);
    </script>

</body>

</html>