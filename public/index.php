<?php
session_start();

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/app/controllers/ProdutoController.php';
require_once BASE_PATH . '/app/controllers/VendaController.php';
require_once BASE_PATH . '/app/controllers/AuthController.php';
require_once BASE_PATH . '/app/controllers/AdminController.php';

$action = $_GET['action'] ?? $_POST['action'] ?? 'home';

$rotasPublicas = ['login', 'autenticar'];

$rotasAdmin = [
    'admin_dashboard',
    'usuarios',
    'empresas'
];

function isAdmin()
{
    return ($_SESSION['tipo'] ?? null) === 'admin';
}

if (!in_array($action, $rotasPublicas)) {

    if (!isset($_SESSION['usuario_id'])) {
        header("Location: index.php?action=login");
        exit;
    }

    if (in_array($action, $rotasAdmin) && !isAdmin()) {
        $_SESSION['msg'] = "Você não tem permissão para acessar essa área";
        $_SESSION['msg_tipo'] = "danger";

        header("Location: index.php?action=home");
        exit;
    }
}

switch ($action) {

    case 'admin_dashboard':
        require_once BASE_PATH . '/app/controllers/AdminController.php';
        (new AdminController())->dashboard();
        break;

    case 'login':
        (new AuthController())->login();
        break;

    case 'autenticar':
        (new AuthController())->autenticar();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    case 'salvar':
        (new ProdutoController())->salvar();
        break;

    case 'editar':
        (new ProdutoController())->editar();
        break;

    case 'atualizar':
        (new ProdutoController())->atualizar();
        break;

    case 'excluir':
        (new ProdutoController())->excluir();
        break;

    case 'entrada':
        (new ProdutoController())->entrada();
        break;

    case 'adicionar_estoque':
        (new ProdutoController())->adicionarEstoque();
        break;

    case 'vendas':
        (new VendaController())->nova();
        break;

    case 'addCarrinho':
        (new VendaController())->addCarrinho();
        break;

    case 'removerCarrinho':
        (new VendaController())->removerCarrinho();
        break;

    case 'finalizarCarrinho':
        (new VendaController())->finalizarCarrinho();
        break;

    case 'historico':
        (new VendaController())->listar();
        break;

    case 'dashboard':
        (new VendaController())->dashboard();
        break;

    case 'buscarProduto':
        (new VendaController())->buscarProduto();
        break;

    case 'alterar_senha':
        (new AuthController())->alterarSenha();
        break;

    case 'salvar_senha':
        (new AuthController())->salvarSenha();
        break;

    case 'home':
        require_once BASE_PATH . '/app/views/home.php';
        break;

    case 'salvarEntradaRapida':
        (new ProdutoController())->salvarEntradaRapida();
        break;
    
    case 'salvarEmpresa':
        (new AdminController())->salvarEmpresa();
        break;

    case 'excluirEmpresa':
        (new AdminController())->excluirEmpresa();
        break;

    case 'editarEmpresa':
        (new AdminController())->editarEmpresa();
        break;
    
    case 'atualizarEmpresa':
        (new AdminController())->atualizarEmpresa();
        break;

    case 'alterarStatusEmpresa':
        (new AdminController())->alterarStatusEmpresa();
        break;

    case 'cadastrar_produto':
        require_once BASE_PATH . '/app/views/cadastrar_produtos.php';
        break;
        
    default:
        (new ProdutoController())->index();
        break;
}
