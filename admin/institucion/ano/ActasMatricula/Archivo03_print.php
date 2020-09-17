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
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//------------------------	
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, curso.ensenanza, curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, alumno.rut_alumno, alumno.dig_rut, alumno.region, alumno.ciudad, alumno.comuna ";
	$sql = $sql . "FROM institucion, ((matricula INNER JOIN ano_escolar ON matricula.id_ano = ano_escolar.id_ano) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN curso ON matricula.id_curso = curso.id_curso and ((matricula.bool_ar=1 and matricula.fecha_retiro > '04-30-".$ano_escolar."') or (matricula.bool_ar=0))";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((curso.ensenanza)>109) AND ((matricula.id_ano)=".$ano.")) ";
	$sql = $sql . "ORDER BY curso.id_curso, alumno.ape_pat, alumno.ape_mat;"; 
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	$fichero = fopen("Actas/a".$institucion."_3.txt", "w+"); 
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
	    <strong> Archivo 03. Estudiantes del Curso </strong>
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
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Digito Rbd</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Tipo Ense&ntilde;anza</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Grado</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Letra</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nro A&ntilde;o </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rut Estududiante</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Digito Rut </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>C&oacute;digo Comuna </strong></font></td>
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
 $grado_curso = $fila['grado_curso'];
 $letra_curso = $fila['letra_curso'];
 $nro_ano = $fila['nro_ano'];
 $rut_alumno = $fila['rut_alumno'];
 $dig_rut = $fila['dig_rut'];
 $region_aux = $fila['region'];
 if ($region_aux<10) $region = "0".$region_aux; else $region = $region_aux;
 $ciudad = $fila['ciudad'];
 $comuna_aux = $fila['comuna'];
 if ($comuna_aux<10) $comuna = "0".$comuna_aux; else $comuna = $comuna_aux;

$ls_string = "3" . "$ls_espacio" . trim($rdb) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rdb)  . "$ls_espacio";
$ls_string = $ls_string . ltrim($ensenanza)  . "$ls_espacio";
$ls_string = $ls_string . trim($grado_curso) . "$ls_espacio";
$ls_string = $ls_string . trim($letra_curso)  . "$ls_espacio";
$ls_string = $ls_string . trim($nro_ano) . "$ls_espacio";
$ls_string = $ls_string . trim($rut_alumno) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rut) . "$ls_espacio";
$ls_string = $ls_string . trim($region).trim($ciudad).trim($comuna) ."$salto";

	//crea un fichero
	//echo $ls_string;
		
	@ fwrite($fichero,"$ls_string"); 
  ?>
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $j+1?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ensenanza?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $grado_curso?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $letra_curso?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rut_alumno?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rut?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo trim($region).trim($ciudad).trim($comuna)?></font></td>
  </tr>
  <? }
pg_close($conn);
fclose($fichero); 

?>
</table>


</center>
</body>
</html>