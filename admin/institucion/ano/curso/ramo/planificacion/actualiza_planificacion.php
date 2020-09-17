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
	
	
	/// actualizo la planificacion	
	$actualizar = "update detalle_planificacion set fecha_ini = '$fecha_ini', fecha_fin = '$fecha_fin', titulo = '$titulo' , descripcion = '$descripcion', realizado = '$realizado' where id = '$id_detalle'";
	$res_actualizar = pg_Exec($conn,$actualizar);
	
	
	// vuelvo a la página de planificacion
	echo  "<script>window.location='planificacion.php?id_ramo=$id_ramo&cmbPERIODO=$id_periodo'</script>";
		
		
?>
