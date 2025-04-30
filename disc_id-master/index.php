<?php
include 'inc/db.php';
//-- consulta os dados do banco de dados
$sql='SELECT * FROM tbl_personalities ORDER BY no ASC';
$result=$db->query($sql);
$x=array();
$no=0;
while($row=$result->fetch_object()){
  if($no!=$row->no){
    $no=$row->no;
    $x[$no]=array();
  }
  $x[$no][]=$row;
}
$data=array();
foreach($x as $dt){
  foreach($dt as $d){
    $data[]=$d;
  }
}
?>
<doctype html>
<html>
  <head>

    <title>Teste de Personalidade</title>
    <meta http-equiv="expires" content="<?php echo date('r');?>" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="no-cache" />
    <link rel='stylesheet' href='css/disc.css?<?php echo md5(date('r'));?>' />
  </head>
  <body>
    <header><h1>Teste de Personalidade</h1></header>
    <div id='container'>
    <div class='info-box'>
      <b>INSTRUÇÕES</b>: Cada número abaixo contém 4 (quatro) frases. Sua tarefa é: <br />
      <ol>
        <li>Marque com um sinal na coluna abaixo da letra [Mais se encaixa] ao lado da frase que MAIS descreve você</li>
        <li>Marque com um sinal na coluna abaixo da letra [Menos se encaixa] ao lado da frase que MENOS descreve você</li>
      </ol>
      <br />
      <b>ATENÇÃO</b>: Para cada número, deve haver apenas 1 (um) sinal em cada uma das colunas Mais se encaixa e Menos se encaixa.<br />
    </div>
    <form method='post' action='result.php'>
    <table>
      <thead>
        <tr>
        <?php for($i=0;$i<3;++$i):?>
          <th>Nº</th>
          <th>Descrição Pessoal</th>
          <th>Mais</th>
          <th>Menos</th>
        <?php endfor; ?>
        </tr>
      </thead>
      <tbody>
      <?php
      for($i=0;$i<8;$i++){
        echo "<tr".($i%2==0?" class='dark'":"").">";
        for($j=0;$j<4;++$j){
          for($n=0;$n<3;$n++){
             if($j>0 && $n==0){
               echo "<tr".($i%2==0?" class='dark'":"").">";
             }elseif($j==0){
               echo "<th rowspan='4'"
                 .($j==0?" class='first'":"").">"
                 .($i+$n*8+1)
                 ."</th>";
             }
             $no=$n*8+$i*4+$j+(24*$n);
            echo "<td".($j==0?" class='first'":"").">
                  {$data[$no]->term}
                  </td>
                  <td".($j==0?" class='first'":"").">
                <input type='radio' 
                       name='m[".($i+$n*8)."]' 
                     value='{$data[$no]->most}' 
                     required />" 
               ."</td>
                  <td".($j==0?" class='first'":"").">
                  <input type='radio' 
                         name='l[".($i+$n*8)."]' 
                         value='{$data[$no]->least}' 
                         required />"
                 ."</td>";
            }
          echo "</tr>";
        }
      }
      ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan='3'>
            <input type='submit' value='Processar' class='btn'/>
           </th>
         </tr>
      </tfoot>
    </table>
    </form>
  </div>
  </body>
</html>
