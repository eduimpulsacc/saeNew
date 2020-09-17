<? require('../../../../../util/header.inc');

	$institucion	= $_INSTIT;
	$frmModo		= $_FRMMODO;
	$ano			= $_ANO;
	$curso			= $_CURSO;
	$horario		= $_HORARIO;
	$_POSP          = 5;
	$bot			= 5;
	
	
	$sql ="SELECT ano_anterior FROM ano_Escolar WHERE id_ano=".$ano;
	$rs_ano = pg_exec($conn,$sql);
	$ano_ant = pg_result($rs_ano,0);

	$sql="SELECT * FROM horario WHERE id_ramo<>0 AND id_curso in (SELECT id_curso
			FROM curso 
			WHERE ensenanza in (SELECT ensenanza FROM curso WHERE id_curso=".$curso.") 
			AND grado_curso in (SELECT grado_curso FROM curso WHERE id_curso=".$curso.")
			AND letra_curso in (SELECT letra_curso FROM curso WHERE id_curso=".$curso.")
			AND id_ano in (SELECT ano_anterior FROM ano_escolar WHERE id_ano=".$ano." ))";
	$rs_horario = pg_exec($conn,$sql);


	for($i=0;$i<pg_numrows($rs_horario);$i++){
		$fila = pg_fetch_array($rs_horario,$i);

		$sql="SELECT id_ramo FROM ramo WHERE id_curso=".$curso." AND cod_subsector in (SELECT cod_subsector FROM ramo
			  WHERE id_ramo=".$fila['id_ramo'].")";
		$rs_ramo =pg_exec($conn,$sql);
		$ramo = pg_result($rs_ramo,0);

		$sql = "INSERT INTO horario (id_curso,id_ramo,id_estancia,dia,horaini,horafin,id_taller,rut_emp)
				VALUES (".$curso.",".$ramo.",0,".$fila['dia'].",'".$fila['horaini']."','".$fila['horafin']."',
				0,".$fila['rut_emp'].")";
		$result = pg_exec($conn,$sql);

	}

	echo "<script>window.location='listarHorario.php'</script>";
	
	


	?>