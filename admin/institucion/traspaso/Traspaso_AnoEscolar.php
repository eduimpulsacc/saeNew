<? 	require('../../../util/header.inc');
	require('../../../util/header.inc');
	
	$sql = " SELECT id_ano, nro_ano, fecha_inicio, fecha_termino, situacion,id_institucion, ano_anterior,tipo_regimen FROM ano_escolar ";
	$sql.= " WHERE id_institucion=".$_INSTIT." ORDER BY id_ano ASC ";
	$rs_origen = @pg_exec($_ORIGEN,$sql);
	$total_filas = @pg_numrows($rs_origen);
	
	if($num=="") {
		$num=0;
		$ano_anterior=0;
	}
	
	if($num < $total_filas){
		$fila = @pg_exec($_ORIGEN,$num);
		$sql = " INSERT INTO ano_escolar (nro_ano, fecha_inicio, fecha_termino, situacion,id_institucion, ano_anterior,tipo_regimen) VALUES ";
		$sql.= " ('".$fila['nro_ano']."','".$fila['fecha_inicio']."','".$fila['fecha_termino']."','".$fila['situacion']."', ";
		$sql.= " '".$fila['id_institucion']."','".$ano_anterior."','".$fila['tipo_regimen']."')";
		$rs_insert = @pg_exec($_DESTINO,$sql);
		
		$sql = " SELECT  id_ano FROM ano_escolar ORDER BY id_ano DESC ";
		$rs_ano = @pg_exec($_DESTINO,$sql);
		$id_ano_new = @pg_result($rs_ano,0);
		
		$sql = " INSERT INTO temporal_ano_escolar (id_ano, id_ano_new, rdb, nro_ano) VALUES ('".$fila['id_ano']."','".$id_ano_new."', ";
		$sql.= " '".$fila['id_institucion']."','".$fila['nro_ano']."')";
		$rs_temporal = @pg_exec($_ORIGEN,$sql);
		
	}else{
		echo "<script>window.location = 'Traspaso_Periodo.php' </script>";
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
        <td><B>Porcentaje del proceso completado: <? echo $porcentaje; ?> %</B></td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='Traspaso_AnoEscolar.php?num=<? echo $num; ?>&ano_anterior=<?=$fila['ano_anterior'];?>'");</script>
</body>
</html>