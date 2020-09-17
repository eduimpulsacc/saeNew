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
	
	$sql = "select institucion.rdb, ";
	$sql = $sql . "institucion.dig_rdb, ";
	$sql = $sql . "curso.cod_es, ";
	$sql = $sql . "ano_escolar.nro_ano, ";
	$sql = $sql . "alumno.ape_pat, ";
	$sql = $sql . "alumno.ape_mat, ";
	$sql = $sql . "alumno.nombre_alu, ";
	$sql = $sql . "alumno.rut_alumno, ";
	$sql = $sql . "alumno.dig_rut, ";
	$sql = $sql . "curso.ensenanza ";
	$sql = $sql . "from   institucion, matricula, curso, ano_escolar, alumno, promocion ";
	$sql = $sql . "where  institucion.rdb = $institucion ";
	$sql = $sql . "and    matricula.id_curso = curso.id_curso ";
	$sql = $sql . "and    curso.id_ano = $ano ";
	$sql = $sql . "and    curso.ensenanza > 309 ";
	$sql = $sql . "and    curso.grado_curso = 4 ";
	$sql = $sql . "and    ano_escolar.id_ano = $ano ";
	$sql = $sql . "and    alumno.rut_alumno = matricula.rut_alumno ";
	$sql = $sql . "and    promocion.id_ano = $ano ";
	$sql = $sql . "and    promocion.rut_alumno = matricula.rut_alumno ";
	$sql = $sql . "and    promocion.situacion_final = 1 order by alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	
	$fichero = fopen("Actas/a".$institucion."_9.txt", "w+"); 
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
	    <strong> Archivo 09. N&oacute;mina de Alumnos Licenciados </strong>
	    </font>
      </div></td>
  </tr>
	</td>
  </tr>
</table><br>
      <table width="650" border="1" cellspacing="0" cellpadding="0">
        <tr>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm;</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rbd</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Dig Rbd </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Especialidad</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>A&ntilde;o N&oacute;mina </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm; Registro </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Apellido Paterno</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Apellido Materno </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombres</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rut</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Dig Rut </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>C&oacute;digo Tipo Licencia </strong></font></td>
        </tr>
<?	
for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 $fila = @pg_fetch_array($resultado_query,$j);

$rdb 				= $fila['rdb'];
$dig_rdb 			= $fila['dig_rdb'];
$rut_alumno 		= $fila['rut_alumno'];
$dig_rut 			= $fila['dig_rut'];
$ape_pat 			= strtoupper($fila['ape_pat']);
$ape_mat 			= strtoupper($fila['ape_mat']);
$nombre_alumno 		= strtoupper($fila['nombre_alu']);
if (empty($fila['cod_es']))
	$especialidad		= 0;
else
	$especialidad		= $fila['cod_es'];	
$nro_ano			= $fila['nro_ano'];
$ensenanza			= $fila['ensenanza'];
if ($ensenanza==410 or $ensenanza==510 or $ensenanza==610 or $ensenanza==710 or $ensenanza==810)
	$tipo_licencia = 1;
if ($ensenanza==310)
	$tipo_licencia = 2;
if ($ensenanza==460 or $ensenanza==461 or $ensenanza==560 or $ensenanza==561 or $ensenanza==660 or $ensenanza==661 or $ensenanza==760 or $ensenanza==761 or $ensenanza==860 or $ensenanza==861)
	$tipo_licencia = 3;
if ($ensenanza==360 or $ensenanza==361)
	$tipo_licencia = 4;
$cont = $j+1;
$ls_string = "9" 								. "$ls_espacio"; 
$ls_string = $ls_string . trim($rdb) 			. "$ls_espacio"; 
$ls_string = $ls_string . trim($dig_rdb)  		. "$ls_espacio";
$ls_string = $ls_string . trim($especialidad)  	. "$ls_espacio";
$ls_string = $ls_string . trim($nro_ano) 		. "$ls_espacio";
$ls_string = $ls_string . trim($cont)			. "$ls_espacio";
$ls_string = $ls_string . trim($ape_pat) 		. "$ls_espacio";
$ls_string = $ls_string . trim($ape_mat) 		. "$ls_espacio";
$ls_string = $ls_string . trim($nombre_alumno) 	. "$ls_espacio";
$ls_string = $ls_string . trim($rut_alumno) 	. "$ls_espacio";
$ls_string = $ls_string . trim($dig_rut) 		. "$ls_espacio";
$ls_string = $ls_string . trim($tipo_licencia)	."$salto";
?>
        <tr>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $j+1?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $especialidad;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo ($j+1);?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ape_pat;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ape_mat;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nombre_alumno;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rut_alumno;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rut;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $tipo_licencia;?></font></td>
        </tr>
<?
	//crea un fichero
	//echo $ls_string;
		
	@ fwrite($fichero,"$ls_string"); 
 
}
pg_close($conn);
fclose($fichero); 

?>
</table>
</center>
</body>
</html>