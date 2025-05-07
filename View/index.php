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
            /* Transição suave entre as imagens */
        }

        .carousel img {
            width: 100%;
            /* Cada imagem ocupará 100% da largura do carrossel */
            height: 100%;
            /* Cada imagem ocupará 100% da altura do carrossel */
            object-fit: cover;
            /* Faz com que as imagens cubram todo o espaço disponível sem distorcer */
            object-position: center;
            /* Garante que a imagem seja centralizada */
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="../IMG/Logo sem fundoe.png" alt="Logo" style="width: 100%; height: 100%;">
        </div>
        <div class="user-name">Olá, <?= htmlspecialchars($user['name'] ?? 'Usuário') ?>!</div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <!-- Imagem de perfil do usuário -->
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

    <script src="../js/script.js"></script> <!-- Caminho corrigido -->

    <div class="metas-section">
        <h3 style="font-weight: normal ;font-size: 50px">Metas ainda não cumpridas:</h3>
        <div class="metas-grid">
            <a href="teste_personalidade.php">
                <div><img height="200px" src="../IMG/Area and Perimeter Quiz Presentation in Colorful Retro Style.png"
                        alt=""></div>
            </a>
                <a href="visualizar_resultados.php">
                    <div><img height="200px" box-shadow: 60px -16px teal;
                            src="../IMG/Area and Perimeter Quiz Presentation in Colorful Retro Style (1).png" alt="">
                    </div>
                    </a>
                <a href="form.php">
                    <div><img height="200px" box-shadow: 60px -16px teal;
                            src="../IMG/Area and Perimeter Quiz Presentation in Colorful Retro Style.jpg" alt="">
                    </div>
                </a>
            </div>
                <br>
                <div class="metas-grid">
                <a href="form_result.php">
                    <div><img height="200px" box-shadow: 60px -16px teal;
                            src="..\IMG\Area and Perimeter Quiz Presentation in Colorful Retro Style (1).jpg" alt="">
                    </div>
                </a>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Projeto de Vida. Todos os direitos reservados. Feito por Octávio Gomes da Silva Ferreira</p>
    </footer>

</body>

</html>