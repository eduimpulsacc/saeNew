<?

$conn=@pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion final "); 


//$conn=@pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

//$conn2=@pg_connect("dbname=respaldo_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");


echo "<br>".$sql="SELECT id_curso, grado_curso, ensenanza FROM curso c INNER JOIN  ano_escolar ae ON c.id_ano=ae.id_ano
WHERE nro_ano=2017";
$rs_curso =pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_curso);$i++){
	$fila =pg_fetch_array($rs_curso,$i);
	
	switch ($fila['grado_curso']){
		case 1:
			$grado = "pr=1";
			break;
		case 2:
			$grado = "sg=1";
			break;
		case 3:
			$grado = "tr=1";
			break;
		case 4:
			$grado = "ct=1";
			break;
		case 5:
			$grado = "qt=1";
			break;
		case 6:
			$grado = "sx=1";
			break;
		case 7:
			$grado = "sp=1";
			break;
		case 8:
			$grado = "oc=1";
			break;
		
	}
	
	echo "<br>".$sql="SELECT id_nivel FROM niveles WHERE tipo_ense=".$fila['ensenanza']." AND $grado";
	$rs_nivel = pg_exec($conn,$sql);
	$nivel = pg_result($rs_nivel,0);
		
	echo "<br>".$sql="UPDATE curso SET id_nivel=".$nivel." WHERE id_curso=".$fila['id_curso'];
	$rs_mod = pg_exec($conn,$sql);
	

	
	}


echo "<br> SE HAN MODIFICADO ".pg_numrows($rs_curso)." CURSOS";
?>