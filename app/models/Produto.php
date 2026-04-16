<?php
class Produto
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function criar($nome, $preco, $quantidade, $codigo, $empresa_id)
    {
        $sql = "INSERT INTO produtos (nome, preco, quantidade, codigo, empresa_id) VALUES (?,?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $preco, $quantidade, $codigo, $empresa_id]);
    }

    public function listar()
    {
        $sql = "SELECT * FROM produtos";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id, $empresa_id, $tipo)
    {
        if($tipo === 'admin'){
            $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE id = ?");
            $stmt->execute([$id]);
        }else{
            $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE id = ? AND empresa_id = ?");
            $stmt->execute([$id, $empresa_id]);
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $nome, $preco, $quantidade, $codigo, $empresa_id)
    {
        $sql = "UPDATE produtos SET nome=?, preco=?, quantidade=?, codigo=?, empresa_id=? WHERE id=? AND empresa_id= ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $preco, $quantidade,$codigo, $empresa_id, $id, $empresa_id]);
    }

    public function excluir($id, $empresa_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM produtos WHERE id = ? AND empresa_id = ?");
        return $stmt->execute([$id, $empresa_id]);
    }

    public function adicionarEstoque($id, $quantidade, $empresa_id){
        $sql = "UPDATE produtos SET quantidade = quantidade + ? WHERE id = ? AND empresa_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$quantidade, $id, $empresa_id]);
    }

    public function listarPorEmpresa($empresa_id){
        $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE empresa_id = ?");
        $stmt->execute([$empresa_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function listarComFiltro($empresa_id, $tipo){
        if($tipo === 'admin'){
            return $this->pdo->query("SELECT * FROM produtos")->fetchAll(PDO::FETCH_ASSOC);
        }

        $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE empresa_id = ?");
        $stmt->execute([$empresa_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
