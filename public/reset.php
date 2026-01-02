<?php
session_start();
require_once '../config/db.php';

$token = $_GET['token'] ?? $_POST['token'] ?? '';
$erro = '';
$sucesso = '';
$valido = false;

if ($token) {
    $sql = "SELECT pr.id, pr.user_id, pr.expires_at
            FROM password_resets pr
            WHERE pr.token = :token
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $reset = $stmt->fetch();

    if ($reset && strtotime($reset['expires_at']) > time()) {
        $valido = true;
    } else {
        $erro = 'Link inválido ou expirado.';
    }
} else {
    $erro = 'Token não informado.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valido) {

    $senha = $_POST['senha'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if (empty($senha) || empty($confirmar)) {
        $erro = 'Preencha todos os campos.';
    } elseif ($senha !== $confirmar) {
        $erro = 'As senhas não conferem.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter no mínimo 6 caracteres.';
    } else {

        $hash = password_hash($senha, PASSWORD_DEFAULT);

        // Atualiza senha
        $sql = "UPDATE users SET password = :senha WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $hash);
        $stmt->bindParam(':id', $reset['user_id']);
        $stmt->execute();

        // Remove token
        $sql = "DELETE FROM password_resets WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $reset['id']);
        $stmt->execute();

        $sucesso = 'Senha redefinida com sucesso! Você já pode fazer login.';
        $valido = false;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cronos Painel - Nova Senha</title>
     <link rel="icon" href="../assets/img/image.png">
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>

<div class="login-container">
    <form method="POST">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <h2>CRONOS <span>NOVA SENHA</span></h2>

        <?php if ($erro): ?>
            <p style="color:#ff4d4d; text-align:center;"><?= $erro ?></p>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <p style="color:#00ff88; text-align:center;">
                <?= $sucesso ?><br>
                <a href="index.php">Ir para login</a>
            </p>
        <?php endif; ?>

        <?php if ($valido): ?>
            <div class="input-group">
                <input type="password" name="senha" required>
                <label>Nova Senha</label>
            </div>

            <div class="input-group">
                <input type="password" name="confirmar" required>
                <label>Confirmar Senha</label>
            </div>

            <button type="submit">Redefinir Senha</button>
        <?php endif; ?>
    </form>
</div>

</body>
</html>
