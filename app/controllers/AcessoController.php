<?php

require_once BASE_PATH . '/app/models/Acesso.php';
require_once BASE_PATH . '/app/models/Acesso.php';

class AcessoController
{
    public function listar()
    {
        $acessos = Acesso::listar();

        require BASE_PATH . '/app/views/admin/acessos.php';
    }
}