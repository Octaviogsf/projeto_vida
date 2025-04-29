<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/../Config.php";

$sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("Token não encontrado.");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("O token expirou.");
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">
    <div class="left-panel">
        <h1>Redefinir Senha</h1>
        <img src="../IMG/Design sem nome (2).png" alt="Projeto de Vida">
    </div>

    <div class="right-panel">
        <form method="post" action="process-reset-password.php">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <label for="password">Nova Senha:</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirmation">Repetir Senha:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <button type="submit">Redefinir Senha</button>
        </form>
    </div>
</div>

</body>
</html>
