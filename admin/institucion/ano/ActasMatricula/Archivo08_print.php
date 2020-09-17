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
	
	$sql = "SELECT DISTINCT institucion.rdb, institucion.dig_rdb, ano_escolar.nro_ano, ramo.cod_subsector, subsector.nombre ";
	$sql = $sql . "FROM institucion, ((ano_escolar INNER JOIN curso ON ano_escolar.id_ano = curso.id_ano) INNER JOIN ramo ON curso.id_curso = ramo.id_curso) INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.")) ";
	$sql = $sql . "ORDER BY ramo.cod_subsector; ";

	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	$fichero = fopen("Actas/a".$institucion."_8.txt", "w+"); 

?>
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
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
	    <strong>Archivo 08. Subsectores, asignaturas o módulos</strong>
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
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>A&ntilde;o Escolar </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>C&oacute;digo Subsector </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombre Subsector</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Horas Semanales</strong></font></td>	
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
$nro_ano = $fila['nro_ano'];
$cod_subsector= $fila['cod_subsector'];
$nombre_subsector = $fila['nombre'];
//-------------
$sql_horas="select * from horas_subsectores where cod_subsector = $cod_subsector and id_ano = $ano";
$resultado_horas = pg_exec($conn,$sql_horas);
$fila_horas = @pg_fetch_array($resultado_horas,0);
$horas = $fila_horas['horas'];
//-------------
$ls_string = "8" . "$ls_espacio" . trim($rdb) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rdb)  . "$ls_espacio";
$ls_string = $ls_string . trim($nro_ano)  . "$ls_espacio";
$ls_string = $ls_string . trim($cod_subsector) . "$ls_espacio";
$ls_string = $ls_string . trim($nombre_subsector) . "$ls_espacio";
$ls_string = $ls_string . trim($horas)."$salto";

	//crea un fichero
	//echo $ls_string;
		
	@ fwrite($fichero,"$ls_string"); 
?>
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $j+1?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $cod_subsector?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nombre_subsector?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $horas?></font></td>	
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