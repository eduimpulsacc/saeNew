<? 	require('../../../util/header.inc');
	require('../../../util/header.inc');
	
	$sql = " SELECT * FROM temporal_ano_escolar WHERE rdb = ".$_INSTIT." ORDER BY id_ano ASC ";
	$result = @pg_exec($_ORIGEN,$sql);
	$total_filas = @pg_numrows($result);
		
	if($num=="") $num=0;
	
	if($num < $total_filas){
		$fils = @pg_fetch_array($result,$num);
		$sql = " SELECT id_periodo,nombre_periodo, fecha_inicio,fecha_termino, id_ano, mostrar_notas, dias_habiles, cerrado, ing_notas FROM periodo ";
		$sql.= " WHERE id_ano = ".$fils['id_ano'];
		$rs_origen = @pg_exec($_ORIGEN,$sql);
		

		for($i=0; $i<@pg_numrows($rs_origen); $i++){	
			$fila = @pg_fetch_array($rs_origen,$i);
			$sql = " INSERT INTO periodo (nombre_periodo, fecha_inicio,fecha_termino, id_ano, mostrar_notas, dias_habiles, cerrado, ing_notas) ";
			$sql.= " VALUES ('".$fila['nombre_periodo']."','".$fila['fecha_inicio']."','".$fila['fecha_termino']."','".$fils['id_ano_new']."', ";
			$sql.= " '".$fila['mostrar_notas']."','".$fila['dias_habiles']."','".$fila['cerrado']."','".$fila['ing_notas']."')"; 
			$rs_destino = @pg_exec($_DESTINO,$sql);
			
			$sql = "SELECT id_periodo FROM periodo ORDER BY id_periodo DESC";
			$rs_periodo = @pg_exec($_DESTINO,$sql);
			$id_periodo_new = @pg_result($rs_periodo,0);
			
			$sql = " INSERT INTO temporal_periodo (id_ano_new,id_ano, id_periodo,id_periodo_new,rdb) VALUES (".$fils['id_ano_new'].", ";
			$sql.= " ".$fils['id_ano'].",".$fila['id_periodo'].",".$id_periodo_new.")";
			$rs_temporal = @pg_exec($_ORIGEN,$sql);
		
		}	
	}else{
		echo "<script>window.location = 'Traspaso_Feriado.php' </script>";
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
        <td><B>PROCESO ANO_ESCOLAR TERMINADO</B></td>
      </tr>
	  <tr>
        <td><B>Porcentaje del proceso completado: <? echo $porcentaje; ?> %</B></td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='Traspaso_Periodo.php?num=<? echo $num; ?>'");</script>
</body>
</html>