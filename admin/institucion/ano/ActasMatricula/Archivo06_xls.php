
<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, institucion.region, curso.ensenanza, curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, curso.cod_decreto, curso.cod_eval, ramo.cod_subsector, dicta.rut_emp, empleado.dig_rut, empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp, ens.nombre_tipo,sb.nombre as nsub ";
	$sql = $sql . "FROM institucion, (((curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) INNER JOIN ramo ON curso.id_curso = ramo.id_curso) INNER JOIN dicta ON ramo.id_ramo = dicta.id_ramo) INNER JOIN empleado ON dicta.rut_emp = empleado.rut_emp
	INNER JOIN tipo_ensenanza ens ON ens.cod_tipo = curso.ensenanza
	left JOIN subsector sb ON sb.cod_subsector = ramo.cod_subsector
	 ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((curso.id_ano)=".$ano.") and curso.ensenanza > 109 AND ramo.cod_subsector<50000) ";
	$sql = $sql . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso, ramo.cod_subsector; ";
	//echo $sql;
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	
?>
<?php header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=".$institucion."_06.xls");
header("Pragma: no-cache");
header("Expires: 0");?>

<table  border="1" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm;</strong></font></td>
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
$region = $fila['region'];
$tipo_ense = $fila['nombre_tipo'];
$grado = $fila['grado_curso'];
$letra = $fila['letra_curso'];
$nro_ano = $fila['nro_ano'];
$dec_eval = $fila['cod_eval'];
$plan_estudios = $fila['cod_decreto'];
if ($plan_estudios==5451996) $plan_estudios = 6252003;
if ($plan_estudios==5521997) $plan_estudios = 6252003;
$cod_subsector = $fila['nsub'];
$rut_profe = $fila['rut_emp'];
$dig_rut = $fila['dig_rut'];
$ape_pat = $fila['ape_pat'];
$ape_mat = $fila['ape_mat'];
$nombre = $fila['nombre_emp'];


	
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


?>
                              </table>


