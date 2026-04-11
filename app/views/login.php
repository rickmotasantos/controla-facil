<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/png">
    <title>Login</title>
</head>

<body class="d-flex flex-column justify-content-center align-items-center vh-100 bg-dark">
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-<?= $_SESSION['msg_tipo'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['msg'] ?>
        </div>

    <?php unset($_SESSION['msg'], $_SESSION['msg_tipo']);
    endif; ?>
    <div class="text-center">
        <img src="/meusSistemas/sistema-comercio/public/assets/logoMn.png" alt="Logo" style="width:320px;" class="img-fluid">
    </div>
    <div class="card p-4 shadow" style="width: 300px;">
        <form method="POST" action="index.php?action=autenticar">

            <h2 class="text-center mb-3 ">Login</h2>

            <input type="text" name="nome" placeholder="nome" required class="form-control mb-2">

            <input type="password" name="senha" placeholder="Senha" required class="form-control mb-3">

            <button class="btn btn-primary w-100">Entrar</button>
        </form>
        <p class="text-center text-muted small m-3">Gestão simples para seu negócio</p>
    </div>

    <p class="text-white mt-4">&copy; <?php echo date('Y'); ?> - Todos os direitos reservados.</p>
    <p class="text-secondary" style="font-size: 12px;">Desenvolvido por: <span class="text-info">rob.infotech</span></p>
</body>

</html>
<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) alert.remove();
    }, 3000);
</script>