<?php
require_once('../config/conn.php');

if (!isset($_GET['id'])) {
    exit('ID do usuário não fornecido.');
}

$user_id = intval($_GET['id']);

$sql = "SELECT foto, foto_tipo FROM fotos WHERE user_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch();
    header("Content-type: " . $user['foto_tipo']);
    echo $user['foto'];
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
