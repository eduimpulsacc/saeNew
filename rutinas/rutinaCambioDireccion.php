<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<? 

//base de datos antigua
$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");

$rbd = 9074;  
$responsable=1;


//traigi apoderados
$sql_apo ="select tiene2.rut_apo,tiene2.rut_alumno,CALLE,nro,region,ciudad,comuna 
from tiene2 
inner join apoderado on apoderado.rut_apo = tiene2.rut_apo
where rut_alumno in (select rut_alumno from matricula where rdb=$rbd) and responsable=$responsable
";
$rs_apo = pg_exec($conn,$sql_apo) or die ("error 1:".$sql_apo);

for($a=0;$a<pg_numrows($rs_apo);$a++){
	$fila_dir = pg_fetch_array($rs_apo,$a);
	
	$sql_dir="update alumno set calle='".$fila_dir['calle']."', nro ='".$fila_dir['nro']."',region=".$fila_dir['region'].",ciudad=".$fila_dir['ciudad'].",comuna=".$fila_dir['comuna']." where rut_alumno=".$fila_dir['rut_alumno'] ;
	
	echo $sql_dir."<br>";
	$rs_ins = pg_exec($conn,$sql_dir) or die ("error 1:".$sql_dir);	

}




?>
