<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <form method="post" action="../Controller/salvar_planejamento.php">
    <h2>Planejamento de Futuro:</h2>

    <label>Minhas aspirações:</label>
    <input type="text" name="aspiracoes">

    <label>Meu sonho de infância:</label>
    <input type="text" name="sonho_infancia">

    <label>Escolha Profissional:</label>
    <select name="escolha_profissional">
        <option value="">Selecione</option>
        <option value="Medicina">Medicina</option>
        <option value="Engenharia">Engenharia</option>
        <option value="Direito">Direito</option>
        <option value="Tecnologia">Tecnologia</option>
        <!-- Adicione mais opções se quiser -->
    </select>

    <label>Detalhes:</label>
    <input type="text" name="detalhes_profissao">

    <label>Áreas de atuação:</label>
    <input type="text" name="areas_atuacao">

    <label>Daqui 10 anos, como você se imagina:</label>
    <textarea name="como_se_imagina_10_anos"></textarea>

    <label>Como irei melhorar meu Relacionamento Familiar:</label>
    <input type="text" name="melhorar_relacionamento_familiar">

    <label>Data limite - Estudo:</label>
    <input type="date" name="data_estudo">

    <label>Data limite - Saúde:</label>
    <input type="date" name="data_saude">

    <label>Data limite - Comunidade:</label>
    <input type="date" name="data_comunidade">

    <label>Salariação:</label>
    <input type="text" name="salariacao">

    <label>Liste seus sonhos:</label>
    <textarea name="lista_sonhos"></textarea>

    <label>O que já estou fazendo para cada sonho:</label>
    <textarea name="ja_faz_sonho"></textarea>

    <label>O que ainda preciso fazer para cada sonho:</label>
    <textarea name="precisa_fazer_sonho"></textarea>

    <label>Objetivos a curto prazo (Um ano):</label>
    <textarea name="objetivos_curto"></textarea>

    <label>Objetivos a médio prazo (Três anos):</label>
    <textarea name="objetivos_medio"></textarea>

    <label>Objetivos a longo prazo (Sete anos):</label>
    <textarea name="objetivos_longo"></textarea>

    <label>Como irei melhorar meu Futuro Profissional:</label>
    <input type="text" name="melhorar_profissao">

    <label>Data limite - Futura Profissão:</label>
    <input type="date" name="data_profissao">

    <label>Data limite - Amigos:</label>
    <input type="date" name="data_amigos">

    <label>Data limite - Tempo Livre:</label>
    <input type="date" name="data_tempo_livre">

    <input type="submit" value="Enviar">
</form>
 
</body>
</html>
