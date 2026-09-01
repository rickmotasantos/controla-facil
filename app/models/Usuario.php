<?php

class Usuario
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorNome($nome)
    {
        $sql = "SELECT * FROM usuarios WHERE nome = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarFuncionarios($empresa_id){
        $sql = "
            SELECT id, nome, empresa_id, tipo
            FROM usuarios
            WHERE empresa_id = ?
            AND tipo = 'funcionario'
            ORDER BY nome ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$empresa_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}