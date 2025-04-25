<?php
require_once('../config/conn.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM user WHERE id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch();

if (!$user) {
    echo "Usuário não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Bem-vindo</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/d650d7db78.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="../IMG/Logo sem fundoe.png" alt="Logo" style="width: 100%; height: 100%;">
        </div>
        <div class="user-name">Olá, <?= htmlspecialchars($user['name'] ?? 'Usuário') ?>!</div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <!-- Imagem de perfil do usuário -->
            <div class="profile-icon">
                <img src="imagem.php?id=<?= $user_id ?>" alt="Foto de Perfil"
                    style="width: 100%; height: 100%; border-radius: 50%;">
            </div>
            <a class="logout" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
    </div>


    <!-- Motivational Section -->
    <div class="motivacional">
        Frases motivacionais
    </div>
    
    <div class="metas-section">
        <h3>Metas ainda não cumpridas:</h3>
        <div class="metas-grid">
            <div class="meta-card"></div>
            <div class="meta-card"></div>
            <div class="meta-card"></div>
            <div class="meta-card"></div>
            <div class="meta-card"></div>
            <div class="meta-card"></div>
        </div>
    </div>
</body>

</html>