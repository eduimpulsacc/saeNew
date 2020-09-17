<?
require('../../../../../util/header.inc');

	setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
	$ensenanza_post = substr($grado_post,1,3);
	$grado_post = substr($grado_post,0,1);
	$region_post = substr($comuna_post,0,2);
	$provincia_post = substr($comuna_post,2,2);
	$comuna_post = substr($comuna_post,4,2);
	//-------------------------------------------

	if($id_post>0)
	{
		$nuevo = 2; // Modificar
	}
	else
	{
		$nuevo = 1; // Agregar Registro
	}
		
	//-------------------------------------------
	if ($nuevo == 1)
	{
		$sql_consul = "select max(folio_post) as cantidad from postulacion where rdb = ".$institucion." and id_ano = ".$id_ano.";";
		$result_consul =@pg_Exec($conn,$sql_consul);
		$fila_consul = @pg_fetch_array($result_consul,0);
		if ($fila_consul['cantidad'] > 0)
		{
			$folio_post = $fila_consul['cantidad']+1;
		}
		else
		{
			$folio_post = 1;
		}

		$sql_existe = "select max(id_post) as contador from postulacion";
		$result_existe =@pg_Exec($conn,$sql_existe);		 
		$fila_existe = @pg_fetch_array($result_existe,0);
		if ($fila_existe['contador']>0)
			$id_post = $fila_existe['contador']+1; 
		else
			$fila_existe['contador'] = 1;

		//-------	
		$sql_insert = "insert into postulacion (id_post, rdb, id_ano, folio_post) values (".$id_post.",".$institucion.",".$id_ano.",".$folio_post.");";
		$result_insert =@pg_Exec($conn,$sql_insert);
		//--------
		$sql_update = "update postulacion set ";
		$sql_update = $sql_update . "id_post = '".$id_post."', ";
		$sql_update = $sql_update . "rdb = '".$institucion."', ";
		$sql_update = $sql_update . "grado_post = '".$grado_post."', ";
		$sql_update = $sql_update . "ensenanza_post = '".$ensenanza_post."', ";
		$sql_update = $sql_update . "id_ano = '".$id_ano."', ";
		$sql_update = $sql_update . "ape_pat_post = '".$ape_pat_post."', ";
		$sql_update = $sql_update . "ape_mat_post = '".$ape_mat_post."', ";
		$sql_update = $sql_update . "nombre_post = '".$nombre_post."', ";
		$sql_update = $sql_update . "nacionalidad_post = '".$nacionalidad_post."', ";
	  	if(checkdate(substr($fecha_nac_post,3,2),substr($fecha_nac_post,0,2),substr($fecha_nac_post,6,4)))		
			$sql_update = $sql_update . "fecha_nac_post = '".$fecha_nac_post."', ";
		$sql_update = $sql_update . "rut_post = '".$rut_post."', ";
		$sql_update = $sql_update . "dig_rut_post = '".$dig_rut_post."', ";
		$sql_update = $sql_update . "calle_post = '".$calle_post."', ";
		$sql_update = $sql_update . "nro_post = '".$nro_post."', ";
		$sql_update = $sql_update . "comuna_post = '".$comuna_post."', ";
		$sql_update = $sql_update . "telefono_post = '".$telefono_post."', ";
		$sql_update = $sql_update . "provincia_post = '".$provincia_post."', ";
		$sql_update = $sql_update . "region_post = '".$region_post."', ";
		$sql_update = $sql_update . "parientes = '".$parientes."', ";
		$sql_update = $sql_update . "nro_hijos = '".$nro_hijos."', ";
		$sql_update = $sql_update . "nro_hijas = '".$nro_hijas."', ";
		$sql_update = $sql_update . "lugar_ocupa = '".$lugar_ocupa."', ";
		$sql_update = $sql_update . "colegio_hermanos = '".$colegio_hermanos."', ";
		$sql_update = $sql_update . "procedencia_post = '".$procedencia_post."', ";
		$sql_update = $sql_update . "otros_colegios_post = '".$otros_colegios_post."', ";
		$sql_update = $sql_update . "ape_pat_padre = '".$ape_pat_padre."', ";
		$sql_update = $sql_update . "ape_mat_padre = '".$ape_mat_padre."', ";
		$sql_update = $sql_update . "nombre_padre = '".$nombre_padre."', ";
	  	if(checkdate(substr($fecha_nac_padre,3,2),substr($fecha_nac_padre,0,2),substr($fecha_nac_post,6,4)))				
			$sql_update = $sql_update . "fecha_nac_padre = '".$fecha_nac_padre."', ";
		$sql_update = $sql_update . "estudios_secundarios_padre = '".$estudios_secundarios_padre."', ";
		$sql_update = $sql_update . "estudios_superiores_padre = '".$estudios_superiores_padre."', ";
		$sql_update = $sql_update . "profesion_actividad_padre = '".$profesion_actividad_padre."', ";
		$sql_update = $sql_update . "empresa_padre = '".$empresa_padre."', ";
		$sql_update = $sql_update . "telefono_oficina_padre = '".$telefono_oficina_padre."', ";
		$sql_update = $sql_update . "celular_padre = '".$celular_padre."', ";
		$sql_update = $sql_update . "cargo_padre = '".$cargo_padre."', ";
		$sql_update = $sql_update . "ape_pat_madre = '".$ape_pat_madre."', ";
		$sql_update = $sql_update . "ape_mat_madre = '".$ape_mat_madre."', ";
		$sql_update = $sql_update . "nombre_madre = '".$nombre_madre."', ";
	  	if(checkdate(substr($fecha_nac_madre,3,2),substr($fecha_nac_madre,0,2),substr($fecha_nac_madre,6,4)))						
			$sql_update = $sql_update . "fecha_nac_madre = '".fEs2En($fecha_nac_madre)."', ";
		$sql_update = $sql_update . "estudios_secundarios_madre = '".$estudios_secundarios_madre."', ";
		$sql_update = $sql_update . "estudios_superiores_madre = '".$estudios_superiores_madre."', ";
		$sql_update = $sql_update . "profesion_actividad_madre = '".$profesion_actividad_madre."', ";
		$sql_update = $sql_update . "empresa_madre = '".$empresa_madre."', ";
		$sql_update = $sql_update . "telefono_oficina_madre = '".$telefono_oficina_madre."', ";
		$sql_update = $sql_update . "celular_madre = '".$celular_madre."', ";
		$sql_update = $sql_update . "cargo_madre = '".$cargo_madre."', ";
		$sql_update = $sql_update . "vive_con = '".$vive_con."', ";
		$sql_update = $sql_update . "situacion_padres = '".$situacion_padres."', ";
		$sql_update = $sql_update . "psicologo = '".$psicologo."', ";
		$sql_update = $sql_update . "neurologo = '".$neurologo."', ";
		$sql_update = $sql_update . "psiquiatra = '".$psiquiatra."', ";
		$sql_update = $sql_update . "otros_especia = '".$otros_especia."', ";
	  	if(checkdate(substr($fecha_ultima_especia,3,2),substr($fecha_ultima_especia,0,2),substr($fecha_ultima_especia,6,4)))								
			$sql_update = $sql_update . "fecha_ultima_especia = '".fEs2En($fecha_ultima_especia)."', ";
		$sql_update = $sql_update . "nombre_especialista_especia = '".$nombre_especialista_especia."', ";
		$sql_update = $sql_update . "motivo_especia = '".$motivo_especia."', ";
		$sql_update = $sql_update . "oido = '".$oido."', ";
		$sql_update = $sql_update . "vista = '".$vista."', ";
		$sql_update = $sql_update . "lenguaje = '".$lenguaje."', ";
		$sql_update = $sql_update . "otros_pediatra = '".$otros_pediatra."', ";
	  	if(checkdate(substr($fecha_ultima_pediatra,3,2),substr($fecha_ultima_pediatra,0,2),substr($fecha_ultima_pediatra,6,4)))										
			$sql_update = $sql_update . "fecha_ultima_pediatra = '".fEs2En($fecha_ultima_pediatra)."', ";
		$sql_update = $sql_update . "nombre_especialista_pediatra = '".$nombre_especialista_pediatra."', ";
		$sql_update = $sql_update . "motivo_pediatra = '".$motivo_pediatra."', ";
		$sql_update = $sql_update . "razones = '".$razones."', ";
		$sql_update = $sql_update . "descripcion = '".$descripcion."', ";
		$sql_update = $sql_update . "inscribiente = '".$inscribiente."', ";
		$sql_update = $sql_update . "folio_post = '".$folio_post."', ";
		$sql_update = $sql_update . "estado = ".$estado." ";		
		$sql_update = $sql_update . "where id_post = ".$id_post;
		$result_update =@pg_Exec($conn,$sql_update);	
		if (!$result_update)
			echo "ERROR"."<br><br>".$sql_update;
		else
			echo "<script>window.location = 'VerFichaPostulacion.php?id_post=".$id_post."'</script>";
	}
	else
	{
		$sql_update = "update postulacion set ";
		$sql_update = $sql_update . "id_post = '".$id_post."', ";
		$sql_update = $sql_update . "rdb = '".$institucion."', ";
		$sql_update = $sql_update . "grado_post = '".$grado_post."', ";
		$sql_update = $sql_update . "ensenanza_post = '".$ensenanza_post."', ";
		$sql_update = $sql_update . "id_ano = '".$id_ano."', ";
		$sql_update = $sql_update . "ape_pat_post = '".$ape_pat_post."', ";
		$sql_update = $sql_update . "ape_mat_post = '".$ape_mat_post."', ";
		$sql_update = $sql_update . "nombre_post = '".$nombre_post."', ";
		$sql_update = $sql_update . "nacionalidad_post = '".$nacionalidad_post."', ";
	  	if(checkdate(substr($fecha_nac_post,3,2),substr($fecha_nac_post,0,2),substr($fecha_nac_post,6,4)))		
			$sql_update = $sql_update . "fecha_nac_post = '".$fecha_nac_post."', ";
		$sql_update = $sql_update . "rut_post = '".$rut_post."', ";
		$sql_update = $sql_update . "dig_rut_post = '".$dig_rut_post."', ";
		$sql_update = $sql_update . "calle_post = '".$calle_post."', ";
		$sql_update = $sql_update . "nro_post = '".$nro_post."', ";
		$sql_update = $sql_update . "comuna_post = '".$comuna_post."', ";
		$sql_update = $sql_update . "telefono_post = '".$telefono_post."', ";
		$sql_update = $sql_update . "provincia_post = '".$provincia_post."', ";
		$sql_update = $sql_update . "region_post = '".$region_post."', ";
		$sql_update = $sql_update . "parientes = '".$parientes."', ";
		$sql_update = $sql_update . "nro_hijos = '".$nro_hijos."', ";
		$sql_update = $sql_update . "nro_hijas = '".$nro_hijas."', ";
		$sql_update = $sql_update . "lugar_ocupa = '".$lugar_ocupa."', ";
		$sql_update = $sql_update . "colegio_hermanos = '".$colegio_hermanos."', ";
		$sql_update = $sql_update . "procedencia_post = '".$procedencia_post."', ";
		$sql_update = $sql_update . "otros_colegios_post = '".$otros_colegios_post."', ";
		$sql_update = $sql_update . "ape_pat_padre = '".$ape_pat_padre."', ";
		$sql_update = $sql_update . "ape_mat_padre = '".$ape_mat_padre."', ";
		$sql_update = $sql_update . "nombre_padre = '".$nombre_padre."', ";
	  	if(checkdate(substr($fecha_nac_padre,3,2),substr($fecha_nac_padre,0,2),substr($fecha_nac_post,6,4)))				
			$sql_update = $sql_update . "fecha_nac_padre = '".$fecha_nac_padre."', ";
		$sql_update = $sql_update . "estudios_secundarios_padre = '".$estudios_secundarios_padre."', ";
		$sql_update = $sql_update . "estudios_superiores_padre = '".$estudios_superiores_padre."', ";
		$sql_update = $sql_update . "profesion_actividad_padre = '".$profesion_actividad_padre."', ";
		$sql_update = $sql_update . "empresa_padre = '".$empresa_padre."', ";
		$sql_update = $sql_update . "telefono_oficina_padre = '".$telefono_oficina_padre."', ";
		$sql_update = $sql_update . "celular_padre = '".$celular_padre."', ";
		$sql_update = $sql_update . "cargo_padre = '".$cargo_padre."', ";
		$sql_update = $sql_update . "ape_pat_madre = '".$ape_pat_madre."', ";
		$sql_update = $sql_update . "ape_mat_madre = '".$ape_mat_madre."', ";
		$sql_update = $sql_update . "nombre_madre = '".$nombre_madre."', ";
	  	if(checkdate(substr($fecha_nac_madre,3,2),substr($fecha_nac_madre,0,2),substr($fecha_nac_madre,6,4)))						
			$sql_update = $sql_update . "fecha_nac_madre = '".fEs2En($fecha_nac_madre)."', ";
		$sql_update = $sql_update . "estudios_secundarios_madre = '".$estudios_secundarios_madre."', ";
		$sql_update = $sql_update . "estudios_superiores_madre = '".$estudios_superiores_madre."', ";
		$sql_update = $sql_update . "profesion_actividad_madre = '".$profesion_actividad_madre."', ";
		$sql_update = $sql_update . "empresa_madre = '".$empresa_madre."', ";
		$sql_update = $sql_update . "telefono_oficina_madre = '".$telefono_oficina_madre."', ";
		$sql_update = $sql_update . "celular_madre = '".$celular_madre."', ";
		$sql_update = $sql_update . "cargo_madre = '".$cargo_madre."', ";
		$sql_update = $sql_update . "vive_con = '".$vive_con."', ";
		$sql_update = $sql_update . "situacion_padres = '".$situacion_padres."', ";
		$sql_update = $sql_update . "psicologo = '".$psicologo."', ";
		$sql_update = $sql_update . "neurologo = '".$neurologo."', ";
		$sql_update = $sql_update . "psiquiatra = '".$psiquiatra."', ";
		$sql_update = $sql_update . "otros_especia = '".$otros_especia."', ";
	  	if(checkdate(substr($fecha_ultima_especia,3,2),substr($fecha_ultima_especia,0,2),substr($fecha_ultima_especia,6,4)))								
			$sql_update = $sql_update . "fecha_ultima_especia = '".fEs2En($fecha_ultima_especia)."', ";
		$sql_update = $sql_update . "nombre_especialista_especia = '".$nombre_especialista_especia."', ";
		$sql_update = $sql_update . "motivo_especia = '".$motivo_especia."', ";
		$sql_update = $sql_update . "oido = '".$oido."', ";
		$sql_update = $sql_update . "vista = '".$vista."', ";
		$sql_update = $sql_update . "lenguaje = '".$lenguaje."', ";
		$sql_update = $sql_update . "otros_pediatra = '".$otros_pediatra."', ";
	  	if(checkdate(substr($fecha_ultima_pediatra,3,2),substr($fecha_ultima_pediatra,0,2),substr($fecha_ultima_pediatra,6,4)))										
			$sql_update = $sql_update . "fecha_ultima_pediatra = '".fEs2En($fecha_ultima_pediatra)."', ";
		$sql_update = $sql_update . "nombre_especialista_pediatra = '".$nombre_especialista_pediatra."', ";
		$sql_update = $sql_update . "motivo_pediatra = '".$motivo_pediatra."', ";
		$sql_update = $sql_update . "razones = '".$razones."', ";
		$sql_update = $sql_update . "descripcion = '".$descripcion."', ";
		$sql_update = $sql_update . "inscribiente = '".$inscribiente."', ";
		$sql_update = $sql_update . "estado = ".$estado." ";				
		$sql_update = $sql_update . "where id_post = ".$id_post;
		$result_update =@pg_Exec($conn,$sql_update);	
		if (!$result_update)
			echo "ERROR"."<br><br>".$sql_update;
		else
			echo "<script>window.location = 'VerFichaPostulacion.php?id_post=".$id_post."'</script>";
	}
	
	pg_close($conn);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

</body>
</html>
