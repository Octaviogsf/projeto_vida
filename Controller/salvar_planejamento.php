<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Upload de Foto e Planejamento Futuro</title>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="card-azul">
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo '<p>Usuário não logado</p>';
    exit();
}

$user_id = $_SESSION['user_id'];
include('../config/conn.php');

if (!isset($pdo)) {
    die("Erro: conexão não foi criada. Verifique o arquivo conn.php.");
}

// Função para tratar arrays
function tratarArray($campo)
{
    if (isset($_POST[$campo]) && is_array($_POST[$campo])) {
        $campo_tratado = array_filter($_POST[$campo]);
        if (count($campo_tratado) > 0) {
            return implode(',', $campo_tratado);
        }
    }
    return null;
}

$dados = [
    'user_id' => $user_id,
    'aspiracoes' => $_POST['aspiracoes'] ?? null,
    'sonho_infancia' => $_POST['sonho_infancia'] ?? null,
    'escolha_profissional' => $_POST['escolha_profissional'] ?? null,
    'detalhes_profissao' => $_POST['detalhes_profissao'] ?? null,
    'areas_atuacao' => $_POST['areas_atuacao'] ?? null,
    'como_se_imagina_10_anos' => $_POST['como_se_imagina_10_anos'] ?? null,
    'melhorar_relacionamento_familiar' => $_POST['melhorar_relacionamento_familiar'] ?? null,
    'data_relacionamento_familiar' => $_POST['data_relacionamento_familiar'] ?? null,
    'melhorar_saude' => $_POST['melhorar_saude'] ?? null,
    'data_saude' => $_POST['data_saude'] ?? null,
    'melhorar_comunidade' => $_POST['melhorar_comunidade'] ?? null,
    'data_comunidade' => $_POST['data_comunidade'] ?? null,
    'melhorar_profissao' => $_POST['melhorar_profissao'] ?? null,
    'data_profissao' => $_POST['data_profissao'] ?? null,
    'melhorar_amigos' => $_POST['melhorar_amigos'] ?? null,
    'data_amigos' => $_POST['data_amigos'] ?? null,
    'melhorar_tempo_livre' => $_POST['melhorar_tempo_livre'] ?? null,
    'data_tempo_livre' => $_POST['data_tempo_livre'] ?? null,
    'salariacao' => $_POST['salariacao'] ?? null,
    'lista_sonhos' => tratarArray('lista_sonhos'),
    'ja_faz_sonho' => tratarArray('ja_faz_sonho'),
    'precisa_fazer_sonho' => tratarArray('precisa_fazer_sonho'),
    'objetivos_curto' => tratarArray('objetivos_curto'),
    'ja_faz_curto' => tratarArray('ja_faz_curto'),
    'precisa_fazer_curto' => tratarArray('precisa_fazer_curto'),
    'data_curto' => tratarArray('data_curto'),
    'objetivos_medio' => tratarArray('objetivos_medio'),
    'ja_faz_medio' => tratarArray('ja_faz_medio'),
    'precisa_fazer_medio' => tratarArray('precisa_fazer_medio'),
    'data_medio' => tratarArray('data_medio'),
    'objetivos_longo' => tratarArray('objetivos_longo'),
    'ja_faz_longo' => tratarArray('ja_faz_longo'),
    'precisa_fazer_longo' => tratarArray('precisa_fazer_longo'),
    'data_longo' => tratarArray('data_longo'),
];

// Processar o upload de foto
if (isset($_FILES['foto'])) {
    $foto = $_FILES['foto'];
    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($foto['type'], $tiposPermitidos)) {
        $dadosImagem = file_get_contents($foto['tmp_name']);
        $nomeImagem = $foto['name'];
        $tipo = $foto['type'];
        $tamanho = $foto['size'];

        // Inserir a foto no banco de dados
        $sqlFoto = "INSERT INTO fotos (nome, conteudo, tipo, tamanho, user_id)
                    VALUES (:nome, :conteudo, :tipo, :tamanho, :user_id)";
        $stmtFoto = $pdo->prepare($sqlFoto);
        $stmtFoto->bindParam(':nome', $nomeImagem);
        $stmtFoto->bindParam(':conteudo', $dadosImagem, PDO::PARAM_LOB);
        $stmtFoto->bindParam(':tipo', $tipo);
        $stmtFoto->bindParam(':tamanho', $tamanho);
        $stmtFoto->bindParam(':user_id', $user_id);

        if ($stmtFoto->execute()) {
            echo '<p>Foto salva com sucesso!</p>';
        } else {
            echo '<p>Erro ao salvar a foto no banco de dados.</p>';
        }
    } else {
        echo '<p>Formato de imagem inválido. Utilize JPEG, PNG ou GIF.</p>';
    }
}

// Inserir os dados do planejamento no banco de dados
$sqlPlanejamento = "INSERT INTO planejamento_futuro (
    user_id, aspiracoes, sonho_infancia, escolha_profissional, detalhes_profissao, areas_atuacao,
    como_se_imagina_10_anos, melhorar_relacionamento_familiar, data_relacionamento_familiar,
    melhorar_saude, data_saude, melhorar_comunidade, data_comunidade,
    melhorar_profissao, data_profissao, melhorar_amigos, data_amigos, melhorar_tempo_livre, data_tempo_livre,
    salariacao, lista_sonhos, ja_faz_sonho, precisa_fazer_sonho,
    objetivos_curto, ja_faz_curto, precisa_fazer_curto, data_curto,
    objetivos_medio, ja_faz_medio, precisa_fazer_medio, data_medio,
    objetivos_longo, ja_faz_longo, precisa_fazer_longo, data_longo
) VALUES (
    :user_id, :aspiracoes, :sonho_infancia, :escolha_profissional, :detalhes_profissao, :areas_atuacao,
    :como_se_imagina_10_anos, :melhorar_relacionamento_familiar, :data_relacionamento_familiar,
    :melhorar_saude, :data_saude, :melhorar_comunidade, :data_comunidade,
    :melhorar_profissao, :data_profissao, :melhorar_amigos, :data_amigos, :melhorar_tempo_livre, :data_tempo_livre,
    :salariacao, :lista_sonhos, :ja_faz_sonho, :precisa_fazer_sonho,
    :objetivos_curto, :ja_faz_curto, :precisa_fazer_curto, :data_curto,
    :objetivos_medio, :ja_faz_medio, :precisa_fazer_medio, :data_medio,
    :objetivos_longo, :ja_faz_longo, :precisa_fazer_longo, :data_longo
)";

$stmtPlanejamento = $pdo->prepare($sqlPlanejamento);
try {
    $stmtPlanejamento->execute($dados);
    echo "Planejamento salvo com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao salvar planejamento: " . $e->getMessage();
}
?>

    <a href="../View/resultados_planejamento.php" class="button-link">Ver Resultado</a>
    <a href="../View/index.php" class="button-link">Página Inicial</a>
</div>

</body>
</html>
