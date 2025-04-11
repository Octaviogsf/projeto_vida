<?php
// Configuração do banco de dados
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'projetovida';

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Consulta os termos da tabela
$sql = 'SELECT * FROM personalities ORDER BY no ASC';
$result = $db->query($sql);
$data = array();
while ($row = $result->fetch_object())
  $data[] = $row;

$cols = 4;
$rows = intval(count($data) / $cols); // Correção: 28 termos / 4 por questão = 7 questões
?>
<!doctype html>
<html>

<head>
  <title>Teste de Personalidade DISC</title>
  <meta charset="utf-8">
</head>

<body>
  <form method='post' action='Resultado personalidade.php'>
    <div>
      <p><strong>Instruções:</strong> Para cada grupo de palavras, escolha uma que MAIS se parece com você e uma que MENOS se parece.</p>
    </div>

    <table>
      <caption><strong>Teste de Personalidade DISC</strong></caption>
      <thead>
        <tr>
          <th>Nº</th>
          <th>Palavra</th>
          <th>MAIS</th>
          <th>MENOS</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $index = 0;
        for ($i = 0; $i < $rows; ++$i) {
          echo "<tr" . ($i % 2 == 0 ? " class='dark'" : "") . ">";
          echo "<td>" . ($i + 1) . "</td>";
          echo "<td colspan='3'>";
          echo "<table width='100%'>";

          for ($j = 0; $j < $cols; ++$j) {
            if (!isset($data[$index])) continue;

            $term = $data[$index]->term;
            $id = $data[$index]->id;

            // Só o primeiro input precisa do required
            $required_m = ($j == 0) ? "required" : "";
            $required_l = ($j == 0) ? "required" : "";

            echo "<tr>
              <td>$term</td>
              <td align='center'>
                <input type='radio' name='m[$i]' value='$id' $required_m />
              </td>
              <td align='center'>
                <input type='radio' name='l[$i]' value='$id' $required_l />
              </td>
            </tr>";
            $index++;
          }

          echo "</table>";
          echo "</td></tr>";
        }
        ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan='4'>
            <input type='submit' value='Processar Resultado' class='btn' />
          </th>
        </tr>
      </tfoot>
    </table>
  </form>

  <!-- Script que impede marcar a mesma palavra como MAIS e MENOS -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelector('form').addEventListener('change', function (e) {
        if (e.target.type === 'radio') {
          const name = e.target.name;
          const value = e.target.value;
          const match = name.match(/\[(\d+)\]/);
          if (!match) return;
          const group = match[1];

          const otherName = name.startsWith('m') ? `l[${group}]` : `m[${group}]`;
          const otherRadios = document.getElementsByName(otherName);

          otherRadios.forEach(radio => {
            if (radio.value === value && radio.checked) {
              e.target.checked = false;
              alert("Não é possível escolher a mesma palavra como MAIS e MENOS.");
            }
          });
        }
      });
    });
  </script>
</body>

</html>
