<?php require('../../../../util/header.inc');?>
<?php 

	//$ls_criterio = $_GET["as_criterio"];
	//$ls_input    = $_GET["as_input"];
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;

$sql = "SELECT institucion.rdb, institucion.dig_rdb, institucion.region, curso.ensenanza, curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, curso.cod_eval, plan_estudio.cod_decreto, plan_estudio.cod_plan, empleado.rut_emp, empleado.dig_rut, ens.nombre_tipo  ";
	$sql = $sql . "FROM institucion, (((curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN supervisa ON curso.id_curso = supervisa.id_curso) INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp
	INNER JOIN tipo_ensenanza ens ON ens.cod_tipo = curso.ensenanza
	 ";
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
empleado.dig_rut  order by curso.ensenanza, curso.grado_curso, curso.letra_curso  ;";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
?>

<?php header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=".$institucion."_02.xls");
header("Pragma: no-cache");
header("Expires: 0");?>
<table border="1" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm;</strong></font></td>
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
$region = $fila['region'];
$tipo_ense = $fila['nombre_tipo'];
$grado = $fila['grado_curso'];
$letra = $fila['letra_curso'];
$nro_ano = $fila['nro_ano'];
$dec_eval = $fila['cod_eval'];
$plan_estudios = $fila['cod_decreto'];
if ($plan_estudios==5451996) $plan_estudios = 6252003;
if ($plan_estudios==5521997) $plan_estudios = 6252003;
$rut_profe = $fila['rut_emp'];
$dig_rut = $fila['dig_rut'];


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


?>
                      </table>