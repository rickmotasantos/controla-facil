<?php

class Venda
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function criarVenda($total, $forma_pagamento)
    {
        $sql = "INSERT INTO vendas (total, forma_pagamento) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$total, $forma_pagamento]);

        return $this->pdo->lastInsertId();
    }

    public function adicionarItem($venda_id, $produto_id, $quantidade, $preco)
    {
        $sql = "INSERT INTO itens_venda(venda_id, produto_id, quantidade, preco) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$venda_id, $produto_id, $quantidade, $preco]);
    }

    public function baixarEstoque($produto_id, $quantidade)
    {
        $sql = "UPDATE produtos SET quantidade = quantidade - ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$quantidade, $produto_id]);
    }

    public function listarVendas()
    {
        $sql = "SELECT * FROM vendas ORDER BY data DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function totalHoje()
    {
        $sql = "SELECT SUM(total) as total FROM vendas WHERE DATE(data) = CURDATE()";
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    public function totalMes()
    {
        $sql = "SELECT SUM(total) as total FROM vendas WHERE MONTH(data) = MONTH(CURDATE()) AND YEAR(data) = YEAR(CURDATE())";
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    public function produtoMaisVendido()
    {
        $sql = "SELECT p.nome, SUM(iv.quantidade) as total FROM itens_venda iv JOIN produtos p ON p.id = iv.produto_id GROUP BY   iv.produto_id ORDER BY total DESC LIMIT 1";

        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    public function listarPorEmpresa($empresa_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM vendas WHERE empresa_id = ?");
        $stmt->execute([$empresa_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
