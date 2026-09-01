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

    public function getImagemFundo($id){
        $formatoImagem = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        foreach($formatoImagem as $formato){
            $arquivo = BASE_PATH . "/public/assets/empresas/{$id}/fundo.{$formato}";
            if(file_exists($arquivo)){
                return "/sistema-comercio/public/assets/empresas/{$id}/fundo.{$formato}";
            }
        }
        return "/sistema-comercio/public/assets/empresas/default/fundo.jpg";
    }
}