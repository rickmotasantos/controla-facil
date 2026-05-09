<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
    <title>Cadastrar Funcionário</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <button class="btn btn-primary mb-4">
            <a class="text-decoration-none text-white" href="index.php?action=home">Voltar</a>
        </button>
        <div class="card shadow p-4">
            <h3 class="mb-4">Cadastrar Funcionário</h3>

            <form method="post" action="index.php?action=salvar_funcionário">
                <div class="mb-3">
                    <label for="Nome">Nome</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="">Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
        </div>
    </div>
</body>
</html>