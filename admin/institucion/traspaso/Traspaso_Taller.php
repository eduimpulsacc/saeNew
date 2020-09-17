<?

	$sql = "SELECT id_taller,rdb,id_ano,nombre_taller,modo_eval,conex,pct_examen,nota_exim,truncado FROM taller WHERE rdb=".$_INSTIT;
	$rs_temporal = @pg_Exec($_ORIGEN,$sql);
	$total_filas = @pg_numrows($rs_temporal);
	
	if($num=="") $num=0;
	
	if($num < $total_filas){
		$fila = @pg_fetch_array($rs_temporal,$num);
		$sql = "INSERT INTO taller (rdb,id_ano,nombre_taller,modo_eval,conex,pct_examen,nota_exim,truncado) VALUES ('".$fila['rdb']."','".$fila['id_ano']."', ";
		$sql.= "'".$fila['nombre_taller']."','".$fila['modo_eval']."','".$fila['conex']."','".$fila['pct_examen']."','".$fila['nota_exim']."', ";
		$sql.= "'".$fila['truncado']."')";
		$rs_taller = @pg_exec($_DESTINO,$sql);
		
		$sql = "SELECT id_taller FROM taller ORDER BY id_taller DESC ";
		$rs_new = @pg_exec($_DESTINO,$sql);
		$id_taller = @pg_result($rs_new,0);
		
		$sql = "INSERT INTO temporal_taller (id_taller,id_taller_new) VALUES (".$fila['id_taller'].",".$id_taller.")";
		$rs_temporal_new = @pg_exec($_ORIGEN,$sql);
		
		/************ PROFESOR DE TALLER ****************/
		$sql = "SELECT rut_emp,id_taller FROM dicta_taller WHERE id_taller = ".$fila['id_taller'];
		$rs_dicta = @pg_exec($_ORIGEN,$sql);
		$rut_emp = @pg_result($rs_dicta,0);

		$sql = "INSERT INTO dicta (rut_emp,id_taller) VALUES (".$rut_emp.",".$id_taller.")";
		$rs_dicta_new = @pg_exec($_DESTINO,$sql);
		
		/************ INSCRIPCION DE ALUMNOS TALLER **********************/
		$sql = "SELECT  rut_alumno,id_taller FROM tiene_taller WHERE id_taller = ".$fila['id_taller'];
		$rs_tiene = @pg_exec($_ORIGEN,$sql);
		
		for($i=0; $i<@pg_numrows($rs_tiene); $i++){
			$fila_tiene = @pg_fetch_array($rs_tiene,$i);
			
			$sql = "INSERT INTO tiene_taller (rut_alumno,id_taller) VALUES (".$fila_tiene['rut_alumno'].",".$id_tiene.")";
			$rs_tiene_new = @pg_exec($_DESTINO,$sql);
		}
		
		/******************NOTAS TALLER **************************************/
		$sql = "SELECT rut_alumno,id_periodo,id_taller,nota1,nota2,nota3,nota4,nota5,nota6,nota7,nota8,nota9,nota10,nota11,nota12,nota13,nota14,nota15,nota16,  ";
		$sql.= "nota17,nota18,nota19,nota20,promedio FROM notas_taller WHERE id_taller =".$fila['id_taller'];
		$rs_notas = @pg_exec($_ORIGEN,$sql);
		
		for($i=0; $i<@pg_numrows($rs_notas); $i++){
			$fila_notas = @pg_fetch_array($rs_notas,$i);
			
			$sql = "INSERT INTO notas_taller (rut_alumno,id_periodo,id_taller,nota1,nota2,nota3,nota4,nota5,nota6, nota7, nota8 ,nota9, nota10, nota11, nota12, ";
			$sql.= "nota13, nota14, nota15, nota16, nota17,nota18,nota19,nota20,promedio) VALUES ('".$fila_notas['rut_alumno']."', '".$fila_notas['id_periodo']."', ";
			$sql.= "'".$id_taller."','".$fila_notas['nota1']."', '".$fila_notas['nota2']."','".$fila_notas['nota3']."','".$fila_notas['nota4']."', ";
			$sql.= "'".$fila_notas['nota5']."','".$fila_notas['nota6']."','".$fila_notas['nota7']."','".$fila_notas['nota8']."','".$fila_notas['nota9']."', ";
			$sql.= "'".$fila_notas['nota10']."','".$fila_notas['nota11']."','".$fila_notas['nota12']."','".$fila_notas['nota13']."', '".$fila_notas['nota14']."', ";
			$sql.= "'".$fila_notas['nota15']."','".$fila_notas['nota16']."','".$fila_notas['nota17']."','".$fila_notas['nota18']."','".$fila_notas['nota19']."', ";
			$sql.= "'".$fila_notas['nota20']."','".$fila_notas['promedio']."')";
			$rs_notas_new = @pg_exec($_DESTINO,$sql);
		}
		
		
	}else{
		echo "<script>window.location = 'Traspaso_Asistencia.php' </script>";
	}
	
/******************** PROFESOR DE TALLER *******************/
$sql = "SELECT rut_emp,id_taller FROM dicta_taller WHERE rut_emp=".$rut_emp;
$rs_taller = @pg_exec($_ORIGEN,$sql);

for($j=0; $j<@pg_numrows($rs_taller); $j++){
	$fila_taller = @pg_fetch_array($rs_taller,$j);
	$sql = "INSERT INTO () VALUES ()";
	$rs_taller_new = @pg_exec($_DESTINO,$sql);
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
        <td><span class="Estilo6">Porcentaje del proceso completado: <? echo $porcentaje; ?> %</span></td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='Traspaso_Taller.php?num=<? echo $num; ?>'");</script>
</body>
</html>