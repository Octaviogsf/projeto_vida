<?php
include '../inc/db.php';
//-- consulta os dados do banco de dados
$sql = 'SELECT * FROM tbl_personalities ORDER BY no ASC';
$result = $db->query($sql);
$x = array();
$no = 0;
while ($row = $result->fetch_object()) {
  if ($no != $row->no) {
    $no = $row->no;
    $x[$no] = array();
  }
  $x[$no][] = $row;
}
$data = array();
foreach ($x as $dt) {
  foreach ($dt as $d) {
    $data[] = $d;
  }
}
?>
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
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../style.css">
  <script src="https://kit.fontawesome.com/d650d7db78.js" crossorigin="anonymous"></script>
  <title>Quiz de múltiplas inteligências e personalidade.</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #0e1a2b;
      color: white;
    }

    tbody {
      font-weight: normal;
    }

    header {
      background-color: #152642;
      padding: 20px;
      text-align: center;
    }

    h1 {
      margin: 0;
      font-size: 44px;
      font-weight: normal;
    }

    .header {
      background-color: #152642;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      padding: 10px 20px;
    }

    .logo {
      max-width: 200px;
      height: auto;
    }

    .user-name {
      font-size: 20px;
      margin: 10px;
    }

    .profile-icon {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .info-box {
      background-color: #1c2f4a;
      padding: 15px;
      margin: 20px;
      border-radius: 8px;
      font-weight: normal;
      font-size: 28px;
      line-height: 1.4;
    }

    #container {
      padding: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px auto;
    }

    th,
    td {
      border: 1px solid #2e4a6d;
      padding: 10px;
      text-align: center;
    }

    thead {
      background-color: #203a5c;
    }

    tbody tr.dark {
      background-color: #1a2f47;
      font-weight: normal;
    }

    tbody tr {
      background-color: #142437;
      font-weight: normal;
    }

    .btn {
      background-color: #204d74;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 32px;
      border-radius: 6px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #2a6ca3;
    }

    .info-box b {
      font-weight: 500;
    }

    form {
      font-size: 32px;
      font-weight: normal;
    }

    thead tr th {
      font-weight: normal;
    }

    /* Responsivo */
    @media (max-width: 768px) {
      h1 {
        font-size: 28px;
      }

      .info-box {
        font-size: 18px;
        padding: 10px;
        margin: 10px;
      }

      .user-name {
        font-size: 34px;
      }

      .btn {
        font-size: 34px;
        padding: 8px 16px;
      }

      form {
        font-size: 34px;
      }

      table th,
      table td {
        font-size: 14px;
        padding: 6px;
      }

      .header {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .profile-icon img {
        width: 80px;
        height: 80px;
      }

      .logo {
        max-width: 150px;
      }
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
    <h1>Quiz de múltiplas inteligências e personalidade.</h1>
  </header>
  <div id='container'>
    <div class='info-box'>
      <b>INSTRUÇÕES</b>: Cada número abaixo contém 4 (quatro) frases. Sua tarefa é: <br />
      <ol>
        <li>Marque com um sinal na coluna abaixo da letra [Mais se encaixa] ao lado da frase que MAIS descreve você</li>
        <li>Marque com um sinal na coluna abaixo da letra [Menos se encaixa] ao lado da frase que MENOS descreve você
        </li>
      </ol>
      <br />
      <b>ATENÇÃO</b>: Para cada número, deve haver apenas 1 (um) sinal em cada uma das colunas Mais se encaixa e Menos
      se encaixa.<br />
    </div>
    <form method='post' action='result.php'>
      <table>
        <thead>
          <tr>
            <?php for ($i = 0; $i < 3; ++$i): ?>
              <th>Nº</th>
              <th>Descrição Pessoal</th>
              <th>Mais</th>
              <th>Menos</th>
            <?php endfor; ?>
          </tr>
        </thead>
        <tbody>
          <?php
          for ($i = 0; $i < 8; $i++) {
            echo "<tr" . ($i % 2 == 0 ? " class='dark'" : "") . ">";
            for ($j = 0; $j < 4; ++$j) {
              for ($n = 0; $n < 3; $n++) {
                if ($j > 0 && $n == 0) {
                  echo "<tr" . ($i % 2 == 0 ? " class='dark'" : "") . ">";
                } elseif ($j == 0) {
                  echo "<th rowspan='4'"
                    . ($j == 0 ? " class='first'" : "") . ">"
                    . ($i + $n * 8 + 1)
                    . "</th>";
                }
                $no = $n * 8 + $i * 4 + $j + (24 * $n);
                echo "<td" . ($j == 0 ? " class='first'" : "") . ">
                        {$data[$no]->term}
                      </td>
                      <td" . ($j == 0 ? " class='first'" : "") . ">
                        <input type='radio' 
                               name='m[" . ($i + $n * 8) . "]' 
                               value='{$data[$no]->most}' 
                               required />
                      </td>
                      <td" . ($j == 0 ? " class='first'" : "") . ">
                        <input type='radio' 
                               name='l[" . ($i + $n * 8) . "]' 
                               value='{$data[$no]->least}' 
                               required />
                      </td>";
              }
              echo "</tr>";
            }
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan='12'>
              <input type='submit' value='Processar' class='btn' />
            </th>
          </tr>
        </tfoot>
      </table>
    </form>
  </div>
</body>

</html>