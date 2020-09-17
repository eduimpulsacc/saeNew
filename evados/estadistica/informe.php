<?php // header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=EvadosRespuetas".date("Y-m-d_h-i-s").".xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); ?>
<?php //base de datos antigua
$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");

//var_dump($_POST);
/*$sql3="select ins.nombre_instit,
rel.id_cargo_evaluador,
rel.rut_evaluador,
rel.id_cargo_evaluado,
rel.rut_evaluado,
ar.nombre dimension,
suba.nombre funcion,
itm.nombre indicador,
conc.categoria respuesta
from institucion ins
inner join evados.eva_ano_escolar an on an.id_institucion = ins.rdb
inner join evados.eva_periodos_evaluacion pe on pe.id_anio = an.id_ano
inner join evados.eva_plantilla_evaluacion rel on rel.ip_periodo = pe.id_periodo
inner join evados.eva_plantilla_area ar on ar.id_area = rel.id_area
inner join evados.eva_plantilla_subarea suba on suba.id_subarea = rel.id_subarea
inner join evados.eva_plantilla_item itm on itm.id_item = rel.id_item
inner join evados.eva_concepto conc on conc.id_concepto = rel.id_concepto
where pe.id_anio = ".$_POST['nano']."
order by rel.rut_evaluador,rel.rut_evaluado
";*/
$qins ="select ins.nombre_instit from institucion ins
inner join evados.eva_ano_escolar an on an.id_institucion = ins.rdb
where an.id_ano= ".$_POST['nano'];
$rins = pg_exec($conn,$qins);

$qblo ="select nombre from evados.eva_plantilla where id_plantilla=".$_POST['bloque'];
$rblo = pg_exec($conn,$qblo);

  $sql3="select pla.*
from evados.eva_plantilla_evaluacion pla
where pla.id_ano = ".$_POST['nano']." and pla.id_plantilla =".$_POST['bloque'];
$rs3=pg_exec($conn,$sql3);



?>
INSTITUCION: <?php echo pg_result($rins,0); ?><br />

PAUTA EVALUACI&Oacute;N:
<?php echo pg_result($rblo,0); ?><br />
<br />

<table width="100%" border="1">
  <tr>
    <td>#</td>
    <td>Cargo Evaluador</td>
    <td>Rut Evaluador</td>
    <td>Nombre Evaluador</td>
    <td>Cargo Evaluado</td>
    <td>Rut Evaluado</td>
    <td>Nombre Evaluado</td>
    <td>Dimensi&oacute;n</td>
    <td>Funci&oacute;n</td>
    <td>Indicador</td>
    <td>Respuesta</td>
  </tr>
  <?php for($d=0;$d<pg_numrows($rs3);$d++){
	  $fe=pg_fetch_array($rs3,$d);
	   $ceval ="select nombre_cargo from cargos where id_cargo=".$fe['id_cargo_evaluador'];
	  $reval = pg_exec($conn,$ceval);
	  
	  switch($fe['id_cargo_evaluador']){
		case 100:
		$sqlevqa="select dig_rut,ape_pat||' '||ape_mat||' '||nombre_alu nom_evaluador from alumno where rut_alumno=".$fe['rut_evaluador'];
		break;
		case 101:
		$sqlevqa="select dig_rut,ape_pat||' '||ape_mat||' '||nombre_apo nom_evaluador from apoderado where rut_apo=".$fe['rut_evaluador'];
		break;
		default:
		$sqlevqa="select dig_rut,ape_pat||' '||ape_mat||' '||nombre_emp nom_evaluador from empleado where rut_emp=".$fe['rut_evaluador'];
		break;
		  
		}

	  $deva=pg_exec($conn,$sqlevqa);
	
	 
	  
	   $cevol ="select nombre_cargo from cargos where id_cargo=".$fe['id_cargo_evaluado'];
	  $revol = pg_exec($conn,$cevol);
	   $devo=pg_exec($conn,"select dig_rut,ape_pat||' '||ape_mat||' '||nombre_emp nom_evaluado from empleado where rut_emp=".$fe['rut_evaluado']);
	   
	   $qarea = "select nombre from evados.eva_plantilla_area where id_area =".$fe['id_area'];
	   $rarea = pg_exec($conn,$qarea);
	   
	    $qsarea = "select nombre from evados.eva_plantilla_subarea where id_subarea =".$fe['id_subarea'];
	   $rsarea = pg_exec($conn,$qsarea);
	   
	   $qsitem = "select nombre from evados.eva_plantilla_item where id_item =".$fe['id_item'];
	   $rsitem = pg_exec($conn,$qsitem);
	   
	    $qsitem = "select categoria from evados.eva_concepto where id_concepto =".$fe['id_concepto'];
	   $rsrep = pg_exec($conn,$qsitem);
	  ?>
  <tr>
    <td><?php echo $d+1  ?></td>
    <td><?php echo pg_result($reval,0); ?></td>
    <td><?php echo $fe['rut_evaluador'] ?>-<?php echo pg_result($deva,0); ?></td>
    <td><?php echo pg_result($deva,1); ?></td>
    <td><?php echo pg_result($revol,0); ?></td>
    <td><?php echo $fe['rut_evaluado'] ?>-<?php echo pg_result($devo,0); ?></td>
    <td><?php echo pg_result($devo,1); ?></td>
    <td><?php echo pg_result($rarea,0) ?></td>
    <td><?php echo pg_result($rsarea,0) ?></td>
    <td><?php echo pg_result($rsitem,0) ?></td>
    <td><?php echo pg_result($rsrep,0) ?></td>
  </tr>
  <?php }?>
</table>
