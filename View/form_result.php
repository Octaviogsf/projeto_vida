<?php
require_once '../config/conn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Buscar dados do usuário
$stmt = $pdo->prepare("SELECT name, birthdate FROM user WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuário não encontrado.");
}

// Buscar última resposta do usuário
$stmt = $pdo->prepare("SELECT * FROM respostas_usuario WHERE user_id = ? ORDER BY id DESC LIMIT 1");
$stmt->execute([$user_id]);
$respostas = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/d650d7db78.js" crossorigin="anonymous"></script>
    <title>Resultados da Autoavaliação</title>
    <style>
        body {
            background-color: #162136;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            background-color: #0d1829;
            padding: 15px;
            margin: 0;
            font-size: 68px;
            font-weight: normal;
        }

        .content {
            max-width: 1000px;
            margin: auto;
            padding: 40px;
            font-size: 30px;
        }

        .label {
            display: block;
            font-size: 36px;
            margin-top: 30px;
            margin-bottom: 5px;
        }

        .value {
            background-color: white;
            color: black;
            padding: 15px;
            border-radius: 8px;
            font-size: 30px;
            word-wrap: break-word;
            /* Quebra palavras longas */
            overflow-wrap: break-word;
            /* Quebra palavras longas em qualquer lugar */
            white-space: normal;
            /* Permite quebra de linha */
            word-break: break-word;
            /* Garante que palavras grandes quebrem */
        }


        .checkbox-group {
            background-color: white;
            color: black;
            padding: 20px;
            border-radius: 8px;
            margin-top: 10px;
            margin-bottom: 40px;
            border: 2px solid #31405e;
        }

        .checkbox-group label {
            display: block;
            font-size: 26px;
            margin-bottom: 10px;
        }

        .not-found {
            text-align: center;
            padding: 100px 20px;
        }

        .not-found p {
            font-size: 36px;
        }

        .not-found a {
            display: inline-block;
            margin-top: 30px;
            font-size: 30px;
            background-color: #0e6ba8;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            text-decoration: none;
        }

        .not-found a:hover {
            background-color: #095a88;
        }

        br {
            margin-bottom: 10px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #0d1829;
            padding: 10px 20px;
        }

        .logo {
            height: 80px;
        }

        .user-name {
            font-size: 28px;
        }

        .profile-icon {
            margin-right: 20px;
        }

        .logout {
            font-size: 40px;
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>
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
    <br>
    <br>
    <br>
    <h2>Resultados da Autoavaliação</h2>

    <?php if ($respostas): ?>
        <div class="content">
            <span class="label">Nome:</span>
            <div class="value"><?= htmlspecialchars($user['name']) ?></div>

            <span class="label">Data de Nascimento:</span>
            <div class="value"><?= htmlspecialchars($user['birthdate']) ?></div>

            <span class="label">Minhas Lembranças:</span>
            <div class="value"><?= htmlspecialchars($respostas['lembrancas']) ?></div>

            <span class="label">O que gosto de fazer:</span>
            <div class="value"><?= htmlspecialchars($respostas['gosto_fazer']) ?></div>

            <span class="label">O que não gosto:</span>
            <div class="value"><?= htmlspecialchars($respostas['nao_gosto']) ?></div>

            <span class="label">Como é minha rotina:</span>
            <div class="value"><?= htmlspecialchars($respostas['rotina']) ?></div>

            <span class="label">O que faço no lazer:</span>
            <div class="value"><?= htmlspecialchars($respostas['lazer']) ?></div>

            <span class="label">O que faço para estudar:</span>
            <div class="value"><?= htmlspecialchars($respostas['estudos']) ?></div>

            <span class="label">Como cuido do meu físico:</span>
            <div class="value"><?= htmlspecialchars($respostas['fisico']) ?></div>

            <span class="label">Como cuido do meu Intelecto:</span>
            <div class="value"><?= htmlspecialchars($respostas['intelectual'] ?? '') ?></div>

            <span class="label">Como cuido do meu emocional:</span>
            <div class="value"><?= htmlspecialchars($respostas['emocional']) ?></div>

            <span class="label">Meus Pontos Fracos:</span>
            <div class="value"><?= htmlspecialchars($respostas['pontos_fracos']) ?></div>

            <span class="label">Meus Pontos Fortes:</span>
            <div class="value"><?= htmlspecialchars($respostas['pontos_fortes']) ?></div>

            <span class="label">Família:</span>
            <div class="value"><?= htmlspecialchars($respostas['familia']) ?></div>

            <span class="label">Amigos:</span>
            <div class="value"><?= htmlspecialchars($respostas['amigos']) ?></div>

            <span class="label">Escolas:</span>
            <div class="value"><?= htmlspecialchars($respostas['escolas']) ?></div>

            <span class="label">Sociedade:</span>
            <div class="value"><?= htmlspecialchars($respostas['sociedade']) ?></div>

            <span class="label">Vida Escolar:</span>
            <div class="value"><?= htmlspecialchars($respostas['vida_escolar']) ?></div>

            <span class="label">Visão dos Amigos:</span>
            <div class="value"><?= htmlspecialchars($respostas['visao_amigos']) ?></div>

            <span class="label">Visão dos Familiares:</span>
            <div class="value"><?= htmlspecialchars($respostas['visao_familiares']) ?></div>

            <span class="label">Visão dos Professores:</span>
            <div class="value"><?= htmlspecialchars($respostas['visao_professores']) ?></div>

            <!-- Seção de checkbox: Meus Valores -->
            <span class="label">Meus Valores:</span>
            <div class="checkbox-group">
                <?php $valores = explode(",", $respostas['valores'] ?? ""); ?>
                <?php foreach (['Respeito', 'Amor', 'Honestidade', 'Solidariedade', 'Responsabilidade'] as $valor): ?>
                    <label>
                        <input type="checkbox" disabled <?= in_array($valor, $valores) ? 'checked' : '' ?>> <?= $valor ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <!-- Seção de checkbox: Minhas Aptidões -->
            <span class="label">Minhas Principais Aptidões:</span>
            <div class="checkbox-group">
                <?php $aptidoes = explode(",", $respostas['aptidoes'] ?? ""); ?>
                <?php foreach (['Criatividade', 'Comunicação', 'Empatia', 'Liderança', 'Organização'] as $apt): ?>
                    <label>
                        <input type="checkbox" disabled <?= in_array($apt, $aptidoes) ? 'checked' : '' ?>> <?= $apt ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="not-found">
            <p>Nenhuma resposta encontrada.</p>
            <a href="form.php">Responder agora</a>
        </div>
    <?php endif; ?>
</body>

</html>