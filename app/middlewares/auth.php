<?php

class Auth
{
    public static function check()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?action=login");
            exit;
        }
    }

    public static function admin()
    {
        self::check();

        if ($_SESSION['tipo'] !== 'admin') {
            die("Acesso negado");
        }
    }
}