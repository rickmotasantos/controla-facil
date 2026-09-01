<?php
require_once __DIR__ . '/../middlewares/auth.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Fechamento de Caixa</title>
</head>

<body>
    <div class="container py-4">

        <div class="row align-items-center mb-3">
            <div class="col-12 col-md-6 d-flex align-items-center gap-3">
                <h3 class="fs-5 fs-md-3 mb-0">Fechamento de Caixa</h3>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-calendar"></i>
                    <p class="mb-0">
                        <?php
                        $dias = [
                            'Sunday' => 'domingo',
                            'Monday' => 'segunda-feira',
                            'Tuesday' => 'terça-feira',
                            'Wednesday' => 'quarta-feira',
                            'Thursday' => 'quinta-feira',
                            'Friday' => 'sexta-feira',
                            'Saturday' => 'sábado'
                        ];
                        echo date('d/m/y') . ', ' . ($dias[date('l')]);
                        ?>
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-end gap-2 mt-3 mt-md-0">
                <a href="index.php?action=home" class="text-decoration-none">
                    <div class="bg-dark rounded d-flex align-items-center gap-2 text-white fw-bold p-2 px-3 small">
                        <i class="bi bi-arrow-left"></i>
                        Voltar
                    </div>
                </a>
            </div>
        </div>

        <div class="row my-4 border p-4 shadow rounded">
            <div class="col-12 col-md-6 d-flex align-items-center mb-3 mb-md-0">
                <div class="fw-bold text-primary bg-light rounded border me-2 p-2 shadow">
                    <i class="bi bi-coin fs-1"></i>
                </div>
                <div>
                    <h3 class="text-uppercase fs-6">Total de todos os Funcionários</h3>
                    <div class="fs-1 fw-bold text-success">R$ <?= number_format($totalGeral, 2, ',', '.') ?></div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="alert alert-success d-flex align-items-center justify-content-sm-end" role="alert">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    <p class="text-success fw-bold text-uppercase mb-0">Caixa do dia fechado</p>
                </div>
            </div>
        </div>

        <?php foreach ($funcionarios as $funcionario): ?>

            <div class="my-4 border p-4 shadow rounded">
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <i class="bi bi-person-circle fs-1 text-primary me-2"></i>
                        <div>
                            <span class="fw-bold fs-5"><?= htmlspecialchars($funcionario['nome']) ?></span>
                            <p class="mb-0">Nº: <span>#<?= str_pad($funcionario['id'], 3, '0', STR_PAD_LEFT) ?></span></p>
                        </div>
                    </div>
                    <div class="alert alert-success py-1 px-2">
                        <span class="text-success fw-bold">Fechado</span>
                    </div>
                </div>

                <hr class="my-3">

                <div class="row g-3">
                    <div class="col-12 col-md-3">
                        <div class="d-flex border rounded p-3">
                            <div class="text-success me-3"><i class="bi bi-piggy-bank-fill fs-2"></i></div>
                            <div class="text-center">
                                <p class="mb-0">Dinheiro</p>
                                <span class="text-success fw-bold fs-6">R$ <?= number_format($funcionario['dinheiro'], 2, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex border rounded p-3">
                            <div class="text-primary me-3"><i class="bi bi-credit-card-fill fs-2"></i></div>
                            <div class="text-center">
                                <p class="mb-0">Cartão</p>
                                <span class="text-primary fw-bold fs-6">R$ <?= number_format($funcionario['cartao'], 2, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex border rounded p-3">
                            <div class="text-info me-3"><i class="bi bi-cash-stack fs-2"></i></div>
                            <div class="text-center">
                                <p class="mb-0">Pix</p>
                                <span class="text-info fw-bold fs-6">R$ <?= number_format($funcionario['pix'], 2, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex border rounded p-3">
                            <div class="text-center w-100">
                                <p class="mb-0">Total do Funcionário</p>
                                <span class="fw-bold fs-5">R$ <?= number_format($funcionario['total'], 2, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h3 class="fs-6">Total de Vendas <span class="text-muted fs-6">(<?= number_format($funcionario['quantidade_mercadoria'] ?? 0, 0, ',', '.') ?> - <?php echo ($funcionario['quantidade_mercadoria'] == 1) ? 'venda' : 'Vendas'; ?>)</span></h3>
                    <div class="table-responsive-sm" style="max-height:200px; overflow-y:auto;">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="text-center bg-light" style="position: sticky; top: 0; z-index: 1;">
                                <tr>
                                    <th>Produto</th>
                                    <th>Qtd.</th>
                                    <th>Valor uni.</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php foreach ($funcionario['produtos'] as $produto): ?>
                                    <tr>
                                        <td>
                                            <?= htmlspecialchars($produto['produto_nome']) ?>
                                        </td>
                                        <td>
                                            <?= number_format($produto['quantidade'], 2, ',', '.') ?>
                                        </td>
                                        <td>
                                            <?= number_format($produto['preco'], 2, ',', '.') ?>
                                        </td>
                                        <td>
                                            <?= number_format($produto['total'], 2, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- <div class="d-flex justify-content-end mt-2">
                        <a href="" class="text-decoration-none">
                            <div class="text-white border bg-danger rounded d-flex align-items-center gap-2 fw-bold p-2 small">
                                <i class="bi bi-file-earmark-pdf"></i>
                                baixar PDF
                            </div>
                        </a>
                    </div> -->
                    <div class="d-flex justify-content-end mt-2">
                        <a href="index.php?action=imprimirFechamento&usuario_id=<?= (int)$funcionario['id'] ?>"
                            class="text-decoration-none">

                            <div class="text-primary border border-primary rounded d-flex align-items-center gap-2 fw-bold p-2 small">
                                <i class="bi bi-printer-fill"></i>
                                <span>Imprimir Fechamento</span>
                            </div>

                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="border shadow rounded p-4">
            <h3 class="fw-bold fs-5 mb-3">Resumo geral do dia</h3>
            <div class="row g-3">
                <div class="col-12 col-md-3">
                    <div class="d-flex border rounded p-3">
                        <div class="text-success me-3"><i class="bi bi-piggy-bank-fill fs-2"></i></div>
                        <div class="text-center">
                            <p class="mb-0">Total em dinheiro</p>
                            <span class="text-success fw-bold fs-6">R$<?= number_format($totalDinheiro, 2, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="d-flex border rounded p-3">
                        <div class="text-primary me-3"><i class="bi bi-credit-card-fill fs-2"></i></div>
                        <div class="text-center">
                            <p class="mb-0">Total em cartão</p>
                            <span class="text-primary fw-bold fs-6">R$<?= number_format($totalCartao, 2, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="d-flex border rounded p-3">
                        <div class="text-info me-3"><i class="bi bi-cash-stack fs-2"></i></div>
                        <div class="text-center">
                            <p class="mb-0">Total em Pix</p>
                            <span class="text-info fw-bold fs-6">R$<?= number_format($totalPix, 2, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="d-flex border rounded p-3">
                        <div class="text-center">
                            <p class="mb-0">Total Geral</p>
                            <span class="fw-bold fs-2">R$<?= number_format($totalGeral, 2, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
                <!-- <div class="d-flex justify-content-end mt-2">
                    <a href="" class="text-decoration-none">
                        <div class="text-white border bg-danger rounded d-flex align-items-center gap-2 fw-bold p-2 small">
                            <i class="bi bi-file-earmark-pdf"></i>
                            baixar PDF
                        </div>
                    </a>
                </div> -->
                <div class="d-flex justify-content-end mt-2">
                    <a href="index.php?action=imprimirRelatorioCompleto"
                        class="text-decoration-none">

                        <div class="text-white border bg-primary rounded d-flex align-items-center gap-2 fw-bold p-2 small">
                            <i class="bi bi-printer-fill"></i>
                            <span>Imprimir Relatório Completo</span>
                        </div>

                    </a>
                </div>

</body>

</html>