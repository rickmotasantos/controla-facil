<?php
require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../models/Venda.php";
require_once __DIR__ . "/../models/Empresa.php";

class VendaController
{

    public function salvar()
    {

        $pdo = conectarBanco();

        $produto_id = $_POST['produto_id'] ?? null;
        $quantidade = (float) str_replace(',', '.', $_POST['quantidade']);
        $empresa_id = $_SESSION['empresa_id'];
        $forma_pagamento = $_POST['forma_pagamento'] ?? '';

        $stmt = $pdo->prepare(" SELECT * FROM produtos WHERE id = ? AND empresa_id = ? ");
        $stmt->execute([$produto_id, $empresa_id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produto_id) {
            $_SESSION['msg'] = "Produto inválido!";
            $_SESSION['msg_tipo'] = "danger";
            header("Location: index.php?action=vendas");
            exit;
        }
        if ($quantidade <= 0) {
            $_SESSION['msg'] = "Quantidade inválida!";
            $_SESSION['msg_tipo'] = "danger";
            header("Location: index.php?action=vendas");
            exit;
        }
        if (!$produto) {
            $_SESSION['msg'] = "Produto não encontrado";
            $_SESSION['msg_tipo'] = "danger";
            header("Location: index.php?action=vendas");
            exit;
        }
        if ((float) $produto['quantidade'] < $quantidade) {
            $_SESSION['msg'] = "Estoque insuficiente";
            $_SESSION['msg_tipo'] = "danger";
            header("Location: index.php?action=vendas");
            exit;
        }
        $preco = (float) $produto['preco'];
        $total = $preco * $quantidade;
        $usuario_id = $_SESSION['usuario_id'];
        $caixa_id = 1;
        $venda = new Venda($pdo);
        $venda_id = $venda->criarVenda($total, $forma_pagamento, $empresa_id, $usuario_id, $caixa_id);
        $venda->adicionarItem($venda_id, $produto_id, $quantidade, $preco, $empresa_id);
        $venda->baixarEstoque($produto_id, $quantidade, $empresa_id);
        header("Location: index.php");
        exit;
    }

    public function listar()
    {
        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];

        $vendaModel = new Venda($pdo);
        $vendasRaw = $vendaModel->listarPorEmpresa($empresa_id);

        $vendas = [];

        foreach ($vendasRaw as $row) {
            $id = $row['id'];

            if (!isset($vendas[$id])) {
                $vendas[$id] = [
                    'id' => $row['id'],
                    'total' => $row['total'],
                    'forma_pagamento' => $row['forma_pagamento'],
                    'data' => $row['data'],
                    'usuario_id' => $row['usuario_id'],
                    'usuario_nome' => $row['usuario_nome'],
                    'itens' => []
                ];
            }

            if ($row['produto_id']) {
                $vendas[$id]['itens'][] = [
                    'nome' => $row['produto_nome'],
                    'quantidade' => $row['quantidade'],
                    'preco' => $row['preco'],
                    'unidade_medida' => $row['unidade_medida']
                ];
            }
        }

        require __DIR__ . '/../views/historico_vendas.php';
    }


    public function dashboard()
    {
        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];

        $venda = new Venda($pdo);

        $totalHoje = $venda->totalHoje($empresa_id);
        $totalMes = $venda->totalMes($empresa_id);

        $produtoTop = $venda->produtoMaisVendido($empresa_id);

        // evita variável indefinida
        if (!$produtoTop) {
            $produtoTop = null;
        }

        require_once __DIR__ . "/../views/dashboard.php";
    }

    public function nova()
    {
        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];
        $produtoModel = new Produto($pdo);
        $produtos = $produtoModel->listarPorEmpresa($empresa_id);

        $empresaModel = new Empresa($pdo);
        $empresa = $empresaModel->buscaPorId($empresa_id);

        $imagemFundo = $empresaModel->getImagemFundo($empresa_id);

        require __DIR__ . '/../views/vendas.php';
    }

    public function addCarrinho()
    {
        $pdo = conectarBanco();

        $produto_id = $_POST['produto_id'];
        $quantidade = (float) str_replace(',', '.', $_POST['quantidade']);
        $empresa_id = $_SESSION['empresa_id'];
        $forma_pagamento = $_POST['forma_pagamento'] ?? '';

        if ($quantidade <= 0) {
            $_SESSION['msg'] = "Quantidade inválida!";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=vendas");
            exit;
        }

        if (empty($produto_id)) {
            $_SESSION['msg'] = "Produto não encontrado";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=vendas");
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ? AND empresa_id = ?");
        $stmt->execute([$produto_id, $empresa_id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            $_SESSION['msg'] = "Produto não encontrado";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=vendas");
            exit;
        }

        if ($produto['quantidade'] <= 0) {
            $_SESSION['msg'] = "Produto sem estoque!";
            $_SESSION['msg_tipo'] = "danger";
            header("Location: index.php?action=vendas");
            exit;
        }

        $item = [
            'id' => $produto['id'],
            'nome' => $produto['nome'],
            'preco' => $produto['preco'],
            'quantidade' => $quantidade,
            'unidade_medida' => $produto['unidade_medida']
        ];

        foreach ($_SESSION['carrinho'] ?? [] as &$c) {
            if ($c['id'] == $produto_id) {
                $c['quantidade'] += $quantidade;
                header("Location: index.php?action=vendas");
                exit;
            }
        }

        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        $_SESSION['carrinho'][] = $item;

        header("Location: index.php?action=vendas");
        exit;
    }

    public function removerCarrinho()
    {

        $index = $_GET['index'] ?? null;

        if (!isset($_SESSION['carrinho'][$index])) {
            header("Location: index.php?action=vendas");
            exit;
        }

        unset($_SESSION['carrinho'][$index]);

        $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);

        header("Location: index.php?action=vendas");
        exit;
    }

    public function finalizarCarrinho()
    {
        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];
        $usuario_id = $_SESSION['usuario_id'];
        $caixa_id = 1;

        $carrinho = $_SESSION['carrinho'] ?? [];
        $forma_pagamento = $_POST['forma_pagamento'] ?? '';

        if (empty($carrinho)) {

            $_SESSION['msg'] = "Carrinho vazio!";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=vendas");
            exit;
        }

        if (empty($forma_pagamento)) {

            $_SESSION['msg'] = "Selecione a forma de pagamento!";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=vendas");
            exit;
        }

        try {

            $pdo->beginTransaction();

            $total = 0;

            foreach ($carrinho as $item) {

                $stmt = $pdo->prepare("
                SELECT quantidade 
                FROM produtos 
                WHERE id = ? AND empresa_id = ?
            ");

                $stmt->execute([
                    $item['id'],
                    $empresa_id
                ]);

                $produto = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$produto) {

                    throw new Exception(
                        "Produto não encontrado: " . $item['nome']

                    );
                }

                if ((float)$produto['quantidade'] < (float)$item['quantidade']) {
                    throw new Exception(
                        "Produto sem estoque: " . $item['nome']
                    );
                }

                $total += $item['preco'] * $item['quantidade'];
            }

            $stmt = $pdo->prepare("
            INSERT INTO vendas (
                total,
                forma_pagamento,
                empresa_id,
                usuario_id,
                caixa_id
            ) VALUES (?, ?, ?, ?, ?)
        ");

            $stmt->execute([
                $total,
                $forma_pagamento,
                $empresa_id,
                $usuario_id,
                $caixa_id
            ]);

            $venda_id = $pdo->lastInsertId();

            foreach ($carrinho as $item) {

                $stmt = $pdo->prepare("
                INSERT INTO itens_venda (
                    venda_id,
                    produto_id,
                    quantidade,
                    preco,
                    empresa_id
                ) VALUES (?, ?, ?, ?, ?)
            ");

                $stmt->execute([
                    $venda_id,
                    $item['id'],
                    $item['quantidade'],
                    $item['preco'],
                    $empresa_id
                ]);

                $stmt = $pdo->prepare("
                UPDATE produtos
                SET quantidade = quantidade - ?
                WHERE id = ? 
                    AND empresa_id = ?
                    AND quantidade >= ?
            ");

                $stmt->execute([
                    $item['quantidade'],
                    $item['id'],
                    $empresa_id,
                    $item['quantidade']
                ]);

                if ($stmt->rowCount() === 0) {
                    throw new Exception(
                        "Estoque insuficiente para o produto: " . $item['nome']
                    );
                }
            }

            $pdo->commit();

            unset($_SESSION['carrinho']);

            $_SESSION['msg'] = "Venda realizada com sucesso!";
            $_SESSION['msg_tipo'] = "success";

            header("location: index.php?action=imprimirNota&id=" . $venda_id);
            exit;
        } catch (Exception $e) {

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            $_SESSION['msg'] = "Erro: " . $e->getMessage();
            $_SESSION['msg_tipo'] = "danger";
        }

        header("Location: index.php?action=vendas");
        exit;
    }

    public function buscarProduto()
    {
        $pdo = conectarBanco();

        $busca = $_GET['busca'] ?? '';
        $empresa_id = $_SESSION['empresa_id'];

        $stmt = $pdo->prepare("

        SELECT * FROM produtos 
        WHERE empresa_id = ?
        AND (nome LIKE ? OR codigo LIKE ?)
    ");
        $like = "%$busca%";
        $stmt->execute([$empresa_id, $like, $like]);

        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($produtos);
        exit;
    }

    public function imprimirNota()
    {
        $pdo = conectarBanco();

        $venda_id = $_GET['id'] ?? null;
        $empresa_id = $_SESSION['empresa_id'];


        $stmt = $pdo->prepare("
        SELECT 
        v.id AS venda_id,
        v.total,
        v.forma_pagamento,
        v.data,
        iv.quantidade,
        iv.preco,
        p.nome,
        p.unidade_medida
        FROM vendas v
        INNER JOIN itens_venda iv
        ON iv.venda_id = v.id
        INNER JOIN produtos p
        ON p.id = iv.produto_id
        WHERE v.id  = ? AND v.empresa_id = ?
        ");

        $stmt->execute([
            $venda_id,
            $empresa_id
        ]);

        $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $empresaModel = new Empresa($pdo);
        $empresa = $empresaModel->buscaPorId($empresa_id);

        require  __DIR__ . '/../views/imprimir_nota.php';
    }

    public function historico_fechamento_caixa()
    {
        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];

        $caixa_id = 1;

        $vendaModel = new Venda($pdo);


        $fechamento = $vendaModel->resumoCaixa(
            $empresa_id,
            $caixa_id
        );

        $totalDinheiro = 0;
        $totalCartao = 0;
        $totalPix = 0;
        $totalGeral = 0;

        foreach ($fechamento as $item) {

            $forma = strtolower(
                trim($item['forma_pagamento'] ?? '')
            );

            $valor = (float) ($item['total'] ?? 0);

            $totalGeral += $valor;

            if ($forma === 'dinheiro') {
                $totalDinheiro += $valor;
            }

            if (
                $forma === 'cartao' ||
                $forma === 'cartão'
            ) {
                $totalCartao += $valor;
            }

            if ($forma === 'pix') {
                $totalPix += $valor;
            }
        }

        $funcionarios = $vendaModel->listarFuncionariosDoCaixa(
            $empresa_id,
            $caixa_id
        );

        foreach ($funcionarios as &$funcionario) {

            $usuario_id = $funcionario['id'];

            $funcionario['fechamento'] = str_pad(
                (string) $caixa_id,
                3,
                '0',
                STR_PAD_LEFT
            );

            $funcionario['dinheiro'] = 0;
            $funcionario['cartao'] = 0;
            $funcionario['pix'] = 0;
            $funcionario['total'] = 0;


            $pagamentos = $vendaModel->totaisFuncionarios(
                $empresa_id,
                $caixa_id,
                $usuario_id
            );

            foreach ($pagamentos as $pagamento) {

                $forma = strtolower(
                    trim($pagamento['forma_pagamento'] ?? '')
                );

                $valor = (float) ($pagamento['total'] ?? 0);

                $funcionario['total'] += $valor;

                if ($forma === 'dinheiro') {
                    $funcionario['dinheiro'] += $valor;
                }

                if (
                    $forma === 'cartao' ||
                    $forma === 'cartão'
                ) {
                    $funcionario['cartao'] += $valor;
                }

                if ($forma === 'pix') {
                    $funcionario['pix'] += $valor;
                }
            }

            $funcionario['produtos'] =
                $vendaModel->produtosVendidosFuncionario(
                    $empresa_id,
                    $caixa_id,
                    $usuario_id
                );

            $quantidadeMercadorias =
                $vendaModel->quantidadeMercadoriasVendidas(
                    $empresa_id,
                    $caixa_id,
                    $usuario_id
                );

            $funcionario['quantidade_mercadoria'] =
                (float) ($quantidadeMercadorias['quantidade'] ?? 0);
        }

        unset($funcionario);

        require __DIR__ . '/../views/historico_fechamento_caixa.php';
    }

    public function imprimirFechamento()
    {
        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];
        $caixa_id = 1;

        $usuario_id = $_GET['usuario_id'] ?? null;

        if (!$usuario_id) {
            die('Funcionário não informado.');
        }

        $vendaModel = new Venda($pdo);

        $funcionarios = $vendaModel->listarFuncionariosDoCaixa(
            $empresa_id,
            $caixa_id
        );

        $funcionario = null;

        foreach ($funcionarios as $item) {
            if ((int) $item['id'] === (int) $usuario_id) {
                $funcionario = $item;
                break;
            }
        }

        if (!$funcionario) {
            die('Funcionário não encontrado.');
        }

        $funcionario['fechamento'] = str_pad(
            (string) $caixa_id,
            3,
            '0',
            STR_PAD_LEFT
        );


        $pagamentos = $vendaModel->totaisFuncionarios(
            $empresa_id,
            $caixa_id,
            $usuario_id
        );

        $funcionario['dinheiro'] = 0;
        $funcionario['cartao'] = 0;
        $funcionario['pix'] = 0;
        $funcionario['total'] = 0;

        foreach ($pagamentos as $pagamento) {

            $forma = strtolower(
                trim($pagamento['forma_pagamento'] ?? '')
            );

            $valor = (float) ($pagamento['total'] ?? 0);

            $funcionario['total'] += $valor;

            if ($forma === 'dinheiro') {
                $funcionario['dinheiro'] += $valor;
            }

            if ($forma === 'cartao' || $forma === 'cartão') {
                $funcionario['cartao'] += $valor;
            }

            if ($forma === 'pix') {
                $funcionario['pix'] += $valor;
            }
        }


        $funcionario['produtos'] =
            $vendaModel->produtosVendidosFuncionario(
                $empresa_id,
                $caixa_id,
                $usuario_id
            );


        $totalVendas = $vendaModel->totalVendasFuncionario(
            $empresa_id,
            $caixa_id,
            $usuario_id
        );

        $funcionario['total_vendas'] =
            (int) ($totalVendas['total_vendas'] ?? 0);

        $empresaModel = new Empresa($pdo);

        $empresa = $empresaModel->buscaPorId($empresa_id);


        require __DIR__ . '/../views/imprimir_fechamento.php';
    }

    public function imprimir_relatorio_completo()
    {
        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];
        $caixa_id = 1;

        $vendaModel = new Venda($pdo);


        $fechamento = $vendaModel->resumoCaixa(
            $empresa_id,
            $caixa_id
        );

        $totalDinheiro = 0;
        $totalCartao = 0;
        $totalPix = 0;
        $totalGeral = 0;

        foreach ($fechamento as $item) {

            $forma = strtolower(
                trim($item['forma_pagamento'] ?? '')
            );

            $valor = (float) ($item['total'] ?? 0);

            $totalGeral += $valor;

            if ($forma === 'dinheiro') {
                $totalDinheiro += $valor;
            }

            if ($forma === 'cartao' || $forma === 'cartão') {
                $totalCartao += $valor;
            }

            if ($forma === 'pix') {
                $totalPix += $valor;
            }
        }


        $funcionarios = $vendaModel->listarFuncionariosDoCaixa(
            $empresa_id,
            $caixa_id
        );

        foreach ($funcionarios as &$funcionario) {

            $usuario_id = $funcionario['id'];

            $funcionario['fechamento'] = str_pad(
                (string) $caixa_id,
                3,
                '0',
                STR_PAD_LEFT
            );

            $funcionario['dinheiro'] = 0;
            $funcionario['cartao'] = 0;
            $funcionario['pix'] = 0;
            $funcionario['total'] = 0;

            $pagamentos = $vendaModel->totaisFuncionarios(
                $empresa_id,
                $caixa_id,
                $usuario_id
            );

            foreach ($pagamentos as $pagamento) {

                $forma = strtolower(
                    trim($pagamento['forma_pagamento'] ?? '')
                );

                $valor = (float) ($pagamento['total'] ?? 0);

                $funcionario['total'] += $valor;

                if ($forma === 'dinheiro') {
                    $funcionario['dinheiro'] += $valor;
                }

                if ($forma === 'cartao' || $forma === 'cartão') {
                    $funcionario['cartao'] += $valor;
                }

                if ($forma === 'pix') {
                    $funcionario['pix'] += $valor;
                }
            }

            $funcionario['produtos'] =
                $vendaModel->produtosVendidosFuncionario(
                    $empresa_id,
                    $caixa_id,
                    $usuario_id
                );

            $totalVendas = $vendaModel->totalVendasFuncionario(
                $empresa_id,
                $caixa_id,
                $usuario_id
            );

            $funcionario['total_vendas'] =
                (int) ($totalVendas['total_vendas'] ?? 0);
        }

        unset($funcionario);

        $empresaModel = new Empresa($pdo);

        $empresa = $empresaModel->buscaPorId($empresa_id);


        require __DIR__ . '/../views/imprimir_relatorio_completo.php';
    }
}
