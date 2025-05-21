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

$sql_planejamento = "SELECT 
    objetivos_curto, ja_faz_curto, precisa_fazer_curto, data_curto,
    objetivos_medio, ja_faz_medio, precisa_fazer_medio, data_medio,
    objetivos_longo, ja_faz_longo, precisa_fazer_longo, data_longo
FROM planejamento_futuro 
WHERE user_id = :user_id 
ORDER BY data_envio DESC";

$stmt_planejamento = $pdo->prepare($sql_planejamento);
$stmt_planejamento->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_planejamento->execute();
$planejamentos = $stmt_planejamento->fetchAll();

function diasRestantes($dataFinal)
{
    $hoje = new DateTime();
    $dataAlvo = new DateTime($dataFinal);
    $diferenca = $hoje->diff($dataAlvo);
    return ($hoje > $dataAlvo) ? "Expirado há {$diferenca->days} dias" : "Faltam {$diferenca->days} dias";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Bem-vindo</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/d650d7db78.js" crossorigin="anonymous"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .header,
        .footer {
            width: 100%;
            padding: 20px;
            background-color: #17243a color: white;
        }

        .footer {
            text-align: center;
            font-size: 24px;
            margin-top: 40px;
        }

        .footer a {
            color: white;
        }

        .header {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .main-content {
            padding: 0 10px;
        }

        .container-vertical {
            display: flex;
            flex-direction: column;
            gap: 40px;
            max-width: 1000px;
            margin: 50px auto;
            width: 100%;
        }

        .bloco {
            display: flex;
            align-items: center;
            gap: 20px;
            background: #f7f7f7;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            flex-wrap: wrap;
        }

        .bloco img {
            width: 100%;
            max-width: 390px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .bloco p {
            font-size: 30px;
            text-align: justify;
            margin: 0;
            flex: 1;
        }

        /* Responsivo para tablets */
        @media (max-width: 900px) {
            .bloco {
                flex-direction: column;
                text-align: center;
            }

            .bloco p {
                font-size: 18px;
            }
        }

        /* Responsivo para celulares */
        @media (max-width: 600px) {
            .bloco img {
                max-width: 100%;
                margin-bottom: 15px;
            }

            .bloco p {
                font-size: 16px;
            }

            .header {
                flex-direction: column;
                text-align: center;
            }

            .profile-icon img {
                width: 90px;
                height: 90px;
            }

            .user-name {
                margin: 10px 0;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <a href="index.php">
            <div class="logo">
                <img src="../IMG/Logo sem fundoe.png" alt="Logo" style="width: 100px; height: auto;">
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
            <a class="logout" href="logout.php"><i class="fa-solid fa-right-from-bracket" style="color: white;"></i></a>
        </div>
    </div>

    <!-- Conteúdo principal -->
    <div class="main-content">
        <div class="container-vertical">
            <div class="bloco">
                <img src="../IMG/casa-de-praia.jpg" alt="Casa na Praia">
                <p>
                    Um dos meus maiores sonhos é possuir uma casa aconchegante na praia, onde eu possa escapar da rotina
                    agitada e encontrar paz na simplicidade do mar e do vento. Imagino passar dias ensolarados acordando
                    com
                    o som das ondas, caminhando pela areia fina e sentindo a brisa fresca tocar meu rosto. Essa casa
                    seria
                    um refúgio para a família e amigos, um lugar para criar memórias, celebrar momentos especiais e
                    desacelerar, longe do barulho e da correria da cidade. Ter um cantinho assim traria uma sensação de
                    liberdade e bem-estar, onde o tempo parece passar mais devagar, e cada pôr do sol vira uma pintura
                    única
                    na minha vida.
                </p>
            </div>

            <div class="bloco">

                <p>
                    Além disso, tenho uma grande paixão por velocidade e adrenalina, por isso sonho em ter um carro de
                    arrancada, que me permita viver a emoção das pistas e a sensação única de acelerar ao máximo. Esse
                    carro
                    não é só um veículo, mas uma extensão do meu estilo de vida, onde cada detalhe é pensado para a
                    performance e o prazer da pilotagem. Imagino sentir o ronco do motor, o controle preciso nas curvas
                    e a
                    vibração do asfalto sob as rodas, tudo isso enquanto compartilho essa paixão com amigos e participo
                    de
                    competições emocionantes. Ter esse carro seria a realização de um desejo de liberdade e desafio,
                    algo
                    que me impulsiona a ir além e a sempre buscar o próximo limite.
                </p>
                <img src="../IMG/noticia-232-20240918162432.jpg" alt="Carro de arrancada">
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; <?= date('Y') ?> Projeto de Vida. Todos os direitos reservados. Feito por <a href="eu.php">Octávio
                Gomes da Silva Ferreira</a></p>
    </div>
</body>

</html>