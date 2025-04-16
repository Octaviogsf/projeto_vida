<?php
require_once('..//conn.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário não logado']);
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_FILES['foto'])) {
    $foto = $_FILES['foto'];

    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($foto['type'], $tiposPermitidos)) {
        $dadosImagem = file_get_contents($foto['tmp_name']);

        $sql = "UPDATE user SET foto = :foto, foto_tipo = :tipo WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':foto', $dadosImagem, PDO::PARAM_LOB);
        $stmt->bindParam(':tipo', $foto['type']);
        $stmt->bindParam(':id', $user_id);

        if ($stmt->execute()) {
            echo json_encode(['sucesso' => true, 'mensagem' => 'Foto atualizada com sucesso!', 'user_id' => $user_id]);
        } else {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar no banco de dados.']);
        }
    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Formato de imagem inválido. Use JPEG, PNG ou GIF.']);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Nenhuma imagem enviada.']);
}