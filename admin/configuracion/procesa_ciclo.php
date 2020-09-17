<?   require "../../util/header.inc";
	//include('../clases/class_Reporte.php');


if($tipo==1){
	$sql_max_ciclo ="SELECT max(id_ciclo) FROM ciclo_conf";
	$resp = pg_exec($conn,$sql_max_ciclo);
	$max = pg_result($resp,0);
	$next = $max+1;
	
	$sql_nuevo_ciclo = "INSERT INTO ciclo_conf (id_ciclo,rdb,id_ano,nomb_ciclo) VALUES (".$next.",".$rdb.",".$ano.",'".$txt_ciclo."')";
	$resp_1 = pg_exec($conn,$sql_nuevo_ciclo);
	echo "<script language='javascript'>window.location='asignar_ciclo.php?tipo=1'</script>";
}
if($tipo==2){

	for($i=0;$i<$count_curso;$i++){
		$check = ${"ck_".$i};
		$curso = ${"curso".$i};
		 if($check==1){
		 	$sql_insert="INSERT INTO ciclos (id_ciclo,id_ano,id_curso) VALUES (".$id_ciclo.",".$ano.",".$curso.")";
			$resp_insert = pg_exec($conn,$sql_insert);
		 }
	}
	
	echo "<script language='javascript'>window.location='asignar_ciclo.php?tipo=2&id_ciclo=".$id_ciclo."&cmb_ensenanza=".$ensenanza."'</script>";

}
if($tipo==3){

	$sql_elimina = "DELETE FROM ciclos WHERE id_ciclo=".$id_ciclo." AND id_curso=".$id_curso;
	$resp = pg_exec($conn,$sql_elimina);
	echo "<script language='javascript'>window.location='asignar_ciclo.php?tipo=2&id_ciclo=".$id_ciclo."&cmb_ensenanza=".$ensenanza."'</script>";
}
/*if($tipo==22){
	$sql_instit = "SELECT rdb FROM institucion";
	$resp_instit = pg_exec($conn,$sql_instit);
	for($i=0;$i<pg_numrows($resp_instit);$i++){
		$fila_instit = pg_fetch_array($resp_instit,$i);
		echo "<br />".$fila_instit['rdb'];
		
			$sql_max_ciclo ="SELECT max(id_ciclo) FROM ciclo_conf";
			$resp = pg_exec($conn,$sql_max_ciclo);
			$max = pg_result($resp,0);
			$next = $max+1;
		for($e=0;$e<6;$e++){
			switch ($e){
				case(0):
					$ciclo="1er Ciclo Parvularia";
					break;
				case(1):
					$ciclo="2do Ciclo Parvularia";
					break;
				case(2):
					$ciclo="1er Ciclo Basica";
					break;
				case(3):
					$ciclo="2do Ciclo Basica";
					break;
				case(4):
					$ciclo="1er Ciclo Media";
					break;
				case(5):
					$ciclo="2do Ciclo Media";
					break;
			}
				//echo "<br />E->".$e;
				$sql_anos = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_instit['rdb'];
				$resp_anos = pg_exec($conn,$sql_anos);
				$num_anos = pg_numrows($resp_anos);
				for($ano=0;$ano<$num_anos;$ano++){
					$fila_anos = pg_fetch_array($resp_anos,$ano);
					$id_anos=$fila_anos['id_ano'];
						echo "<br />".$sql_nuevo_ciclo = "INSERT INTO ciclo_conf (id_ciclo,rdb,id_ano,nomb_ciclo) VALUES (".$next.",".$fila_instit['rdb'].",".$id_anos.",'".$ciclo."')";
						//$resp_1 = pg_exec($conn,$sql_nuevo_ciclo);
						/*	$sql_ensenanza=" SELECT * FROM tipo_ensenanza WHERE cod_tipo ";
							$sql_ensenanza.=" IN (SELECT ensenanza FROM curso WHERE id_ano IN (SELECT id_ano FROM ano_escolar ";
							$sql_ensenanza.=" WHERE id_institucion=".$fila_instit['rdb']." AND nro_ano=2008)) ORDER BY cod_tipo ASC";
							$resp_ensenanza = pg_exec($conn,$sql_ensenanza);
							$num_ense=pg_numrows($resp_ensenanza);
										$sql_ano_escolar ="SELECT id_ano FROM ano_escolar WHERE id_institucion =".$fila_instit['rdb']."AND nro_ano=2008";
										$resp_ano = pg_exec($conn,$sql_ano_escolar);
										$ano_escolar = pg_result($resp_ano,0);
								for($ii=0;$ii<$num_ense;$ii++){
									$fila_ense = pg_fetch_array($resp_ensenanza,$ii);
									$tipo_ense = $fila_ense['cod_tipo'];
									//echo "<br />".$nomb_ense = $fila_ense['nombre_tipo'];
										echo "<br >".$sql_cursos = "SELECT * FROM curso WHERE ensenanza=".$tipo_ense."AND id_ano=".$ano_escolar;
										$resp_cursos = pg_exec($conn,$sql_cursos);
										$num_cursos = pg_numrows($resp_cursos);
											for($ee=0;$ee<$num_cursos;$ee++){
												$fila_cursos = pg_fetch_array($resp_cursos,$ee);
												echo "<br />".$fila_cursos['id_curso'];
											}
									
								
								}
						$next = $next+1;
				}
		}
	}
}*/
/*if ($tipo=23){
	$sql_instit = "SELECT rdb FROM institucion WHERE rdb IN (SELECT rdb FROM ciclo_conf)";
	$resp = pg_exec($conn,$sql_instit);
	for($i=0;$i<pg_numrows($resp);$i++){
		$fila_instit2 = pg_fetch_array($resp,$i);
		echo "<br />".$instit = $fila_instit2['rdb'];
		
			$sql="SELECT a.id_curso,a.grado_curso,a.letra_curso,a.ensenanza,b.nombre_tipo,a.id_ano FROM curso a ";
			$sql.=" INNER JOIN tipo_ensenanza b ON (a.ensenanza=b.cod_tipo) ";
			echo "<br />".$sql.="WHERE a.ensenanza=110 AND a.id_ano IN (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$instit.") ORDER BY id_ano,grado_curso ASC ";
			$resp_cursos = pg_exec($conn,$sql);
			$num_cursos = pg_numrows($resp_cursos);
			for($e=0;$e<$num_cursos;$e++){
				$fila_cursos = pg_fetch_array($resp_cursos,$e);
				echo "<br />".$fila_cursos['grado_curso']."-".$fila_cursos['letra_curso']."-".$fila_cursos['nombre_tipo'];
					
					$sql_anos = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$instit;
					$resp_anos = pg_exec($conn,$sql_anos);
					$num_anos = pg_numrows($resp_anos);
					for($ano=0;$ano<$num_anos;$ano++){
						$fila_anos = pg_fetch_array($resp_anos,$ano);
						$id_anos=$fila_anos['id_ano'];
					
						$sql_select_id_ciclo = "SELECT id_ciclo FROM ciclo_conf WHERE rdb=".$instit." AND id_ano =".$id_anos;
						if($fila_cursos['grado_curso'] == 1 or $fila_cursos['grado_curso']==2 or $fila_cursos['grado_curso']==3){
							$sql_select_id_ciclo.=" AND nomb_ciclo='1er Ciclo Basica'";
						}else{
							$sql_select_id_ciclo.=" AND nomb_ciclo='2do Ciclo Basica'";
					
						}
							echo "<br />".$sql_select_id_ciclo;
							$resp_select = pg_exec($conn,$sql_select_id_ciclo);
							echo "<br />".$ciclo=pg_result($resp_select,0);
							echo "<br />".$sql_insert_ciclo ="INSERT INTO ciclos (id_ciclo,id_ano,id_curso) VALUES (".$ciclo.",".$id_anos.",".$fila_cursos['id_curso'].")";
							//$resp_insert = pg_exec($conn,$sql_insert_ciclo);
						}
				//$sql_insert="INSERT INTO ciclos "
			
			}
	}
	
}*/
?>


