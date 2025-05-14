<?php require_once('../config/conn.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/d650d7db78.js" crossorigin="anonymous"></script>
    <title>Planejamento de Futuro</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #162136;
            color: white;
        }

        h2 {
            text-align: center;
            background-color: #0f1828;
            padding: 20px;
            font-size: 68px;
            font-weight: normal;
            margin: 0;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 30px;
            gap: 40px;
        }

        .coluna {
            flex: 1;
            min-width: 300px;
            max-width: 550px;
        }

        label {
            display: block;
            margin-top: 20px;
            margin-bottom: 5px;
            font-size: 40px;
        }

        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            font-size: 35px;
            border: none;
            border-radius: 5px;
            background-color: white;
            color: #000;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 60px;
        }

        input[type="submit"],
        button[type="button"] {
            margin-top: 20px;
            padding: 15px 30px;
            background-color: #0f3d91;
            color: white;
            font-size: 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        input[type="submit"]:hover,
        button[type="button"]:hover {
            background-color: #0d3275;
        }

        .bloco-sonho {
            background-color: #1f2b42;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        h3 {
            font-size: 45px;
            font-weight: normal;
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

    <h2>Planejamento de Futuro:</h2>

    <form method="post" action="../Controller/salvar_planejamento.php">
        <div class="coluna">
            <label>Minhas aspirações:</label>
            <input type="text" name="aspiracoes">

            <label>Meu sonho de infância:</label>
            <input type="text" name="sonho_infancia">
            <div class="bloco-sonho">
                <label>Escolha Profissional:</label>
                <select name="escolha_profissional">
                    <option value="">Selecione</option>
                    <option value="Medicina">Medicina</option>
                    <option value="Engenharia">Engenharia</option>
                    <option value="Direito">Direito</option>
                    <option value="Tecnologia">Tecnologia</option>
                    <option value="Arquitetura">Arquitetura</option>
                    <option value="Psicologia">Psicologia</option>
                    <option value="Enfermagem">Enfermagem</option>
                    <option value="Fisioterapia">Fisioterapia</option>
                    <option value="Jornalismo">Jornalismo</option>
                    <option value="Cabeleireiro">Cabeleireiro</option>
                    <option value="Design de Moda">Design de Moda</option>
                    <option value="Estilista">Estilista</option>
                    <option value="Nutrição">Nutrição</option>
                    <option value="Engenharia Civil">Engenharia Civil</option>
                    <option value="Engenharia de Software">Engenharia de Software</option>
                    <option value="Design Gráfico">Design Gráfico</option>
                    <option value="Veterinária">Veterinária</option>
                    <option value="Química">Química</option>
                    <option value="Biologia">Biologia</option>
                    <option value="Cientista de Dados">Cientista de Dados</option>
                    <option value="Fotografia">Fotografia</option>
                    <option value="Música">Música</option>
                    <option value="Teatro">Teatro</option>
                    <option value="Arqueologia">Arqueologia</option>
                    <option value="Farmácia">Farmácia</option>
                    <option value="Publicidade">Publicidade</option>
                    <option value="Gestão de Projetos">Gestão de Projetos</option>
                    <option value="Engenharia Mecânica">Engenharia Mecânica</option>
                    <option value="Contabilidade">Contabilidade</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Economia">Economia</option>
                    <option value="Administração">Administração</option>
                    <option value="Ciência da Computação">Ciência da Computação</option>
                    <option value="Gestão de Recursos Humanos">Gestão de Recursos Humanos</option>
                    <option value="Gestão Financeira">Gestão Financeira</option>
                    <option value="Assistente Social">Assistente Social</option>
                    <option value="Turismo">Turismo</option>
                    <option value="Logística">Logística</option>
                    <option value="Engenharia Ambiental">Engenharia Ambiental</option>
                    <option value="Gestão de TI">Gestão de TI</option>
                    <option value="Análise de Sistemas">Análise de Sistemas</option>
                    <option value="Gestão de E-commerce">Gestão de E-commerce</option>
                    <option value="Designer de Interiores">Designer de Interiores</option>
                    <option value="Técnico de Enfermagem">Técnico de Enfermagem</option>
                    <option value="Engenharia de Produção">Engenharia de Produção</option>
                    <option value="Produção de Vídeo">Produção de Vídeo</option>
                    <option value="Gestão de Marketing">Gestão de Marketing</option>
                    <option value="Serviço Social">Serviço Social</option>
                    <option value="Educação Física">Educação Física</option>
                    <option value="Segurança do Trabalho">Segurança do Trabalho</option>
                    <option value="Gestão de Saúde">Gestão de Saúde</option>
                    <option value="Biblioteconomia">Biblioteconomia</option>
                    <option value="Engenharia Eletrônica">Engenharia Eletrônica</option>
                    <option value="Análises Clínicas">Análises Clínicas</option>
                    <option value="Design de Produtos">Design de Produtos</option>
                    <option value="Relações Públicas">Relações Públicas</option>
                    <option value="Pedagogia">Pedagogia</option>
                    <option value="Arquitetura e Urbanismo">Arquitetura e Urbanismo</option>
                    <option value="Ciências Contábeis">Ciências Contábeis</option>
                    <option value="Serviços Jurídicos">Serviços Jurídicos</option>
                    <option value="Tecnologia da Informação">Tecnologia da Informação</option>
                    <option value="Gestão de Vendas">Gestão de Vendas</option>
                    <option value="Consultoria de TI">Consultoria de TI</option>
                    <option value="Cultura e Arte">Cultura e Arte</option>
                    <option value="Ciências Sociais">Ciências Sociais</option>
                    <option value="Pedreiro">Pedreiro</option>
                    <option value="Carpinteiro">Carpinteiro</option>
                    <option value="Técnico de Informática">Técnico de Informática</option>
                    <option value="Gestor de Produto">Gestor de Produto</option>
                    <option value="Operador de Máquinas">Operador de Máquinas</option>
                    <option value="Consultor de Imagem">Consultor de Imagem</option>
                    <option value="Biotecnologia">Biotecnologia</option>
                    <option value="Design de Interface">Design de Interface</option>
                    <option value="Ciências Políticas">Ciências Políticas</option>
                    <option value="Técnico em Edificações">Técnico em Edificações</option>
                    <option value="Técnico em Mecânica">Técnico em Mecânica</option>
                    <option value="Gestão de Eventos">Gestão de Eventos</option>
                    <option value="Designer de Moda">Designer de Moda</option>
                    <option value="Gestão de Comunicação">Gestão de Comunicação</option>
                    <option value="Gestão Comercial">Gestão Comercial</option>
                    <option value="Gestão de Empresas">Gestão de Empresas</option>
                    <option value="Consultoria Financeira">Consultoria Financeira</option>
                    <option value="Gestão de Riscos">Gestão de Riscos</option>
                    <option value="Psicopedagogia">Psicopedagogia</option>
                    <option value="Mecânica Automotiva">Mecânica Automotiva</option>
                    <option value="Engenharia Química">Engenharia Química</option>
                    <option value="Geologia">Geologia</option>
                    <option value="Gestão de Produtos Digitais">Gestão de Produtos Digitais</option>
                    <option value="Sistemas de Informação">Sistemas de Informação</option>
                    <option value="Técnico de Radiologia">Técnico de Radiologia</option>
                    <option value="Enologia">Enologia</option>
                    <option value="Agronomia">Agronomia</option>
                    <option value="Biologia Marinha">Biologia Marinha</option>
                    <option value="Gestão de Processos">Gestão de Processos</option>
                    <option value="Design de Animação">Design de Animação</option>
                    <option value="Design de Comunicação">Design de Comunicação</option>
                    <option value="Ciências Aeronáuticas">Ciências Aeronáuticas</option>
                    <option value="Engenharia de Alimentos">Engenharia de Alimentos</option>
                    <option value="Marketing Digital">Marketing Digital</option>
                    <option value="Gestão de Transportes">Gestão de Transportes</option>
                    <option value="Técnico de Telecomunicações">Técnico de Telecomunicações</option>
                    <option value="Gestão de Inovação">Gestão de Inovação</option>
                    <option value="Tecnologia de Alimentos">Tecnologia de Alimentos</option>
                    <option value="Automação Industrial">Automação Industrial</option>
                    <option value="Cinema e Audiovisual">Cinema e Audiovisual</option>
                    <option value="Segurança Pública">Segurança Pública</option>
                    <option value="Gestão de Marketing Digital">Gestão de Marketing Digital</option>
                    <option value="Técnico de Enfermagem do Trabalho">Técnico de Enfermagem do Trabalho</option>
                    <option value="Gestão de Recursos Hídricos">Gestão de Recursos Hídricos</option>
                    <option value="Gestão de Saúde Pública">Gestão de Saúde Pública</option>
                    <option value="História">História</option>
                    <option value="Gestão Cultural">Gestão Cultural</option>
                    <option value="Gestão de Organizações">Gestão de Organizações</option>
                    <option value="Engenharia de Automação">Engenharia de Automação</option>
                    <option value="Gestão de Meio Ambiente">Gestão de Meio Ambiente</option>
                    <option value="Tecnologia de Redes de Computadores">Tecnologia de Redes de Computadores</option>
                    <option value="Gestão de Processos Industriais">Gestão de Processos Industriais</option>
                    <option value="Economia Criativa">Economia Criativa</option>
                    <option value="Gestão de Comércio Exterior">Gestão de Comércio Exterior</option>
                    <option value="Comércio e Vendas">Comércio e Vendas</option>
                    <option value="Agropecuária">Agropecuária</option>
                    <option value="Gestão de Infraestrutura">Gestão de Infraestrutura</option>
                    <option value="Filosofia">Filosofia</option>
                    <option value="Psicologia Organizacional">Psicologia Organizacional</option>
                    <option value="Gestão de Eletroeletrônica">Gestão de Eletroeletrônica</option>
                    <option value="Gestão de Comunicação Organizacional">Gestão de Comunicação Organizacional
                    </option>
                    <option value="Gestão de Empresas de Tecnologia">Gestão de Empresas de Tecnologia</option>
                    <option value="Gestão de Logística Empresarial">Gestão de Logística Empresarial</option>
                    <option value="Gestão Ambiental">Gestão Ambiental</option>
                    <option value="Gestão de Informações e Conhecimento">Gestão de Informações e Conhecimento
                    </option>
                </select>
                <label>Detalhes:</label>
                <input type="text" name="detalhes_profissao">
                <label>Áreas de atuação:</label>
                <input type="text" name="areas_atuacao">
                <label>Salariação:</label>
                <input type="text" name="salariacao">
                <label>Daqui 10 anos, como você se imagina:</label>
                <textarea name="como_se_imagina_10_anos"></textarea>
            </div>
            <br>
            <div class="bloco-sonho">
                <h3 style="text-align: center;">Como irei melhorar meu:</h3>
                <label>Relacionamento Familiar:</label>
                <input type="text" name="melhorar_relacionamento_familiar">
                <label>Data limite para estabelecer essas boas práticas:</label>
                <input type="date" name="data_relacionamento_familiar">

                <label>Saúde:</label>
                <input type="text" name="melhorar_saude">
                <label>Data limite para estabelecer essas boas práticas:</label>
                <input type="date" name="data_saude">

                <label>Comunidade:</label>
                <input type="text" name="melhorar_comunidade">
                <label>Data limite para estabelecer essas boas práticas:</label>
                <input type="date" name="data_comunidade">

                <label>Futuro Profissional:</label>
                <input type="text" name="melhorar_profissao">
                <label>Data limite para estabelecer essas boas práticas:</label>
                <input type="date" name="data_profissao">

                <label>Amigos:</label>
                <input type="text" name="melhorar_amigos">
                <label>Data limite para estabelecer essas boas práticas:</label>
                <input type="date" name="data_amigos">

                <label>Tempo Livre:</label>
                <input type="text" name="melhorar_tempo_livre">
                <label>Data limite para estabelecer essas boas práticas:</label>
                <input type="date" name="data_tempo_livre">
            </div>
        </div>

        <div class="coluna">
            <label>Liste seus sonhos:</label>
            <div id="lista-sonhos">
                <div class="bloco-sonho">
                    <input type="text" name="lista_sonhos[]" placeholder="Digite um sonho">
                    <label>O que já estou fazendo:</label>
                    <textarea name="ja_faz_sonho[]"></textarea>
                    <label>O que ainda preciso fazer:</label>
                    <textarea name="precisa_fazer_sonho[]"></textarea>
                    <label>Data limite para realizar este sonho:</label>
                    <input type="date" name="data_sonho[]">
                </div>
            </div>
            <button type="button" onclick="adicionarSonho()">+ Adicionar sonho</button>

            <label>Objetivos a curto prazo (Um ano):</label>
            <div id="objetivos-curto">
                <div class="bloco-sonho">
                    <input type="text" name="objetivos_curto[]" placeholder="Objetivo curto prazo">
                    <label>O que já estou fazendo:</label>
                    <textarea name="ja_faz_curto[]"></textarea>
                    <label>O que ainda preciso fazer:</label>
                    <textarea name="precisa_fazer_curto[]"></textarea>
                    <label>Data limite para realizar este objetivo:</label>
                    <input type="date" name="data_curto[]">
                </div>
            </div>
            <button type="button" onclick="adicionarObjetivo('curto')">+ Adicionar objetivo curto</button>

            <label>Objetivos a médio prazo (Três anos):</label>
            <div id="objetivos-medio">
                <div class="bloco-sonho">
                    <input type="text" name="objetivos_medio[]" placeholder="Objetivo médio prazo">
                    <label>O que já estou fazendo:</label>
                    <textarea name="ja_faz_medio[]"></textarea>
                    <label>O que ainda preciso fazer:</label>
                    <textarea name="precisa_fazer_medio[]"></textarea>
                    <label>Data limite para realizar este objetivo:</label>
                    <input type="date" name="data_medio[]">
                </div>
            </div>
            <button type="button" onclick="adicionarObjetivo('medio')">+ Adicionar objetivo médio</button>

            <label>Objetivos a longo prazo (Sete anos):</label>
            <div id="objetivos-longo">
                <div class="bloco-sonho">
                    <input type="text" name="objetivos_longo[]" placeholder="Objetivo longo prazo">
                    <label>O que já estou fazendo:</label>
                    <textarea name="ja_faz_longo[]"></textarea>
                    <label>O que ainda preciso fazer:</label>
                    <textarea name="precisa_fazer_longo[]"></textarea>
                    <label>Data limite para realizar este objetivo:</label>
                    <input type="date" name="data_longo[]">
                </div>
            </div>
            <button type="button" onclick="adicionarObjetivo('longo')">+ Adicionar objetivo longo</button>
        </div>

        <div style="width: 100%; text-align: center;">
            <input type="submit" value="Enviar">
        </div>
    </form>

    <script>
        function adicionarSonho() {
            const container = document.getElementById('lista-sonhos');
            const bloco = document.createElement('div');
            bloco.classList.add('bloco-sonho');
            bloco.innerHTML = `
                <input type="text" name="lista_sonhos[]" placeholder="Digite um sonho">
                <label>O que já estou fazendo:</label>
                <textarea name="ja_faz_sonho[]"></textarea>
                <label>O que ainda preciso fazer:</label>
                <textarea name="precisa_fazer_sonho[]"></textarea>
                <label>Data limite para realizar este sonho:</label>
                <input type="date" name="data_sonho[]">
            `;
            container.appendChild(bloco);
        }

        function adicionarObjetivo(tipo) {
            const container = document.getElementById('objetivos-' + tipo);
            const bloco = document.createElement('div');
            bloco.classList.add('bloco-sonho');
            bloco.innerHTML = `
                <input type="text" name="objetivos_${tipo}[]" placeholder="Objetivo ${tipo} prazo">
                <label>O que já estou fazendo:</label>
                <textarea name="ja_faz_${tipo}[]"></textarea>
                <label>O que ainda preciso fazer:</label>
                <textarea name="precisa_fazer_${tipo}[]"></textarea>
                <label>Data limite para realizar este objetivo:</label>
                <input type="date" name="data_${tipo}[]">
            `;
            container.appendChild(bloco);
        }
    </script>

</body>

</html>