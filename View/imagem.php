<?php
require_once('../config/conn.php');

if (!isset($_GET['id'])) {
    exit('ID do usuário não fornecido.');
}

$user_id = intval($_GET['id']);

$sql = "SELECT conteudo, tipo FROM fotos WHERE user_id = :id ORDER BY id DESC LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $foto = $stmt->fetch();
    header("Content-type: " . $foto['tipo']);
    echo $foto['conteudo'];
} else {
    // Imagem padrão
    $default = '../default.png';
    if (file_exists($default)) {
        header("Content-type: image/png");
        readfile($default);
    } else {
        echo 'Imagem não disponível.';
    }
}
