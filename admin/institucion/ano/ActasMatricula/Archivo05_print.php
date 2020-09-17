<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//------------------------		
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, curso.ensenanza, curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, matricula.rut_alumno, alumno.dig_rut, promocion.promedio, promocion.asistencia, promocion.situacion_final ";
	$sql = $sql . "FROM (((matricula INNER JOIN curso ON (matricula.id_ano = curso.id_ano) AND (matricula.id_curso = curso.id_curso)) INNER JOIN ano_escolar ON matricula.id_ano = ano_escolar.id_ano) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN (institucion INNER JOIN promocion ON institucion.rdb = promocion.rdb) ON (matricula.id_ano = promocion.id_ano) AND (matricula.id_curso = promocion.id_curso) AND (matricula.rut_alumno = promocion.rut_alumno) ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND (curso.ensenanza > 109) AND ((matricula.id_ano)=".$ano.")) and ((matricula.bool_ar=1 and matricula.fecha_retiro > '04-30-".$ano_escolar."') or (matricula.bool_ar=0))";
	$sql = $sql . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; "; 

	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	$fichero = fopen("Actas/a".$institucion."_5.txt", "w+"); 
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="window.print();window.close();"> 
<center>
  <table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<tr  bgcolor=#003b85> 
    <td >
		<div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif" >
	    <strong>Archivo 05. Situación de Promoción de los Estudiantes</strong>
	    </font>
      </div></td>
  </tr>
	</td>
  </tr>
</table>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nº</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rbd</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>D&iacute;gito Rbd </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Tipo Ense&ntilde;anza</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Grado Curso </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Letra Curso </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>A&ntilde;o Escolar </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rut Estudiante </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>D&iacute;gito Rut</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Promedio General </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Porcentaje Asistencia </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Observaci&oacute;n</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Situaci&oacute;n Final </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Tipo Promoci&oacute;n </strong></font></td>
  </tr>
<?
for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 $fila = @pg_fetch_array($resultado_query,$j);

$rdb = $fila['rdb'];
$dig_rdb = $fila['dig_rdb'];
$ensenanza = $fila['ensenanza'];
$grado = $fila['grado_curso'];
$letra = $fila['letra_curso'];
$nro_ano = $fila['nro_ano'];
$alumno = $fila['rut_alumno'];
$dig_rut = $fila['dig_rut'];
if (!empty($fila['promedio']))
	$promedio = substr($fila['promedio'],0,1).".".substr($fila['promedio'],1,1);
else
	$promedio = "";

$asistencia = $fila['asistencia'];
$observacion = "";
$situacion_aux = $fila['situacion_final'];
if ($situacion_aux==1) $situacion_final = "P";
if ($situacion_aux==2) $situacion_final = "R";
if ($situacion_aux==3) $situacion_final = "Y";
if ($situacion_final == "Y") $asistencia=0;
if ($situacion_final == "Y")
{
	$sql_retirado = "select fecha_retiro from matricula where rut_alumno = " . $alumno . " and id_ano = " . $ano;
	$resultado_retirado = pg_exec($conn,$sql_retirado);
    $fila_retirado = @pg_fetch_array($resultado_retirado,0);
	$observacion = "RET ".substr(cfecha($fila_retirado['fecha_retiro']),0,5);
	$promedio = "";
	$asistencia = "";
	
}

$ls_string = "5" . "$ls_espacio" . trim($rdb) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rdb)  . "$ls_espacio";
$ls_string = $ls_string . trim($ensenanza)  . "$ls_espacio";
$ls_string = $ls_string . trim($grado)  . "$ls_espacio";
$ls_string = $ls_string . trim($letra)  . "$ls_espacio";
$ls_string = $ls_string . trim($nro_ano)  . "$ls_espacio";
$ls_string = $ls_string . trim($alumno)  . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rut)  . "$ls_espacio";
$ls_string = $ls_string . trim($promedio)  . "$ls_espacio";
$ls_string = $ls_string . trim($asistencia)  . "$ls_espacio";
$ls_string = $ls_string . trim($observacion)  . "$ls_espacio";
$ls_string = $ls_string . trim($situacion_final)  . "$ls_espacio";
$ls_string = $ls_string ."1"."$salto";

	//crea un fichero
	//echo $ls_string;
		
	@ fwrite($fichero,"$ls_string"); 
?>
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $j+1?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ensenanza?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $grado?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $letra?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $alumno?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rut?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? if (empty($promedio)) echo "&nbsp;"; else echo $promedio;?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? if ($asistencia>0)echo $asistencia; else echo "&nbsp;";?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? if (empty($observacion)) echo "&nbsp;"; else echo $observacion;?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $situacion_final?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo "1"?></font></td>
  </tr>
 <?
}
pg_close($conn);
fclose($fichero); 

?>
</table>
</center>
</body>
</html>