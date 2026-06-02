<?php

class Acesso {
    public static function listar(){
        $pdo = conectarBanco();

        $sql = "SELECT 
        a.*,
        u.nome AS usuario,
        e.nome AS empresa
        FROM acessos a
        INNER JOIN usuarios u ON u.id = a.usuario_id
        INNER JOIN empresas e ON e.id = a.empresa_id
        ORDER BY a.login_em DESC";

        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
