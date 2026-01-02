<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario   = trim($_POST['usuario'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $senha     = $_POST['senha'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if (empty($usuario) || empty($email) || empty($senha) || empty($confirmar)) {
        $_SESSION['erro'] = 'Preencha todos os campos.';
        header('Location: register.php');
        exit;
    }

    if (strlen($usuario) < 3) {
        $_SESSION['erro'] = 'Usuário deve ter no mínimo 3 caracteres.';
        header('Location: register.php');
        exit;
    }

    if ($senha !== $confirmar) {
        $_SESSION['erro'] = 'As senhas não conferem.';
        header('Location: register.php');
        exit;
    }

    require_once '../controllers/auth.php';

    $resultado = register($usuario, $email, $senha);

    if ($resultado === true) {
        $_SESSION['sucesso'] = 'Conta criada com sucesso! Faça login.';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['erro'] = $resultado;
        header('Location: register.php');
        exit;
    }
}

$erro = $_SESSION['erro'] ?? '';
$sucesso = $_SESSION['sucesso'] ?? '';
unset($_SESSION['erro'], $_SESSION['sucesso']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cronos Painel - Criar Conta</title>
    <link rel="stylesheet" href="../assets/css/index.css">
     <link rel="icon" href="../assets/img/image.png">
</head>
<body>
    <div class="login-container">
        <form action="register.php" method="POST">
            <h2>CRONOS <span>PAINEL</span></h2>
            <p>Crie sua conta gratuita</p>

            <div class="input-group">
                <input type="text" name="usuario" required>
                <label>Nome de Usuário</label>
            </div>

            <div class="input-group">
                <input type="email" name="email" required>
                <label>E-mail</label>
            </div>

            <div class="input-group">
                <input type="password" name="senha" required>
                <label>Senha</label>
            </div>

            <div class="input-group">
                <input type="password" name="confirmar" required>
                <label>Confirmar Senha</label>
            </div>

            <button type="submit">Cadastrar Agora</button>

            <div class="footer-links">
                <p>Já tem uma conta? <a href="index.php">Faça Login</a></p>
            </div>

            <?php if ($erro): ?>
                <div style="color:red"><?= $erro ?></div>
            <?php endif; ?>

            <?php if ($sucesso): ?>
                <div style="color:green"><?= $sucesso ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
