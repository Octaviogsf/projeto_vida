<?php
require_once '../config/conn.php';
session_start();

// Verifica se o usuário está logado
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    die("Usuário não autenticado.");
}

// Trata os campos de múltipla escolha
$valores = isset($_POST['valores']) ? implode(",", $_POST['valores']) : "";
$aptidoes = isset($_POST['aptidoes']) ? implode(",", $_POST['aptidoes']) : "";

// Verifica se o usuário já tem um registro na tabela 'respostas_usuario'
$stmt = $pdo->prepare("SELECT id FROM respostas_usuario WHERE user_id = ?");
$stmt->execute([$user_id]);
$existing = $stmt->fetch();

if ($existing) {
    // Se o registro já existe, faz um UPDATE
    $stmt = $pdo->prepare("
        UPDATE respostas_usuario SET 
            lembrancas = ?, 
            gosto_fazer = ?, 
            nao_gosto = ?, 
            rotina = ?, 
            lazer = ?, 
            estudos = ?, 
            fisico = ?, 
            intelectual = ?, 
            emocional = ?, 
            pontos_fracos = ?, 
            pontos_fortes = ?, 
            valores = ?, 
            aptidoes = ?, 
            familia = ?, 
            amigos = ?, 
            escolas = ?, 
            sociedade = ?, 
            vida_escolar = ?, 
            visao_amigos = ?, 
            visao_familiares = ?, 
            visao_professores = ? 
        WHERE user_id = ?
    ");
    
    $stmt->execute([
        $_POST['lembrancas'],
        $_POST['gosto_fazer'],
        $_POST['nao_gosto'],
        $_POST['rotina'],
        $_POST['lazer'],
        $_POST['estudos'],
        $_POST['fisico'],
        $_POST['intelecto'],
        $_POST['emocional'],
        $_POST['pontos_fracos'],
        $_POST['pontos_fortes'],
        $valores,
        $aptidoes,
        $_POST['familia'],
        $_POST['amigos'],
        $_POST['escolas'],
        $_POST['sociedade'],
        $_POST['vida_escolar'],
        $_POST['visao_amigos'],
        $_POST['visao_familiares'],
        $_POST['visao_professores'],
        $user_id
    ]);

    echo "Autoavaliação atualizada com sucesso!";
} else {
    // Se o registro não existe, faz um INSERT
    $stmt = $pdo->prepare("
        INSERT INTO respostas_usuario (
            user_id, lembrancas, gosto_fazer, nao_gosto, rotina, lazer, estudos,
            fisico, intelectual, emocional, pontos_fracos, pontos_fortes,
            valores, aptidoes, familia, amigos, escolas, sociedade, vida_escolar,
            visao_amigos, visao_familiares, visao_professores
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $user_id,
        $_POST['lembrancas'],
        $_POST['gosto_fazer'],
        $_POST['nao_gosto'],
        $_POST['rotina'],
        $_POST['lazer'],
        $_POST['estudos'],
        $_POST['fisico'],
        $_POST['intelecto'],
        $_POST['emocional'],
        $_POST['pontos_fracos'],
        $_POST['pontos_fortes'],
        $valores,
        $aptidoes,
        $_POST['familia'],
        $_POST['amigos'],
        $_POST['escolas'],
        $_POST['sociedade'],
        $_POST['vida_escolar'],
        $_POST['visao_amigos'],
        $_POST['visao_familiares'],
        $_POST['visao_professores']
    ]);

    echo "Autoavaliação salva com sucesso!";
}
