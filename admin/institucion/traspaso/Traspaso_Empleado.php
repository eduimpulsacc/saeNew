<? 
	$sql = "SELECT rdb,rut_emp,fecha_ingreso,fecha_retiro,cargo,identificador FROM trabaja WHERE rdb=".$_INSTIT;
	$rs_trabaja = @pg_exec($_ORIGEN,$sql);
	$total_filas = @pg_numrows($rs_temporal);
	
	if($num=="") $num=0;
	
	if($num < $total_filas){
		$fila = @pg_fetch_array($rs_trabaja,$num);
		$sql = "SELECT rut_emp,dig_rut,nombre_emp,ape_pat,ape_mat,calle,nro,depto,block,villa,region,ciudad,comuna,telefono,sexo,titulo,email, ";
		$sql.= "estado_civil,id_usuario,foto,estudios,nu_resol,fecha_resol,tipo_titulo,anos_exp,idiomas_malo,idiomas,nacionalidad,telefono2, ";
		$sql.= "telefono3,atencion,habilitado,titulado,tit_otras,habilitado_old,habilitado_tras,habilitado_para,nom_foto,nom_foto2,hxcontrato, ";
		$sql.= "hxclase,cargo_total,fecha_nacimiento,fecha_ingreso,horas_presente_ano,prevision,sistema_salud,t_institucion1,t_institucion2,  ";
		$sql.= "t_institucion3,t_hora1,t_hora2,t_hora3) FROM empleado WHERE rut_emp=".$fila['rut_emp'];
		$rs_empleado = @pg_exec($_ORIGEN,$sql);
		$fila_emp = @pg_fetch_array($rs_empleado,0);
		
		$sql = "INSERT INTO empleado (rut_emp, dig_rut,nombre_emp,ape_pat,ape_mat,calle,nro,depto,block,villa, region, ciudad, comuna, ";
		$sql.= "telefono,sexo,titulo,email, estado_civil, id_usuario,foto, estudios,nu_resol, fecha_resol,tipo_titulo, anos_exp,idiomas_malo, ";
		$sql.= "idiomas,nacionalidad,telefono2, telefono3, atencion, habilitado, titulado, tit_otras, habilitado_old, habilitado_tras, ";
		$sql.= "habilitado_para,nom_foto,nom_foto2,hxcontrato, hxclase, cargo_total, fecha_nacimiento, fecha_ingreso, horas_presente_ano, ";
		$sql.= "prevision,sistema_salud,t_institucion1,t_institucion2, t_institucion3,t_hora1,t_hora2,t_hora3) VALUES ( ";
		$sql.= "'".$fila_emp['rut_emp']."','".$fila_emp['dig_rut']."','".$fila_emp['nombre_emp']."','".$fila_emp['ape_pat']."', ";
		$sql.= "'".$fila_emp['ape_mat']."','".$fila_emp['calle']."','".$fila_emp['nro']."','".$fila_emp['depto']."','".$fila_emp['block']."', ";
		$sql.= "'".$fila_emp['villa']."','".$fila_emp['region']."','".$fila_emp['ciudad']."','".$fila_emp['comuna']."','".$fila_emp['telefono']."', ";
		$sql.= "'".$fila_emp['sexo']."','".$fila_emp['titulo']."','".$fila_emp['email']."','".$fila_emp['estado_civil']."', ";
		$sql.= "'".$fila_emp['id_usuario']."','".$fila_emp['foto']."','".$fila_emp['estudios']."','".$fila_emp['nu_resol']."', ";
		$sql.= "'".$fila_emp['fecha_resol']."','".$fila_emp['tipo_titulo']."','".$fila_emp['anos_exp']."','".$fila_emp['idiomas_malo']."', ";
		$sql.= "'".$fila_emp['idiomas']."','".$fila_emp['nacionalidad']."','".$fila_emp['telefono2']."','".$fila_emp['telefono3']."', ";
		$sql.= "'".$fila_emp['atencion']."','".$fila_emp['habilitado']."','".$fila_emp['titulado']."','".$fila_emp['tit_otras']."', ";
		$sql.= "'".$fila_emp['habilitado_old']."','".$fila_emp['habilitado_tras']."','".$fila_emp['habilitado_para']."', ";
		$sql.= "'".$fila_emp['nom_foto']."','".$fila_emp['nom_foto2']."','".$fila_emp['hxcontrato']."','".$fila_emp['hxclase']."', ";
		$sql.= "'".$fila_emp['cargo_total']."','".$fila_emp['fecha_nacimiento']."','".$fila_emp['fecha_ingreso']."', ";
		$sql.= "'".$fila_emp['horas_presente_ano']."','".$fila_emp['prevision']."','".$fila_emp['sistema_salud']."', ";
		$sql.= "'".$fila_emp['t_institucion1']."','".$fila_emp['t_institucion2']."','".$fila_emp['t_institucion3']."','".$fila_emp['t_hora1']."', ";
		$sql.= "'".$fila_emp['t_hora2']."','".$fila_emp['t_hora1']."')";
		$rs_apo_new = @pg_exec($_DESTINO,$sql);
		
		$sql = "INSERT INTO trabaja (rdb,rut_emp,fecha_ingreso,fecha_retiro,cargo,identificador) VALUES ('".$fila['rdb']."', ";
		$sql.= "'".$fila['rut_emp']."','".$fila['fecha_ingreso']."','".$fila['fecha_retiro']."','".$fila['cargo']."','".$fila['identificador']."')";
		$rs_trabaja_new = @pg_exec($_DESTINO,$sql);
		
		$sql = "SELECT rut_empleado,id_estudio,nombre,institucion,ano,horas,tipo,orden FROM empleado_estudios WHERE rut_empleado=".$fila['rut_emp'];
		$rs_estudios = @pg_exec($_ORIGEN,$sql);
		
		for($i=0; $i < @pg_numrows($rs_estudios); $i++){
			$fila_est = @pg_fetch_array($rs_estudios,$i);
			$sql = "INSERT INTO empleado_estudios (rut_empleado,id_estudio,nombre,institucion,ano,horas,tipo,orden FROM empleado_estudios) VALUES ( ";
			$sql.= "'".$fila_est['rut_empleado']."','".$fila_est['id_estudio']."','".$fila_est['nombre']."','".$fila_est['institucion']."', ";
			$sql.= "'".$fila_est['ano']."','".$fila_est['horas']."','".$fila_est['tipo']."','".$fila_est['orden']."')";
			$rs_estudios_new = @pg_exec($_DESTINO,$sql);	
		}	
		
	}else{
		echo "<script>window.location = 'Traspaso_Profesor.php' </script>";
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
        <td><span class="Estilo6">Porcentaje del proceso completado: <? echo $porcentaje; ?> %</span></td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='Traspaso_Empleado.php?num=<? echo $num; ?>'");</script>
</body>
</html>