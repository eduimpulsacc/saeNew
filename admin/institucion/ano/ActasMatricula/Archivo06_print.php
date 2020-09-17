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
	
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, curso.ensenanza, curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, curso.cod_decreto, curso.cod_eval, ramo.cod_subsector, dicta.rut_emp, empleado.dig_rut, empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql = $sql . "FROM institucion, (((curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) INNER JOIN ramo ON curso.id_curso = ramo.id_curso) INNER JOIN dicta ON ramo.id_ramo = dicta.id_ramo) INNER JOIN empleado ON dicta.rut_emp = empleado.rut_emp ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((curso.id_ano)=".$ano.") and curso.ensenanza > 109) ";
	$sql = $sql . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso, ramo.cod_subsector; ";

	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	$fichero = fopen("Actas/a".$institucion."_6.txt", "w+"); 
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
	    <strong>Archivo 06. Docentes de los Subsectores  </strong>
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
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Tipo Ense&ntilde;anza </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Grado</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Letra</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Ano Escolar </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>C&oacute;digo Decreto </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Plan Estudio </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Subsector</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rut Docente </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>D&iacute;gito Rut </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Apellido Paterno </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Apellido Materno </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombres</strong></font></td>
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
$cod_subsector = $fila['cod_subsector'];
$rut_profe = $fila['rut_emp'];
$dig_rut = $fila['dig_rut'];
$ape_pat = $fila['ape_pat'];
$ape_mat = $fila['ape_mat'];
$nombre = $fila['nombre_emp'];


$ls_string = "6" . "$ls_espacio" . trim($rdb) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rdb)  . "$ls_espacio";
$ls_string = $ls_string . trim($tipo_ense)  . "$ls_espacio";
$ls_string = $ls_string . trim($grado) . "$ls_espacio";
$ls_string = $ls_string . trim($letra)  . "$ls_espacio";
$ls_string = $ls_string . trim($nro_ano) . "$ls_espacio";
$ls_string = $ls_string . trim($plan_estudios) . "$ls_espacio";
$ls_string = $ls_string . trim($plan_estudios) . "$ls_espacio";
$ls_string = $ls_string . trim($cod_subsector) . "$ls_espacio";
$ls_string = $ls_string . trim($rut_profe) . "$ls_espacio";
$ls_string = $ls_string . trim($dig_rut) . "$ls_espacio";
$ls_string = $ls_string . trim($ape_pat) . "$ls_espacio";
$ls_string = $ls_string . trim($ape_mat) . "$ls_espacio";
$ls_string = $ls_string . trim($nombre)."$salto";

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
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $plan_estudios?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $plan_estudios?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $cod_subsector?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rut_profe?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rut?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ape_pat?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ape_mat?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nombre?></font></td>
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