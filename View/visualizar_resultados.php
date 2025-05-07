<?php
session_start();
require_once('../config/conn.php');

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// Busca dados do usuário
$sql_user = "SELECT * FROM user WHERE id = :user_id";
$stmt_user = $pdo->prepare($sql_user);
$stmt_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_user->execute();
$user = $stmt_user->fetch();

// Busca último resultado
$sql = "SELECT * FROM resultados_quiz WHERE user_id = ? ORDER BY id DESC LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Resultado do Teste</title>
  <link rel="stylesheet" href="../style.css">
  <script src="https://kit.fontawesome.com/d650d7db78.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    header h1 {
      text-align: center;
      color: #162136;
      margin-top: 5px;
      font-size: 80px;
      font-weight: normal;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
    }

    .info-box {
      background: #162136;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      flex: 1;
      min-width: 320px;
      max-width: 600px;
      color: white;
      font-size: 30px;
    }

    .chart-box {
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      flex: 1;
      min-width: 320px;
      max-width: 600px;
    }

    #radarChart {
      width: 100% !important;
      height: 100% !important;
    }

    h1,
    h2,
    h3 {
      margin-top: 0;
      font-weight: normal;
    }

    ul {
      padding-left: 20px;
    }

    ul li {
      margin-bottom: 5px;
      font-weight: lighter;
    }
  </style>
</head>

<body>
  <?php if ($result): ?>
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

    <header>
      <h1>Resultado da Personalidade</h1>
    </header>

    <div class="container">
      <div class="chart-box">
        <canvas id="radarChart"></canvas>
      </div>

      <div class="info-box">
        <h3>Significado dos Aspectos:</h3>
        <ul>
          <li>D – Dominância: Foco em resultados, assertividade, controle.</li>
          <li>I – Influência: Comunicação, entusiasmo, persuasão.</li>
          <li>S – Estabilidade: Paciência, lealdade, previsibilidade.</li>
          <li>C – Conformidade: Precisão, lógica, foco em regras.</li>
        </ul>

        <h2>RESULTADO</h2>
        <p>Personalidade em público:</p>
        <ul>
          <?php
          $publico = explode(',', $result['comportamento_publico'] ?? '');
          foreach ($publico as $item) {
            if (trim($item))
              echo "<li>" . htmlspecialchars(trim($item)) . "</li>";
          }
          ?>
        </ul>

        <p>Personalidade sob pressão:</p>
        <ul>
          <?php
          $pressao = explode(',', $result['comportamento_pressao'] ?? '');
          foreach ($pressao as $item) {
            if (trim($item))
              echo "<li>" . htmlspecialchars(trim($item)) . "</li>";
          }
          ?>
        </ul>

        <p>Personalidade verdadeira e oculta:</p>
        <ul>
          <?php
          $oculto = explode(',', $result['comportamento_oculto'] ?? '');
          foreach ($oculto as $item) {
            if (trim($item))
              echo "<li>" . htmlspecialchars(trim($item)) . "</li>";
          }
          ?>
        </ul>

        <h3>Descrição da Personalidade:</h3>
        <p><?= htmlspecialchars($result['descricao'] ?? 'Descrição não disponível.') ?></p>

        <h3>Profissões Compatíveis:</h3>
        <ul>
          <?php
          $profissoes = explode(',', $result['profissoes'] ?? '');
          if (count($profissoes) > 0 && trim($profissoes[0]) != '') {
            foreach ($profissoes as $p) {
              echo "<li>" . htmlspecialchars(trim($p)) . "</li>";
            }
          } else {
            echo "<li>Profissões não disponíveis.</li>";
          }
          ?>
        </ul>
      </div>
    </div>

    <script>
      const ctx = document.getElementById('radarChart');
      new Chart(ctx, {
        type: 'radar',
        data: {
          labels: ['Dominância (D)', 'Influência (I)', 'Estabilidade (S)', 'Conformidade (C)'],
          datasets: [
            {
              label: 'MAIS (Eu Público)',
              data: [<?= $result['d_mais'] ?>, <?= $result['i_mais'] ?>, <?= $result['s_mais'] ?>, <?= $result['c_mais'] ?>],
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              pointBackgroundColor: 'rgba(54, 162, 235, 1)'
            },
            {
              label: 'MENOS (Eu Privado)',
              data: [<?= $result['d_menos'] ?>, <?= $result['i_menos'] ?>, <?= $result['s_menos'] ?>, <?= $result['c_menos'] ?>],
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgba(255, 99, 132, 1)',
              pointBackgroundColor: 'rgba(255, 99, 132, 1)'
            },
            {
              label: 'MUDANÇA (Eu Percebido)',
              data: [<?= $result['d_dif'] ?>, <?= $result['i_dif'] ?>, <?= $result['s_dif'] ?>, <?= $result['c_dif'] ?>],
              backgroundColor: 'rgba(75, 192, 192, 0.2)',
              borderColor: 'rgba(75, 192, 192, 1)',
              pointBackgroundColor: 'rgba(75, 192, 192, 1)'
            }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom'
            }
          },
          scales: {
            r: {
              min: -8,
              max: 8,
              ticks: {
                stepSize: 2
              }
            }
          }
        }
      });
    </script>
  <?php else: ?>
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

    <header>
      <h1>Sem Resultados</h1>
    </header>
    <div class="info-box">
      <h2>Você ainda não realizou o teste de personalidade.</h2>
      <p>Para visualizar seus resultados, é necessário concluir o teste.</p>
      <a href="teste_personalidade.php" style="color: white; font-weight: bold; text-decoration: underline;">Fazer o Teste
        Agora</a>
    </div>
  <?php endif; ?>
</body>

</html>