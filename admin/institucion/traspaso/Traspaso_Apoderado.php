<? 
	$sql ="SELECT id_ano,id_ano_new,nro_ano FROM temporal_ano_escolar WHERE rdb=".$_INSTIT;
	$rs_temporal = @pg_exec($_ORIGEN,$sql);
	$total_filas = @pg_numrows($rs_temporal);
	
	if($num=="") $num=0;
	
	if($num < $total_filas){
		$fila = @pg_fetch_array($rs_temporal,$num);
		$sql ="SELECT * FROM apoderado WHERE rut_apo IN (SELECT rut_apo FROM tiene2 WHERE tiene2.rut_alumno in (SELECT rut_alumno FROM matricula ";
		$sql.=" WHERE id_ano=".$fila['id_ano']."))";
		$rs_apo = @pg_exec($_ORIGEN,$sql);
		
		for($i=0; $i<@pg_numrows($rs_apo); $i++){
			$fila_apo = @pg_fetch_array($rs_apo,$i);
			$sql = "INSERT INTO apoderado rut_apo,dig_rut,nombre_apo,ape_pat,ape_mat,calle,nro,depto,block,vila,region,ciudad,comuna,telefono, ";
			$sql.= "relacion,email, id_usuario,foto,celular,nivel_edu,profesion,lugar_trabajo,cargo,nom_foto,fecha_nac,sexo, nacionalidad, ";
			$sql.= " direccion_lab, situacion_familiar,nivel_social,ocupacion,fono_pega ) VALUES ('".$fila_apo['rut_apo']."', ";
			$sql.= "'".$fila_apo['dig_rut']."','".$fila_apo['nombre_apo']."','".$fila_apo['ape_pat']."','".$fila_apo['ape_mat']."', ";
			$sql.= "'".$fila_apo['calle']."','".$fila_apo['nro']."','".$fila_apo['depto']."','".$fila_apo['block']."','".$fila_apo['villa']."', ";
			$sql.= "'".$fila_apo['region']."','".$fila_apo['ciudad']."','".$fila_apo['comuna']."','".$fila_apo['telefono']."', ";
			$sql.= "'".$fila_apo['relacion']."','".$fila_apo['email']."','".$fila_apo['id_usuario']."','".$fila_apo['foto']."', ";
			$sql.= "'".$fila_apo['celular']."','".$fila_apo['nivel_edu']."','".$fila_apo['profesion']."','".$fila_apo['lugar_trabajo']."', ";
			$sql.= "'".$fila_apo['cargo']."','".$fila_apo['nom_foto']."','".$fila_apo['fecha_nac']."','".$fila_apo['sexo']."', ";
			$sql.= "'".$fila_apo['nacionalidad']."','".$fila_apo['direccion_lab']."','".$fila_apo['situacion_familiar']."', ";
			$sql.= "'".$fila_apo['nivel_social']."','".$fila_apo['ocupacion']."','".$fila_apo['fono_pega']."') ";
			$rs_apo_new = @pg_exec($_DESTINO,$sql);
			
			$sql = "SELECT rut_apo,rut_alumno,reponsable,sostenedor FROM tiene2 WHERE rut_apo=".$fila_apo['rut_apo'];
			$rs_tiene = @pg_exec($_ORIGEN,$sql);
			
			for($j=0;$j < @pg_numrows($rs_tiene); $j++){
				$fila_tiene = @pg_fetch_array($rs_tiene,$j++);
				$sql = "INSERT INTO tiene2 (rut_apo,rut_alumno,reponsable,sostenedor) VALUES ('".$fila_tiene['rut_apo']."', ";
				$sql.= "'".$fila_tiene['rut_alumno']."','".$fila_tiene['responsable']."','".$fila_tiene['sostenedor']."')";
				$rs_tiene_new = @pg_exec($_DESTINO,$sql);
			}
		}	
	}else{
		echo "<script>window.location = 'Traspaso_Empleado.php' </script>";
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
        <td><span class="Estilo6">Porcentaje del proceso completado: <? echo $porcentaje; ?> %</span></td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='Traspaso_Apoderado.php?num=<? echo $num; ?>'");</script>
</body>
</html>