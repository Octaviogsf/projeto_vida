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
<?php
require_once '../config/conn.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("Usuário não autenticado.");
}

$stmt = $pdo->prepare("SELECT name, birthdate, password_hash, sobre_mim FROM user WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuário não encontrado.");
}

$stmt = $pdo->prepare("SELECT * FROM respostas_usuario WHERE user_id = ?");
$stmt->execute([$user_id]);
$respostas = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/d650d7db78.js" crossorigin="anonymous"></script>
    <title>Quem sou eu?</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #162136;
            color: white;
        }

        h2 {
            text-align: center;
            background-color: #0d1829;
            padding: 15px;
            margin: 0;
            font-size: 68px;
            font-weight: normal;

        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            gap: 40px;
        }

        .column {
            width: 48%;
            padding: 10px;
            box-sizing: border-box;
        }

        .column.right {
            border-left: 2px solid #1f2c45;
            font-size: 50px;
            font-weight: normal;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="date"],
        input[type="password"],
        textarea {
            width: 100%;
            padding: 8px;
            background-color: #1f2c45;
            border: 1px solid #31405e;
            border-radius: 5px;
            color: white;
            font-size: 30px;

        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        .checkbox-group {
            margin: 10px 0;
        }

        .checkbox-group label {
            display: inline-block;
            margin-right: 10px;
            font-weight: normal;
        }

        .checkbox-group {
            margin: 10px 0;
        }

        .checkbox-group label {
            display: block;
            margin: 5px 0;
            font-weight: normal;
        }

        input[type="submit"] {
            background-color: #0e6ba8;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            margin: 20px auto;
            display: block;
            font-size: 46px;
            cursor: pointer;
        }

        input[readonly] {
            background-color: #1c293f;
        }

        textarea {
            height: 60px;
            resize: vertical;
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
            <!-- Imagem de perfil do usuário -->
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
    <h2>Quem sou eu?</h2>
    <form action="../Controller/salve.php" method="post">
        <div class="column">
            <label>Nome:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($user['name']) ?>" readonly>

            <label>Data de Nascimento:</label>
            <input type="date" name="nascimento" value="<?= $user['birthdate'] ?>" readonly>

            <label>Minhas Lembranças:</label>
            <textarea name="lembrancas"><?= htmlspecialchars($respostas['lembrancas'] ?? '') ?></textarea>

            <label>O que gosto de fazer:</label>
            <input type="text" name="gosto_fazer" value="<?= htmlspecialchars($respostas['gosto_fazer'] ?? '') ?>">

            <label>O que não gosto:</label>
            <input type="text" name="nao_gosto" value="<?= htmlspecialchars($respostas['nao_gosto'] ?? '') ?>">

            <label>Como é minha rotina:</label>
            <input type="text" name="rotina" value="<?= htmlspecialchars($respostas['rotina'] ?? '') ?>">

            <label>O que faço no lazer:</label>
            <input type="text" name="lazer" value="<?= htmlspecialchars($respostas['lazer'] ?? '') ?>">

            <label>O que faço para estudar:</label>
            <input type="text" name="estudos" value="<?= htmlspecialchars($respostas['estudos'] ?? '') ?>">

            <label>Como cuido do meu físico:</label>
            <input type="text" name="fisico" value="<?= htmlspecialchars($respostas['fisico'] ?? '') ?>">

            <label>Como cuido do meu intelecto:</label>
            <input type="text" name="intelecto" value="<?= htmlspecialchars($respostas['intelecto'] ?? '') ?>">

            <label>Como cuido do meu emocional:</label>
            <input type="text" name="emocional" value="<?= htmlspecialchars($respostas['emocional'] ?? '') ?>">
        </div>

        <div class="column right">
            <label>Meus Pontos Fracos:</label>
            <textarea name="pontos_fracos"><?= htmlspecialchars($respostas['pontos_fracos'] ?? '') ?></textarea>

            <label>Meus Pontos Fortes:</label>
            <textarea name="pontos_fortes"><?= htmlspecialchars($respostas['pontos_fortes'] ?? '') ?></textarea>

            <label>Meus Valores:</label>
            <div class="checkbox-group">
                <?php $valores = explode(",", $respostas['valores'] ?? ""); ?>
                <?php foreach (['Respeito', 'Amor', 'Honestidade', 'Solidariedade', 'Responsabilidade'] as $valor): ?>
                    <label><input type="checkbox" name="valores[]" value="<?= $valor ?>" <?= in_array($valor, $valores) ? "checked" : "" ?>> <?= $valor ?></label>
                <?php endforeach; ?>
            </div>

            <label>Minhas Principais Aptidões:</label>
            <div class="checkbox-group">
                <?php $aptidoes = explode(",", $respostas['aptidoes'] ?? ""); ?>
                <?php foreach (['Criatividade', 'Comunicação', 'Empatia', 'Liderança', 'Organização'] as $apt): ?>
                    <label><input type="checkbox" name="aptidoes[]" value="<?= $apt ?>" <?= in_array($apt, $aptidoes) ? "checked" : "" ?>> <?= $apt ?></label>
                <?php endforeach; ?>
            </div>

            <label>Como me relaciono com:</label>
            Família: <input type="text" name="familia" value="<?= htmlspecialchars($respostas['familia'] ?? '') ?>">
            Amigos: <input type="text" name="amigos" value="<?= htmlspecialchars($respostas['amigos'] ?? '') ?>">
            Escola: <input type="text" name="escolas" value="<?= htmlspecialchars($respostas['escolas'] ?? '') ?>">
            Sociedade: <input type="text" name="sociedade"
                value="<?= htmlspecialchars($respostas['sociedade'] ?? '') ?>">

            <label>Como foi minha vida escolar:</label>
            <textarea name="vida_escolar"><?= htmlspecialchars($respostas['vida_escolar'] ?? '') ?></textarea>

            <label>Como me veem:</label>
            Meus amigos: <input type="text" name="visao_amigos"
                value="<?= htmlspecialchars($respostas['visao_amigos'] ?? '') ?>">
            Meus familiares: <input type="text" name="visao_familiares"
                value="<?= htmlspecialchars($respostas['visao_familiares'] ?? '') ?>">
            Meus professores: <input type="text" name="visao_professores"
                value="<?= htmlspecialchars($respostas['visao_professores'] ?? '') ?>">
        </div>

        <input type="submit" value="Enviar Autoavaliação">
    </form>
</body>

</html>