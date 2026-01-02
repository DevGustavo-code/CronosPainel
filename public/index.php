<?php
session_start();

$erro = $_SESSION['erro'] ?? '';
unset($_SESSION['erro']);

// PROCESSA LOGIN
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario = trim($_POST['usuario'] ?? '');
    $senha   = $_POST['senha'] ?? '';

    // Validacoes no backend
    if (empty($usuario) || empty($senha)) {
        $_SESSION['erro'] = 'Preencha todos os campos.';
        header('Location: index.php');
        exit;
    }

    if (strlen($usuario) > 20) {
        $_SESSION['erro'] = 'Usuário muito longo (máx. 20 caracteres).';
        header('Location: index.php');
        exit;
    }

    if (strlen($senha) < 6) {
        $_SESSION['erro'] = 'Senha deve ter no mínimo 6 caracteres.';
       header('Location: index.php');
        exit;
    }

    require_once '../controllers/auth.php';

    $resultado = login($usuario, $senha);

    if ($resultado === true) {
        header('Location: dashboard.php');
        exit;
    } else {
        // erro
        $_SESSION['erro'] = $resultado;
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cronos Painel - Login</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="icon" href="../assets/img/image.png">
</head>
<body>

<div class="login-container">
    <form id="loginForm" method="POST">
        <h2>CRONOS <span>PAINEL</span></h2>
        <p>Acesse sua conta para continuar</p>

        <div class="input-group">
            <input type="text" name="usuario" id="usuario" maxlength="20" required>
            <label>Usuário</label>
        </div>

        <div class="input-group">
            <input type="password" name="senha" id="senha" minlength="6" required>
            <label>Senha</label>
        </div>

        <button type="submit">Entrar</button>

        <?php if ($erro): ?>
            <div id="message" style="color:#ff4d4d; margin-top:10px;">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php else: ?>
            <div id="message" style="margin-top:10px;"></div>
        <?php endif; ?>

        <div class="footer-links">
            <p>Esqueceu sua senha? <a href="recuver.php">Recuperar</a></p>
            <p>Não tem uma conta? <a href="register.php">Criar conta</a></p>
        </div>
    </form>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function (e) {
    const usuario = document.getElementById('usuario').value.trim();
    const senha   = document.getElementById('senha').value;
    const msg     = document.getElementById('message');

    msg.innerText = '';
    msg.style.color = '#ff4d4d';

    if (usuario.length === 0 || senha.length === 0) {
        e.preventDefault();
        msg.innerText = 'Preencha todos os campos.';
        return;
    }

    if (usuario.length > 20) {
        e.preventDefault();
        msg.innerText = 'Usuário pode ter no máximo 20 caracteres.';
        return;
    }

    if (senha.length < 6) {
        e.preventDefault();
        msg.innerText = 'Senha deve ter no mínimo 6 caracteres.';
        return;
    }
});
</script>

</body>
</html>
