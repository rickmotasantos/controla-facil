<?php

require_once __DIR__ . '../../../middlewares/permissao.php';

somenteAdmin();

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Painel Admin</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
        rel="stylesheet">

    <style>
        html,
        body {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        .container-fluid {
            width: 100%;
            padding-left: 0;
            padding-right: 0;
        }


        /* =========================================
   PAINEL NO CELULAR
========================================= */

        @media (max-width: 767.98px) {

            aside {
                width: 100% !important;
                min-height: auto !important;
                padding: 15px !important;
            }

            aside h4 {
                text-align: center;
            }

            aside .d-grid {
                gap: 5px !important;
            }

            aside .btn {
                font-size: 14px;
            }

            main {
                width: 100% !important;
                padding: 15px !important;
            }

            main>.d-flex {
                flex-direction: column;
                align-items: stretch !important;
                gap: 15px;
            }

            main>.d-flex .btn {
                width: 100%;
            }

            .row.g-3 .col-md-3 {
                width: 100%;
            }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table {
                min-width: 900px;
            }
        }


        /* =========================================
   MODAL NOVO CLIENTE
========================================= */

        #modalNovaEmpresa .modal-dialog {
            max-width: 800px;
        }

        #modalNovaEmpresa .modal-content {
            border-radius: 10px;
        }

        #modalNovaEmpresa .modal-body {
            overflow-y: auto;
        }


        /* =========================================
   MODAL NOVO CLIENTE
========================================= */

        #modalNovaEmpresa {
            overflow-y: auto !important;
        }

        #modalNovaEmpresa .modal-dialog {
            max-width: 800px;
        }


        /* =========================================
   CELULAR
========================================= */

        @media (max-width: 767.98px) {

            #modalNovaEmpresa {
                overflow-y: auto !important;
                overflow-x: hidden !important;
                padding: 0 !important;
            }

            #modalNovaEmpresa .modal-dialog {
                width: 100%;
                max-width: 100%;
                margin: 0 !important;
                min-height: 100vh;
            }

            #modalNovaEmpresa .modal-content {
                min-height: 100vh;
                height: auto;
                border-radius: 0;
            }

            #modalNovaEmpresa .modal-body {
                overflow: visible !important;
                height: auto !important;
                max-height: none !important;
            }

            #modalNovaEmpresa .col-md-6,
            #modalNovaEmpresa .col-md-4,
            #modalNovaEmpresa .col-md-9,
            #modalNovaEmpresa .col-md-3 {
                width: 100%;
            }

            #modalNovaEmpresa input,
            #modalNovaEmpresa select {
                width: 100%;
                font-size: 16px;
            }
        }
    </style>
</head>


<body class="bg-light">


    <div class="container-fluid">

        <div class="row min-vh-100">


            <!-- ===================================================== -->
            <!-- MENU LATERAL -->
            <!-- ===================================================== -->

            <aside class="col-md-2 bg-dark text-white p-4">

                <h4 class="mb-4">

                    <i class="bi bi-shield-lock"></i>

                    Admin

                </h4>


                <div class="d-grid gap-2">


                    <a
                        href="index.php?action=acessos"
                        class="btn btn-outline-light text-start">

                        <i class="bi bi-speedometer2"></i>

                        Monitorar Acessos

                    </a>


                    <a
                        href="#"
                        class="btn btn-outline-light text-start">

                        <i class="bi bi-buildings"></i>

                        Clientes

                    </a>


                    <a
                        href="#"
                        class="btn btn-outline-light text-start">

                        <i class="bi bi-people"></i>

                        Usuários

                    </a>


                    <a
                        href="#"
                        class="btn btn-outline-light text-start">

                        <i class="bi bi-cash-stack"></i>

                        Financeiro

                    </a>


                    <a
                        href="#"
                        class="btn btn-outline-light text-start">

                        <i class="bi bi-gear"></i>

                        Configurações

                    </a>


                    <a
                        href="index.php?action=home"
                        class="btn btn-primary text-start mt-4">

                        <i class="bi bi-house"></i>

                        Home

                    </a>


                </div>

            </aside>



            <!-- ===================================================== -->
            <!-- CONTEÚDO -->
            <!-- ===================================================== -->

            <main class="col-md-10 p-4">


                <!-- ================================================= -->
                <!-- MENSAGEM -->
                <!-- ================================================= -->

                <?php if (isset($_SESSION['msg'])): ?>

                    <div
                        class="alert alert-<?= htmlspecialchars($_SESSION['msg_tipo'] ?? 'info') ?> alert-dismissible fade show"
                        role="alert">

                        <?= htmlspecialchars($_SESSION['msg']) ?>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"></button>

                    </div>


                    <?php

                    unset(
                        $_SESSION['msg'],
                        $_SESSION['msg_tipo']
                    );

                    ?>

                <?php endif; ?>



                <!-- ================================================= -->
                <!-- CABEÇALHO -->
                <!-- ================================================= -->

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h2 class="mb-1">

                            <i class="bi bi-speedometer2"></i>

                            Painel Administrativo

                        </h2>

                        <small class="text-muted">

                            Gerenciamento dos clientes do sistema

                        </small>

                    </div>


                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalNovaEmpresa">

                        <i class="bi bi-plus-lg"></i>

                        Novo Cliente

                    </button>

                </div>



                <!-- ================================================= -->
                <!-- CARDS -->
                <!-- ================================================= -->

                <div class="row g-3 mb-4">


                    <!-- TOTAL CLIENTES -->

                    <div class="col-md-3">

                        <div class="card shadow-sm border-0 h-100">

                            <div class="card-body">

                                <div class="d-flex justify-content-between">

                                    <div>

                                        <h6 class="text-muted">

                                            Total de Clientes

                                        </h6>

                                        <h3>

                                            <?= $empresas['total'] ?? 0 ?>

                                        </h3>

                                    </div>


                                    <div class="fs-1 text-primary">

                                        <i class="bi bi-buildings"></i>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- USUÁRIOS -->

                    <div class="col-md-3">

                        <div class="card shadow-sm border-0 h-100">

                            <div class="card-body">

                                <div class="d-flex justify-content-between">

                                    <div>

                                        <h6 class="text-muted">

                                            Total de Usuários

                                        </h6>

                                        <h3>

                                            <?= $usuarios['total'] ?? 0 ?>

                                        </h3>

                                    </div>


                                    <div class="fs-1 text-success">

                                        <i class="bi bi-people"></i>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- ATIVOS -->

                    <div class="col-md-3">

                        <div class="card shadow-sm border-0 h-100">

                            <div class="card-body">

                                <div class="d-flex justify-content-between">

                                    <div>

                                        <h6 class="text-muted">

                                            Clientes Ativos

                                        </h6>

                                        <h3>

                                            <?= $ativas['total'] ?? 0 ?>

                                        </h3>

                                    </div>


                                    <div class="fs-1 text-success">

                                        <i class="bi bi-check-circle"></i>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- RECEITA -->

                    <div class="col-md-3">

                        <div class="card shadow-sm border-0 h-100">

                            <div class="card-body">

                                <div class="d-flex justify-content-between">

                                    <div>

                                        <h6 class="text-muted">

                                            Receita Mensal SaaS

                                        </h6>

                                        <h3>

                                            R$

                                            <?= number_format(
                                                $mensalidades['total'] ?? 0,
                                                2,
                                                ',',
                                                '.'
                                            ) ?>

                                        </h3>

                                    </div>


                                    <div class="fs-1 text-warning">

                                        <i class="bi bi-cash-stack"></i>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>



                <!-- ================================================= -->
                <!-- TABELA DE CLIENTES -->
                <!-- ================================================= -->

                <div class="card shadow-sm border-0">


                    <div class="card-body">


                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <h5 class="mb-0">

                                <i class="bi bi-buildings"></i>

                                Clientes Cadastrados

                            </h5>


                            <span class="badge bg-dark">

                                <?= count($listaEmpresas) ?>

                                clientes

                            </span>

                        </div>



                        <div class="table-responsive">


                            <table class="table table-bordered table-hover align-middle">


                                <thead class="table-dark">

                                    <tr>

                                        <th>ID</th>

                                        <th>Empresa</th>

                                        <th>Responsável</th>

                                        <th>Telefone</th>

                                        <th>Plano</th>

                                        <th>Valor</th>

                                        <th>Vencimento</th>

                                        <th>Status</th>

                                        <th style="min-width: 300px;">

                                            Ações

                                        </th>

                                    </tr>

                                </thead>



                                <tbody>


                                    <?php if (empty($listaEmpresas)): ?>

                                        <tr>

                                            <td
                                                colspan="9"
                                                class="text-center text-muted py-4">

                                                <i class="bi bi-building fs-2"></i>

                                                <br>

                                                Nenhum cliente cadastrado.

                                            </td>

                                        </tr>

                                    <?php endif; ?>



                                    <?php foreach ($listaEmpresas as $empresa): ?>


                                        <tr>


                                            <!-- ID -->

                                            <td>

                                                <strong>

                                                    #<?= $empresa['id'] ?>

                                                </strong>

                                            </td>



                                            <!-- EMPRESA -->

                                            <td>

                                                <strong>

                                                    <?= htmlspecialchars(
                                                        $empresa['nome_fantasia']
                                                            ?? $empresa['nome']
                                                            ?? '-'
                                                    ) ?>

                                                </strong>


                                                <?php if (!empty($empresa['razao_social'])): ?>

                                                    <br>

                                                    <small class="text-muted">

                                                        <?= htmlspecialchars(
                                                            $empresa['razao_social']
                                                        ) ?>

                                                    </small>

                                                <?php endif; ?>

                                            </td>



                                            <!-- RESPONSÁVEL -->

                                            <td>

                                                <?= htmlspecialchars(
                                                    $empresa['responsavel'] ?? '-'
                                                ) ?>

                                            </td>



                                            <!-- TELEFONE -->

                                            <td>

                                                <?= htmlspecialchars(
                                                    $empresa['telefone'] ?? '-'
                                                ) ?>

                                            </td>



                                            <!-- PLANO -->

                                            <td>

                                                <?= htmlspecialchars(
                                                    $empresa['plano'] ?? '-'
                                                ) ?>

                                            </td>



                                            <!-- VALOR -->

                                            <td>

                                                <?php if (!empty($empresa['valor_mensal'])): ?>

                                                    R$

                                                    <?= number_format(
                                                        $empresa['valor_mensal'],
                                                        2,
                                                        ',',
                                                        '.'
                                                    ) ?>

                                                <?php else: ?>

                                                    -

                                                <?php endif; ?>

                                            </td>



                                            <!-- VENCIMENTO -->

                                            <td>

                                                <?php if (!empty($empresa['vencimento_dia'])): ?>

                                                    Dia

                                                    <?= $empresa['vencimento_dia'] ?>

                                                <?php else: ?>

                                                    -

                                                <?php endif; ?>

                                            </td>



                                            <!-- STATUS -->

                                            <td>


                                                <?php

                                                $statusClass = match ($empresa['status'] ?? '') {

                                                    'ativo' => 'success',

                                                    'teste' => 'warning',

                                                    'suspenso' => 'secondary',

                                                    'inadimplente' => 'danger',

                                                    default => 'dark'
                                                };

                                                ?>


                                                <span
                                                    class="badge bg-<?= $statusClass ?>">

                                                    <?= ucfirst(
                                                        $empresa['status'] ?? '-'
                                                    ) ?>

                                                </span>


                                            </td>



                                            <!-- AÇÕES -->

                                            <td>


                                                <div class="d-flex gap-1 flex-wrap">


                                                    <!-- VER -->

                                                    <button
                                                        type="button"
                                                        class="btn btn-info btn-sm text-white"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalCliente<?= $empresa['id'] ?>">

                                                        <i class="bi bi-eye"></i>

                                                        Ver

                                                    </button>



                                                    <!-- EDITAR -->

                                                    <a
                                                        href="index.php?action=editarEmpresa&id=<?= $empresa['id'] ?>"
                                                        class="btn btn-warning btn-sm">

                                                        <i class="bi bi-pencil"></i>

                                                        Editar

                                                    </a>



                                                    <!-- EXCLUIR -->

                                                    <a
                                                        href="index.php?action=excluirEmpresa&id=<?= $empresa['id'] ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Tem certeza que deseja excluir este cliente?')">

                                                        <i class="bi bi-trash"></i>

                                                        Excluir

                                                    </a>



                                                    <?php if (($empresa['status'] ?? '') === 'ativo'): ?>


                                                        <a
                                                            href="index.php?action=alterarStatusEmpresa&id=<?= $empresa['id'] ?>&status=suspenso"
                                                            class="btn btn-secondary btn-sm"
                                                            onclick="return confirm('Deseja inativar este cliente?')">

                                                            <i class="bi bi-pause-circle"></i>

                                                            Inativar

                                                        </a>


                                                    <?php else: ?>


                                                        <a
                                                            href="index.php?action=alterarStatusEmpresa&id=<?= $empresa['id'] ?>&status=ativo"
                                                            class="btn btn-success btn-sm"
                                                            onclick="return confirm('Deseja ativar este cliente?')">

                                                            <i class="bi bi-check-circle"></i>

                                                            Ativar

                                                        </a>


                                                    <?php endif; ?>


                                                </div>


                                            </td>


                                        </tr>


                                    <?php endforeach; ?>


                                </tbody>


                            </table>


                        </div>


                    </div>

                </div>


                <?php foreach ($listaEmpresas as $empresa): ?>


                    <div
                        class="modal fade"
                        id="modalCliente<?= $empresa['id'] ?>"
                        tabindex="-1"
                        aria-hidden="true">


                        <div
                            class="modal-dialog modal-lg modal-dialog-scrollable">


                            <div class="modal-content">


                                <!-- CABEÇALHO -->

                                <div class="modal-header bg-dark text-white">


                                    <h5 class="modal-title">


                                        <i class="bi bi-building"></i>


                                        <?= htmlspecialchars(
                                            $empresa['nome_fantasia']
                                                ?? $empresa['nome']
                                                ?? 'Cliente'
                                        ) ?>


                                    </h5>


                                    <button
                                        type="button"
                                        class="btn-close btn-close-white"
                                        data-bs-dismiss="modal"></button>


                                </div>


                                <div class="modal-body">

                                    <h6 class="border-bottom pb-2 mb-3">

                                        <i class="bi bi-shop"></i>

                                        Dados do Comércio

                                    </h6>


                                    <div class="row">


                                        <div class="col-md-6 mb-3">

                                            <strong>Nome:</strong>

                                            <div>

                                                <?= htmlspecialchars(
                                                    $empresa['nome'] ?? '-'
                                                ) ?>

                                            </div>

                                        </div>



                                        <div class="col-md-6 mb-3">

                                            <strong>Nome Fantasia:</strong>

                                            <div>

                                                <?= htmlspecialchars(
                                                    $empresa['nome_fantasia'] ?? '-'
                                                ) ?>

                                            </div>

                                        </div>



                                        <div class="col-md-6 mb-3">

                                            <strong>Razão Social:</strong>

                                            <div>

                                                <?= htmlspecialchars(
                                                    $empresa['razao_social'] ?? '-'
                                                ) ?>

                                            </div>

                                        </div>



                                        <div class="col-md-6 mb-3">

                                            <strong>CPF / CNPJ:</strong>

                                            <div>

                                                <?= htmlspecialchars(
                                                    $empresa['documento'] ?? '-'
                                                ) ?>

                                            </div>

                                        </div>



                                        <div class="col-md-6 mb-3">

                                            <strong>Ramo de Atividade:</strong>

                                            <div>

                                                <?= htmlspecialchars(
                                                    $empresa['ramo_atividade'] ?? '-'
                                                ) ?>

                                            </div>

                                        </div>


                                    </div>


                                    <h6 class="border-bottom pb-2 mb-3 mt-3">

                                        <i class="bi bi-telephone"></i>

                                        Contato

                                    </h6>


                                    <div class="row">


                                        <div class="col-md-6 mb-3">

                                            <strong>Responsável:</strong>

                                            <div>

                                                <?= htmlspecialchars(
                                                    $empresa['responsavel'] ?? '-'
                                                ) ?>

                                            </div>

                                        </div>



                                        <div class="col-md-6 mb-3">

                                            <strong>Telefone / WhatsApp:</strong>

                                            <div>

                                                <?= htmlspecialchars(
                                                    $empresa['telefone'] ?? '-'
                                                ) ?>

                                            </div>

                                        </div>



                                        <div class="col-md-12 mb-3">

                                            <strong>E-mail:</strong>

                                            <div>

                                                <?= htmlspecialchars(
                                                    $empresa['email'] ?? '-'
                                                ) ?>

                                            </div>

                                        </div>


                                    </div>


                                    <h6 class="border-bottom pb-2 mb-3 mt-3">

                                        <i class="bi bi-geo-alt"></i>

                                        Endereço

                                    </h6>


                                    <div class="row">


                                        <div class="col-md-9 mb-3">

                                            <strong>Endereço:</strong>

                                            <div>

                                                <?= htmlspecialchars(
                                                    $empresa['endereco'] ?? '-'
                                                ) ?>

                                            </div>

                                        </div>



                                        <div class="col-md-3 mb-3">

                                            <strong>CEP:</strong>

                                            <div>

                                                <?= htmlspecialchars(
                                                    $empresa['cep'] ?? '-'
                                                ) ?>

                                            </div>

                                        </div>


                                    </div>


                                    <h6 class="border-bottom pb-2 mb-3 mt-3">

                                        <i class="bi bi-credit-card"></i>

                                        Plano e Faturamento

                                    </h6>


                                    <div class="row">


                                        <div class="col-md-4 mb-3">

                                            <strong>Plano:</strong>

                                            <div>

                                                <?= htmlspecialchars(
                                                    $empresa['plano'] ?? '-'
                                                ) ?>

                                            </div>

                                        </div>



                                        <div class="col-md-4 mb-3">

                                            <strong>Valor Mensal:</strong>

                                            <div>


                                                <?php if (!empty($empresa['valor_mensal'])): ?>


                                                    R$

                                                    <?= number_format(
                                                        $empresa['valor_mensal'],
                                                        2,
                                                        ',',
                                                        '.'
                                                    ) ?>


                                                <?php else: ?>

                                                    -

                                                <?php endif; ?>


                                            </div>

                                        </div>



                                        <div class="col-md-4 mb-3">

                                            <strong>Vencimento:</strong>

                                            <div>


                                                <?php if (!empty($empresa['vencimento_dia'])): ?>

                                                    Dia
                                                    <?= $empresa['vencimento_dia'] ?>

                                                <?php else: ?>

                                                    -

                                                <?php endif; ?>


                                            </div>

                                        </div>


                                    </div>

                                    <h6 class="border-bottom pb-2 mb-3 mt-3">

                                        <i class="bi bi-gear"></i>

                                        Informações do Sistema

                                    </h6>


                                    <div class="row">


                                        <div class="col-md-4 mb-3">

                                            <strong>ID do Cliente:</strong>

                                            <div>

                                                #<?= $empresa['id'] ?>

                                            </div>

                                        </div>



                                        <div class="col-md-4 mb-3">

                                            <strong>Status:</strong>

                                            <div>


                                                <?php

                                                $statusClass = match ($empresa['status'] ?? '') {

                                                    'ativo' => 'success',

                                                    'teste' => 'warning',

                                                    'suspenso' => 'secondary',

                                                    'inadimplente' => 'danger',

                                                    default => 'dark'
                                                };

                                                ?>


                                                <span
                                                    class="badge bg-<?= $statusClass ?>">

                                                    <?= ucfirst(
                                                        $empresa['status'] ?? '-'
                                                    ) ?>

                                                </span>


                                            </div>

                                        </div>



                                        <div class="col-md-4 mb-3">

                                            <strong>Cliente desde:</strong>

                                            <div>


                                                <?php if (!empty($empresa['created_at'])): ?>

                                                    <?= date(
                                                        'd/m/Y H:i',
                                                        strtotime(
                                                            $empresa['created_at']
                                                        )
                                                    ) ?>

                                                <?php else: ?>

                                                    -

                                                <?php endif; ?>


                                            </div>

                                        </div>


                                    </div>


                                </div>


                                <div class="modal-footer">


                                    <a
                                        href="index.php?action=editarEmpresa&id=<?= $empresa['id'] ?>"
                                        class="btn btn-warning">

                                        <i class="bi bi-pencil"></i>

                                        Editar Cliente

                                    </a>


                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">

                                        Fechar

                                    </button>


                                </div>


                            </div>

                        </div>

                    </div>


                <?php endforeach; ?>


                <div
                    class="modal fade"
                    id="modalNovaEmpresa"
                    tabindex="-1"
                    aria-hidden="true">


                    <div class="modal-dialog modal-lg">


                        <div class="modal-content">


                            <form
                                action="index.php?action=salvarEmpresa"
                                method="post">


                                <!-- CABEÇALHO -->

                                <div class="modal-header">


                                    <h5 class="modal-title">

                                        <i class="bi bi-building"></i>

                                        Novo Cliente

                                    </h5>


                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"></button>


                                </div>



                                <div class="modal-body">

                                    <h6 class="border-bottom pb-2 mb-3">

                                        <i class="bi bi-shop"></i>

                                        Dados do Comércio

                                    </h6>


                                    <div class="row">


                                        <div class="col-md-6 mb-3">


                                            <label class="form-label">

                                                Razão Social

                                            </label>


                                            <input
                                                type="text"
                                                name="razao_social"
                                                class="form-control"
                                                placeholder="Razão Social"
                                                required>


                                        </div>



                                        <div class="col-md-6 mb-3">


                                            <label class="form-label">

                                                Nome Fantasia

                                            </label>


                                            <input
                                                type="text"
                                                name="nome_fantasia"
                                                id="nome_fantasia"
                                                class="form-control"
                                                placeholder="Nome na fachada"
                                                required>


                                        </div>



                                        <div class="col-md-6 mb-3">


                                            <label class="form-label">

                                                CPF / CNPJ

                                            </label>


                                            <input
                                                type="text"
                                                name="documento"
                                                class="form-control"
                                                placeholder="CPF ou CNPJ">


                                        </div>



                                        <div class="col-md-6 mb-3">


                                            <label class="form-label">

                                                Ramo de Atividade

                                            </label>


                                            <input
                                                type="text"
                                                name="ramo_atividade"
                                                class="form-control"
                                                placeholder="Ex: Mercado, Adega, Loja">


                                        </div>


                                    </div>

                                    <h6 class="border-bottom pb-2 mb-3 mt-2">

                                        <i class="bi bi-telephone"></i>

                                        Contato

                                    </h6>


                                    <div class="row">


                                        <div class="col-md-6 mb-3">


                                            <label class="form-label">

                                                E-mail Principal

                                            </label>


                                            <input
                                                type="email"
                                                name="email"
                                                class="form-control"
                                                placeholder="email@empresa.com">


                                        </div>



                                        <div class="col-md-6 mb-3">


                                            <label class="form-label">

                                                Telefone / WhatsApp

                                            </label>


                                            <input
                                                type="text"
                                                name="telefone"
                                                class="form-control"
                                                placeholder="(21) 99999-9999">


                                        </div>



                                        <div class="col-md-6 mb-3">


                                            <label class="form-label">

                                                Responsável

                                            </label>


                                            <input
                                                type="text"
                                                name="responsavel"
                                                class="form-control"
                                                placeholder="Nome do responsável">


                                        </div>


                                    </div>



                                    <h6 class="border-bottom pb-2 mb-3 mt-2">

                                        <i class="bi bi-geo-alt"></i>

                                        Endereço

                                    </h6>


                                    <div class="row">


                                        <div class="col-md-9 mb-3">


                                            <label class="form-label">

                                                Endereço Completo

                                            </label>


                                            <input
                                                type="text"
                                                name="endereco"
                                                class="form-control"
                                                placeholder="Rua, Número, Bairro e Cidade">


                                        </div>



                                        <div class="col-md-3 mb-3">


                                            <label class="form-label">

                                                CEP

                                            </label>


                                            <input
                                                type="text"
                                                name="cep"
                                                class="form-control"
                                                placeholder="00000-000">


                                        </div>


                                    </div>

                                    <h6 class="border-bottom pb-2 mb-3 mt-2">

                                        <i class="bi bi-credit-card"></i>

                                        Plano e Faturamento

                                    </h6>


                                    <div class="row">


                                        <div class="col-md-4 mb-3">


                                            <label class="form-label">

                                                Plano

                                            </label>


                                            <input
                                                type="text"
                                                name="plano"
                                                class="form-control"
                                                placeholder="Plano">


                                        </div>



                                        <div class="col-md-4 mb-3">


                                            <label class="form-label">

                                                Valor Mensal

                                            </label>


                                            <input
                                                type="number"
                                                name="valor_mensal"
                                                step="0.01"
                                                min="0"
                                                class="form-control"
                                                placeholder="0,00">


                                        </div>



                                        <div class="col-md-4 mb-3">


                                            <label class="form-label">

                                                Vencimento

                                            </label>


                                            <select
                                                name="vencimento_dia"
                                                class="form-select">


                                                <option value="">

                                                    Selecione

                                                </option>


                                                <?php for ($dia = 1; $dia <= 31; $dia++): ?>


                                                    <option value="<?= $dia ?>">

                                                        Dia <?= $dia ?>

                                                    </option>


                                                <?php endfor; ?>


                                            </select>


                                        </div>


                                    </div>


                                    <h6 class="border-bottom pb-2 mb-3 mt-2">

                                        <i class="bi bi-gear"></i>

                                        Status

                                    </h6>


                                    <select
                                        name="status"
                                        class="form-select">


                                        <option value="teste">

                                            Teste

                                        </option>


                                        <option value="ativo">

                                            Ativo

                                        </option>


                                        <option value="suspenso">

                                            Suspenso

                                        </option>


                                        <option value="inadimplente">

                                            Inadimplente

                                        </option>


                                    </select>


                                    <input
                                        type="hidden"
                                        name="nome"
                                        id="nome"
                                        value="">


                                </div>



                                <!-- RODAPÉ -->

                                <div class="modal-footer">


                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">

                                        Cancelar

                                    </button>


                                    <button
                                        type="submit"
                                        class="btn btn-primary">

                                        <i class="bi bi-check-lg"></i>

                                        Salvar Cliente

                                    </button>


                                </div>


                            </form>


                        </div>

                    </div>

                </div>


            </main>

        </div>

    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        const nomeFantasia =
            document.getElementById('nome_fantasia');

        const nome =
            document.getElementById('nome');


        if (nomeFantasia && nome) {

            nomeFantasia.addEventListener(
                'input',
                function() {

                    nome.value = this.value;

                }
            );

        }


        setTimeout(function() {

            const alert =
                document.querySelector('.alert');

            if (alert) {

                alert.remove();

            }

        }, 3000);
    </script>


</body>

</html>