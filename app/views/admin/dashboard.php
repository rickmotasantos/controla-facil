<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <title>Painel Admin</title>
    <style>
        body{
            background-color: #F5F6FA;
        }

        .card-hover {
            transition: 0.3s;
        }

        .card-hover:hover{
            transform: scale(1.03);
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <h2 class="mb-4 text-center">Painel Administrativo</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary shadow card-hover">
                    <div class="card-body text-center">
                        <i class="bi bi-people-fill fs-1"></i>
                        <h5 class="card-title mt-2">Usuário</h5>
                        <h2><?=  $usuarios['total'] ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

       <div class="col-md-4">
            <div class="card text-white bg-success shadow card-hover">
                <div class="card-body text-center">
                    <i class="bi bi-building fs-1"></i>
                    <h5 class="card-title mt-2">Empresas</h5>
                    <h2><?= $empresas['total'] ?></h2>
                </div>
            </div>
        </div>
</body>
</html>