<?	require('../../../util/header.inc');
	require('../../../util/header.inc');
	
	$sql = "SELECT rdb, corre, corre_new FROM temporal_tipo_ense_inst WHERE rdb=".$_INSTIT;
	$result = @pg_exec($_ORIGEN,$sql);
	$total_filas = @pg_numrows($result);
	
	if($num=="") $num=0;
	
	if($num < $total_filas){
		$fila = @pg_fetch_array($result,$num);
		$sql = "SELECT corre,hora_ini,hora_ter FROM hora_jm WHERE corre = ".$fila['corre'];
		$rs_jm = @pg_exec($_ORIGEN,$sql);
		
		if(@pg_numrows($rs_jm)!=0){
			$fils = @pg_fetch_array($rd_jm,0);
			$sql = "INSERT INTO hora_jm (corre,hora_ini,hora_ter) VALUES ('".$fila['corre_new']."','".$fils['fecha_ini']."','".$fils['fecha_ter']."'";
			$rs_destino = @pg_exec($_DESTINO,$sql);
		}
		$sql = "SELECT corre,hora_ini,hora_ter FROM hora_jt WHERE corre = ".$fila['corre'];
		$rs_jt = @pg_exec($_ORIGEN,$sql);
		
		if(@pg_numrows($rs_jt)!=0){
			$fils = @pg_fetch_array($rd_jt,0);
			$sql = "INSERT INTO hora_jt (corre,hora_ini,hora_ter) VALUES ('".$fila['corre_new']."','".$fils['fecha_ini']."','".$fils['fecha_ter']."'";
			$rs_destino = @pg_exec($_DESTINO,$sql);
		}
		$sql = "SELECT corre,hora_ini,hora_ter FROM hora_mt WHERE corre = ".$fila['corre'];
		$rs_mt = @pg_exec($_ORIGEN,$sql);
		
		if(@pg_numrows($rs_mt)!=0){
			$fils = @pg_fetch_array($rd_mt,0);
			$sql = "INSERT INTO hora_mt (corre,hora_ini,hora_ter) VALUES ('".$fila['corre_new']."','".$fils['fecha_ini']."','".$fils['fecha_ter']."'";
			$rs_destino = @pg_exec($_DESTINO,$sql);
		}
		$sql = "SELECT corre,hora_ini,hora_ter FROM hora_vn WHERE corre = ".$fila['corre'];
		$rs_vn = @pg_exec($_ORIGEN,$sql);
		
		if(@pg_numrows($rs_vn)!=0){
			$fils = @pg_fetch_array($rd_vn,0);
			$sql = "INSERT INTO hora_vn (corre,hora_ini,hora_ter) VALUES ('".$fila['corre_new']."','".$fils['fecha_ini']."','".$fils['fecha_ter']."'";
			$rs_destino = @pg_exec($_DESTINO,$sql);
		}
	}else{
		echo "<script>window.location = 'Traspaso_IncluyePropio.php' </script>";
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
        <td><B>PROCESO ENSEÑANZA INSTITUCION TERMINADO</B></td>
      </tr>
	  <tr>
        <td><B>Porcentaje del proceso completado: <? echo $porcentaje; ?> %</B></td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='Traspaso_Hora.php?num=<? echo $num; ?>'");</script>
</body>
</html>