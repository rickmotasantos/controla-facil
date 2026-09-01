<?php
require_once __DIR__ . '/../../middlewares/permissao.php';

somenteAdmin();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <title>Editar Empresa</title>
</head>

<body>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>
            <i class="bi bi-building"></i>
            Editar Cliente
        </h3>

        <a href="index.php?action=admin_dashboard" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Voltar
        </a>
    </div>

    <form method="POST" action="index.php?action=atualizarEmpresa">

        <input type="hidden" name="id" value="<?= htmlspecialchars($empresa['id']) ?>">

        <!-- DADOS DO COMÉRCIO -->

        <div class="card mb-4">

            <div class="card-header">
                <strong>
                    <i class="bi bi-shop"></i>
                    Dados do Comércio
                </strong>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Razão Social
                        </label>

                        <input
                            type="text"
                            name="razao_social"
                            class="form-control"
                            value="<?= htmlspecialchars($empresa['razao_social'] ?? '') ?>"
                            placeholder="Razão Social"
                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nome Fantasia
                        </label>

                        <input
                            type="text"
                            name="nome_fantasia"
                            class="form-control"
                            value="<?= htmlspecialchars($empresa['nome_fantasia'] ?? '') ?>"
                            placeholder="Nome que aparece na fachada"
                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            CPF / CNPJ
                        </label>

                        <input
                            type="text"
                            name="documento"
                            class="form-control"
                            value="<?= htmlspecialchars($empresa['documento'] ?? '') ?>"
                            placeholder="CPF ou CNPJ"
                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Ramo de Atividade
                        </label>

                        <input
                            type="text"
                            name="ramo_atividade"
                            class="form-control"
                            value="<?= htmlspecialchars($empresa['ramo_atividade'] ?? '') ?>"
                            placeholder="Ex: Mercado, Adega, Loja"
                        >

                    </div>

                </div>

            </div>

        </div>


        <!-- CONTATO -->

        <div class="card mb-4">

            <div class="card-header">

                <strong>
                    <i class="bi bi-telephone"></i>
                    Contato
                </strong>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            E-mail Principal
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="<?= htmlspecialchars($empresa['email'] ?? '') ?>"
                            placeholder="email@empresa.com"
                        >

                        <small class="text-muted">
                            E-mail para receber alertas e informações de faturamento.
                        </small>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Telefone / WhatsApp
                        </label>

                        <input
                            type="text"
                            name="telefone"
                            class="form-control"
                            value="<?= htmlspecialchars($empresa['telefone'] ?? '') ?>"
                            placeholder="(21) 99999-9999"
                        >

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Responsável
                        </label>

                        <input
                            type="text"
                            name="responsavel"
                            class="form-control"
                            value="<?= htmlspecialchars($empresa['responsavel'] ?? '') ?>"
                            placeholder="Nome do responsável"
                        >

                    </div>

                </div>

            </div>

        </div>


        <!-- ENDEREÇO -->

        <div class="card mb-4">

            <div class="card-header">

                <strong>
                    <i class="bi bi-geo-alt"></i>
                    Endereço
                </strong>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-9 mb-3">

                        <label class="form-label">
                            Endereço Completo
                        </label>

                        <input
                            type="text"
                            name="endereco"
                            class="form-control"
                            value="<?= htmlspecialchars($empresa['endereco'] ?? '') ?>"
                            placeholder="Rua, Número, Bairro e Cidade"
                        >

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            CEP
                        </label>

                        <input
                            type="text"
                            name="cep"
                            class="form-control"
                            value="<?= htmlspecialchars($empresa['cep'] ?? '') ?>"
                            placeholder="00000-000"
                        >

                    </div>

                </div>

            </div>

        </div>


        <!-- DADOS DO PLANO -->

        <div class="card mb-4">

            <div class="card-header">

                <strong>
                    <i class="bi bi-credit-card"></i>
                    Plano e Faturamento
                </strong>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Plano
                        </label>

                        <input
                            type="text"
                            name="plano"
                            class="form-control"
                            value="<?= htmlspecialchars($empresa['plano'] ?? '') ?>"
                            placeholder="Nome do plano"
                        >

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Valor Mensal
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="valor_mensal"
                            class="form-control"
                            value="<?= htmlspecialchars($empresa['valor_mensal'] ?? '') ?>"
                            placeholder="0,00"
                        >

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Dia do Vencimento
                        </label>

                        <select name="vencimento_dia" class="form-select">

                            <option value="">
                                Selecione
                            </option>

                            <?php for ($dia = 1; $dia <= 31; $dia++): ?>

                                <option
                                    value="<?= $dia ?>"
                                    <?= ($empresa['vencimento_dia'] ?? '') == $dia ? 'selected' : '' ?>
                                >
                                    Dia <?= $dia ?>
                                </option>

                            <?php endfor; ?>

                        </select>

                    </div>

                </div>

            </div>

        </div>


        <!-- SISTEMA -->

        <div class="card mb-4">

            <div class="card-header">

                <strong>
                    <i class="bi bi-gear"></i>
                    Configuração do Sistema
                </strong>

            </div>

            <div class="card-body">

                <label class="form-label">
                    Status da Empresa
                </label>

                <select name="status" class="form-select">

                    <option
                        value="ativo"
                        <?= ($empresa['status'] ?? '') == 'ativo' ? 'selected' : '' ?>
                    >
                        Ativo
                    </option>

                    <option
                        value="teste"
                        <?= ($empresa['status'] ?? '') == 'teste' ? 'selected' : '' ?>
                    >
                        Teste
                    </option>

                    <option
                        value="suspenso"
                        <?= ($empresa['status'] ?? '') == 'suspenso' ? 'selected' : '' ?>
                    >
                        Suspenso
                    </option>

                    <option
                        value="inadimplente"
                        <?= ($empresa['status'] ?? '') == 'inadimplente' ? 'selected' : '' ?>
                    >
                        Inadimplente
                    </option>

                </select>

            </div>

        </div>


        <div class="d-flex gap-2">

            <button type="submit" class="btn btn-success btn-lg">

                <i class="bi bi-check-lg"></i>

                Salvar Alterações

            </button>

            <a
                href="index.php?action=admin_dashboard"
                class="btn btn-secondary btn-lg"
            >

                Cancelar

            </a>

        </div>

    </form>

</div>

</body>

</html>