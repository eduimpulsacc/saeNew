<?	require('../../../util/header.inc');
	require('../../../util/header.inc');
	
	$sql = "SELECT rdb, id_ano, id_ano_new FROM temporal_ano_escolar WHERE rdb =".$_INSTIT."";
	$result = @pg_exec($_ORIGEN,$sql);
	$total_filas = @pg_numrows($result);
	
	if($num=="") $num=0;
	
	if($num < $total_filas){
		$fila = @pg_fetch_array($result,$num);
		$sql = " SELECT id_curso, grado_curso, letra_curso, ensenanza, cod_decreto, cod_eval, id_ano,cod_es,cod_sector, cod_rama, bool_jor, ";
		$sql.= " truncado_per, simce,acta, observaciones, truncado_final, truncado_sf, val_sub, total_horas1, total_horas2, total_horas3 ";
		$sql.= " cap_curso, vacantes FROM curso WHERE id_ano=".$fila['id_ano'];
		$rs_curso = @pg_exec($_ORIGEN,$sql);
		
		if(@pg_numrows($rs_curso)!=0){
			for($i=0; $i < @pg_numrows($rs_curso); $i++){
				$fila_curso = @pg_fetch_array($rs_curso,$i);	
				$sql = " INSERT INTO curso (grado_curso, letra_curso, ensenanza, cod_decreto, cod_eval, id_ano,cod_es,cod_sector, cod_rama, ";
				$sql.= " bool_jor, truncado_per, simce,acta, observaciones, truncado_final, truncado_sf, val_sub, total_horas1, total_horas2, ";
				$sql.= " total_horas3 cap_curso, vacantes) VALUES ('".$fila_curso['grado_curso']."','".$fila_curso['letra_curso']."', ";
				$sql.= " '".$fila_curso['ensenanza']."', '".$fila_curso['cod_decreto']."','".$fila_curso['cod_eval']."','".$fila['id_ano']."', ";
				$sql.= " '".$fila_curso['cod_es']."','".$fila_curso['cod_sector']."','".$fila_curso['cod_rama']."','".$fila_curso['bool_jor']."', ";
				$sql.= " '".$fila_curso['truncado_per']."','".$fila_curso['since']."','".$fila_curso['acta']."','".$fila_curso['observaciones']."', ";
				$sql.= " '".$fila_curso['truncado_final']."','".$fila_curso['truncado_sf']."','".$fila_curso['val_sub']."', ";
				$sql.= " '".$fila_curso['total_horas1']."','".$fila_curso['total_horas2']."','".$fila_curso['total_horas3']."', ";
				$sql.= " '".$fila_curso['cap_curso']."','".$fila_curso['vacantes']."')";
				$rs_destino = @pg_exec($_DESTINO,$sql);
				
				$sql ="SELECT id_curso FROM curso ORDER BY id_curso DESC ";
				$rs_id = @pg_exec($_DESTINO,$sql);
				$id_curso_new = @pg_result($rs_id,0);
				
				$sql ="INSERT INTO temporal_curso (id_curso,id_curso_new,rdb) VALUES (".$fila_curso['id_curso'].",".$id_curso_new.",".$_INSTIT.")";
				$rs_temporal = @pg_exec($_ORIGEN,$sql);
			}
		}
		
	}else{
		echo "<script>window.location = 'Traspaso_Ramo.php' </script>";
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
        <td><B>PROCESO HORAS TIPO ENSENANZA TERMINADO</B></td>
      </tr>
	   <tr>
        <td><B>PROCESO SUBSECTORES PROPIOS TERMINADO</B></td>
      </tr>
	  <tr>
        <td><B>Porcentaje del proceso completado: <? echo $porcentaje; ?> %</B></td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='Traspaso_Curso.php?num=<? echo $num; ?>'");</script>
</body>
</html>