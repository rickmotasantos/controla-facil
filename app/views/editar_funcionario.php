<?php

require_once __DIR__ . '/../middlewares/auth.php';
require_once __DIR__ . '/../middlewares/permissao.php';

somenteEmpresa();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Editar Funcionário</title>

</head>

<body class="bg-light">

    <div class="container py-4">

        <div class="card shadow-sm">

            <div class="card-header bg-primary text-white">

                <i class="bi bi-person-gear"></i>

                Editar Funcionário

            </div>

            <div class="card-body">

                <form
                    method="post"
                    action="index.php?action=atualizar_funcionario">

                    <!-- ID -->

                    <input
                        type="hidden"
                        name="id"
                        value="<?= $funcionario['id'] ?>">

                    <!-- NOME -->

                    <div class="mb-3">

                        <label class="form-label">
                            Nome
                        </label>

                        <input
                            type="text"
                            name="nome"
                            class="form-control"
                            value="<?= htmlspecialchars($funcionario['nome']) ?>"
                            required>

                    </div>

                    <!-- SENHA -->

                    <div class="mb-3">

                        <label class="form-label">
                            Nova senha
                        </label>

                        <input
                            type="password"
                            name="senha"
                            class="form-control">

                        <div class="form-text">
                            Deixe em branco para manter a senha atual.
                        </div>

                    </div>

                    <!-- BOTÕES -->

                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-check-lg"></i>

                            Salvar alterações

                        </button>

                        <a
                            href="index.php?action=funcionarios"
                            class="btn btn-secondary">

                            <i class="bi bi-arrow-left"></i>

                            Voltar

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>