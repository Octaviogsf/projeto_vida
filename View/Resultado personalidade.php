<doctype html>
	<html>

	<head>
		<title>DISC Personality Test</title>
	</head>

	<body>

		<?php
		if (isset($_POST['m']) && isset($_POST['l'])) {
			$most = array_count_values($_POST['m']);
			$least = array_count_values($_POST['l']);
			$result = array();
			$aspect = array('D', 'I', 'S', 'C', '#');
			foreach ($aspect as $a) {
				$result[$a]['most'] = isset($most[$a]) ? $most[$a] : 0;
				$result[$a]['least'] = isset($least[$a]) ? $least[$a] : 0;
				$result[$a]['change'] = ($a != '#' ? $result[$a]['most'] - $result[$a]['least'] : 0);
			}

			//-- database configuration
			$dbhost = 'localhost';
			$dbuser = 'root';
			$dbpass = '';
			$dbname = 'projetovida';
			//-- database connection
			$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
			$sql = "
        SELECT b.*,c.* 
		FROM
		pattern_map a
		JOIN
		(
		    SELECT
				d.d,i.i,s.s,c.c
			FROM
				(SELECT segment AS d FROM results WHERE graph=3 AND dimension='D' AND value=" . $result['D']['change'] . ") d,
				(SELECT segment AS i FROM results WHERE graph=3 AND dimension='I' AND value=" . $result['I']['change'] . ") i,
				(SELECT segment AS s FROM results WHERE graph=3 AND dimension='S' AND value=" . $result['S']['change'] . ") s,
				(SELECT segment AS c FROM results WHERE graph=3 AND dimension='C' AND value=" . $result['C']['change'] . ") c
		) b ON (a.d=b.d AND a.i=b.i AND a.s=b.s AND a.c=b.c)
		JOIN patterns c ON c.id=a.pattern";
			$result = $db->query($sql);
			$data = (isset($result) && !empty($result)) ? $result->fetch_object() : '';
			//-- if empty result found, get default result
			if (!isset($data->name)) {
				$sql = "
		SELECT b.*,c.* 
			FROM
			pattern_map a
			JOIN
			(
			    SELECT
					d.d,i.i,s.s,c.c
				FROM
					(SELECT segment AS d FROM results WHERE graph=3 AND dimension='D' AND value=15) d,
					(SELECT segment AS i FROM results WHERE graph=3 AND dimension='I' AND value=14) i,
					(SELECT segment AS s FROM results WHERE graph=3 AND dimension='S' AND value=15) s,
					(SELECT segment AS c FROM results WHERE graph=3 AND dimension='C' AND value=14) c
			) b ON (a.d=b.d AND a.i=b.i AND a.s=b.s AND a.c=b.c)
			JOIN patterns c ON c.id=a.pattern";
				$result = $db->query($sql);
				$data = (isset($result) && !empty($result)) ? $result->fetch_object() : die('Data not found, check your database');
			}
			?>
			<div>
				<h1>RESULTADO</h1>
				<?php if ($data): ?>
					<b>Segmento: </b><br /><?= "{$data->d}-{$data->i}-{$data->s}-{$data->c}" ?><br />
					<b>Padrão: </b><br /><?= $data->name ?><br />
					<b>Emoções: </b><br /><?= $data->emotions ?><br />
					<b>Objetivo: </b><br /><?= $data->goal ?><br />
					<b>Julga os outros por: </b><br /><?= $data->judges_others ?><br />
					<b>Influencia os outros por: </b><br /><?= $data->influences_others ?><br />
					<b>Valor para a organização: </b><br /><?= $data->organization_value ?><br />
					<b>Exagera em: </b><br /><?= $data->overuses ?><br />
					<b>Sob pressão: </b><br /><?= $data->under_pressure ?><br />
					<b>Medos: </b><br /><?= $data->fear ?><br />
					<b>Aumentaria sua eficácia por meio de: </b><br /><?= $data->effectiveness ?><br />
					<b>Descrição: </b><br /><?= $data->description ?><br />
				<?php else: ?>
					<p><strong>Não foi possível encontrar um perfil correspondente. Por favor, revise os dados ou o banco de
							dados.</strong></p>
				<?php endif; ?>
			</div>
			<?php
		}
		?>
	</body>

	</html>