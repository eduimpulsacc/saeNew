<?php require('../../../../../../util/header.inc');
    
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$id_curso		=$_CURSO;
		
	$dd = substr($fecha_ini,0,2);
	$mm = substr($fecha_ini,3,2);
	$aa = substr($fecha_ini,6,4);
	
	$fecha_ini = "$aa$mm$dd";
	
	$dd = substr($fecha_fin,0,2);
	$mm = substr($fecha_fin,3,2);
	$aa = substr($fecha_fin,6,4);
	
	$fecha_fin = "$aa$mm$dd";
	
	
	
	/// verificamos si existe este ramo en la planificacion
	$buscar_ramo = "select * from planificacion where id_ramo = '$id_ramo' and id_periodo = '$id_periodo'";
	$res_buscar = @pg_Exec($conn,$buscar_ramo);
	$num_buscar = @pg_numrows($res_buscar);
	
	if ($num_buscar > 0){
	     /// no ingreso, rescato el id_planificacion
		 $fil_buscar = @pg_fetch_array($res_buscar,0);
		 $id_planificacion = $fil_buscar['id'];
		 
	}else{
	    /// ingreso por que es nuevo
	
		/// guardamos la planificación
		$insertar = "insert into planificacion (rdb,id_ano,id_periodo,id_curso,id_ramo,rut_docente)
		values ('$institucion','$ano','$id_periodo','$id_curso','$id_ramo','$rut_docente')";
		$res_insertar = pg_Exec($conn,$insertar);
		
		/// buscar el último id creado
		$seleccionar = "select * from planificacion order by id Desc limit 1";
		$res_seleccionar = @pg_Exec($conn,$seleccionar);
		$fil_seleccionar = @pg_fetch_array($res_seleccionar,0);
		
		$id_planificacion = $fil_seleccionar['id'];
	}
	
	
	/// inserto en el detalle de la planificacion
	
	$insertar = "insert into detalle_planificacion (id_planificacion, fecha_ini, fecha_fin, titulo, descripcion,realizado, activo)
	values ('$id_planificacion','$fecha_ini','$fecha_fin','$titulo','$descripcion','0','1')";
	$res_insertar = pg_Exec($conn,$insertar);
	
	// vuelvo a la página de planificacion
	echo "<script>window.location='planificacion.php?id_ramo=$id_ramo&cmbPERIODO=$id_periodo'</script>";
		
		
?>
