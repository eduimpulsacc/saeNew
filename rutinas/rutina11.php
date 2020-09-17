<?
$conn=@pg_connect("dbname=admedif host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");

echo $conn;
exit;
//$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("Error de conexión Antofagasta.");	
//$conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Corporacion.");
//$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");



//$sql ="SELECT NOTAS2011.*, RAMO.truncado FROM NOTAS2011 INNER JOIN RAMO ON NOTAS2011.ID_RAMO=RAMO.ID_RAMO WHERE modo_Eval=1 "; 
$sql=" SELECT NOTAS2011.*, RAMO.truncado FROM NOTAS2011 INNER JOIN RAMO ON NOTAS2011.ID_RAMO=RAMO.ID_RAMO WHERE id_periodo in (
select id_periodo from periodo p INNER JOIN ano_escolar a ON p.id_ano=a.id_ano where id_institucion=8680 and nro_ano=2011) AND  modo_Eval=1";
//and id_ramo=
$rs_notas = @pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_notas);$i++){
	
	$fila = pg_fetch_array($rs_notas,$i);
	$rut_alumno = $fila['rut_alumno'];
	$contador =0;
	$suma =0;
	
	for($j=1;$j<20;$j++){
		
		$n ="nota".$j;
		
		echo "<br>alumno-->".$fila['rut_alumno'];
		echo "notas-->".$nota = $fila[$n];	
		
		if($fila['rut_alumno']==$rut_alumno && $nota>0){
		
			$suma = $suma + $nota;
			$contador++;	
		}
		
		if($j==19){
			if($fila['truncado']==1){
				echo  "promedio-->".$promedio = round($suma / $contador);
			}else{
				echo  "promedio-->".$promedio = intval($suma / $contador);
			}
		
			echo "sql-->".$sql = "UPDATE notas2011 SET promedio=".$promedio." WHERE rut_alumno=".$fila['rut_alumno']." AND id_ramo=".$fila['id_ramo']." AND id_periodo=".$fila['id_periodo']."";
			$rs_promedio = @pg_exec($conn,$sql);
		
		}
	
	}
		
}
pg_close($conn);
?>






