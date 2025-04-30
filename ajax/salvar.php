<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Upload de Foto</title>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="card-azul">
<?php
require_once('../config/conn.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo '<p>Usuário não logado</p>';
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_FILES['foto'])) {
    $foto = $_FILES['foto'];

    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($foto['type'], $tiposPermitidos)) {
        $dadosImagem = file_get_contents($foto['tmp_name']);
        $nomeImagem = $foto['name'];
        $tipo = $foto['type'];
        $tamanho = $foto['size'];

        $sql = "INSERT INTO fotos (nome, conteudo, tipo, tamanho, user_id)
                VALUES (:nome, :conteudo, :tipo, :tamanho, :user_id)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nomeImagem);
        $stmt->bindParam(':conteudo', $dadosImagem, PDO::PARAM_LOB);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':tamanho', $tamanho);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            echo '<p>Foto salva com sucesso!</p>';
        } else {
            echo '<p>Erro ao salvar no banco de dados.</p>';
        }
    } else {
        echo '<p>Formato de imagem inválido. Utilize JPEG, PNG ou GIF.</p>';
    }
} else {
    echo '<p>Nenhuma imagem enviada.</p>';
}
?>
    <a href="../View/perfil.php" class="button-link">Editar perfil</a>
    <a href="../View/index.php" class="button-link">Página Inicial</a>
</div>

</body>
</html>
