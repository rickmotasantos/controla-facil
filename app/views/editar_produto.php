<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
    <title>Editar Produto</title>
</head>

<body>
    <div class="container mt-4">

        <h1 class="mb-4">Sistema Comércio</h1>

        <nav class="mb-4">
            <a class="btn btn-primary" href="index.php">Voltar</a>
        </nav>

        <hr>
        
        <h2>Editar Produto</h2>

        <form method="post" action="index.php?action=atualizar" class="row g-3">
            <input class="form-control" type="hidden" name="id" value="<?= $dados['id'] ?>">
            <input type="text" name="nome" value="<?= $dados['nome'] ?>">
            <input type="number" step="0.01" name="preco" value="<?= $dados['preco'] ?>" required>
            <input type="hidden" name="quantidade" value="<?= $dados['quantidade'] ?>" required>
            <input type="number" name="codigo" value="<?= $dados['codigo'] ?>" required>

            <button class="btn btn-success" type="submit">Atualizar</button>
        </form>
    </div>
</body>
</html>