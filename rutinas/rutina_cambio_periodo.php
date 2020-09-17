<?php 

$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("Error de conexion Antofagasta.");	

 $sql ="select count(rut_alumno) from notas2013 n
inner join ramo r on r.id_ramo=n.id_ramo
inner join curso c on c.id_curso=r.id_curso
where n.id_periodo=2565 and c.id_curso=45431";
$result = pg_Exec($conn,$sql)or die("fallo ".$sql);

//for($i=0;$i<pg_numrows($result);$i++){
	//$fila = pg_fetch_array($result,$i);

	$rut_al = pg_result($result,0);

/*$sql2 ="select count(rut_alumno) from notas2013 n
inner join ramo r on r.id_ramo=n.id_ramo
inner join curso c on c.id_curso=r.id_curso
where n.id_periodo=2564 and c.id_curso=45431 and rut_alumno<>".$fila['rut_alumno']."";
$result2 = pg_Exec($conn,$sql2) or die ("Fallo ".$sql2);
	
$rut_al = pg_result($result2,0);
 $rut_al;	*/
	
	
//}
echo $rut_al;	
?>
