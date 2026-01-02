<?php
require_once __DIR__ . '/../config/db.php';
// login
function login($usuario, $senha) {
    global $pdo;

    $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username' => $usuario
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return "Usuário não encontrado.";
    }

    if (!password_verify($senha, $user['password'])) {
        return "Senha incorreta.";
    }

  
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    return true;
}

// registro
function register($username, $email, $senha) {
    global $pdo;

    // Verifica se usuario ou email existem
    $check = $pdo->prepare(
        "SELECT id FROM users WHERE username = :username OR email = :email"
    );
    $check->execute([
        ':username' => $username,
        ':email' => $email
    ]);

    if ($check->fetch()) {
        return "Usuário ou email já cadastrados.";
    }

    $hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password)
            VALUES (:username, :email, :password)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $hash
    ]);

    return true;
}
