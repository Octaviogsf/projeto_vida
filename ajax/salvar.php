<?php
require_once('../config/conn.php');
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
            echo json_encode(['sucesso' => true, 'mensagem' => 'Foto salva com sucesso!']);
        } else {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao salvar no banco de dados.']);
        }
    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Formato de imagem inválido. Use JPEG, PNG ou GIF.']);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Nenhuma imagem enviada.']);
}
