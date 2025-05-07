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
<!doctype html>
<html>

<head>
  <title>Teste de Personalidade</title>
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
  <?php
  if (isset($_POST['m']) && isset($_POST['l'])) {
    include '../inc/db.php';
    include '../inc/formula.php';

    $mais = array_count_values($_POST['m']);
    $menos = array_count_values($_POST['l']);
    $resultado = array();
    $aspecto = array('D', 'I', 'S', 'C');

    foreach ($aspecto as $a) {
      $resultado[$a][1] = $mais[$a] ?? 0;
      $resultado[$a][2] = $menos[$a] ?? 0;
      $resultado[$a][3] = $resultado[$a][1] - $resultado[$a][2];
    }

    $linha1 = getPattern($db, $resultado, 1);
    $linha2 = getPattern($db, $resultado, 2);
    $linha3 = getPattern($db, $resultado, 3);

    // Salva no banco
    $stmt = $db->prepare("INSERT INTO resultados_quiz (
      d_mais, i_mais, s_mais, c_mais,
      d_menos, i_menos, s_menos, c_menos,
      d_dif, i_dif, s_dif, c_dif,
      comportamento_publico,
      comportamento_pressao,
      comportamento_oculto,
      descricao,
      profissoes,
      user_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
      $linha1[0]->d,
      $linha1[0]->i,
      $linha1[0]->s,
      $linha1[0]->c,
      $linha2[0]->d,
      $linha2[0]->i,
      $linha2[0]->s,
      $linha2[0]->c,
      $linha3[0]->d,
      $linha3[0]->i,
      $linha3[0]->s,
      $linha3[0]->c,
      $linha1[1]->behaviour ?? '',
      $linha2[1]->behaviour ?? '',
      $linha3[1]->behaviour ?? '',
      $linha3[1]->description ?? '',
      $linha3[1]->jobs ?? '',
      $_SESSION["user_id"]
    ]);
    ?>
    <div class="header">
      <a href="index.php">
        <div class="logo">
          <img src="../IMG/Logo sem fundoe.png" alt="Logo" style="width: 100%; height: 100%;">
        </div>
      </a>
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
    <header>
      <h1>Resultado da Personalidade</h1>
    </header>

    <div class="container">
      <!-- Gráfico -->
      <div class="chart-box">
        <canvas id="radarChart"></canvas>
      </div>

      <!-- Informações -->
      <div class="info-box">
        <h3>Significado dos Aspectos:</h3>
        <ul>
          <li>D – Dominância: Foco em resultados, assertividade, controle.</li>
          <li>I – Influência: Comunicação, entusiasmo, persuasão.</li>
          <li>S – Estabilidade: Paciência, lealdade, previsibilidade.</li>
          <li>C – Conformidade: Precisão, lógica, foco em regras.</li>
        </ul>

        <h2>RESULTADO</h2>

        Personalidade em público:
        <?php
        if ($linha1[1]->behaviour ?? false) {
          echo "<ul><li>" . implode('</li><li>', explode(',', $linha1[1]->behaviour)) . "</li></ul>";
        }

        echo "Personalidade sob pressão:";
        if ($linha2[1]->behaviour ?? false) {
          echo "<ul><li>" . implode('</li><li>', explode(',', $linha2[1]->behaviour)) . "</li></ul>";
        }

        echo "Personalidade verdadeira e oculta:";
        if ($linha3[1]->behaviour ?? false) {
          echo "<ul><li>" . implode('</li><li>', explode(',', $linha3[1]->behaviour)) . "</li></ul>";
        }
        ?>
        <br>
        <h3>Descrição da Personalidade:</h3>
        <p><?= $linha3[1]->description ?? 'Descrição não disponível.' ?></p>

        <h3>Profissões Compatíveis</h3>
        <?php
        if ($linha3[1]->jobs ?? false) {
          echo "<ul><li>" . implode('</li><li>', explode(',', $linha3[1]->jobs)) . "</li></ul>";
        } else {
          echo "<p>Profissões não disponíveis.</p>";
        }
        ?>
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
              data: [<?= $linha1[0]->d ?>, <?= $linha1[0]->i ?>, <?= $linha1[0]->s ?>, <?= $linha1[0]->c ?>],
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              pointBackgroundColor: 'rgba(54, 162, 235, 1)'
            },
            {
              label: 'MENOS (Eu Privado)',
              data: [<?= $linha2[0]->d ?>, <?= $linha2[0]->i ?>, <?= $linha2[0]->s ?>, <?= $linha2[0]->c ?>],
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgba(255, 99, 132, 1)',
              pointBackgroundColor: 'rgba(255, 99, 132, 1)'
            },
            {
              label: 'MUDANÇA (Eu Percebido)',
              data: [<?= $linha3[0]->d ?>, <?= $linha3[0]->i ?>, <?= $linha3[0]->s ?>, <?= $linha3[0]->c ?>],
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

  <?php } else {
    echo "<p>Erro: dados não enviados.</p>";
  } ?>
</body>

</html>