<?	require('../../../util/header.inc');
	require('../../../util/header.inc');
	
	$sql = "SELECT rdb,cod_tipo,estado,nu_resolucion,fecha_res,nu_resolucion_cierre,fecha_res_cierre,nu_grupos_dif,bool_ecp, ";
	$sql.= "bool_jp, cod_decreto, corre FROM tipo_ense_inst WHERE rdb=".$_INSTIT;
	$result = @pg_exec($_ORIGEN,$sql);
	$total_filas = @pg_numrows($result);
	
	if($num=="") $num=0;
	
	if($num < $total_filas){
		$fila = @pg_fetch_array($result,$num);
		$sql = "INSERT INTO plan_tipo (rdb,cod_tipo,estado,nu_resolucion,fecha_res,nu_resolucion_cierre,fecha_res_cierre,nu_grupos_dif,bool_ecp, ";
		$sql.= "bool_jp, cod_decreto) VALUES ('".$fila['rdb']."','".$fila['cod_tipo']."','".$fila['estado']."','".$fila['nu_resolucion']."', ";
		$sql.= " '".$fila['fecha_res']."','".$fila['nu_resolucion_cierre']."','".$fila['fecha_res_cierre']."','".$fila['nu_grupos']."', ";
		$sql.= " '".$fila['bool_ecp']."','".$fila['bool_jp']."','".$fila['cod_decreto']."')";
		$rs_destino = @pg_exec($_DESTINO,$sql);
		
		$sql = "SELECT corre FROM plan_tipo ORDER BY corre DESC ";
		$rs_id = @pg_exec($_DESTINO,$sql);
		$corre_new = @pg_result($rs_id,0);
		
		$sql = "INSERT INTO temporal_tipo_ense_inst (rdb,corre,corre_new) VALUES ('".$fila['rdb']."','".$fila['corre']."','".$corre_new."') ";
		$rs_temporal = @pg_exec($_ORIGEN,$sql);
	}else{
		echo "<script>window.location = 'Traspaso_PlanTipo.php' </script>";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../estilo1.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?
		$num = $num +1;
		$porcentaje = round(($num*100)/$total_filas,2);?>
<table width="700" border="0" class="celdas3" align="center" >
  <tr>
    <td><strong>PROCESO DE TRASPASO DE INSTITUCION </strong></td>
  </tr>
  <tr>
    <td><table width="699" border="0" class="celdas2">
      <tr>
        <td><B>PROCESO INSTITUCION TERMINADO</B></td>
      </tr>
	  <tr>
        <td><B>PROCESO ANO ESCOLAR TERMINADO</B></td>
      </tr>
	    <tr>
        <td><B>PROCESO PERIODO TERMINADO</B></td>
      </tr>
	   <tr>
        <td><B>PROCESO FERIADO TERMINADO</B></td>
      </tr>
	   <tr>
        <td><B>PROCESO PLAN ESTUDIO TERMINADO</B></td>
      </tr>
	   <tr>
        <td><B>PROCESO CURSOS PLAN TERMINADO</B></td>
      </tr>
	  <tr>
        <td><B>PROCESO PLAN INSTITUCION TERMINADO</B></td>
      </tr>
	  <tr>
        <td><B>PROCESO PLAN TIPO TERMINADO</B></td>
      </tr>
	  <tr>
        <td><B>Porcentaje del proceso completado: <? echo $porcentaje; ?> %</B></td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='Traspaso_TipoEnseInst.php?num=<? echo $num; ?>'");</script>
</body>
</html>