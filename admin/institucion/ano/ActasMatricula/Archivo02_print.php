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

	//$ls_criterio = $_GET["as_criterio"];
	//$ls_input    = $_GET["as_input"];
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, curso.ensenanza, curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, curso.cod_eval, plan_estudio.cod_decreto, plan_estudio.cod_plan, empleado.rut_emp, empleado.dig_rut  ";
	$sql = $sql . "FROM institucion, (((curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN supervisa ON curso.id_curso = supervisa.id_curso) INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql = $sql . "where curso.id_ano = ".$ano." and institucion.rdb = ".$institucion." and curso.ensenanza > 109 group by institucion.rdb, 
institucion.dig_rdb, 
institucion.region, 
curso.ensenanza, 
curso.grado_curso, 
curso.letra_curso, 
ano_escolar.nro_ano, 
curso.cod_eval, 
plan_estudio.cod_decreto, 
plan_estudio.cod_plan, 
empleado.rut_emp, 
empleado.dig_rut   order by curso.ensenanza, curso.grado_curso, curso.letra_curso  ;";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	$fichero = fopen("Actas/a".$institucion."_2.txt", "w+"); 
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-size: -2}
-->
</style>
</head>

<body onLoad="window.print();window.close();"> 

<center>
<table width="650" border="0" cellspacing="0" cellpadding="0"  bgcolor=#003b85>
  <tr>
    <td align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif" >
	    <strong> Archivo 02. Información del Curso</strong>
	    </font></td>
  </tr>
</table>
<<br>
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nº</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rbd</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>DigRbd</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Tipo Ense&ntilde;anza </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Grado</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Letra</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>NroA&ntilde;o</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Decreto Evaluaci&oacute;n </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Plan de Estudios </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rut Profesor </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>DigRut</strong></font></td>
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
$tipo_ense = $fila['ensenanza'];
$grado = $fila['grado_curso'];
$letra = $fila['letra_curso'];
$nro_ano = $fila['nro_ano'];
$dec_eval = $fila['cod_eval'];
$plan_estudios = $fila['cod_decreto'];
if ($plan_estudios==5451996) $plan_estudios = 6252003;
if ($plan_estudios==5521997) $plan_estudios = 6252003;
$rut_profe = $fila['rut_emp'];
$dig_rut = $fila['dig_rut'];


$ls_string = "2" . "$ls_espacio" . trim($rdb) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rdb)  . "$ls_espacio";
$ls_string = $ls_string . trim($tipo_ense)  . "$ls_espacio";
$ls_string = $ls_string . trim($grado) . "$ls_espacio";
$ls_string = $ls_string . trim($letra)  . "$ls_espacio";
$ls_string = $ls_string . trim($nro_ano) . "$ls_espacio";
$ls_string = $ls_string . trim($dec_eval) . "$ls_espacio";
$ls_string = $ls_string . trim($plan_estudios) . "$ls_espacio";
$ls_string = $ls_string . trim($plan_estudios) . "$ls_espacio";
$ls_string = $ls_string . trim($rut_profe) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rut)."$salto";

	//crea un fichero
	//echo $ls_string;
		
	@ fwrite($fichero,"$ls_string"); 
?>  
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $j+1?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $tipo_ense?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $grado?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $letra?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dec_eval?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $plan_estudios?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rut_profe?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rut?></font></td>
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