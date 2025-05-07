<?php
require_once '../config/conn.php';
session_start();

// Verifica se o usuário está logado
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    die("Usuário não autenticado.");
}

// Busca as respostas do usuário logado
$stmt = $pdo->prepare("SELECT 
    r.*, u.name, u.birthdate, u.sobre_mim 
    FROM respostas_usuario r
    JOIN user u ON r.user_id = u.id
    WHERE r.user_id = ?
    ORDER BY r.id DESC
");
$stmt->execute([$user_id]);

$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($resultados) {
    // Exibe as respostas do usuário logado
    $row = $resultados[0];  // Como estamos pegando apenas os dados do usuário logado, só precisamos do primeiro (e único) resultado

    echo "<h2>Resultados da Autoavaliação</h2>";
    echo "<strong>Nome:</strong> " . htmlspecialchars($row['name']) . "<br>";
    echo "<strong>Data de Nascimento:</strong> " . htmlspecialchars($row['birthdate']) . "<br>";

    echo "<strong>Minhas Lembranças:</strong> " . htmlspecialchars($row['lembrancas']) . "<br><br>";
    echo "<strong>O que gosto de fazer:</strong> " . htmlspecialchars($row['gosto_fazer']) . "<br><br>";
    echo "<strong>O que não gosto:</strong> " . htmlspecialchars($row['nao_gosto']) . "<br><br>";
    echo "<strong>Como é minha rotina:</strong> " . htmlspecialchars($row['rotina']) . "<br><br>";
    echo "<strong>O que faço no lazer:</strong> " . htmlspecialchars($row['lazer']) . "<br><br>";
    echo "<strong>O que faço para estudar:</strong> " . htmlspecialchars($row['estudos']) . "<br><br>";
    echo "<strong>Como cuido do meu físico:</strong> " . htmlspecialchars($row['fisico']) . "<br><br>";
    echo "<strong>Como cuido do meu intelecto:</strong> " . htmlspecialchars($row['intelectual']) . "<br><br>";
    echo "<strong>Como cuido do meu emocional:</strong> " . htmlspecialchars($row['emocional']) . "<br><br>";
    echo "<strong>Meus Pontos Fracos:</strong> " . htmlspecialchars($row['pontos_fracos']) . "<br><br>";
    echo "<strong>Meus Pontos Fortes:</strong> " . htmlspecialchars($row['pontos_fortes']) . "<br><br>";
    echo "<strong>Família:</strong> " . htmlspecialchars($row['familia']) . "<br><br>";
    echo "<strong>Amigos:</strong> " . htmlspecialchars($row['amigos']) . "<br><br>";
    echo "<strong>Escolas:</strong> " . htmlspecialchars($row['escolas']) . "<br><br>";
    echo "<strong>Sociedade:</strong> " . htmlspecialchars($row['sociedade']) . "<br><br>";
    echo "<strong>Vida Escolar:</strong> " . htmlspecialchars($row['vida_escolar']) . "<br><br>";
    echo "<strong>Visão dos Amigos:</strong> " . htmlspecialchars($row['visao_amigos']) . "<br><br>";
    echo "<strong>Visão dos Familiares:</strong> " . htmlspecialchars($row['visao_familiares']) . "<br><br>";
    echo "<strong>Visão dos Professores:</strong> " . htmlspecialchars($row['visao_professores']) . "<br><br>";
} else {
    echo "Nenhuma resposta encontrada.";
}
?>
