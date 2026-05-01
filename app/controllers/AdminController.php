<?php

require_once __DIR__ . '/../../config/Database.php';

class AdminController
{
    public function dashboard()
    {
        $pdo = conectarBanco();

        $mensalidades = $pdo->query("SELECT SUM(valor_mensal) as total  FROM empresas WHERE status = 'ativo'")->fetch();

        $usuarios = $pdo->query("SELECT COUNT(*) as total FROM usuarios")->fetch();

        $empresas = $pdo->query("SELECT COUNT(*) as total FROM empresas")->fetch();

        $vendas = $pdo->query("SELECT SUM(total) as total FROM vendas")->fetch();

        $ativas = $pdo->query("SELECT COUNT(*) as total FROM empresas WHERE status = 'ativa'")->fetch();

        $teste = $pdo->query("SELECT COUNT(*) as total FROM empresas WHERE status = 'teste'")->fetch();

        $inadimplestes = $pdo->query("SELECT COUNT(*) as total FROM empresas WHERE status = 'inadimplentes'")->fetch();

        $listaEmpresas = $pdo->query("SELECT * FROM empresas ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function salvarEmpresa()
    {
        $pdo = conectarBanco();

        $nome = $_POST['nome'];
        $responsavel = $_POST['responsavel'];
        $telefone = $_POST['telefone'];
        $plano = $_POST['plano'];
        $status = $_POST['status'];

        $valor_mensal = !empty($_POST['valor_mensal'])
            ? $_POST['valor_mensal']
            : null;

        $vencimento_dia = !empty($_POST['vencimento_dia'])
            ? $_POST['vencimento_dia']
            : null;

        $sql = "INSERT INTO empresas
    (nome, responsavel, telefone, plano, valor_mensal, vencimento_dia, status)
    VALUES
    (:nome, :responsavel, :telefone, :plano, :valor_mensal, :vencimento_dia, :status)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nome' => $nome,
            ':responsavel' => $responsavel,
            ':telefone' => $telefone,
            ':plano' => $plano,
            ':valor_mensal' => $valor_mensal,
            ':vencimento_dia' => $vencimento_dia,
            ':status' => $status
        ]);

        $empresa_id = $pdo->lastInsertId();

        $usuario_nome = !empty($responsavel)
            ? $responsavel
            : $nome;

        $senha_padrao = password_hash('123456', PASSWORD_DEFAULT);

        $sqlUsuario = "INSERT INTO usuarios
    (
        nome,
        senha,
        tipo,
        empresa_id
    )
    VALUES (?, ?, ?, ?)";

        $stmtUsuario = $pdo->prepare($sqlUsuario);

        $stmtUsuario->execute([
            $usuario_nome,
            $senha_padrao,
            'empresa',
            $empresa_id
        ]);

        $_SESSION['msg'] = "Empresa e login criados com sucesso! Senha inicial: 123456";
        $_SESSION['msg_tipo'] = "success";

        header("Location: index.php?action=admin_dashboard");
        exit;
    }

    public function excluirEmpresa()
    {
        $pdo = conectarBanco();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['msg'] = "Empresa não encontrada.";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=admin_dashboard");
            exit;
        }

        try {

            $stmtUsuarios = $pdo->prepare("
            DELETE FROM usuarios
            WHERE empresa_id = ?
            AND tipo = 'empresa'
        ");

            $stmtUsuarios->execute([$id]);

            $stmtEmpresa = $pdo->prepare("
            DELETE FROM empresas
            WHERE id = ?
        ");

            $stmtEmpresa->execute([$id]);

            $_SESSION['msg'] = "Empresa e login excluídos com sucesso!";
            $_SESSION['msg_tipo'] = "success";
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        header("Location: index.php?action=admin_dashboard");
        exit;
    }
    public function editarEmpresa()
    {
        $pdo = conectarBanco();

        $id = $_GET['id'];

        $stmt = $pdo->prepare("SELECT * FROM empresas WHERE id = ?");
        $stmt->execute([$id]);

        $empresa = $stmt->fetch(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/admin/editar_empresa.php';
    }

    public function atualizarEmpresa()
    {
        $pdo = conectarBanco();

        $sql = "UPDATE empresas SET
        nome = :nome,
        responsavel = :responsavel,
        telefone = :telefone,
        plano = :plano,
        valor_mensal = :valor_mensal,
        vencimento_dia = :vencimento_dia,
        status = :status
        WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':id' => $_POST['id'],
            ':nome' => $_POST['nome'],
            ':responsavel' => $_POST['responsavel'],
            ':telefone' => $_POST['telefone'],
            ':plano' => $_POST['plano'],
            ':valor_mensal' => !empty($_POST['valor_mensal']) ? $_POST['valor_mensal'] : null,
            ':vencimento_dia' => !empty($_POST['vencimento_dia']) ? $_POST['vencimento_dia'] : null,
            ':status' => $_POST['status']
        ]);

        $_SESSION['msg'] = "Cliente atualizado com sucesso!";
        $_SESSION['msg_tipo'] = "success";

        header("Location: index.php?action=admin_dashboard");
        exit;
    }
    public function alterarStatusEmpresa()
    {
        $pdo = conectarBanco();

        $id = $_GET['id'] ?? null;
        $status = $_GET['status'] ?? null;

        if (!$id || !$status) {
            $_SESSION['msg'] = "Dados inválidos.";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=admin_dashboard");
            exit;
        }

        $stmt = $pdo->prepare("
        UPDATE empresas 
        SET status = ? 
        WHERE id = ?
    ");

        $stmt->execute([$status, $id]);

        $_SESSION['msg'] = "Status do cliente atualizado com sucesso!";
        $_SESSION['msg_tipo'] = "success";

        header("Location: index.php?action=admin_dashboard");
        exit;
    }
}
