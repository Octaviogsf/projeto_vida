<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Autoavaliação</title>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <div class="card-azul">
        <?php
        require_once '../config/conn.php';
        session_start();

        // Verifica se o usuário está logado
        $user_id = $_SESSION['user_id'] ?? null;

        if (!$user_id) {
            echo "<p>Usuário não autenticado.</p>";
            exit();
        }

        // Trata os campos de múltipla escolha
        $valores = isset($_POST['valores']) ? implode(",", $_POST['valores']) : "";
        $aptidoes = isset($_POST['aptidoes']) ? implode(",", $_POST['aptidoes']) : "";

        // Verifica se o usuário já tem um registro na tabela 'respostas_usuario'
        $stmt = $pdo->prepare("SELECT id FROM respostas_usuario WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $existing = $stmt->fetch();

        $dados = [
            $_POST['lembrancas'] ?? '',
            $_POST['gosto_fazer'] ?? '',
            $_POST['nao_gosto'] ?? '',
            $_POST['rotina'] ?? '',
            $_POST['lazer'] ?? '',
            $_POST['estudos'] ?? '',
            $_POST['fisico'] ?? '',
            $_POST['intelecto'] ?? '',
            $_POST['emocional'] ?? '',
            $_POST['pontos_fracos'] ?? '',
            $_POST['pontos_fortes'] ?? '',
            $valores,
            $aptidoes,
            $_POST['familia'] ?? '',
            $_POST['amigos'] ?? '',
            $_POST['escolas'] ?? '',
            $_POST['sociedade'] ?? '',
            $_POST['vida_escolar'] ?? '',
            $_POST['visao_amigos'] ?? '',
            $_POST['visao_familiares'] ?? '',
            $_POST['visao_professores'] ?? '',
        ];

        if ($existing) {
            // Atualiza os dados existentes
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
            $stmt->execute([...$dados, $user_id]);

            echo "<p>Autoavaliação atualizada com sucesso!</p>";
        } else {
            // Insere novos dados
            $stmt = $pdo->prepare("
        INSERT INTO respostas_usuario (
            lembrancas, gosto_fazer, nao_gosto, rotina, lazer, estudos,
            fisico, intelectual, emocional, pontos_fracos, pontos_fortes,
            valores, aptidoes, familia, amigos, escolas, sociedade, vida_escolar,
            visao_amigos, visao_familiares, visao_professores, user_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
            $stmt->execute([...$dados, $user_id]);

            echo "<p>Autoavaliação salva com sucesso!</p>";
        }
        ?>
        <a href="../View/index.php" class="button-link">Voltar para o Início</a>
    </div>

</body>

</html>