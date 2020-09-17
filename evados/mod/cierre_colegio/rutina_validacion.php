
<? 
//$conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Final.");	
$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	



$periodo=2964;
$plantilla = 38;
$rut = 6622619;

$sql="SELECT nombre_emp ||' '|| ape_pat as nombre FROM empleado WHERE rut_emp=".$rut;
$rs_empleado = pg_exec($conn,$sql);
$nombre = pg_result($rs_empleado,0);

/*header("Content-Type:application/vnd.ms-excel; charset=utf-8");
header("Content-type:application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=$nombre.xls"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<?

$sql="select distinct id_cargo_evaluador, c.nombre_cargo
FROM evados.eva_plantilla_evaluacion epe
INNER JOIN cargos c ON c.id_cargo=epe.id_cargo_evaluador
WHERE id_plantilla=".$plantilla."
AND rut_evaluado=".$rut."
AND ip_periodo=".$periodo."
ORDER BY 1";
$rs_cargos  =pg_exec($conn,$sql);


for($i=0;$i<pg_numrows($rs_cargos);$i++){
	$fila_cargos = pg_fetch_array($rs_cargos,$i);
?>


	<table width="900" border="1" style="border-collapse:collapse" align="center">
  <tr>
    <td width="200" rowspan="2">DIMENSION</td>
    <td colspan="10" align="center">&nbsp;<?=$fila_cargos['nombre_cargo'];?></td>
    <td width="50" rowspan="2">TOTAL<br />
      OBTENIDO</td>
    <td width="50" rowspan="2">OPTIMO</td>
    <td width="50" rowspan="2">% </td>
    <td width="100" rowspan="2">RESULTADO</td>
  </tr>
  <tr>
    <td colspan="2">SIE</td>
    <td colspan="2">GEN</td>
    <td colspan="2">A/V</td>
    <td colspan="2">NUN</td>
    <td colspan="2">N/O</td>
  </tr>
  
	<?	
	
	$sql="SELECT  distinct epa.nombre, epa.id_area
			FROM evados.eva_plantilla_evaluacion  epe
			INNER JOIN evados.eva_plantilla_area epa ON epe.id_area=epa.id_area
			WHERE id_plantilla=".$plantilla."
			AND rut_evaluado=".$rut."
			AND ip_periodo=".$periodo."
			and id_cargo_evaluador=".$fila_cargos['id_cargo_evaluador']."
			ORDER BY 1 ASC";
	$rs_area=pg_exec($conn,$sql);
	$sum_s=0;
	$sum_g=0;
	$sum_av=0;
	$sum_n=0;
	$sum_no=0;
	for($j=0;$j<pg_numrows($rs_area);$j++){
		$fila_area=pg_fetch_array($rs_area,$j);
		
	?>
    
    <tr>
    <td  width="200">&nbsp;<?=$fila_area['nombre'];?></td>
    <td width="9">&nbsp; <? 
	 $sql="SELECT count(*) as cantidad
			FROM evados.eva_plantilla_evaluacion epe 
			WHERE id_plantilla=".$plantilla."
			AND rut_evaluado=".$rut."
			AND ip_periodo=".$periodo."
			and id_cargo_evaluador=".$fila_cargos['id_cargo_evaluador']."
			AND id_area=".$fila_area['id_area']."  AND epe.id_concepto=19";
	$rs_siempre = pg_exec($conn,$sql);

	 echo $s_cantidad = pg_result($rs_siempre,0);?></td> 
	 <td width="15">&nbsp; <? echo $s_valor= pg_result($rs_siempre,0) * 4;  ?></td> 
	 <td width="15">&nbsp; <?
	  $sql="SELECT count(*) as cantidad
			FROM evados.eva_plantilla_evaluacion epe 
			WHERE id_plantilla=".$plantilla."
			AND rut_evaluado=".$rut."
			AND ip_periodo=".$periodo."
			and id_cargo_evaluador=".$fila_cargos['id_cargo_evaluador']."
			AND id_area=".$fila_area['id_area']."  AND epe.id_concepto=18";
	$rs_g = pg_exec($conn,$sql);
	 echo $g_cantidad = pg_result($rs_g,0);?></td> 
	 <td width="15">&nbsp; <? echo $g_valor =  pg_result($rs_g,0) * 3;  ?></td> 
     <td width="15">&nbsp; <? 
	 $sql="SELECT count(*) as cantidad
			FROM evados.eva_plantilla_evaluacion epe 
			WHERE id_plantilla=".$plantilla."
			AND rut_evaluado=".$rut."
			AND ip_periodo=".$periodo."
			and id_cargo_evaluador=".$fila_cargos['id_cargo_evaluador']."
			AND id_area=".$fila_area['id_area']."  AND epe.id_concepto=17";
	$rs_av = pg_exec($conn,$sql);
	 echo $av_cantidad = pg_result($rs_av,0);?></td> 
	 <td width="15">&nbsp; <? echo $av_valor = pg_result($rs_av,0)*2 ;  ?></td> 
     <td width="15">&nbsp; <? 
	 $sql="SELECT count(*) as cantidad
			FROM evados.eva_plantilla_evaluacion epe 
			WHERE id_plantilla=".$plantilla."
			AND rut_evaluado=".$rut."
			AND ip_periodo=".$periodo."
			and id_cargo_evaluador=".$fila_cargos['id_cargo_evaluador']."
			AND id_area=".$fila_area['id_area']."  AND epe.id_concepto=16";
	$rs_n = pg_exec($conn,$sql);
	 echo $n_cantidad=pg_result($rs_n,0);?></td> 
	 <td width="15">&nbsp; <? echo $n_valor=pg_result($rs_n,0) *1;  ?></td> 
     <td width="15">&nbsp; <? 
	  $sql="SELECT count(*) as cantidad
			FROM evados.eva_plantilla_evaluacion epe 
			WHERE id_plantilla=".$plantilla."
			AND rut_evaluado=".$rut."
			AND ip_periodo=".$periodo."
			and id_cargo_evaluador=".$fila_cargos['id_cargo_evaluador']."
			AND id_area=".$fila_area['id_area']."  AND epe.id_concepto=15";
	$rs_no = pg_exec($conn,$sql);
	 echo $no_cantidad = pg_result($rs_no,0);?></td> 
	 <td width="15">&nbsp;<? echo $no_valor = pg_result($rs_no,0)*0;  ?></td> 
	 <td width="20" align="center">&nbsp;<? echo $total_obtenido = $s_valor + $g_valor + $av_valor + $n_valor + $no_valor;?></td>
    <td width="20" align="center">&nbsp;<? echo $optimo = ($s_cantidad + $g_cantidad + $av_cantidad + $n_cantidad + $no_cantidad) * 4;?></td>
    <td width="20" align="center">&nbsp;<? echo $porcentaje = round(($total_obtenido / $optimo) * 100);?></td>
    <td width="100" align="center">&nbsp;<? 
	$sql="SELECT concepto FROM evados.eva_escala WHERE desde<=".$porcentaje." AND hasta>=".$porcentaje."";
	$rs_concepto = pg_exec($conn,$sql);
	echo pg_result($rs_concepto,0);
	?></td>
  </tr>
    <? 
	$sum_s+=$s_valor;
	$sum_g+=$g_valor;
	$sum_av+=$av_valor;
	$sum_n+=$n_valor;
	$sum_no+=$no_valor;
	} ?>
    <tr>
      <td>TOTALES</td>
      <td>&nbsp;</td>
      <td>&nbsp;<?=$sum_s;?></td>
      <td>&nbsp;</td>
      <td>&nbsp;<?=$sum_g;?></td>
      <td>&nbsp;</td>
      <td>&nbsp;<?=$sum_av;?></td>
      <td>&nbsp;</td>
      <td>&nbsp;<?=$sum_n;?></td>
      <td>&nbsp;</td>
      <td>&nbsp;<?=$sum_no;?></td>
      <td align="center"><?=$total=$sum_s+$sum_g+$sum_av+$sum_n+$sum_no;?>&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>

  
</table>
<br />
<br />
<? 	
	}
?>
</html>