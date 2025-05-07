<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Erro: usuário não autenticado.");
}

$user_id = $_SESSION['user_id'];

include('../config/conn.php');

// Verifica se a conexão foi criada
if (!isset($pdo)) {
    die("Erro: conexão não foi criada. Verifique o arquivo conn.php.");
}

// Recebendo os dados do formulário
$dados = [
    'user_id' => $user_id,  // Adicionando o user_id para salvar no banco
    'aspiracoes' => $_POST['aspiracoes'],
    'sonho_infancia' => $_POST['sonho_infancia'],
    'escolha_profissional' => $_POST['escolha_profissional'],
    'detalhes_profissao' => $_POST['detalhes_profissao'],
    'areas_atuacao' => $_POST['areas_atuacao'],
    'como_se_imagina_10_anos' => $_POST['como_se_imagina_10_anos'],
    'melhorar_relacionamento_familiar' => $_POST['melhorar_relacionamento_familiar'],
    'data_estudo' => $_POST['data_estudo'],
    'data_saude' => $_POST['data_saude'],
    'data_comunidade' => $_POST['data_comunidade'],
    'salariacao' => $_POST['salariacao'],
    'lista_sonhos' => $_POST['lista_sonhos'],
    'ja_faz_sonho' => $_POST['ja_faz_sonho'],
    'precisa_fazer_sonho' => $_POST['precisa_fazer_sonho'],
    'objetivos_curto' => $_POST['objetivos_curto'],
    'objetivos_medio' => $_POST['objetivos_medio'],
    'objetivos_longo' => $_POST['objetivos_longo'],
    'melhorar_profissao' => $_POST['melhorar_profissao'],
    'data_profissao' => $_POST['data_profissao'],
    'data_amigos' => $_POST['data_amigos'],
    'data_tempo_livre' => $_POST['data_tempo_livre']
];

// Preparando o SQL
$sql = "INSERT INTO planejamento_futuro (
    user_id, aspiracoes, sonho_infancia, escolha_profissional, detalhes_profissao, areas_atuacao,
    como_se_imagina_10_anos, melhorar_relacionamento_familiar, data_estudo, data_saude,
    data_comunidade, salariacao, lista_sonhos, ja_faz_sonho, precisa_fazer_sonho,
    objetivos_curto, objetivos_medio, objetivos_longo, melhorar_profissao,
    data_profissao, data_amigos, data_tempo_livre
) VALUES (
    :user_id, :aspiracoes, :sonho_infancia, :escolha_profissional, :detalhes_profissao, :areas_atuacao,
    :como_se_imagina_10_anos, :melhorar_relacionamento_familiar, :data_estudo, :data_saude,
    :data_comunidade, :salariacao, :lista_sonhos, :ja_faz_sonho, :precisa_fazer_sonho,
    :objetivos_curto, :objetivos_medio, :objetivos_longo, :melhorar_profissao,
    :data_profissao, :data_amigos, :data_tempo_livre
)";

// Use $pdo agora
$stmt = $pdo->prepare($sql);
$stmt->execute($dados);

echo "Planejamento salvo com sucesso!";
?>
