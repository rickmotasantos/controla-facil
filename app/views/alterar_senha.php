<?php require_once __DIR__ . '/../middlewares/auth.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark ">
    <div class="container d-flex justify-content-center align-items-center vh-100">

        <div class="card p-4 shadow w-100" style="width: 350px;">

            <h3 class="text-center mb-3">Alterar Senha</h3>

            <?php if (isset($_SESSION['msg'])): ?>
                <div class="alert alert-<?= $_SESSION['msg_tipo'] ?>">
                    <?= $_SESSION['msg'] ?>
                </div>
                <?php unset($_SESSION['msg'], $_SESSION['msg_tipo']); ?>
            <?php endif; ?>

            <form method="POST" action="index.php?action=salvar_senha">

                <input type="password" name="senha_atual" class="form-control mb-2" placeholder="Senha atual" required>

                <input type="password" name="nova_senha" class="form-control mb-2" placeholder="Nova senha" required>

                <input type="password" name="confirmar_senha" class="form-control mb-3" placeholder="Confirmar senha" required>

                <button class="btn btn-primary w-100">Salvar</button>

            </form>

            <a href="index.php" class="btn btn-secondary w-100 mt-2">Voltar</a>

        </div>
    </div>

</body>

</html>