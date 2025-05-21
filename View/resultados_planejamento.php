<?php
require_once('../config/conn.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Recuperar dados do usuário
$sql_user = "SELECT * FROM user WHERE id = :user_id";
$stmt_user = $pdo->prepare($sql_user);
$stmt_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_user->execute();
$user = $stmt_user->fetch();

if (!$user) {
    echo "Usuário não encontrado.";
    exit();
}

// Recuperar dados do planejamento futuro (mais recente)
$sql_planejamento = "SELECT * FROM planejamento_futuro WHERE user_id = :user_id ORDER BY data_envio DESC LIMIT 1";
$stmt_planejamento = $pdo->prepare($sql_planejamento);
$stmt_planejamento->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_planejamento->execute();
$planejamento = $stmt_planejamento->fetch(PDO::FETCH_ASSOC);

if (!$planejamento) {
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Usuário não encontrado</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Jomhuria&display=swap');

            * {
                box-sizing: border-box;
                margin: 0;
                font-family: "Jomhuria", serif;
            }

            body {
                background-color: #162136;
                color: white;
                font-family: Arial, sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
            }

            .card-azul {
                background-color: #1f2b42;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
                text-align: center;
                max-width: 600px;
                width: 90%;
            }

            .card-azul p {
                font-size: 58px;
                margin-bottom: 30px;
            }

            .button-link {
                display: inline-block;
                background-color: #0f3d91;
                color: white;
                text-decoration: none;
                padding: 12px 25px;
                margin: 10px;
                border-radius: 8px;
                font-size: 38px;
                transition: background-color 0.3s ease;
            }

            .button-link:hover {
                background-color: #0d3275;
            }
        </style>
    </head>

    <body>
        <div class="card-azul">
            <p>Nenhum planejamento futuro cadastrado.</p>
            <a href="index.php" class="button-link">Página Inicial</a>
        </div>
    </body>

    </html>
    <?php
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
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

        /* Estilização para campos desabilitados */
        input[readonly],
        textarea[readonly],
        select[disabled] {
            background-color: #d3d3d3;
            color: #888888;
            cursor: not-allowed;
        }

        input[readonly],
        textarea[readonly],
        select[disabled] {
            pointer-events: none;
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
            <input type="text" name="aspiracoes" readonly
                value="<?= htmlspecialchars($planejamento['aspiracoes'] ?? '') ?>">

            <label>Meu sonho de infância:</label>
            <input type="text" name="sonho_infancia" readonly
                value="<?= htmlspecialchars($planejamento['sonho_infancia'] ?? '') ?>">

            <div class="bloco-sonho">
                <label>Escolha Profissional:</label>
                <input type="text" readonly
                    value="<?= htmlspecialchars($planejamento['escolha_profissional'] ?? 'Não selecionado') ?>">
                <label>Detalhes:</label>
                <input type="text" name="detalhes_profissao" readonly
                    value="<?= htmlspecialchars($planejamento['detalhes_profissao'] ?? '') ?>">
                <label>Áreas de atuação:</label>
                <input type="text" name="areas_atuacao" readonly
                    value="<?= htmlspecialchars($planejamento['areas_atuacao'] ?? '') ?>">
                <label>Salariação:</label>
                <input type="text" name="salariacao" readonly
                    value="<?= htmlspecialchars($planejamento['salariacao'] ?? '') ?>">
                <label>Daqui 10 anos, como você se imagina:</label>
                <textarea name="como_se_imagina_10_anos"
                    readonly><?= htmlspecialchars($planejamento['como_se_imagina_10_anos'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="coluna">
            <label>Liste seus sonhos:</label>
            <div id="lista-sonhos">
                <div class="bloco-sonho">
                    <input type="text" name="lista_sonhos[]" placeholder="Digite um sonho" readonly
                        value="<?= htmlspecialchars($planejamento['lista_sonhos'] ?? '') ?>">
                    <label>O que já estou fazendo:</label>
                    <textarea name="ja_faz_sonho[]"
                        readonly><?= htmlspecialchars($planejamento['ja_faz_sonho'] ?? '') ?></textarea>
                    <label>O que ainda preciso fazer:</label>
                    <textarea name="precisa_fazer_sonho[]"
                        readonly><?= htmlspecialchars($planejamento['precisa_fazer_sonho'] ?? '') ?></textarea>
                    <label>Data limite para realizar este sonho:</label>
                    <input type="date" name="data_sonho[]" readonly
                        value="<?= htmlspecialchars($planejamento['data_sonho'] ?? '') ?>">
                </div>
            </div>
            <div class="bloco-sonho">
                <h3>Objetivos:</h3>

                <label>Objetivo de Curto Prazo:</label>
                <textarea name="objetivo_curto"
                    readonly><?= htmlspecialchars($planejamento['objetivos_curto'] ?? '') ?></textarea>

                <label>Objetivo de Médio Prazo:</label>
                <textarea name="objetivo_medio"
                    readonly><?= htmlspecialchars($planejamento['objetivos_medio'] ?? '') ?></textarea>

                <label>Objetivo de Longo Prazo:</label>
                <textarea name="objetivo_longo"
                    readonly><?= htmlspecialchars($planejamento['objetivos_longo'] ?? '') ?></textarea>

            </div>

        </div>
    </form>

</body>

</html>