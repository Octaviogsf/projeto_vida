<doctype html>
<html>
  <head>
    <title>Teste de Personalidade</title>
    <link rel='stylesheet' href='css/disc.css' />
  </head>
  <body>
  <header><h1>Resultado do Teste de Personalidade</h1></header>
<?php
if(isset($_POST['m']) && isset($_POST['l'])){
  include 'inc/db.php';
  include 'inc/formula.php';
  $mais = array_count_values($_POST['m']);
  $menos = array_count_values($_POST['l']);
  $resultado = array();
  $aspectos = array('D', 'I', 'S', 'C', 'N');
  foreach($aspectos as $a){
    $resultado[$a][1] = isset($mais[$a]) ? $mais[$a] : 0;
    $resultado[$a][2] = isset($menos[$a]) ? $menos[$a] : 0;
    $resultado[$a][3] = ($a != 'N' ? $resultado[$a][1] - $resultado[$a][2] : 0);
  }
  $grafico1 = getPattern($db, $resultado, 1);
  $grafico2 = getPattern($db, $resultado, 2);
  $grafico3 = getPattern($db, $resultado, 3);
?>
    <div id='container'>
      <script src="js/raphael.min.js"></script>
      <script src="js/jquery.min.js"></script>
      <script src="js/morris.min.js"></script>
      <script>
      $(function(){
        Morris.Line({
          element: 'graph',
          data: [
            <?php
            echo "
            { y: 'Personalidade', a: {$grafico1[0]->d}, b:{$grafico2[0]->d}, c:{$grafico3[0]->d}},
            { y: 'Público', a: {$grafico1[0]->i}, b:{$grafico2[0]->i}, c:{$grafico3[0]->i}},
            { y: 'Pressão', a: {$grafico1[0]->s}, b:{$grafico2[0]->s}, c:{$grafico3[0]->s}},
            { y: 'Verdadeira', a: {$grafico1[0]->c}, b:{$grafico2[0]->c}, c:{$grafico3[0]->c}},
            ";
            ?>
          ],
          xkey: 'y',
          ykeys: ['a', 'b', 'c'],
          parseTime: false,
          labels: ['MAIS - Mais Público', 'MENOS - Mais Privado', 'MUDANÇA - Como sou percebido'],
          ymax: 8,
          ymin: -8
        });
      });
      </script>
      <table>
        <caption>Quadro de Resultados</caption>
        <tr>
          <th>Mais</th>
          <th>Menos</th>
          <th>Mudança</th>
          <th>Gráfico de Resultados</th>
        </tr>
    <?php
    $i = 0;
    // Removemos a impressão das siglas
    foreach($aspectos as $a){
      // Imprime apenas os valores sem siglas, com explicações mais amigáveis
      echo "<tr>
              <td>{$resultado[$a][1]}</td>
              <td>{$resultado[$a][2]}</td>
              <td>{$resultado[$a][3]}</td>"
              .(++$i == 1 ? "<td id='graph' rowspan='5' width='400'></td>" : "")
           ."</tr>";
      }
    ?>
      </table>
    </div>
    <div>
      <h1>RESULTADO</h1>
      <div>
        <h2>Visão Geral da Personalidade</h2>
        <b>Personalidade em Público</b><br />
        <?php
        echo "<ul><li>" . implode('</li><li>', explode(',', $grafico1[1]->behaviour)) . "</li></ul>";
        ?>
        <b>Personalidade sob Pressão</b><br />
        <?php
        echo "<ul><li>" . implode('</li><li>', explode(',', $grafico2[1]->behaviour)) . "</li></ul>";
        ?>
        <b>Personalidade Verdadeira (Oculta)</b><br />
        <?php
        echo "<ul><li>" . implode('</li><li>', explode(',', $grafico3[1]->behaviour)) . "</li></ul>";
        ?>
        <h2>Descrição da Personalidade</h2>
        <?php
        echo "<p>{$grafico3[1]->description}</p>";
        ?>
        <h2>Combinação de Cargos (Empregos Compatíveis)</h2>
        <?php
        echo "<ul><li>" . implode('</li><li>', explode(',', $grafico3[1]->jobs)) . "</li></ul>";
        ?>
      </div>
    </div>
<?php
}
?>
  </body>
</html>
