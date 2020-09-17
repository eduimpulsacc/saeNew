
<? 
require('../../../../../../util/header.inc');
if($cont=="0"){ ?>
	<script>
		if(confirm ('IMPORTANTE: Presione el botón Aceptar si desea eliminar las notas de todos los alumnos para esta asignatura')==true){
			window.location = 'new_valida_temporal.php?resp=1';	
			exit();	 		
		}
	</script>
	<?

		echo "<script>window.location = 'new_mostrarNotas.php3?periodo=$_PERIODORAMO&drop=1'</script>";
		exit();
}
?>
<style type="text/css">
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
if($resp=="1" OR $cont!="0")  //Reemplazo todos los datos de la tabla
{
$sql_ano = "select nro_ano from ano_escolar where id_ano = ".$_ANO;
$result_ano =@pg_Exec($conn,$sql_ano);
$fila_ano = @pg_fetch_array($result_ano,0);	
$nro_ano = $fila_ano['nro_ano'];

$qry_notas = "select * from $_TABLA_TEMP where id_ramo = '$_RAMO' and id_periodo = '$_PERIODORAMO'";
$res_notas = pg_Exec($qry_notas);
	
	for($i=0;$i<pg_num_rows($res_notas);++$i){     // INICIO DE INFORMACION EN TABLA TEMPORAL
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
		
		$qry_refresh ="	update notas$nro_ano set nota1='$nota1',nota2='$nota2',nota3='$nota3',nota4='$nota4',nota5='$nota5',nota6='$nota6',nota7='$nota7',nota8='$nota8',nota9='$nota9',nota10='$nota10',					nota11='$nota11',nota12='$nota12',nota13='$nota13',nota14='$nota14',nota15='$nota15',nota16='$nota16',nota17='$nota17',nota18='$nota18',nota19='$nota19',nota20='$nota20',promedio='$promedio'
where id_ramo = '$_RAMO' and id_periodo = '$_PERIODORAMO' and rut_alumno = '$rut_alumno'";
$res_refresh = pg_Exec($qry_refresh);

$qry_verifica = "select rut_alumno from notas$nro_ano where id_ramo = '$_RAMO' and id_periodo = '$_PERIODORAMO' and rut_alumno = '$rut_alumno'";
$res_verifica = pg_Exec($qry_verifica);

if(pg_numrows($res_verifica)==0){
$qry_inserta = "INSERT INTO notas$nro_ano(RUT_ALUMNO, ID_RAMO, ID_PERIODO, NOTA1, NOTA2, NOTA3, NOTA4, NOTA5, NOTA6, NOTA7, NOTA8, NOTA9, NOTA10, NOTA11, NOTA12, NOTA13, NOTA14, NOTA15, NOTA16, NOTA17, NOTA18, NOTA19, NOTA20, PROMEDIO) 
VALUES ('$rut_alumno','$id_ramo','$id_periodo','$nota1','$nota2','$nota3','$nota4','$nota5','$nota6','$nota7','$nota8','$nota9','$nota10','$nota11','$nota12','$nota13','$nota14','$nota15','$nota16','$nota17','$nota18','$nota19','$nota20','$promedio')";
		$res_inserta = @pg_Exec($qry_inserta);						

		} // RECORRIENDO CICLO DESDE TABLA TEMPORAL
		

	}
	
pg_close($conn);

if($_INSTIT==12086){
	echo "<script>window.location = 'new_proceso_promedio.php'</script>";
}else{
	echo "<script>window.location = 'new_mostrarNotas.php3?periodo=".trim($periodo)."'</script>";
}
	
}//Fin de remplazo



?>