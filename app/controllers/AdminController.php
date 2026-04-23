<?php

require_once __DIR__ . '/../../config/Database.php';

class AdminController
{
    public function dashboard()
    {
        $pdo = conectarBanco();

        // total de usuários
        $usuarios = $pdo->query("SELECT COUNT(*) as total FROM usuarios")->fetch();

        // total de empresas
        $empresas = $pdo->query("SELECT COUNT(*) as total FROM empresas")->fetch();

        // total de vendas
        $vendas = $pdo->query("SELECT SUM(total) as total FROM vendas")->fetch();

        require __DIR__ . '/../views/admin/dashboard.php';
    }
}