<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/Config.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="left-panel">
        <h1>Login</h1>
        <img src="IMG/Design sem nome (2).png" alt="Projeto de Vida">
    </div>

    <div class="right-panel">
        <?php if ($is_invalid): ?>
            <em>Email ou senha inválidos</em>
        <?php endif; ?>

        <form method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email"
                   value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>

            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>
            <button type="submit" style="margin-top: 10px"><a href="signup.html">Criar Conta</a></button>
        </form>

        <a href="forgot-password.php" style="color: #000000">Esqueci minha senha</a>
    </div>
</div>

</body>
</html>
