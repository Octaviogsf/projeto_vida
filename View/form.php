<?php
require_once '../config/conn.php';
session_start();

// Verifica se o usuário está logado
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    die("Usuário não autenticado.");
}

// Busca os dados do usuário
$stmt = $pdo->prepare("SELECT name, birthdate, password_hash, sobre_mim FROM user WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuário não encontrado.");
}

// Busca as respostas do usuário na tabela respostas_usuario
$stmt = $pdo->prepare("SELECT * FROM respostas_usuario WHERE user_id = ?");
$stmt->execute([$user_id]);
$respostas = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quem sou eu?</title>
</head>
<body>
    <h2>Quem sou eu?</h2>
    <form action="../Controller/salve.php" method="post">
        Nome: <input type="text" name="nome" value="<?= htmlspecialchars($user['name']) ?>" readonly><br>
        Data de Nascimento: <input type="date" name="nascimento" value="<?= $user['birthdate'] ?>" readonly><br>

        Minhas Lembranças:<br>
        <textarea name="lembrancas"><?= htmlspecialchars($respostas['lembrancas'] ?? '') ?></textarea><br><br>

        O que gosto de fazer:<br>
        <input type="text" name="gosto_fazer" value="<?= htmlspecialchars($respostas['gosto_fazer'] ?? '') ?>"><br><br>

        O que não gosto:<br>
        <input type="text" name="nao_gosto" value="<?= htmlspecialchars($respostas['nao_gosto'] ?? '') ?>"><br><br>

        Como é minha rotina:<br>
        <input type="text" name="rotina" value="<?= htmlspecialchars($respostas['rotina'] ?? '') ?>"><br><br>

        O que faço no lazer:<br>
        <input type="text" name="lazer" value="<?= htmlspecialchars($respostas['lazer'] ?? '') ?>"><br><br>

        O que faço para estudar:<br>
        <input type="text" name="estudos" value="<?= htmlspecialchars($respostas['estudos'] ?? '') ?>"><br><br>

        Como cuido do meu físico:<br>
        <input type="text" name="fisico" value="<?= htmlspecialchars($respostas['fisico'] ?? '') ?>"><br><br>

        Como cuido do meu intelecto:<br>
        <input type="text" name="intelecto" value="<?= htmlspecialchars($respostas['intelecto'] ?? '') ?>"><br><br>

        Como cuido do meu emocional:<br>
        <input type="text" name="emocional" value="<?= htmlspecialchars($respostas['emocional'] ?? '') ?>"><br><br>

        Meus Pontos Fracos:<br>
        <textarea name="pontos_fracos"><?= htmlspecialchars($respostas['pontos_fracos'] ?? '') ?></textarea><br><br>

        Meus Pontos Fortes:<br>
        <textarea name="pontos_fortes"><?= htmlspecialchars($respostas['pontos_fortes'] ?? '') ?></textarea><br><br>

        Meus Valores:<br>
        <?php
        $valores = explode(",", $respostas['valores'] ?? "");
        ?>
        <input type="checkbox" name="valores[]" value="Respeito" <?= in_array("Respeito", $valores) ? "checked" : "" ?>> Respeito<br>
        <input type="checkbox" name="valores[]" value="Amor" <?= in_array("Amor", $valores) ? "checked" : "" ?>> Amor<br>
        <input type="checkbox" name="valores[]" value="Honestidade" <?= in_array("Honestidade", $valores) ? "checked" : "" ?>> Honestidade<br>
        <input type="checkbox" name="valores[]" value="Solidariedade" <?= in_array("Solidariedade", $valores) ? "checked" : "" ?>> Solidariedade<br>
        <input type="checkbox" name="valores[]" value="Responsabilidade" <?= in_array("Responsabilidade", $valores) ? "checked" : "" ?>> Responsabilidade<br><br>

        Minhas Principais Aptidões:<br>
        <?php
        $aptidoes = explode(",", $respostas['aptidoes'] ?? "");
        ?>
        <input type="checkbox" name="aptidoes[]" value="Criatividade" <?= in_array("Criatividade", $aptidoes) ? "checked" : "" ?>> Criatividade<br>
        <input type="checkbox" name="aptidoes[]" value="Comunicação" <?= in_array("Comunicação", $aptidoes) ? "checked" : "" ?>> Comunicação<br>
        <input type="checkbox" name="aptidoes[]" value="Empatia" <?= in_array("Empatia", $aptidoes) ? "checked" : "" ?>> Empatia<br>
        <input type="checkbox" name="aptidoes[]" value="Liderança" <?= in_array("Liderança", $aptidoes) ? "checked" : "" ?>> Liderança<br>
        <input type="checkbox" name="aptidoes[]" value="Organização" <?= in_array("Organização", $aptidoes) ? "checked" : "" ?>> Organização<br><br>

        Como me relaciono com:<br>
        Família: <input type="text" name="familia" value="<?= htmlspecialchars($respostas['familia'] ?? '') ?>"><br>
        Amigos: <input type="text" name="amigos" value="<?= htmlspecialchars($respostas['amigos'] ?? '') ?>"><br>
        Escola: <input type="text" name="escolas" value="<?= htmlspecialchars($respostas['escolas'] ?? '') ?>"><br>
        Sociedade: <input type="text" name="sociedade" value="<?= htmlspecialchars($respostas['sociedade'] ?? '') ?>"><br><br>

        Como foi minha vida escolar:<br>
        <textarea name="vida_escolar"><?= htmlspecialchars($respostas['vida_escolar'] ?? '') ?></textarea><br><br>

        Como me veem:<br>
        Meus amigos: <input type="text" name="visao_amigos" value="<?= htmlspecialchars($respostas['visao_amigos'] ?? '') ?>"><br>
        Meus familiares: <input type="text" name="visao_familiares" value="<?= htmlspecialchars($respostas['visao_familiares'] ?? '') ?>"><br>
        Meus professores: <input type="text" name="visao_professores" value="<?= htmlspecialchars($respostas['visao_professores'] ?? '') ?>"><br><br>

        <input type="submit" value="Enviar Autoavaliação">
    </form>
</body>
</html>
