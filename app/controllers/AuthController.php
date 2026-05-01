<?php

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../../config/Database.php';

class AuthController
{
    public function login()
    {
        require __DIR__ . '/../views/login.php';
    }

    public function autenticar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $pdo = conectarBanco();

        $nome = $_POST['nome'];
        $senha = $_POST['senha'];

        $usuarioModel = new Usuario($pdo);
        $usuario = $usuarioModel->buscarPorNome($nome);

        if ($usuario && password_verify($senha, $usuario['senha'])) {

            // bloqueio para clientes empresa
            if ($usuario['tipo'] === 'empresa') {

                $stmt = $pdo->prepare("
                SELECT status 
                FROM empresas 
                WHERE id = ?
            ");

                $stmt->execute([$usuario['empresa_id']]);
                $empresa = $stmt->fetch(PDO::FETCH_ASSOC);

                if (
                    $empresa &&
                    in_array($empresa['status'], ['suspenso', 'inadimplente'])
                ) {
                    $_SESSION['msg'] = "Seu acesso foi bloqueado. Entre em contato com o administrador.";
                    $_SESSION['msg_tipo'] = "danger";

                    header("Location: index.php?action=login");
                    exit;
                }
            }

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['empresa_id'] = $usuario['empresa_id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['tipo'] = $usuario['tipo'];

            header("Location: index.php?action=home");
            exit;
        } else {
            $_SESSION['msg'] = "Usuário ou senha inválidos";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=login");
            exit;
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header("Location: index.php?action=login");
        exit;
    }
    public function alterarSenha()
    {
        require __DIR__ . '/../views/alterar_senha.php';
    }

    public function salvarSenha()
    {
        $pdo = conectarBanco();

        $usuario_id = $_SESSION['usuario_id'];

        $senhaAtual = $_POST['senha_atual'];
        $novaSenha = $_POST['nova_senha'];
        $confirmar = $_POST['confirmar_senha'];

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$usuario_id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario || !password_verify($senhaAtual, $usuario['senha'])) {
            $_SESSION['msg'] = "Senha atual incorreta!";
            $_SESSION['msg_tipo'] = "danger";
            header("Location: index.php?action=alterar_senha");
            exit;
        }

        if ($novaSenha !== $confirmar) {
            $_SESSION['msg'] = "As senhas não coincidem!";
            $_SESSION['msg_tipo'] = "danger";
            header("Location: index.php?action=alterar_senha");
            exit;
        }

        $novaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
        $stmt->execute([$novaHash, $usuario_id]);

        $_SESSION['msg'] = "Senha alterada com sucesso!";
        $_SESSION['msg_tipo'] = "success";

        header("Location: index.php?action=alterar_senha");
        exit;
    }
}
