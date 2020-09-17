
<?php require('../../../../../../util/header.inc');
?><style type="text/css">
<!--
.Estilo4 {
	font-size: 14px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
-->
</style>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div align="center"><p><img src="load.gif" width="50" height="50" /><br />
    <span class="Estilo4">La informaci&oacute;n se esta procesando, por favor espere </span></p>
</div>
<?
$tabla = "notas_".$_INSTIT."_".$_RAMO."_".time(0);
$tabla2 = $tabla."_new_index";

$_TABLA_TEMP = $tabla;
session_register('_TABLA_TEMP');

$sql_ano = "select * from ano_escolar where id_ano = ".$_ANO;
$result_ano =@pg_Exec($conn,$sql_ano);
$fila_ano = @pg_fetch_array($result_ano,0);	
$nro_ano = $fila_ano['nro_ano'];
	
$sql = "CREATE TABLE $tabla
			(
			  rut_alumno int4 NOT NULL,
			  id_ramo int4 NOT NULL,
			  id_periodo int4 NOT NULL,
			  nota1 char(4),
			  nota2 char(4),
			  nota3 char(4),
			  nota4 char(4),
			  nota5 char(4),
			  nota6 char(4),
			  nota7 char(4),
			  nota8 char(4),
			  nota9 char(4),
			  nota10 char(4),
			  nota11 char(4),
			  nota12 char(4),
			  nota13 char(4),
			  nota14 char(4),
			  nota15 char(4),
			  nota16 char(4),
			  nota17 char(4),
			  nota18 char(4),
			  nota19 char(4),
			  nota20 char(4),
			  promedio char(4),
			  CONSTRAINT $tabla2 PRIMARY KEY (rut_alumno, id_ramo, id_periodo)
			) 
			WITH OIDS;
			ALTER TABLE $tabla OWNER TO postgres;";
$res = pg_Exec($sql);			


$qry_notas = "select * from notas$nro_ano where id_ramo = '$_RAMO' and id_periodo = '$_PERIODORAMO'";
$res_notas = pg_Exec($qry_notas);

if(pg_num_rows($res_notas)=="0"){ //Si el registro esta en blanco, lo ingreso de la antigua forma
	$qry_drop = "DROP TABLE $_TABLA_TEMP";	
	$res_drop = @pg_Exec($qry_drop);
	echo "<script>window.location = 'ingresoNota.php3?curso=".trim($_CURSO)."&'</script>";
	exit();	
}

for($i=0;$i<pg_num_rows($res_notas);$i++){
$fila_notas = pg_fetch_array($res_notas,$i);

$rut_alumno = $fila_notas['rut_alumno'];
$id_ramo = $fila_notas['id_ramo'];
$id_periodo = $fila_notas['id_periodo'];
$nota1 = $fila_notas['nota1'];
$nota2 = $fila_notas['nota2'];
$nota3 = $fila_notas['nota3'];
$nota4 = $fila_notas['nota4'];
$nota5 = $fila_notas['nota5'];
$nota6 = $fila_notas['nota6'];
$nota7 = $fila_notas['nota7'];
$nota8 = $fila_notas['nota8'];
$nota9 = $fila_notas['nota9'];
$nota10 = $fila_notas['nota10'];
$nota11 = $fila_notas['nota11'];
$nota12 = $fila_notas['nota12'];
$nota13 = $fila_notas['nota13'];
$nota14 = $fila_notas['nota14'];
$nota15 = $fila_notas['nota15'];
$nota16 = $fila_notas['nota16'];
$nota17 = $fila_notas['nota17'];
$nota18 = $fila_notas['nota18'];
$nota19 = $fila_notas['nota19'];
$nota20 = $fila_notas['nota20'];
$promedio = $fila_notas['promedio'];


$qry_inserta = "insert into $tabla(rut_alumno, id_ramo, id_periodo, nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14, nota15, nota16, nota17, nota18, nota19, nota20, promedio)
values('$rut_alumno','$id_ramo','$id_periodo','$nota1','$nota2','$nota3','$nota4','$nota5','$nota6','$nota7','$nota8','$nota9','$nota10','$nota11','$nota12','$nota13','$nota14','$nota15','$nota16','$nota17','$nota18','$nota19','$nota20','$promedio')";
$res_inserta = pg_Exec($qry_inserta);

}


$dia = date('d');
$qry_registra = "insert into registra_temporales(nombre, dia) values('$tabla','$dia')";
$res_registra = pg_Exec($qry_registra);
 pg_close($conn);
 

echo "<script>window.location = 'new_ingresoNota.php3?curso=".trim($_CURSO)."'</script>";

?>


