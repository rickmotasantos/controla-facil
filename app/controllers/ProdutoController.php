<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Produto.php';

class ProdutoController
{
    public function salvar()
    {
        $pdo = conectarBanco();

        $nome = $_POST['nome'] ?? '';
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];
        $codigo = $_POST['codigo'];
        $empresa_id = $_SESSION['empresa_id'];

        $produtoModel = new Produto($pdo);
        $produtoModel->criar($nome, $preco, $quantidade, $codigo, $empresa_id);
        $_SESSION['msg'] = "Produto criado com sucesso!";
        $_SESSION['msg_tipo'] = "success";

        header("Location: index.php");
        exit;
    }

    public function listar()
    {
        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];
        $tipo = $_SESSION['tipo'];

        $produto = new Produto($pdo);
        $produtos = $produto->listarComFiltro($empresa_id, $tipo);

        return $produtos;
    }

    public function editar()
    {
        $pdo = conectarBanco();

        $id = $_GET['id'];
        $empresa_id = $_SESSION['empresa_id'];
        $tipo = $_SESSION['tipo'];

        $produto = new Produto($pdo);
        $dados = $produto->buscarPorId($id, $empresa_id, $tipo);

        require __DIR__ . '/../views/editar_produto.php';
    }

    public function atualizar()
    {
        $pdo = conectarBanco();

        $id = $_POST['id'];
        $nome = $_POST['nome'] ?? '';
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];
        $codigo = $_POST['codigo'];
        $empresa_id = $_SESSION['empresa_id'];
        $tipo = $_SESSION['tipo'];

        $produto = new Produto($pdo);
        $produto->atualizar($id, $nome, $preco, $quantidade, $codigo, $empresa_id, $tipo);

        header("Location: index.php?action=produtos");
        exit;
    }

    public function excluir()
    {
        $pdo = conectarBanco();

        $id = $_GET['id'];
        $empresa_id = $_SESSION['empresa_id'];
        $tipo = $_SESSION['tipo'];

        $produto = new Produto($pdo);
        $produto->excluir($id, $empresa_id, $tipo);

        header("Location: index.php?action=produtos");
        exit;
    }

    public function adicionarEstoque()
    {
        $pdo = conectarBanco();

        $codigo = trim($_POST['codigo']);
        $quantidade = (int) $_POST['quantidade'];
        $empresa_id = $_SESSION['empresa_id'];
        $tipo = $_SESSION['tipo'];

        if ($tipo === 'admin') {
            $stmt = $pdo->prepare("
        SELECT * FROM produtos 
        WHERE codigo LIKE ? OR nome LIKE ?
    ");
            $stmt->execute(["%$codigo%", "%$codigo%"]);
        } else {
            $stmt = $pdo->prepare("
        SELECT * FROM produtos 
        WHERE (codigo LIKE ? OR nome LIKE ?) 
        AND empresa_id = ?
    ");
            $stmt->execute(["%$codigo%", "%$codigo%", $empresa_id]);
        }

        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            $_SESSION['msg'] = "Produto não encontrado!";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=entrada");
            exit;
        }

        $novoEstoque = $produto['quantidade'] + $quantidade;

        if ($novoEstoque < 0) {
            $_SESSION['msg'] = "Estoque insuficiente!";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=entrada");
            exit;
        }

        if ($tipo === 'admin') {
            $stmt = $pdo->prepare("UPDATE produtos SET quantidade = quantidade + ? WHERE id = ?");
            $stmt->execute([$quantidade, $produto['id']]);
        } else {
            $stmt = $pdo->prepare("UPDATE produtos SET quantidade = quantidade + ? WHERE id = ? AND empresa_id = ?");
            $stmt->execute([$quantidade, $produto['id'], $empresa_id]);
        }

        if ($quantidade > 0) {
            $_SESSION['msg'] = "Entrada de estoque realizada!";
        } else {
            $_SESSION['msg'] = "Saída de estoque realizada!";
        }
        $_SESSION['msg_tipo'] = "success";

        header("Location: index.php?action=entrada");
        exit;
    }

    public function entrada()
    {
        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];
        $tipo = $_SESSION['tipo'];

        $produto = new Produto($pdo);
        $produtos = $produto->listarComFiltro($empresa_id, $tipo);

        require __DIR__ . '/../views/entrada_estoque.php';
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];
        $tipo = $_SESSION['tipo'];

        $produtoModel = new Produto($pdo);
        $produtos = $produtoModel->listarComFiltro($empresa_id, $tipo);

        require __DIR__ . '/../views/produtos.php';
    }
    public function salvarEntradaRapida()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $pdo = conectarBanco();

            $produto_id = $_POST['produto_id'];
            $quantidade = $_POST['quantidade'];

            $model = new Produto($pdo);
            $model->somarEstoque($produto_id, $quantidade);

            $_SESSION['msg'] = "Entrada de estoque realizada com sucesso!";
            $_SESSION['msg_tipo'] = "success";

            header("Location: index.php?action=vendas");
            exit;
        }
    }

    public function cadastrar()
    {
        require __DIR__ . '/../views/cadastrar_produto.php';
    }
}
