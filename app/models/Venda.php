<?php

class Venda
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function criarVenda($total, $forma_pagamento, $empresa_id, $usuario_id, $caixa_id)
    {
        $sql = "INSERT INTO vendas (total, forma_pagamento, empresa_id, usuario_id, caixa_id) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$total, $forma_pagamento, $empresa_id, $usuario_id, $caixa_id]);

        return $this->pdo->lastInsertId();
    }

    public function adicionarItem($venda_id, $produto_id, $quantidade, $preco, $empresa_id)
    {
        $sql = "
        INSERT INTO itens_venda
        (venda_id, produto_id, quantidade, preco, empresa_id)
        VALUES (?, ?, ?, ?, ?)
    ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $venda_id,
            $produto_id,
            $quantidade,
            $preco,
            $empresa_id
        ]);
    }
    public function baixarEstoque($produto_id, $quantidade, $empresa_id)
    {
        $sql = "UPDATE produtos 
            SET quantidade = quantidade - ? 
            WHERE id = ? 
            AND empresa_id = ?";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $quantidade,
            $produto_id,
            $empresa_id
        ]);
    }

    public function listarVendas()
    {
        $sql = "SELECT * FROM vendas ORDER BY data DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function totalHoje($empresa_id)
    {
        $stmt = $this->pdo->prepare("
        SELECT SUM(total) as total
        FROM vendas
        WHERE empresa_id = ?
        AND DATE(data) = CURDATE()
    ");

        $stmt->execute([$empresa_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function totalMes($empresa_id)
    {
        $stmt = $this->pdo->prepare("
        SELECT SUM(total) as total
        FROM vendas
        WHERE empresa_id = ?
        AND MONTH(data) = MONTH(CURDATE())
        AND YEAR(data) = YEAR(CURDATE())
    ");

        $stmt->execute([$empresa_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function produtoMaisVendido($empresa_id)
    {
        $stmt = $this->pdo->prepare("
        SELECT 
            p.nome,
            SUM(iv.quantidade) as total

        FROM itens_venda iv

        JOIN produtos p 
            ON p.id = iv.produto_id

        WHERE iv.empresa_id = ?

        GROUP BY iv.produto_id

        ORDER BY total DESC

        LIMIT 1
    ");

        $stmt->execute([$empresa_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function listarPorEmpresa($empresa_id)
    {
        $stmt = $this->pdo->prepare("
        SELECT 
            v.id,
            v.total,
            v.forma_pagamento,
            v.data,
            v.usuario_id,
            u.nome AS usuario_nome,

            i.produto_id,
            i.quantidade,
            i.preco,

            p.nome AS produto_nome,
            p.unidade_medida

        FROM vendas v

        LEFT JOIN usuarios u
            ON u.id = v.usuario_id

        LEFT JOIN itens_venda i 
            ON i.venda_id = v.id

        LEFT JOIN produtos p 
            ON p.id = i.produto_id

        WHERE v.empresa_id = ?

        ORDER BY v.data DESC
    ");

        $stmt->execute([$empresa_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarFuncionariosDoCaixa($empresa_id, $caixa_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT
            u.id,
            u.nome
            FROM vendas v
            INNER JOIN usuarios u
            ON u.id = v.usuario_id
            WHERE v.empresa_id = ?
            AND v.caixa_id = ?
            GROUP BY u.id, u.nome
            ORDER BY u.nome
        ");

        $stmt->execute([
            $empresa_id,
            $caixa_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function totaisFuncionarios($empresa_id, $caixa_id, $usuario_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
            forma_pagamento,
            SUM(total) AS total
            FROM vendas
            WHERE empresa_id = ?
            AND caixa_id = ?
            AND usuario_id = ?
            GROUP BY forma_pagamento
        ");

        $stmt->execute([
            $empresa_id,
            $caixa_id,
            $usuario_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function produtosVendidosFuncionario($empresa_id, $caixa_id, $usuario_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT
            p.nome AS produto_nome,
            SUM(iv.quantidade) AS quantidade,
            iv.preco,
            SUM(iv.quantidade * iv.preco) AS total
            FROM vendas v

            INNER JOIN itens_venda iv
            ON iv.venda_id = v.id

            INNER JOIN produtos p
            ON p.id = iv.produto_id

            WHERE v.empresa_id = ?
            AND v.caixa_id = ?
            AND v.usuario_id = ?

            GROUP BY
            iv.produto_id,
            p.nome,
            iv.preco

            ORDER BY p.nome
        ");

        $stmt->execute([
            $empresa_id,
            $caixa_id,
            $usuario_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function quantidadeMercadoriasVendidas($empresa_id, $caixa_id, $usuario_id)
    {
        $stmt = $this->pdo->prepare("
        SELECT COUNT(DISTINCT v.id) AS quantidade
        FROM vendas v
            WHERE v.empresa_id = ?
            AND v.caixa_id = ?
            AND v.usuario_id = ?
    ");

        $stmt->execute([
            $empresa_id,
            $caixa_id,
            $usuario_id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function totalVendasFuncionario($empresa_id, $caixa_id, $usuario_id)
    {
        $stmt = $this->pdo->prepare("
        SELECT COUNT(*) AS total_vendas
        FROM vendas
        WHERE empresa_id = ?
        AND caixa_id = ?
        AND usuario_id = ?
    ");

        $stmt->execute([
            $empresa_id,
            $caixa_id,
            $usuario_id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function resumoCaixa($empresa_id, $caixa_id)
    {
        $sql = "
            SELECT
                forma_pagamento,
                SUM(total) AS total
            FROM vendas
            WHERE empresa_id = ?
            AND caixa_id = ?
            GROUP BY forma_pagamento
            ORDER BY forma_pagamento
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $empresa_id,
            $caixa_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
