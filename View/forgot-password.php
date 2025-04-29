<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="../style.css"> <!-- Certifique-se de que esse arquivo contenha o CSS que você forneceu -->
</head>

<body>

    <div class="container">
        <!-- Painel Esquerdo -->
        <div class="left-panel">
            <h1 style="margin-bottom: -5px">Recuperar</h1>
            <br>
            <h1 style="margin-bottom: -20px">Senha</h1>
            <img src="../IMG/Design sem nome (2).png" alt="Projeto de Vida">
        </div>

        <!-- Painel Direito -->
        <div class="right-panel">
            <form method="post" action="../Controller/send-password-reset.php">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>

                <label for="confirm_email">Confirmação do Email:</label>
                <input type="email" name="confirm_email" id="confirm_email" required>

                <button type="submit">Recuperar Senha</button>
            </form>
        </div>
    </div>

</body>

</html>