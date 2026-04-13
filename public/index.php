<?php
session_start();

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/app/controllers/ProdutoController.php';
require_once BASE_PATH . '/app/controllers/VendaController.php';
require_once BASE_PATH . '/app/controllers/AuthController.php';


$action = $_GET['action'] ?? $_POST['action'] ?? 'home';


$rotasPublicas = ['login', 'autenticar'];

if (!in_array($action, $rotasPublicas) && !isset($_SESSION['usuario_id'])) {
    header("Location: index.php?action=login");
    exit;
}

if ($action == 'login') {
    (new AuthController())->login();
} elseif ($action == 'autenticar') {
    (new AuthController())->autenticar();
} elseif ($action == 'logout') {
    (new AuthController())->logout();
} elseif ($action == 'salvar') {
    (new ProdutoController())->salvar();
} elseif ($action == 'editar') {
    (new ProdutoController())->editar();
} elseif ($action == 'atualizar') {
    (new ProdutoController())->atualizar();
} elseif ($action == 'excluir') {
    (new ProdutoController())->excluir();
} elseif ($action == 'entrada') {
    (new ProdutoController())->entrada();
} elseif ($action == 'adicionar_estoque') {
    (new ProdutoController())->adicionarEstoque();
} elseif ($action == 'vendas') {
    (new VendaController())->nova();
} elseif ($action == 'addCarrinho') {
    (new VendaController())->addCarrinho();
} elseif ($action == 'removerCarrinho') {
    (new VendaController())->removerCarrinho();
} elseif ($action == 'finalizarCarrinho') {
    (new VendaController())->finalizarCarrinho();
} elseif ($action == 'historico') {
    (new VendaController())->listar();
} elseif ($action == 'dashboard') {
    (new VendaController())->dashboard();
} elseif ($action == 'buscarProduto') {
    (new VendaController())->buscarProduto();
}elseif ($action == 'home') {
    require_once BASE_PATH . '/app/views/home.php';
} else {
    (new ProdutoController())->index();
}