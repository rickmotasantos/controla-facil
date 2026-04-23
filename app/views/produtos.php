<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
    <title>Produtos</title>
</head>

</html>

<body>
    <div class="dropdown bg-primary p-2 text-end">
        <button class="btn text-white d-flex align-items-center gap-2 dropdown-toggle" type="button" data-bs-toggle="dropdown">

            <i class="bi bi-person-circle" style="font-size: 20px;"></i>

            <span><?= $_SESSION['usuario_nome'] ?? 'Usuário' ?></span>

        </button>

        <ul class="dropdown-menu dropdown-menu-end mt-2">

            <li>
                <a class="dropdown-item" href="index.php?action=perfil">
                    <i class="bi bi-person"></i> Perfil
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="index.php?action=alterar_senha">
                    <i class="bi bi-key"></i> Alterar senha
                </a>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <a class="dropdown-item text-danger" href="index.php?action=logout" onclick="return confirm('Tem certeza que deseja sair?')">
                    <i class="bi bi-box-arrow-right"></i> Sair
                </a>
            </li>

        </ul>
    </div>
    <div class="container p-2">
        <h3 class="mb-3 text-center">Sistema Comércio</h3>

        <div class="gap-2 d-flex justify-content-center flex-wrap mb-3">

            <a class="btn btn-primary" href="index.php">Home</a>
            <a class="btn btn-success" href="index.php?action=vendas">Venda</a>
            <a class="btn btn-warning" href="index.php?action=historico">Histórico</a>
            <a class="btn btn-dark" href="index.php?action=dashboard">Dashboard</a>
            <a class="btn btn-info" href="index.php?action=entrada">Estoque</a>
            <?php if (($_SESSION['tipo'] ?? '') === 'admin'): ?>
                <a class="btn btn-danger" href="index.php?action=admin_dashboard">Admin - Empresas</a>
                <i class="bi bi-shield-lock"></i>
            <?php endif; ?>

        </div>

        <hr>

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-<?= $_SESSION['msg_tipo'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['msg'] ?>
            </div>
        <?php unset($_SESSION['msg'], $_SESSION['msg_tipo']);
        endif; ?>

        <h5 class="m-2">Cadastrar Produtos</h5>

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
                            </td>
                            <td data-label="Código"><?= $p['codigo'] ?></td>
                            <td data-label="Nome"><?= $p['nome'] ?></td>
                            <td data-label="Preço">R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                            <td data-label="Qtd"><?php if ($p['quantidade'] == 0): ?>
                                    <span class="badge bg-danger p-2">Sem est.</span>
                                <?php elseif ($p['quantidade'] <= 5): ?>
                                    <span class="badge bg-warning text-dark p-2">Est. baixo</span>
                                <?php else: ?>
                                    <span class="badge bg-success p-2">Disponível</span>
                                <?php endif; ?> - 
                                <span class="badge border border-black text-black"><?= $p['quantidade'] ?></span>
                            </td>
                            <td data-label="Ações" class="d-flex flex-wrap gap-2 justify-content-center">
                                <div class="acoes-btns">
                                    <a href="index.php?action=editar&id=<?= $p['id'] ?>" class="mb-1 btn btn-warning btn-sm">Editar</a>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
</script>
<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) alert.remove();
    }, 3000);
</script>