<?php

class Empresa {
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function buscaPorId($id){
        $stmt = $this->pdo->prepare("SELECT * FROM empresas WHERE id = ?");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}