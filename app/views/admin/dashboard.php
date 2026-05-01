<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Painel Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container-fluid">
    <div class="row min-vh-100">

      <aside class="col-md-2 bg-dark text-white p-4">
        <h4 class="mb-4">Admin</h4>

        <div class="d-grid gap-2">
          <a href="#" class="btn btn-outline-light text-start">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>

          <a href="#" class="btn btn-outline-light text-start">
            <i class="bi bi-buildings"></i> Clientes
          </a>

          <a href="#" class="btn btn-outline-light text-start">
            <i class="bi bi-people"></i> Usuários
          </a>

          <a href="#" class="btn btn-outline-light text-start">
            <i class="bi bi-cash-stack"></i> Financeiro
          </a>

          <a href="#" class="btn btn-outline-light text-start">
            <i class="bi bi-gear"></i> Configurações
          </a>

          <a href="index.php?action=home" class="btn btn-primary text-start mt-4">
            <i class="bi bi-house"></i> Home
          </a>
        </div>
      </aside>

      <main class="col-md-10 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2>Painel Administrativo</h2>

          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovaEmpresa">+ Novo Cliente</button>
        </div>

        <div class="row g-3 mb-4">
          <div class="col-md-3">
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <h6 class="text-center">Total de Clientes</h6>
                <h3 class="text-center"><?= $empresas['total'] ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <h6 class="text-center">Total Usuários</h6>
                <h3 class="text-center"><?= $usuarios['total'] ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <h6 class="text-center">Clientes Ativos</h6>
                <h3 class="text-center"><?= $ativas['total'] ?></h3>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card shadow-sm border-0">
              <div class="card-body">
                <h6 class="text-center">Receita Total SaaS</h6>
                <h3 class="text-center">R$ <?= number_format($mensalidades['total'] ?? 0, 2, ',', '.') ?></h3>
              </div>
            </div>
          </div>
        </div>

        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="mb-3">Clientes Cadastrados</h5>

            <div class="table-responsive">
              <table class="table table-bordered align-middle">
                <thead>
                  <tr>
                    <th>Empresa</th>
                    <th>Responsável</th>
                    <th>Plano</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($listaEmpresas as $empresa): ?>
                    <tr>
                      <td><?= $empresa['nome'] ?></td>
                      <td><?= $empresa['responsavel'] ?></td>
                      <td><?= $empresa['plano'] ?></td>
                      <td>
                        <?= $empresa['valor_mensal']
                          ? 'R$ ' . number_format($empresa['valor_mensal'], 2, ',', '.')
                          : '-' ?>
                      </td>
                      <td><?= ucfirst($empresa['status']) ?></td>
                      <td>
                        <a href="index.php?action=editarEmpresa&id=<?= $empresa['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="index.php?action=excluirEmpresa&id=<?= $empresa['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        <?php if($empresa['status'] == 'ativo'):?>
                          <a href="index.php?action=alterarStatusEmpresa&id=<?= $empresa['id'] ?>&status=suspenso" class="btn btn-secondary btn-sm" onclick="return confirm('Deseja inativer este cliente')">Inativar</a>
                          <?php else:?>
                            <a href="index.php?action=alterarStatusEmpresa&id=<?= $empresa['id']?>&status=ativo" class="btn btn-success btn-sm" onclick="return confirm('Deseja ativar esta cliente')">Ativar</a>
                            <?php endif;?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal fade" id="modalNovaEmpresa" tabeindex="-1" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="index.php?action=salvarEmpresa" method="post">
                <div class="modal-header">
                  <h5>Novo Cliente</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                  <input name="nome" class="form-control mb-2" placeholder="Nome da empresa" required>
                  <input name="responsavel" class="form-control mb-2" placeholder="Responsável">
                  <input name="telefone" class="form-control mb-2" placeholder="Telefone">
                  <input name="plano" class="form-control mb-2" placeholder="Plano">
                  <input name="valor_mensal" type="number" step="0.01" class="form-control mb-2" placeholder="Valor Mensal">
                  <input name="vencimento_dia" type="number" class="form-control" placeholder="dia do vencimento">

                  <select name="status" class="form-control" id="">
                    <option value="ativo">Ativo</option>
                    <option value="teste">Teste</option>
                    <option value="suspenso">Suspenso</option>
                  </select>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>