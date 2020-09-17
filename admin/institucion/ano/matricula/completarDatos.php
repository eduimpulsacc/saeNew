<?php
 require('../../../../util/header.inc');

$institucion	=$_INSTIT;
$ano			=$_ANO;

 $sql_int ="select region,ciudad,comuna from institucion where rdb=$institucion";
$rs_int = pg_exec($conn,$sql_int);
$region = pg_result($rs_int,0);
$ciudad = pg_result($rs_int,1);
$comuna = pg_result($rs_int,2);


 $sel_alu = "select * from alumno where rut_alumno in(select rut_alumno from matricula where id_ano=$ano)";
$rs_alu = pg_exec($conn,$sel_alu);

for($al=0;$al<pg_numrows($rs_alu);$al++){
$fila_alumno = pg_fetch_array($rs_alu,$al);

	if(intval($fila_alumno['nacionalidad'])==0 ){
	$sql_up = "update alumno set nacionalidad = 2 where rut_alumno = ".$fila_alumno['rut_alumno'];
	pg_exec($conn,$sql_up);
	}
	
	if(intval($fila_alumno['comuna'])==0){
	$sql_up = "update alumno set region = $region,ciudad=$ciudad,comuna=$comuna where rut_alumno = ".$fila_alumno['rut_alumno'];
	pg_exec($conn,$sql_up);
	}

}

?>
<script>
location.href='listarMatricula.php3?menu=6&categoria=4&nw=1';
</script>