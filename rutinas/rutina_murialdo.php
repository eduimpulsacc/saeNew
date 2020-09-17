<?php

$conn1=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 1");

$sql ="SELECT * FROM usuario WHERE nombre_usuario not in ('evados222','admin',' ') and CAST(nombre_usuario as integer) in (SELECT ap.rut_apo FROM apoderado ap INNER JOIN tiene2 ti on ap.rut_apo=ti.rut_apo
INNER JOIN matricula ma ON ti.rut_alumno=ma.rut_alumno and id_ano=1269)";
$rs_usuario = pg_exec($conn1,$sql);

for($i=0;$i<pg_numrows($rs_usuario);$i++){
	$fila=pg_fetch_array($rs_usuario,$i);
	$sql ="SELECT * FROM accede WHERE nombre_usuario='".$fila['nombre_usuario']."'";
	$rs_existe = pg_exec($conn1,$sql);
	

		echo "<br>".$sql ="UPDATE accede SET id_perfil=15 WHERE id_usuario=".$fila['id_usuario'];
		$rs_accede = pg_exec($conn1,$sql);	

}


 
?>
