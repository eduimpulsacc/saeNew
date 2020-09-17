<? 
	$sql = "SELECT id_curso,id_curso_new,rdb FROM temporal_curso WHERE rdb=".$_INSTIT;
	$rs_temporal = @pg_exec($_ORIGEN,$sql);
	$total_filas = @pg_numrows($rs_temporal);
	
	if($num=="") $num=0;
	
	if($num < $total_filas){
		$fila = @pg_fetch_array($rs_temporal,$num);
		/****************PROFESOR JEFE **********************/
		$sql = "SELECT rut_emp,id_curso FROM supervisa WHERE id_curso=".$fila['id_curso'];
		$rs_super = @pg_exec($_ORIGEN,$sql);
		$rut_emp = @pg_result($rs_super,0);
		
		$sql = "INSERT INTO supervisa (rut_emp,id_curso) VALUES (".$rut_emp.",".$fila['id_curso_new'].")";
		$rs_super_new = @pg_exec($_DESTINO,$sql);
		
		/************** PROFESOR DE SUBSECTOR *********************/
		$sql = "SELECT id_ramo,id_ramo_new,id_curso,id_curso,rdb FROM temporal_ramo WHERE id_curso_new= ".$fila['id_curso_new'];
		$rs_temporal_ramo = @pg_exec($_ORIGEN,$sql);
		
		for($i=0;$i<@pg_numrows($rs_temporal_ramo);$i++){
			$fila_ramo = @pg_fetch_array($rs_temporal_ramo,$i++);
			$sql = "SELECT rut_emp,id_ramo FROM dicta WHERE rut_emp=".$fila_ramo['id_ramo']."";
			$rs_existe_dicta = @pg_exec($_ORIGEN,$sql);
			if(@pg_numrows($rs_existe_dicta)==0){
				$sql = "INSERT INTO dicta (rut_emp,id_ramo) VALUES (".$rut_emp.",".$fila_ramo['id_ramo'].")";
				$rs_dicta = @pg_exec($_DESTINO,$sql);
			}
		}
		/****************** PROFESOR DE AYUDANTIA *****************/
		for($i=0;$i<@pg_numrows($rs_temporal_ramo);$i++){
			$fila_ramo = @pg_fetch_array($rs_temporal_ramo,$i++);
			$sql = "SELECT rut_emp,id_ramo FROM dicta WHERE rut_emp=".$fila_ramo['id_ramo']."";
			$rs_existe_ayuda = @pg_exec($_ORIGEN,$sql);
			if(@pg_numrows($rs_existe_ayuda)==0){
				$sql = "INSERT INTO dicta (rut_emp,id_ramo) VALUES (".$rut_emp.",".$fila_ramo['id_ramo'].")";
				$rs_dicta = @pg_exec($_DESTINO,$sql);
			}
		}
	}else{
		echo "<script>window.location = 'Traspaso_Taller.php' </script>";
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
        <td><span class="Estilo6">Porcentaje del proceso completado: <? echo $porcentaje; ?> %</span></td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='Traspaso_Profesor.php?num=<? echo $num; ?>'");</script>
</body>
</html>