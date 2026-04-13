<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
    <title>Produtos</title>
</head>

</html>

<body>
    <div class="bg-dark text-white position-fixed top-0 start-0 w-100 d-flex align-items-center" style="height: 60px; z-index:1000;">
        <div class="container d-flex align-items-center justify-content-between py-2">
            <div></div>

            <div class="text-center text-white fw-bold d-flex align-items-center gap-1">
                <div>Usuário:</div><?= $_SESSION['usuario_nome'] ?? 'Usuario:' ?>
            </div>

            <div>
                <a href="index.php?action=logout" onclick="return confirm('Tem certeza que deseja sair')" class="btn btn-outline-danger">
                    Sair
                </a>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 80px;">

        <h3 class="mb-3 text-center text-md-start">Sistema Comércio</h3>

        <div class="d-grid gap-2 d-md-flex mb-3">

            <a class="btn btn-primary" href="index.php">Home</a>
            <a class="btn btn-success" href="index.php?action=vendas">Venda</a>
            <a class="btn btn-warning" href="index.php?action=historico">Histórico</a>
            <a class="btn btn-dark" href="index.php?action=dashboard">Dashboard</a>
            <a class="btn btn-info" href="index.php?action=entrada">Estoque</a>

        </div>

        <hr>

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-<?= $_SESSION['msg_tipo'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['msg'] ?>
            </div>
        <?php unset($_SESSION['msg'], $_SESSION['msg_tipo']);
        endif; ?>

        <h5 class="row g-2 mb-4">Cadastrar Produtos</h5>

        <form method="post" action="index.php?action=salvar" class="row g-2 mb-4">

            <div class="col-12">
                <input type="text" name="codigo" class="form-control" placeholder="Código" required>
            </div>

            <div class="col-12">
                <input type="text" name="nome" class="form-control" placeholder="Nome" required>
            </div>

            <div class="col-12">
                <input type="number" step="0.01" name="preco" class="form-control" placeholder="Preço" required>
            </div>

            <div class="col-12">
                <input type="number" name="quantidade" class="form-control" placeholder="Qtd" required>
            </div>

            <div class="col-12">
                <button class="btn btn-success w-100">Salvar</button>
            </div>

        </form>

        <h5 class="mb-3">Lista de Produtos</h5>

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
                    <?php foreach ($produtos as $p): ?>
                        <tr>
                            <td data-label="Código"><?= $p['codigo'] ?></td>
                            <td data-label="Nome"><?= $p['nome'] ?></td>
                            <td data-label="Preço">R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                            <td data-label="Qtd"><?= $p['quantidade'] ?></td>
                            <td data-label="Ações" class="d-flex flex-wrap gap-2 justify-content-center">
                                <div class="acoes-btns">
                                    <a href="index.php?action=editar&id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="index.php?action=excluir&id=<?= $p['id'] ?>"
                                        onclick="return confirm('Tem certeza?')"
                                        class="btn btn-danger btn-sm">Excluir</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>
</body>
<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) alert.remove();
    }, 3000);
</script>