<?php
require_once('../config/conn.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Busca os dados do usuário
$sql = "SELECT * FROM user WHERE id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch();

if (!$user) {
    echo "Usuário não encontrado.";
    exit();
}

// Busca todos os planejamentos do usuário
$sql_planejamento = "SELECT 
    objetivos_curto, ja_faz_curto, precisa_fazer_curto, data_curto,
    objetivos_medio, ja_faz_medio, precisa_fazer_medio, data_medio,
    objetivos_longo, ja_faz_longo, precisa_fazer_longo, data_longo
FROM planejamento_futuro 
WHERE user_id = :user_id 
ORDER BY data_envio DESC";

$stmt_planejamento = $pdo->prepare($sql_planejamento);
$stmt_planejamento->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_planejamento->execute();
$planejamentos = $stmt_planejamento->fetchAll();

function diasRestantes($dataFinal)
{
    $hoje = new DateTime();
    $dataAlvo = new DateTime($dataFinal);
    $diferenca = $hoje->diff($dataAlvo);
    return ($hoje > $dataAlvo) ? "Expirado há {$diferenca->days} dias" : "Faltam {$diferenca->days} dias";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/d650d7db78.js" crossorigin="anonymous"></script>
    <style>
        .carousel-container {
            position: relative;
            width: 600px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin: 0 auto;
            margin-top: 100px;
        }

        .carousel {
            display: flex;
            transition: transform 0.5s ease;
        }

        .carousel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .objetivos-planejamento {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #f7f7f7;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .objetivos-planejamento h2 {
            margin-bottom: 20px;
        }

        .objetivos-planejamento ul {
            list-style: none;
            padding: 0;
        }

        .objetivos-planejamento li {
            margin-bottom: 25px;
            font-size: 35px;
            padding: 10px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: pre-wrap;
        }

        .metas-grid {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .metas-section {
            padding: 50px;
            text-align: center;
        }

        .footer {
            text-align: center;
            padding: 30px;
            margin-top: 50px;
        }

        em {
            text-align: left;
        }

        h2 {
            font-weight: normal;
            font-size: 68px;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <a href="index.php">
            <div class="logo">
                <img src="../IMG/Logo sem fundoe.png" alt="Logo" style="width: 100%; height: 100%;">
            </div>
        </a>
        <div class="user-name">Olá, <?= htmlspecialchars($user['name'] ?? 'Usuário') ?>!</div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <div class="profile-icon">
                <a href="perfil.php">
                    <img id="fotoPerfil" src="imagem.php?id=<?= $user_id ?>" alt="Foto de Perfil"
                         style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;"
                         onerror="this.onerror=null; this.style.display='none'; this.insertAdjacentHTML('afterend', '<i style=\'font-size: 80px;\' class=\'fa-solid fa-circle-user\'></i>');">
                </a>
            </div>
            <a class="logout" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
    </div>