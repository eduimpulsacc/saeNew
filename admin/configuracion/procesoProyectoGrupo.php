<?	require('../../util/header.inc');

$institucion	= $_INSTIT;



if($caso==1){ // ELIMINAR
	$sql = "DELETE FROM proyecto_grupo WHERE rdb = ".$institucion." AND id_proy=".$id_pro;
	$rs_proyecto = @pg_exec($conn,$sql);

}
if($caso==2){ //MODIFICAR
	$sql ="UPDATE proyecto_grupo SET rut_emp=".$cmbEMPLEADO.", nombre='".$txtNOMBRE."', objetivo='".$txtOBJETIVO."', tipo=".$cmbTIPO." WHERE  rdb = ".$institucion." AND  id_proy=".$id_pro;
	$rs_proyecto = @pg_exec($conn,$sql);
}

if($caso==3){ // AGREGAR
	$sql = "INSERT INTO proyecto_grupo (rdb,rut_emp,nombre,objetivo,tipo) VALUES (".$institucion.",".$cmbEMPLEADO.",'".$txtNOMBRE."','".$txtOBJETIVO."',".$cmbTIPO.")";
	$rs_proyecto = @pg_exec($conn,$sql);
}

echo "<script>window.location='listaProyectoGrupo.php'</script>";

 pg_close($conn);?>