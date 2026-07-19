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
        INNER JOIN (
            SELECT empresa_id, MAX(id) AS ultimo_id
            FROM acessos
            GROUP BY empresa_id
            ) ultimos
            ON a.id = ultimos.ultimo_id
            ORDER BY a.login_em DESC";

        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
