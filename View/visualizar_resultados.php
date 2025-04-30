<?php
session_start();
include '../inc/db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

// Buscar o último resultado associado ao usuário
$sql = "SELECT * FROM resultados_quiz WHERE user_id = ? ORDER BY id DESC LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Se resultado encontrado, mostra o gráfico e dados
if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Resultado do Teste</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    #radarContainer {
      width: 700px;
      height: 500px;
      margin: 0 auto;
    }
    canvas {
      width: 100% !important;
      height: 100% !important;
    }
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f8f9fa;
    }
    h3 {
      margin-top: 40px;
    }
  </style>
</head>
<body>

<div id="radarContainer">
  <canvas id="radarChart"></canvas>
</div>

<script>
const ctx = document.getElementById('radarChart');
new Chart(ctx, {
  type: 'radar',
  data: {
    labels: ['Dominância (D)', 'Influência (I)', 'Estabilidade (E)', 'Conformidade (C)'],
    datasets: [
      {
        label: 'MAIS (Eu Público)',
        data: [<?= $row['d_mais'] ?>, <?= $row['i_mais'] ?>, <?= $row['s_mais'] ?>, <?= $row['c_mais'] ?>],
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        pointBackgroundColor: 'rgba(54, 162, 235, 1)'
      },
      {
        label: 'MENOS (Eu Privado)',
        data: [<?= $row['d_menos'] ?>, <?= $row['i_menos'] ?>, <?= $row['s_menos'] ?>, <?= $row['c_menos'] ?>],
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgba(255, 99, 132, 1)',
        pointBackgroundColor: 'rgba(255, 99, 132, 1)'
      },
      {
        label: 'MUDANÇA (Eu Percebido)',
        data: [<?= $row['d_dif'] ?>, <?= $row['i_dif'] ?>, <?= $row['s_dif'] ?>, <?= $row['c_dif'] ?>],
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

<h3>Comportamentos:</h3>
<p><strong>Comportamento em Público:</strong> <?= !empty($row['comportamento_publico']) ? $row['comportamento_publico'] : "Comportamento não disponível." ?></p>
<p><strong>Comportamento sob Pressão:</strong> <?= !empty($row['comportamento_pressao']) ? $row['comportamento_pressao'] : "Comportamento não disponível." ?></p>
<p><strong>Comportamento Oculto:</strong> <?= !empty($row['comportamento_oculto']) ? $row['comportamento_oculto'] : "Comportamento não disponível." ?></p>

<h3>Descrição:</h3>
<p><?= !empty($row['descricao']) ? $row['descricao'] : "Descrição não disponível." ?></p>

<h3>Profissões Compatíveis:</h3>
<ul>
  <?php
    $profissoes = !empty($row['profissoes']) ? explode(',', $row['profissoes']) : [];
    if (count($profissoes) > 0) {
      foreach ($profissoes as $profissao) {
        echo "<li>" . htmlspecialchars($profissao) . "</li>";
      }
    } else {
      echo "<li>Profissões não disponíveis.</li>";
    }
  ?>
</ul>

</body>
</html>
<?php
} else {
  // Nenhum resultado encontrado – mostrar mensagem e botão para fazer o teste
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Sem Resultado</title>
</head>
<body>

<div class="box">
  <h2>Você ainda não realizou o teste de personalidade.</h2>
  <p>Para visualizar seus resultados, você precisa concluir o teste.</p>
  <a href="teste_personalidade.php" class="button">Fazer o Teste Agora</a>
</div>

</body>
</html>
<?php
}
?>
