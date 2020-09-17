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
	$sql = $sql . "curso.ensenanza, ";
	$sql = $sql . "curso.cod_es, ";
	$sql = $sql . "alumno.rut_alumno, ";
	$sql = $sql . "alumno.dig_rut, ";
	$sql = $sql . "ano_escolar.nro_ano ";
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
	$fichero = fopen("Actas/a".$institucion."_10.txt", "w+"); 

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<body >
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">
	<div id="capa0">
	<INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ARCHIVO" name=btnModificar  onClick=document.location="Archivo10_txt.php">
	<input name="button3" type="button" class="botonX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
	<INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="Menu_Actas.php">
	</div>
	
	</td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<tr  bgcolor=#003b85> 
    <td >
		<div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif" >
	    <strong> Archivo 10. N&oacute;mina de Alumnos Licenciados </strong>
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
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Ensenanza</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Especialidad</strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rut Estudiante </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Dig Rut </strong></font></td>
          <td ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>A&ntilde;o N&oacute;mina </strong></font></td>
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
if (empty($fila['cod_es']))
	$especialidad		= 0;
else
	$especialidad		= $fila['cod_es'];	
$nro_ano			= $fila['nro_ano'];
$ensenanza			= $fila['ensenanza'];

if ($ensenanza>409){
	$cont = $j+1;
	$ls_string = "10" 								. "$ls_espacio"; 
	$ls_string = $ls_string . trim($rdb) 			. "$ls_espacio"; 
	$ls_string = $ls_string . trim($dig_rdb)  		. "$ls_espacio";
	$ls_string = $ls_string . trim($ensenanza)  	. "$ls_espacio";	
	$ls_string = $ls_string . trim($especialidad)  	. "$ls_espacio";
	$ls_string = $ls_string . trim($rut_alumno)		. "$ls_espacio";
	$ls_string = $ls_string . trim($dig_rut)		. "$ls_espacio";
	$ls_string = $ls_string . trim($nro_ano) 		. "$ls_espacio";
	$ls_string = $ls_string . trim($ape_mat) 		. "$ls_espacio";
	$ls_string = $ls_string . " "				 	. "$ls_espacio";
	$ls_string = $ls_string . " "				 	. "$ls_espacio";
	$ls_string = $ls_string . " "				 	."$salto";
	?>
			<tr>
			  <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $j+1?></font></td>
			  <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb;?></font></td>
			  <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb;?></font></td>
			  <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ensenanza;?></font></td>
			  <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $especialidad;?></font></td>
			  <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rut_alumno;?></font></td>
			  <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rut;?></font></td>
			  <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano;?></font></td>
		    </tr>
	<?
		@ fwrite($fichero,"$ls_string"); 
	}
}	
pg_close($conn);
fclose($fichero); 

?>
</table>
</center>
</body>
</html>