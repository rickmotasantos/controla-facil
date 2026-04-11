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
}