<? 	require('../../../util/header.inc');
	require('../../../util/header.inc');
	
	if($rb_ORIGEN==1){
		$_ORIGEN = $conn2;
		$_DESTINO = $conn;
	}else{
		$_ORIGEN = $conn;
		$_DESTINO = $conn2;
	}
	if($rb_ELIMINA==1){
		//  DEBE IR A FUNCION DE ELIMINACION DE INSTITUCION
	}else{
		$sql = " SELECT rdb, dig_rdb, nombre_instit, calle, nro, depto, block, villa, region, ciudad, comuna, telefono, fax, email, tipo_instit, ";
		$sql.= " tipo__educ, tipo_regimen, idioma, sexo, metodo, formacion, carta_direccion, proyecto_educativo, reglamento_interno, ";
		$sql.= " nuestra_institucion, proceso_admision, uniforme, insignia, mapa, contacto, img_proyecto, img_uniforme, bool_pae, bool_ca, bool_cp ";
		$sql.= " bool_ws, bool_cpa, bool_ex, emailcp, repcp, emailca, emailws, repws, emailcpa, repcpa, emailex, repex, plan, nu_resolucion, ";
		$sql.= " numero_inst, num_res_ro, fecha_resolucion, letra_inst, fecha_res_ro, dependencia, area_geo, info_colegio, estado_colegio,  ";
		$sql.= " matricula_inicial, proceso_promocion FROM institucion WHERE rdb=".$cmb_colegio;
		$rs_origen = @pg_exec($_ORIGEN,$sql);
		$total_filas = @pg_numrows($rs_origen);
		
		if($num=="") $num=0;
		
		if($num < $total_filas){
			$fila = pg_fetch_array($rs_origen,$num);
			$sql = " INSERT INTO institucion (rdb, dig_rdb, nombre_instit, calle, nro, depto, block, villa, region, ciudad, comuna, telefono, ";
			$sql.= " fax, email, tipo_instit, tipo__educ, tipo_regimen, idioma, sexo, metodo, formacion, carta_direccion, proyecto_educativo, ";
			$sql.= " reglamento_interno, nuestra_institucion, proceso_admision, uniforme, insignia, mapa, contacto, img_proyecto, img_uniforme, ";
			$sql.= " bool_pae, bool_ca, bool_cp bool_ws, bool_cpa, bool_ex, emailcp, repcp, emailca, emailws, repws, emailcpa, repcpa, emailex, ";
			$sql.= " repex, plan, nu_resolucion, numero_inst, num_res_ro, fecha_resolucion, letra_inst, fecha_res_ro, dependencia, area_geo, ";
			$sql.= " info_colegio, estado_colegio, matricula_inicial, proceso_promocion) VALUES ";
			$sql.= " ('".$fila['rdb']."','".$fila['dig_rdb']."','".$fila['nombre_instit']."','".$fila['calle']."','".$fila['nro']."', ";
			$sql.= " '".$fila['depto']."','".$fila['block']."','".$fila['villa']."','".$fila['region']."','".$fila['ciudad']."', ";
			$sql.= " '".$fila['comuna']."','".$fila['telefono']."', '".$fila['fax']."', '".$fila['email']."', '".$fila['tipo_instit']."', ";
			$sql.= " '".$fila['tipo_regimen']."', '".$fila['idioma']."','".$fila['sexo']."','".$fila['metodo']."', '".$fila['formacion']."', ";
			$sql.= " '".$fila['carta_direccion']."', '".$fila['proyecto_educativo']."', '".$fila['reglamento_interno']."', ";
			$sql.= " '".$fila['nuestra_institucion']."','".$fila['']."','".$fila['proceso_admision']."','".$fila['uniforme']."', ";
			$sql.= " '".$fila['insignia']."','".$fila['mapa']."','".$fila['contacto']."','".$fila['img_proyecto']."','".$fila['img_uniforme']."', ";
			$sql.= " '".$fila['bool_pae']."', '".$fila['bool_ca']."','".$fila['bool_cp']."','".$fila['bool_ws']."','".$fila['bool_cpa']."', ";
			$sql.= " '".$fila['bool_ex']."','".$fila['emailcp']."','".$fila['repcp']."','".$fila['emailca']."','".$fila['emailws']."', ";
			$sql.= " '".$fila['repws']."','".$fila['emailcpa']."','".$fila['repcpa']."','".$fila['emailex']."','".$fila['repex']."', ";
			$sql.= " '".$fila['plan']."','".$fila['nu_resolucion']."','".$fila['numero_inst']."','".$fila['num_res_ro']."', ";
			$sql.= " '".$fila['fecha_resolucion']."','".$fila['letra_inst']."','".$fila['fecha_res_ro']."','".$fila['dependencia']."', ";
			$sql.= " '".$fila['area_geo']."','".$fila['info_colegio']."','".$fila['estado_colegio']."','".$fila['matricula_inicial']."', ";
			$sql.= " '".$fila['proceso_promocion']."' )";
			$rs_insert = @pg_exec($destino,$sql);
			
			$sql = "DELETE FROM institucion WHERE rdb=".$cmb_colegio;
			$rs_delete = @pg_exec($_ORIGEN,$sql);
		}else{
			echo "<script>window.location = 'Traspaso_AnoEscolar.php' </script>";
		}
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
<input name="indice" type="hidden" value="<? echo $num+1; ?>">
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
        <td><B>Porcentaje del proceso completado: <? echo $porcentaje; ?> %</B></td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='Traspaso_Institucion.php?num=<? echo $num; ?>'");</script>
</body>
</html>
