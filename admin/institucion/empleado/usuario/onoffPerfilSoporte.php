 <?php require('../../../../util/header.inc'); ?>
<?php

	$usuario = $_GET['idusuario'];
	"<br>".$perfil = $_GET['id_perfil'];
	"<br>".$_INSTIT = $_GET['rdb'];
	"<br>".$servidor = $_GET['servidor'];
	"<br>".$estado = $_GET['estado'];
	"<br>".$accion = $_GET['accion'];
	

	if($estado==0){
		$qry="UPDATE ACCEDE SET ESTADO=1 WHERE ID_USUARIO=".$usuario." AND ID_PERFIL=".$perfil." AND RDB=".$_INSTIT;
		$result =@pg_Exec($conn2,$qry);
	}

	if($estado==1){
		$qry="UPDATE ACCEDE SET ESTADO=0 WHERE ID_USUARIO=".$usuario." AND ID_PERFIL=".$perfil." AND RDB=".$_INSTIT;
		$result =@pg_Exec($conn2,$qry);
	}
	
	if($accion==3){
		$qry = "DELETE FROM accede WHERE id_usuario=".$usuario." AND id_perfil=".$perfil." AND rdb=".$_INSTIT."";
		$result = @pg_Exec($conn2,$qry);
	}
	
	if($servidor=="murialdo"){
		 echo "<script>window.location = 'http://190.162.116.194/admin/institucion/empleado/empleado.php3?pesta=4'</script>";	
		 }
		 
	if($servidor=="antofagasta"){
		 echo "<script>window.location = 'http://www.cmds.cl/admin/institucion/empleado/empleado.php3?pesta=4'</script>";	
		 }	
		 
	if($servidor=="zapallar"){
		 echo "<script>window.location = 'http://200.29.22.36/admin/institucion/empleado/empleado.php3?pesta=4'</script>";	
		 }	 
	
	
?>