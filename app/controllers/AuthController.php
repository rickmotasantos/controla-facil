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

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['empresa_id'] = $usuario['empresa_id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];

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
}
