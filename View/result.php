<!doctype html>
<html>

<head>
  <title>Teste de Personalidade</title>
  <link rel='stylesheet' href='' />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    #radarContainer {
      width: 700px;
      height: 500px;
      margin: 0 auto;
    }

    canvas {
      width: 100% !important;
      height: 100% !important;
    }
  </style>
</head>

<body>
  <header>
    <h1>Resultado da Personalidade</h1>
  </header>

  <?php
  session_start();
  if (isset($_POST['m']) && isset($_POST['l'])) {
    include '../inc/db.php';
    include '../inc/formula.php';

    $mais = array_count_values($_POST['m']);
    $menos = array_count_values($_POST['l']);
    $resultado = array();
    $aspecto = array('D', 'I', 'S', 'C');

    foreach ($aspecto as $a) {
      $resultado[$a][1] = isset($mais[$a]) ? $mais[$a] : 0;
      $resultado[$a][2] = isset($menos[$a]) ? $menos[$a] : 0;
      $resultado[$a][3] = $resultado[$a][1] - $resultado[$a][2];
    }

    $linha1 = getPattern($db, $resultado, 1);
    $linha2 = getPattern($db, $resultado, 2);
    $linha3 = getPattern($db, $resultado, 3);

    // Inserir os dados no banco de dados
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

    <div style="margin-top: 30px;">
      <h3>Significado dos Aspectos DISC:</h3>
      <ul>
        <li><b>D – Dominância</b>: Foco em resultados, assertividade, controle.</li>
        <li><b>I – Influência</b>: Comunicação, entusiasmo, persuasão.</li>
        <li><b>E – Estabilidade</b>: Paciência, lealdade, previsibilidade.</li>
        <li><b>C – Conformidade</b>: Precisão, lógica, foco em regras.</li>
      </ul>
    </div>

    <div>
      <h1>RESULTADO</h1>
      <div>
        <h2>Perfil de Caráter</h2>
        <b>Personalidade em público</b><br />
        <?php
        if (isset($linha1[1]) && isset($linha1[1]->behaviour)) {
          echo "<ul><li>" . implode('</li><li>', explode(',', $linha1[1]->behaviour)) . "</li></ul>";
        } else {
          echo "<p>Comportamento não disponível.</p>";
        }
        ?>

        <b>Personalidade sob pressão</b><br />
        <?php
        if (isset($linha2[1]) && isset($linha2[1]->behaviour)) {
          echo "<ul><li>" . implode('</li><li>', explode(',', $linha2[1]->behaviour)) . "</li></ul>";
        } else {
          echo "<p>Comportamento não disponível.</p>";
        }
        ?>

        <b>Personalidade verdadeira e oculta</b><br />
        <?php
        if (isset($linha3[1]) && isset($linha3[1]->behaviour)) {
          echo "<ul><li>" . implode('</li><li>', explode(',', $linha3[1]->behaviour)) . "</li></ul>";
        } else {
          echo "<p>Comportamento não disponível.</p>";
        }
        ?>

        <h2>Descrição da Personalidade</h2>
        <?php
        if (isset($linha3[1]) && isset($linha3[1]->description)) {
          echo "<p>{$linha3[1]->description}</p>";
        } else {
          echo "<p>Descrição não disponível.</p>";
        }
        ?>

        <h2>Profissões Compatíveis</h2>
        <?php
        if (isset($linha3[1]) && isset($linha3[1]->jobs)) {
          echo "<ul><li>" . implode('</li><li>', explode(',', $linha3[1]->jobs)) . "</li></ul>";
        } else {
          echo "<p>Profissões não disponíveis.</p>";
        }
        ?>
      </div>
    </div>

  <?php } ?>
</body>

</html>