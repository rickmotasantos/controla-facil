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

        <h3>Editar Cliente</h3>

        <form method="POST" action="index.php?action=atualizarEmpresa">

            <input type="hidden" name="id" value="<?= $empresa['id'] ?>">

            <input name="nome"
                class="form-control mb-2"
                value="<?= $empresa['nome'] ?>"
                required>

            <input name="responsavel"
                class="form-control mb-2"
                value="<?= $empresa['responsavel'] ?>">

            <input name="telefone"
                class="form-control mb-2"
                value="<?= $empresa['telefone'] ?>">

            <input name="plano"
                class="form-control mb-2"
                value="<?= $empresa['plano'] ?>">

            <input name="valor_mensal"
                type="number"
                step="0.01"
                class="form-control mb-2"
                value="<?= $empresa['valor_mensal'] ?>">

            <input name="vencimento_dia"
                type="number"
                class="form-control mb-2"
                value="<?= $empresa['vencimento_dia'] ?>">

            <select name="status" class="form-control mb-3">

                <option value="ativo" <?= $empresa['status'] == 'ativo' ? 'selected' : '' ?>>
                    Ativo
                </option>

                <option value="teste" <?= $empresa['status'] == 'teste' ? 'selected' : '' ?>>
                    Teste
                </option>

                <option value="suspenso" <?= $empresa['status'] == 'suspenso' ? 'selected' : '' ?>>
                    Suspenso
                </option>

                <option value="inadimplente" <?= $empresa['status'] == 'inadimplente' ? 'selected' : '' ?>>
                    Inadimplente
                </option>

            </select>

            <button class="btn btn-success">
                Salvar Alterações
            </button>

        </form>

    </div>
</body>

</html>