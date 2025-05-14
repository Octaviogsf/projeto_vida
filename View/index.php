<?php
require_once('../config/conn.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Busca os dados do usuário
$sql = "SELECT * FROM user WHERE id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch();

if (!$user) {
    echo "Usuário não encontrado.";
    exit();
}

// Busca todos os planejamentos do usuário
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
        .carousel-container {
            position: relative;
            width: 600px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin: 0 auto;
            margin-top: 100px;
        }

        .carousel {
            display: flex;
            transition: transform 0.5s ease;
        }

        .carousel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .objetivos-planejamento {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #f7f7f7;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .objetivos-planejamento h2 {
            margin-bottom: 20px;
        }

        .objetivos-planejamento ul {
            list-style: none;
            padding: 0;
        }

        .objetivos-planejamento li {
            margin-bottom: 25px;
            font-size: 35px;
            padding: 10px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: pre-wrap;
        }

        .metas-grid {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .metas-section {
            padding: 50px;
            text-align: center;
        }

        .footer {
            text-align: center;
            padding: 30px;
            margin-top: 50px;
        }

        em {
            text-align: left;
        }

        h2 {
            font-weight: normal;
            font-size: 68px;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Header -->
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

    <!-- Carrossel -->
    <div class="carousel-container">
        <div class="carousel">
            <img src="../IMG/albert_camus_antes_a_questao_era_descobrir_se_a_vida_pr_lkeq5nk.webp" alt="Imagem 1">
            <img src="../IMG/arnold_bennett_o_pessimismo_depois_de_voce_se_acostumar_lx0qgy2.webp" alt="Imagem 2">
            <img src="../IMG/max_planck_para_os_crentes_deus_esta_no_principio_das_c_lxv95o2.webp" alt="Imagem 3">
            <img src="../IMG/paulo_coelho_imagine_uma_nova_historia_para_sua_vida_e_lk7re9p.webp" alt="Imagem 4">
            <img src="../IMG/platao_nao_espere_por_uma_crise_para_descobrir_o_que_e_lkzpmdp.webp" alt="Imagem 5">
            <img src="../IMG/roberto_shinyashiki_tudo_o_que_um_sonho_precisa_para_se_lkm033x.webp" alt="Imagem 6">
            <img src="../IMG/vergilio_ferreira_o_contrario_do_pessimismo_raramente_e_l2q7m8k.webp" alt="Imagem 7">
            <img src="../IMG/william_james_pessimismo_leva_a_fraqueza_otimismo_ao_po_lx3zzy7.webp" alt="Imagem 8">
        </div>
    </div>

    <script src="../js/script.js"></script>

    <!-- Exibição dos Objetivos -->
    <?php if ($planejamentos): ?>
        <div class="objetivos-planejamento">
            <h2>Meus Objetivos:</h2>
            <ul>
                <?php foreach ($planejamentos as $planejamento): ?>
                    <?php if (!empty($planejamento['objetivos_curto'])): ?>
                        <li>
                            Curto Prazo: <?= htmlspecialchars($planejamento['objetivos_curto']) ?><br>
                            <em>Data Final:</em> <?= date('d/m/Y', strtotime($planejamento['data_curto'])) ?>
                            (<?= diasRestantes($planejamento['data_curto']) ?>)<br>
                            Já estou fazendo: <?= htmlspecialchars($planejamento['ja_faz_curto']) ?><br>
                            Preciso fazer: <?= htmlspecialchars($planejamento['precisa_fazer_curto']) ?>
                        </li>
                    <?php endif; ?>

                    <?php if (!empty($planejamento['objetivos_medio'])): ?>
                        <li>
                            Médio Prazo: <?= htmlspecialchars($planejamento['objetivos_medio']) ?><br>
                            <em>Data Final:</em> <?= date('d/m/Y', strtotime($planejamento['data_medio'])) ?>
                            (<?= diasRestantes($planejamento['data_medio']) ?>)<br>
                            Já estou fazendo: <?= htmlspecialchars($planejamento['ja_faz_medio']) ?><br>
                            Preciso fazer: <?= htmlspecialchars($planejamento['precisa_fazer_medio']) ?>
                        </li>
                    <?php endif; ?>

                    <?php if (!empty($planejamento['objetivos_longo'])): ?>
                        <li>
                            Longo Prazo: <?= htmlspecialchars($planejamento['objetivos_longo']) ?><br>
                            <em>Data Final:</em> <?= date('d/m/Y', strtotime($planejamento['data_longo'])) ?>
                            (<?= diasRestantes($planejamento['data_longo']) ?>)<br>
                            Já estou fazendo: <?= htmlspecialchars($planejamento['ja_faz_longo']) ?><br>
                            Preciso fazer: <?= htmlspecialchars($planejamento['precisa_fazer_longo']) ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <div style="text-align: center; margin: 20px auto; color: #888; font-size: 30px;">
            Nenhum objetivo preenchido no planejamento.
        </div>
    <?php endif; ?>

    <!-- Funcionalidades -->
    <div class="metas-section">
        <h3 style="font-weight: normal; font-size: 50px">Funcionalidades:</h3>
        <div class="metas-grid">
            <a href="teste_personalidade.php"><div><img height="200px" src="../IMG/Area and Perimeter Quiz Presentation in Colorful Retro Style.png" alt=""></div></a>
            <a href="visualizar_resultados.php"><div><img height="200px" src="../IMG/Area and Perimeter Quiz Presentation in Colorful Retro Style (1).png" alt=""></div></a>
        </div>
        <br>
        <div class="metas-grid">
            <a href="form.php"><div><img height="200px" src="../IMG/Area and Perimeter Quiz Presentation in Colorful Retro Style.jpg" alt=""></div></a>
            <a href="form_result.php"><div><img height="200px" src="../IMG/Area and Perimeter Quiz Presentation in Colorful Retro Style (1).jpg" alt=""></div></a>
        </div>
        <div class="metas-grid">
            <a href="form_planejamento.php"><div><img height="200px" src="../IMG/Area and Perimeter Quiz Presentation in Colorful Retro Style (2).png" alt=""></div></a>
            <a href="resultados_planejamento.php"><div><img height="200px" src="../IMG/Area and Perimeter Quiz Presentation in Colorful Retro Style (3).png" alt=""></div></a>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Projeto de Vida. Todos os direitos reservados. Feito por <a href="eu.php">Octávio Gomes da Silva Ferreira</a></p>
    </footer>
</body>
</html>
