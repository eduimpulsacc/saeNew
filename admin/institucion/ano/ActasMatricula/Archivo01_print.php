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
	
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, alumno.rut_alumno, alumno.dig_rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, curso.ensenanza, alumno.sexo, alumno.fecha_nac, alumno.nacionalidad ";
	$sql = $sql . "FROM institucion, (matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN curso ON matricula.id_curso = curso.id_curso and ((matricula.bool_ar=1 and matricula.fecha_retiro > '04-30-".$ano_escolar."') or (matricula.bool_ar=0))";
	$sql = $sql . "where  institucion.rdb = ".$institucion." and matricula.id_ano = ".$ano." and curso.ensenanza > 109 order by alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu;";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	
	$fichero = fopen("Actas/a".$institucion."_1.txt", "w+"); 
?>
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<body  onLoad="window.print();window.close();">
<center>

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<tr  bgcolor=#003b85> 
    <td >
		<div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif" >
	    <strong> Archivo 01. N&oacute;mina de Estudiantes </strong>
	    </font>
      </div></td>
  </tr>
	</td>
  </tr>
</table><br>
      <table width="650" border="1" cellspacing="0" cellpadding="0">
        <tr>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Archivo</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rbd</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Dig Rbd </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rut Alumno</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Dig Rut </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Apellido Paterno </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Apellido Materno</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombres</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Sexo</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Fecha Nacimiento</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nacionalodad</strong></font></td>
        </tr>
<?	
for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
// $salto = "\r\n"; 	 
// $ls_espacio= chr(9);
 $salto = "\n\r"; 	 
 $ls_espacio= "\t";
 $fila = @pg_fetch_array($resultado_query,$j);

$rdb = $fila['rdb'];
$dig_rdb = $fila['dig_rdb'];
$rut_alumno = $fila['rut_alumno'];
$dig_rut = $fila['dig_rut'];
$ape_pat = strtoupper($fila['ape_pat']);
$ape_mat = strtoupper($fila['ape_mat']);
$nombre_alumno = strtoupper($fila['nombre_alu']);
$sexo = $fila['sexo'];
if ($sexo==1) $sexo = 2; else $sexo = 1;
$fecha_nacimiento = cfecha2($fila['fecha_nac']);
$extranjero = $fila['nacionalidad'];

$ls_string = "1" . "$ls_espacio" . trim($rdb) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rdb)  . "$ls_espacio";
$ls_string = $ls_string . ltrim($rut_alumno)  . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rut) . "$ls_espacio";
$ls_string = $ls_string . trim($ape_pat)  . "$ls_espacio";
$ls_string = $ls_string . trim($ape_mat) . "$ls_espacio";
$ls_string = $ls_string . trim($nombre_alumno) . "$ls_espacio";
$ls_string = $ls_string . trim($sexo) . "$ls_espacio";
$ls_string = $ls_string . trim($fecha_nacimiento) . "$ls_espacio";
$ls_string = $ls_string . $extranjero."$salto";
?>
        <tr>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $j+1?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rut_alumno;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rut;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ape_pat;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ape_mat;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nombre_alumno;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $sexo;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $fecha_nacimiento;?></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $extranjero;?></font></td>
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