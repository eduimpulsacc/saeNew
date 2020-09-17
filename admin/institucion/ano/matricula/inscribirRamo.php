<?php
 require('../../../../util/header.inc');

$institucion	=$_INSTIT;
$ano			=$_ANO;

$sql_ano_actual = "select nro_ano from ano_escolar where id_ano = '".$_ANO."'";
	$res_ano_actual = @pg_Exec($conn,$sql_ano_actual);
	$fil_ano_actual = @pg_fetch_array($res_ano_actual,0);
	$nro_ano = $fil_ano_actual['nro_ano'];

//borro los ramos
$sql_del = "delete from tiene$nro_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = $ano))";	
$rs_del = pg_exec($conn,$sql_del);

//ir a buscar los cursos que tengo que ese año
$sql_cur = " select id_curso from curso where id_ano = $ano and ensenanza >10";
$rs_cur = pg_exec($conn,$sql_cur);


for($c=0;$c<pg_numrows($rs_cur);$c++){
	$fila_cur = pg_fetch_array($rs_cur,$c);

 
 $sql_alu = "select distinct(rut_alumno) from matricula where id_curso=".$fila_cur['id_curso']/*." and bool_ar=0"*/;
 $rs_alu = pg_exec($conn,$sql_alu);
 
  $sql_ramo = "select id_ramo from ramo where id_curso=".$fila_cur['id_curso'];
  $rs_ram = pg_exec($conn,$sql_ramo);
 
 for($a=0;$a<pg_numrows($rs_alu);$a++){
	$fila_alu = pg_fetch_array($rs_alu,$a);
	
	for($r=0;$r<pg_numrows($rs_ram);$r++){
		$fila_ramo = pg_fetch_array($rs_ram,$r);
		
	 $sql_insramo = "insert into tiene$nro_ano (rut_alumno,id_curso,id_ramo) values (".$fila_alu['rut_alumno'].",".$fila_cur['id_curso'].",".$fila_ramo['id_ramo'].")";
	 $rs_insramo = pg_exec($conn,$sql_insramo);
	}
	
	
	
 }
}
?>
<script>
location.href='listarMatricula.php3?menu=6&categoria=4&nw=1';
</script>