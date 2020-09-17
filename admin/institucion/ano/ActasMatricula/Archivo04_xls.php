
<?php require('../../../../util/header.inc');?>
<?php 

	//$ls_criterio = $_GET["as_criterio"];
	//$ls_input    = $_GET["as_input"];
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$con			=0;	
	$sql = "select a04.*, ens.nombre_tipo,sb.nombre as nsub from archivo04 a04 
	INNER JOIN tipo_ensenanza ens ON ens.cod_tipo = a04.ensenanza
	left JOIN subsector sb ON sb.cod_subsector = a04.subsector
	where rdb = $institucion";  
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	$ls_string = "&nbsp;";
	$salto = "\r\n"; 	 
	$ls_espacio= chr(9);
	
?>
<?php header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=".$institucion."_04.xls");
header("Pragma: no-cache");
header("Expires: 0");?>

<table  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm;</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rbd</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>D&iacute;gito Rbd</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Tipo de Ensenanza </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Grado</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Letra</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nro A&ntilde;o </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rut Estudiante </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Digito Rut </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Plan de Estudio </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Cod Eval </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>C&oacute;digo Subsector </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Calificaci&oacute;n Final </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Calificaci&oacute;n Conceptual </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Eximido en el subsector </strong></font></td>
  </tr>
  <?
  
for ($j=0; $j < pg_numrows($resultado_query); $j++)
{
	$fila 		= @pg_fetch_array($resultado_query,$j);
	$rdb		= $fila['rdb']			;
	$dig_rdb	= $fila['dig_rdb']		;
	$ensenanza 	= $fila['nombre_tipo']	;
	$grado 		= $fila['grado']	;	
	$letra 		= $fila['letra']	;
	$nro_ano 	= $fila['nro_ano']		;		
	$alumno 	= $fila['alumno']	;
	$dig_rut 	= $fila['dig_rut']		;	
	$cod_decreto= $fila['cod_decreto']	;
	$cod_eval 	= $fila['cod_eval']		;	
	$subsector 	= $fila['nsub'];
	if (chop($fila['promedio1'])==".")
		$promedio1 = "";
	else
		$promedio1 	= chop($fila['promedio1']);
		
	$promedio2 	= chop($fila['promedio2']);
	$promedio3 	= chop($fila['promedio3']);
	
	$con = $con + 1;

?>

   <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ensenanza?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $grado?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $letra?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $alumno?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rut?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $cod_decreto?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $cod_eval?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $subsector?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? if (empty($promedio1))echo "&nbsp;"; else echo $promedio1;?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? if (empty($promedio2))echo "&nbsp;"; else echo $promedio2;?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? if (empty($promedio3))echo "&nbsp;"; else echo $promedio3;?></font></td>
  </tr>
 <?		
}
pg_close($conn);

  ?>
</table>
