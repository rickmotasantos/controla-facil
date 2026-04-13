<?php
require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../models/Venda.php";

class VendaController
{

    public function salvar()
    {
        $pdo = conectarBanco();

        $produto_id = $_POST['produto_id'];
        $quantidade = $_POST['quantidade'];
        $empresa_id = $_SESSION['empresa_id'];
        $forma_pagamento = $_POST['forma_pagamento'];

        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ? AND empresa_id = ?");
        $stmt->execute([$produto_id, $empresa_id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            die("Produto não encontrado");
        }

        if ($produto['quantidade'] < $quantidade) {
            die("estoque insuficiente");
        }

        $preco = $produto['preco'];
        $total = $preco * $quantidade;

        $venda = new Venda($pdo);

        $venda_id = $venda->criarVenda($total, $forma_pagamento);
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
        $vendas = $vendaModel->listarPorEmpresa($empresa_id);

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

        require_once __DIR__ . "/../views/dashboard.php";
    }

    public function nova()
    {
        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];
        $produtoModel = new Produto($pdo);
        $produtos = $produtoModel->listarPorEmpresa($empresa_id);

        require __DIR__ . '/../views/vendas.php';
    }

    public function addCarrinho()
    {
        $pdo = conectarBanco();

        $produto_id = $_POST['produto_id'];
        $quantidade = $_POST['quantidade'];
        $empresa_id = $_SESSION['empresa_id'];

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
            'quantidade' => $quantidade
        ];

        foreach ($_SESSION['carrinho'] ?? [] as &$c) {
            if ($c['id'] == $produto_id) {
                $c['quantidade'] += $quantidade;
                header("Location: index.php?action=vendas");
                exit;
            }
        }

        $_SESSION['carrinho'][] = $item;

        header("Location: index.php?action=vendas");
        exit;
    }

    public function removerCarrinho()
    {

        $index = $_GET['index'];

        unset($_SESSION['carrinho'][$index]);

        $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);

        header("Location: index.php?action=vendas");
        exit;
    }

    public function finalizarCarrinho()
    {
        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];
        $carrinho = $_SESSION['carrinho'] ?? [];

        if (empty($carrinho)) {
            $_SESSION['msg'] = "Carrinho vazio!";
            $_SESSION['msg_tipo'] = "danger";
            header("Location: index.php?action=vendas");
            exit;
        }

        $forma_pagamento = $_POST['forma_pagamento'];

        $total = 0;

        foreach ($carrinho as $item) {

            $stmt = $pdo->prepare("
            SELECT quantidade 
            FROM produtos 
            WHERE id = ? AND empresa_id = ?
        ");
            $stmt->execute([$item['id'], $empresa_id]);

            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$produto) {
                $_SESSION['msg'] = "Produto inválido: {$item['nome']}";
                $_SESSION['msg_tipo'] = "danger";
                header("Location: index.php?action=vendas");
                exit;
            }

            if ($produto['quantidade'] < $item['quantidade']) {
                $_SESSION['msg'] = "Estoque insuficiente para {$item['nome']}";
                $_SESSION['msg_tipo'] = "danger";
                header("Location: index.php?action=vendas");
                exit;
            }

            $total += $item['preco'] * $item['quantidade'];
        }

        $stmt = $pdo->prepare("
        INSERT INTO vendas (total, forma_pagamento, empresa_id)
        VALUES (?, ?, ?)
    ");
        $stmt->execute([$total, $forma_pagamento, $empresa_id]);

        $venda_id = $pdo->lastInsertId();

        foreach ($carrinho as $item) {

            $stmt = $pdo->prepare("
            INSERT INTO itens_venda (venda_id, produto_id, quantidade, preco, empresa_id)
            VALUES (?, ?, ?, ?, ?)
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
            WHERE id = ? AND empresa_id = ?
        ");
            $stmt->execute([
                $item['quantidade'],
                $item['id'],
                $empresa_id
            ]);
        }

        unset($_SESSION['carrinho']);

        $_SESSION['msg'] = "Venda realizada com sucesso!";
        $_SESSION['msg_tipo'] = "success";

        header("Location: index.php?action=vendas");
        exit;
    }

    public function buscarProduto()
    {
        $pdo = conectarBanco();

        $busca = $_GET['busca'];
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
}
