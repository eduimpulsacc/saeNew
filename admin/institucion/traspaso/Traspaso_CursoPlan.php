<?	require('../../../util/header.inc');
	require('../../../util/header.inc');
	
	$sql = " SELECT  cod_decreto,pa,sa,ta,cu,qu,sx,sp,oc,nv,dc,d1,d2,d3 FROM cursos_plan WHERE cod_decreto IN (SELECT cod_decreto FROM ";
	$sql.= " plan_estudio WHERE rdb=".$_INSTIT.")";
	$result = @pg_exec($_ORIGEN,$sql);
	$total_filas = @pg_numrows($result);
	
	if($num=="") $num=0;
	
	if($num < $total_filas){
		$fila = @pg_fetch_array($result,$num);
		$sql = " INSERT INTO cursos_plan (cod_decreto,pa,sa,ta,cu,qu,sx,sp,oc,nv,dc,d1,d2,d3) VALUES ";
		$sql.= " ('".$fila['cod_decreto']."','".$fila['pa']."','".$fila['sa']."','".$fila['ta']."','".$fila['cu']."','".$fila['qu']."', ";
		$sql.= " '".$fila['sx']."','".$fila['sp']."','".$fila['oc']."','".$fila['nv']."','".$fila['dc']."','".$fila['d1']."','".$fila['d2']."', ";
		$sql.= " '".$fila['d3']."')";
		$rs_destino = @pg_exec($_DESTINO,$sql);
		
	
	}else{
		echo "<script>window.location = 'Traspaso_PlanInst.php' </script>";
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
        <td><B>Porcentaje del proceso completado: <? echo $porcentaje; ?> %</B></td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='Traspaso_CursoPlan.php?num=<? echo $num; ?>'");</script>
</body>
</html>