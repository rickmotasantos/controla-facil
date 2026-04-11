<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Produto.php';

class ProdutoController
{
    public function salvar()
    {
        $pdo = conectarBanco();

        $nome = $_POST['nome'];
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

        $produto = new Produto($pdo);
        $produtos = $produto->listarPorEmpresa($empresa_id);

        return $produtos;
    }

    public function editar()
    {
        $pdo = conectarBanco();

        $id = $_GET['id'];
        $empresa_id = $_SESSION['empresa_id'];

        $produto = new Produto($pdo);
        $dados = $produto->buscarPorId($id, $empresa_id);

        require __DIR__ . '/../views/editar_produto.php';
    }

    public function atualizar()
    {
        $pdo = conectarBanco();

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];
        $codigo = $_POST['codigo'];
        $empresa_id = $_SESSION['empresa_id'];

        $produto = new Produto($pdo);
        $produto->atualizar($id, $nome, $preco, $quantidade, $codigo, $empresa_id);

        header("Location: index.php?action=produtos");
        exit;
    }

    public function excluir()
    {
        $pdo = conectarBanco();

        $id = $_GET['id'];
        $empresa_id = $_SESSION['empresa_id'];

        $produto = new Produto($pdo);
        $produto->excluir($id, $empresa_id);

        header("Location: index.php?action=produtos");
        exit;
    }

    public function adicionarEstoque()
{
    $pdo = conectarBanco();

    $codigo = $_POST['codigo'];
    $quantidade = $_POST['quantidade'];
    $empresa_id = $_SESSION['empresa_id'];

    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE codigo = ? AND empresa_id = ?");
    $stmt->execute([$codigo, $empresa_id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produto) {
        $_SESSION['msg'] = "Produto não encontrado!";
        $_SESSION['msg_tipo'] = "danger";

        header("Location: index.php?action=entrada");
        exit;
    }

    $stmt = $pdo->prepare("UPDATE produtos SET quantidade = quantidade + ? WHERE id = ? AND empresa_id = ?");
    $stmt->execute([$quantidade, $produto['id'], $empresa_id]);

    $_SESSION['msg'] = "Estoque atualizado com sucesso!";
    $_SESSION['msg_tipo'] = "success";

    header("Location: index.php?action=entrada");
    exit;
}

    public function entrada(){
        $pdo = conectarBanco();

        $empresa_id = $_SESSION
        ['empresa_id'];

        $produto = new Produto($pdo);
        $produtos = $produto->listarPorEmpresa($empresa_id);

        require __DIR__ . '/../views/entrada_estoque.php';
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];

        $produtoModel = new Produto($pdo);
        $produtos = $produtoModel->listarPorEmpresa($empresa_id);

        require __DIR__ . '/../views/produtos.php';
    }
}
