
<? 
//$conn=@pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");
$conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Corporacion.");
//$conn=pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");



function Concepto($nota, $tipo){
	//$tipo = 1 --- $nota viene con valor numérico devuelve conceptual
	//$tipo = 2 --- $nota viene con valor conceptual devuelve numérico
	$nota_res=0;
	$concepto="";		
	if ($tipo == 1){
		if ($nota >= 60 and $nota<=70)
			$concepto = "MB";
		if ($nota >= 50 and $nota<=59)
			$concepto = "B";
		if ($nota >= 40 and $nota<=49)
			$concepto = "S";
		if ($nota >= 0 and $nota<=39)
			$concepto = "I";
		if($nota==0)
			$concepto = "-";
		return $concepto ;
	}else{
		if (trim($nota) == "MB")
			$nota_res = 65;
		if (trim($nota) == "B")
			$nota_res = 55;			
		if (trim($nota) == "S")
			$nota_res = 45;
		if (trim($nota) == "I")
			$nota_res = 35;						
		return $nota_res;
	}
}
//$sql ="SELECT * FROM NOTAS2011 WHERE ID_PERIODO=2386 "; //and id_ramo=

$sql="select n.*,r.cod_subsector from notas2011 n INNER JOIN ramo r ON n.id_ramo=r.id_ramo where id_periodo=2386 and cod_subsector=13";
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
			echo  "promedio-->".$promedio = round($suma / $contador);
			$promedio = Concepto($promedio,1);
			echo "sql-->".$sql = "UPDATE notas2011 SET promedio='".$promedio."' WHERE rut_alumno=".$fila['rut_alumno']." AND id_ramo=".$fila['id_ramo']." AND id_periodo=".$fila['id_periodo']."";
			$rs_promedio = @pg_exec($conn,$sql);
		}
	}
		
}

?>






