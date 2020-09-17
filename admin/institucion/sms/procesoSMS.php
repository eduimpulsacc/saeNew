<?php
require('../../../util/header.inc');

foreach($_SESSION as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
 //  echo $asignacion."<br>";
}

 	$frmModo		=$_FRMMODO;
if ($frmModo=="ingresar") {
	
	 $sql1="update sms_config set estado=0 where rdb=$_INSTIT";
	@$rs1=pg_exec($conn,$sql1);
	
	 $sql="insert into sms_config(rdb,cantidad,fecha_habilitacion,fecha_caducidad,saldo,estado) values($_INSTIT,$cant_sms,'".CambioFE($fecha_hab)."','".CambioFE($fecha_cad)."',$cant_sms,1)";
	$rs1=pg_exec($conn,$sql);
	
}
	
	echo "<script>window.location = 'seteaSMS.php?caso=1'</script>";
?>