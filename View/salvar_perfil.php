<?php
require_once('../config/conn.php');
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Coleta os dados do formulário
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$data_nascimento = $_POST['data_nascimento'] ?? '';
$senha = $_POST['senha'] ?? '';
$sobre_mim = $_POST['sobre_mim'] ?? '';

// Validação básica
if (empty($nome) || empty($email)) {
    echo "Nome e email são obrigatórios.";
    exit();
}

try {
    if (!empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE user 
                SET name = :nome, email = :email, birthdate = :data_nascimento, password_hash = :senha, sobre_mim = :sobre_mim 
                WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $senhaHash);
    } else {
        $sql = "UPDATE user 
                SET name = :nome, email = :email, birthdate = :data_nascimento, sobre_mim = :sobre_mim 
                WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
    }

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':data_nascimento', $data_nascimento);
    $stmt->bindParam(':sobre_mim', $sobre_mim);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('Location: perfil.php');
        exit();
    } else {
        echo "Erro ao atualizar perfil.";
    }
} catch (PDOException $e) {
    echo "Erro no banco de dados: " . $e->getMessage();
}
