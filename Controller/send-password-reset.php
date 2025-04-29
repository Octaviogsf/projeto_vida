<?php

$email = $_POST["email"];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$mysqli = require __DIR__ . "/../Config.php";

$sql = "UPDATE user
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email);

$stmt->execute();

if ($mysqli->affected_rows) {

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("noreply@example.com");
    $mail->addAddress($email);
    $mail->Subject = "Redefinir Senha";
    $mail->Body = <<<END

    Clique <a href="http://localhost/projeto_vida/Controller/reset-password.php?token=$token">aqui</a> para redefinir sua senha.

    END;

    try {
        $mail->send();
        $message = "Mensagem enviada, por favor, verifique sua caixa de entrada.";
    } catch (Exception $e) {
        $message = "A mensagem não pôde ser enviada. Erro do Email: {$mail->ErrorInfo}";
    }

} else {
    $message = "Este email não está cadastrado em nosso sistema.";
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Mensagem</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">
    <div class="left-panel">
        <h1>Mensagem</h1>
        <img src="../IMG/Design sem nome (2).png" alt="Projeto de Vida">
    </div>

    <div class="right-panel">
        <div class="success-message">
            <h1><?= htmlspecialchars($message) ?></h1>
        </div>
    </div>
</div>

</body>
</html>
