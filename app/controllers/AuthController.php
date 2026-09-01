<?php

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../../config/Database.php';

class AuthController
{
    public function login()
    {
        require __DIR__ . '/../views/login.php';
    }

    public function autenticar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $pdo = conectarBanco();


        $nome = $_POST['nome'];
        $senha = $_POST['senha'];

        $usuarioModel = new Usuario($pdo);
        $usuario = $usuarioModel->buscarPorNome($nome);

        if ($usuario && password_verify($senha, $usuario['senha'])) {

            // bloqueio para clientes empresa
            if (!empty($usuario['empresa_id'])) {

                $stmt = $pdo->prepare("
                SELECT status 
                FROM empresas 
                WHERE id = ?
            ");

                $stmt->execute([$usuario['empresa_id']]);
                $empresa = $stmt->fetch(PDO::FETCH_ASSOC);

                if (
                    $empresa &&
                    in_array($empresa['status'], ['suspenso', 'inadimplente'])
                ) {
                    $_SESSION['msg'] = "Seu acesso foi bloqueado. Entre em contato com o administrador. (21) 98828-1330";
                    $_SESSION['msg_tipo'] = "danger";

                    header("Location: index.php?action=login");
                    exit;
                }
            }

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['empresa_id'] = $usuario['empresa_id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['tipo'] = $usuario['tipo'];

            $stmt = $pdo->prepare("
            INSERT INTO acessos (
            usuario_id,
            empresa_id,
            login_em)
            VALUES (?, ?, NOW())");

            $stmt->execute([$usuario['id'], $usuario['empresa_id']]);

            $_SESSION['acesso_id'] = $pdo->lastInsertId();

            if ($usuario['tipo'] === 'funcionario') {
                header("Location: index.php?action=vendas");
                exit;
            } else {
                header("Location: index.php?action=home");
                exit;
            }
        } else {
            $_SESSION['msg'] = "Usuário ou senha inválidos";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=login");
            exit;
        }
    }

    public function logout()
    {
        $pdo = conectarBanco();

        $acesso_id = $_SESSION['acesso_id'] ?? null;

        if ($acesso_id) {
            $stmt = $pdo->prepare("
            UPDATE acessos
            SET logout_em = NOW(),
            tempo_conectado = TIMESTAMPDIFF(
            MINUTE,
            login_em,
            NOW()
            )
            WHERE id = ?
            ");

            $stmt->execute([$acesso_id]);
        }

        session_unset();
        session_destroy();

        header("Location: index.php?action=login");
        exit;
    }
    public function alterarSenha()
    {
        require __DIR__ . '/../views/alterar_senha.php';
    }

    public function salvarSenha()
    {
        $pdo = conectarBanco();

        $usuario_id = $_SESSION['usuario_id'];

        $senhaAtual = $_POST['senha_atual'];
        $novaSenha = $_POST['nova_senha'];
        $confirmar = $_POST['confirmar_senha'];

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$usuario_id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario || !password_verify($senhaAtual, $usuario['senha'])) {
            $_SESSION['msg'] = "Senha atual incorreta!";
            $_SESSION['msg_tipo'] = "danger";
            header("Location: index.php?action=alterar_senha");
            exit;
        }

        if ($novaSenha !== $confirmar) {
            $_SESSION['msg'] = "As senhas não coincidem!";
            $_SESSION['msg_tipo'] = "danger";
            header("Location: index.php?action=alterar_senha");
            exit;
        }

        $novaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
        $stmt->execute([$novaHash, $usuario_id]);

        $_SESSION['msg'] = "Senha alterada com sucesso!";
        $_SESSION['msg_tipo'] = "success";

        header("Location: index.php?action=alterar_senha");
        exit;
    }

    public function resetSimples()
    {
        $pdo = conectarBanco();

        $login = $_POST['login'];
        $nova = $_POST['nova_senha'];
        $confirmar = $_POST['confirmar'];

        if ($nova !== $confirmar) {
            $_SESSION['msg'] = "Senhas não coincidem";
            $_SESSION['msg_tipo'] = "danger";
            header("Location: index.php?action=esqueci_senha");
            exit;
        }

        $empresa_nome = $_POST['empresa_nome'];

        $stmt = $pdo->prepare("
    SELECT u.* 
    FROM usuarios u
    JOIN empresas e ON u.empresa_id = e.id
    WHERE u.nome LIKE ? 
    AND e.nome LIKE ?
");

        $stmt->execute([
            "%$login%",
            "%$empresa_nome%"
        ]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            $_SESSION['msg'] = "Usuário não encontrado";
            $_SESSION['msg_tipo'] = "danger";
            header("Location: index.php?action=esqueci_senha");
            exit;
        }

        $novaHash = password_hash($nova, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
        $stmt->execute([$novaHash, $usuario['id']]);

        $_SESSION['msg'] = "Senha redefinida com sucesso!";
        $_SESSION['msg_tipo'] = "success";

        header("Location: index.php?action=login");
        exit;
    }

    public function cadastrarFuncionario()
    {
        require __DIR__ . '/../views/cadastrar_funcionario.php';
    }

    public function salvarFuncionario()
    {
        $pdo = conectarBanco();

        $nome = $_POST['nome'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $empresa_id = $_SESSION['empresa_id'];

        $stmt = $pdo->prepare("
        INSERT INTO usuarios
        (nome, senha, empresa_id, tipo)
        VALUES (?, ?, ?, 'funcionario')
    ");

        $stmt->execute([
            $nome,
            $senha,
            $empresa_id
        ]);

        $_SESSION['msg'] = "Funcionário cadastrado!";
        $_SESSION['msg_tipo'] = "success";

        header("Location: index.php?action=home");
        exit;
    }

    public function listarFuncionarios()
    {
        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];

        $stmt = $pdo->prepare("
        SELECT id, nome, empresa_id, tipo
        FROM usuarios
        WHERE empresa_id = ?
        AND tipo = 'funcionario'
        ORDER BY nome ASC
    ");

        $stmt->execute([$empresa_id]);

        $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/funcionarios.php';
    }

    public function atualizarFuncionario()
    {
        $pdo = conectarBanco();

        $id = $_POST['id'] ?? null;
        $nome = trim($_POST['nome'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $empresa_id = $_SESSION['empresa_id'];

        if (!$id || empty($nome)) {
            $_SESSION['msg'] = "Dados inválidos.";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=funcionarios");
            exit;
        }

        // Se a senha foi preenchida, atualiza nome e senha
        if (!empty($senha)) {

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("
            UPDATE usuarios
            SET nome = ?, senha = ?
            WHERE id = ?
            AND empresa_id = ?
            AND tipo = 'funcionario'
        ");

            $stmt->execute([
                $nome,
                $senhaHash,
                $id,
                $empresa_id
            ]);
        } else {

            // Se não informou senha, mantém a senha atual
            $stmt = $pdo->prepare("
            UPDATE usuarios
            SET nome = ?
            WHERE id = ?
            AND empresa_id = ?
            AND tipo = 'funcionario'
        ");

            $stmt->execute([
                $nome,
                $id,
                $empresa_id
            ]);
        }

        $_SESSION['msg'] = "Funcionário atualizado com sucesso!";
        $_SESSION['msg_tipo'] = "success";

        header("Location: index.php?action=funcionarios");
        exit;
    }
    
    public function buscarFuncionarioPorId()
    {
        $pdo = conectarBanco();

        $empresa_id = $_SESSION['empresa_id'];

        $stmt = $pdo->prepare("
            SELECT id, nome, empresa_id, tipo
            FROM usuarios
            WHERE id = ?
            AND empresa_id = ?
            AND tipo = 'funcionario'
        ");

        $stmt->execute([$empresa_id]);

        $funcionarios =  $stmt->fetch(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/funcionarios.php';
    }

    public function editarFuncionario()
    {
        $pdo = conectarBanco();

        $id = $_GET['id'] ?? null;
        $empresa_id = $_SESSION['empresa_id'];

        if (!$id) {
            $_SESSION['msg'] = "Funcionário não encontrado.";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=funcionarios");
            exit;
        }

        $stmt = $pdo->prepare("
        SELECT id, nome
        FROM usuarios
        WHERE id = ?
        AND empresa_id = ?
        AND tipo = 'funcionario'
    ");

        $stmt->execute([
            $id,
            $empresa_id
        ]);

        $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$funcionario) {
            $_SESSION['msg'] = "Funcionário não encontrado.";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=funcionarios");
            exit;
        }

        require __DIR__ . '/../views/editar_funcionario.php';
    }

    public function excluirFuncionario()
    {
        $pdo = conectarBanco();

        $id = $_GET['id'] ?? null;
        $empresa_id = $_SESSION['empresa_id'];

        if (!$id) {
            $_SESSION['msg'] = "Funcionário não encontrado.";
            $_SESSION['msg_tipo'] = "danger";

            header("Location: index.php?action=funcionarios");
            exit;
        }

        $stmt = $pdo->prepare("
        DELETE FROM usuarios
        WHERE id = ?
        AND empresa_id = ?
        AND tipo = 'funcionario'
    ");

        $stmt->execute([
            $id,
            $empresa_id
        ]);

        $_SESSION['msg'] = "Funcionário excluído com sucesso!";
        $_SESSION['msg_tipo'] = "success";

        header("Location: index.php?action=funcionarios");
        exit;
    }
}
