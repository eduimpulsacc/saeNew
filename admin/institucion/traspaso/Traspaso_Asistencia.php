<?
	$sql = "SELECT id_curso,id_curso_new FROM temporal_curso WHERE rdb=".$_INSTIT;
	$rs_temporal = @pg_exec($_ORIGEN,$sql);
	$total_filas = @pg_numrows($rs_temporal);
	
	if($num=="") $num=0;
	
	if($num < $total_filas){
		$fila = @pg_fetch_array($rs_temporal,$num);
		
		$sql = "SELECT rut_alumno,ano,id_curso,fecha FROM asistencia WHERE id_curso=".$fila['id_curso'];
		$rs_curso = @pg_exec($_ORIGEN,$sql);
		
		for($i=0; $i<@pg_numrows($rs_curso); $i++){
			$fila_curso =@pg_fetch_array($rs_curso,$i);
			
			$sql = "INSERT INTO asistencia (rut_alumno,ano,id_curso,fecha) VALUES (".$fila_curso['rut_alumno'].",".$fila_curso['ano'].",".$fila['id_curso_new'].", ";
			$sql.= "'".$fila_curso['fecha']."')";
			$rs_asistencia = @pg_exec($_DESTINO,$sql);
		}
		
	}else{
		echo "<script>window.location = 'Traspaso_Asistencia.php' </script>";
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
<style type="text/css">
<!--
.Estilo6 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif;}
.Estilo8 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
-->
</style>

<table width="700" border="0" class="celdas3" align="center" >
  <tr>
    <td><strong>PROCESO DE TRASPASO DE INSTITUCION </strong></td>
  </tr>
  <tr>
    <td><table width="699" border="0" class="celdas2">
      <tr>
        <td><span class="Estilo8">PROCESO INSTITUCION TERMINADO</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo8">PROCESO ANO ESCOLAR TERMINADO</span></td>
      </tr>
	    <tr>
        <td><span class="Estilo8">PROCESO PERIODO TERMINADO</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO FERIADO TERMINADO</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO PLAN ESTUDIO TERMINADO</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO CURSOS PLAN TERMINADO</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo8">PROCESO PLAN INSTITUCION TERMINADO</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo8">PROCESO PLAN TIPO TERMINADO</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO HORAS TIPO ENSENANZA TERMINADO</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO SUBSECTORES PROPIOS TERMINADO</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO CURSOS TERMINADO</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO RAMO TERMINADO</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo8">PROCESO MATRICULA TERMINADO</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo8">PROCESO INSCRIPCION DE ALUMNO</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo8">PROCESO NOTAS</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo8">PROCESO APODERADOS</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo8">PROCESO EMPLEADOS</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo8">PROCESO DOCENTES</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO TALLER</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo6">Porcentaje del proceso completado: <? echo $porcentaje; ?> %</span></td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='Traspaso_Asistencia.php?num=<? echo $num; ?>'");</script>
</body>
</html>