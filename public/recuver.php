<?php
session_start();
require_once '../config/db.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $mensagem = 'Informe um e-mail válido.';
    } else {

        // Verifica se o e-mail existe
        $sql = "SELECT id FROM users WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if (!$user) {
            $mensagem = 'E-mail não encontrado.';
        } else {

            // Gera token 
            $token = bin2hex(random_bytes(32));
            $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $pdo->prepare("DELETE FROM password_resets WHERE user_id = ?")
            ->execute([$user['id']]);

            // Salva token
            $sql = "INSERT INTO password_resets (user_id, token, expires_at)
                    VALUES (:user_id, :token, :expires)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user['id']);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expires', $expira);
            $stmt->execute();

            // Simula envio de email 
            $mensagem = "
                Link de recuperação gerado:<br><br>
                <a href='reset.php?token=$token'>Clique aqui para redefinir a senha</a>
            ";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cronos Painel - Recuperar Senha</title>
    <link rel="stylesheet" href="../assets/css/index.css">
     <link rel="icon" href="../assets/img/image.png">
</head>
<body>

<div class="login-container">
    <form id="recoverForm" method="POST">
        <h2>CRONOS <span>RECOVER</span></h2>
        <p>Insira seu e-mail para receber as instruções de redefinição.</p>

        <div class="input-group">
            <input type="email" name="email" id="emailRecover" required>
            <label>E-mail cadastrado</label>
        </div>

        <button type="submit">Enviar Link</button>

        <div class="footer-links">
            <p><a href="index.php">Voltar para o Login</a></p>
        </div>

        <?php if ($mensagem): ?>
            <div style="margin-top:15px; color:#38bdf8; text-align:center;">
                <?= $mensagem ?>
            </div>
        <?php endif; ?>
    </form>
</div>

</body>
</html>
