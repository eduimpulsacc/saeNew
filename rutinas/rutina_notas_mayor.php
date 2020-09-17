<?
// Rutina para varias cosas
//$conn=pg_connect("dbname=coi_final host=200.2.201.19 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");
$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn_anto=pg_connect("dbname=coe host=200.29.20.214 port=1550 user=postgres password=post2005") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Corporacion.");	
				

$sql="SELECT id_curso FROM curso WHERE ID_ANO=1553 AND ensenanza=110 AND grado_curso in(7,8)";
$rs_curso = pg_exec($conn,$sql);

$sql="SELECT id_periodo FROM periodo WHERE id_ano=1553";
$rs_periodo = pg_exec($conn,$sql);


for($i=0;$i<pg_numrows($rs_curso);$i++){
	$fila_curso = pg_fetch_array($rs_curso,$i);
	
	$sql="SELECT id_ramo FROM ramo WHERE id_curso=".$fila_curso['id_curso']." AND cod_subsector=18";
	$rs_artistica = pg_exec($conn,$sql);
	$artistica = pg_Result($rs_artistica,0);
	

	$sql="SELECT rut_alumno FROM matricula WHERE id_curso=".$fila_curso['id_curso'];
	$rs_mat =pg_exec($conn,$sql);
	
	for($j=0;$j<pg_numrows($rs_periodo);$j++){
		$fila_periodo =pg_fetch_array($rs_periodo,$j);
		
		for($x=0;$x<pg_numrows($rs_mat);$x++){
			$fila_alumno=pg_fetch_array($rs_mat,$x);
			
			$sql="SELECT nota1,nota2,nota3,nota4,nota5,nota6,nota7,nota8,nota9,nota10 FROM notas2015 WHERE id_periodo=".$fila_periodo['id_periodo']." AND id_ramo IN (SELECT id_ramo FROM ramo WHERE id_curso=".$fila_curso['id_curso']." AND cod_subsector in (28,29)) AND rut_alumno=".$fila_alumno['rut_alumno'];
			$rs_notas = pg_exec($conn,$sql);
			
			$suma=0;
			$cont=0;
			for($c=0;$c<pg_numrows($rs_notas);$c++){
				$fila_notas =pg_fetch_array($rs_notas,$c);
				
				for($v=1;$v<11;$v++){
					$nota = "nota".$v;
					if($fila_notas[$nota]!=0){
						$suma = $suma + $fila_notas[$nota];
						$cont++;	
					}
					
				} //fin suma notas
			} // fin ciclo notas
				
				$promedio = round($suma / $cont);
				
				echo "<br>".$sql ="DELETE FROM notas2015 WHERE id_ramo=".$artistica." AND rut_alumno=".$fila_alumno['rut_alumno']." AND id_periodo=".$fila_periodo['id_periodo'];
				$rs_delete = pg_exec($conn,$sql);
				
				echo "<br>".$sql="INSERT INTO notas2015 (rut_alumno,id_ramo, id_periodo, nota1, promedio) VALUES (".$fila_alumno['rut_alumno'].", ".$artistica.",".$fila_periodo['id_periodo'].",".$promedio." ,".$promedio.")";
				$rs_insert=pg_exec($conn,$sql);

		}
		
	}
		
}
?>
