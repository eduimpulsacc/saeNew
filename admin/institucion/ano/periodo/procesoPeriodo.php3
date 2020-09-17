<?php require('../../../../util/header.inc');?> 
<?php
 	$frmModo		=$_FRMMODO;
	
	
	

/*if(pg_dbname($conn)== "coi_antofagasta" ){ 
	$txtFECHAINI = ($txtFECHAINI);
 	$txtFECHATER = ($txtFECHATER);
}else {*/ 
	$txtFECHAINI = fEs2En($txtFECHAINI);
	$txtFECHATER = fEs2En($txtFECHATER);
//} 
		  

if ($frmModo=="ingresar") {
	$qry="SELECT MAX(ID_PERIODO) AS CANT FROM PERIODO";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}else{
		$fila = @pg_fetch_array($result,0);	
		if (!$fila){
			error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			//exit();
		}
		$newID = trim($fila[0]);
		$newID++;
		
		
		$qry="INSERT INTO PERIODO (ID_PERIODO, NOMBRE_PERIODO, FECHA_INICIO, FECHA_TERMINO, ID_ANO,    
		MOSTRAR_NOTAS,DIAS_HABILES, CERRADO) VALUES 
		(".$newID.",'".$txtPER."','".$txtFECHAINI."','".$txtFECHATER."',".$ano.",1,".$txtHABIL.",0)";
		
		
				
		$result =@pg_Exec($conn,$qry);
		
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)');
		}else{
			echo "<script>window.location = 'listarPeriodo.php3'</script>";
		}
	}
}
if ($frmModo=="modificar") {

$qry="UPDATE periodo SET nombre_periodo = '".$txtPER."', 
fecha_inicio = '".$txtFECHAINI."', fecha_termino = '".$txtFECHATER."', 
dias_habiles = ".$txtHABIL." 
WHERE (((id_periodo)=".$_PERIODO."))";
	
	$result =@pg_Exec($conn,$qry) or die (pg_last_error($conn));


	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
	}else{
	/*	echo "<script>window.location = 'seteaPeriodo.php3?caso=1&periodo=".$_PERIODO."'</script>";*/
	}
}

if ($frmModo=="eliminar") {
	$qry="DELETE FROM PERIODO WHERE ID_PERIODO=".$_PERIODO;
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al eliminar.'.$qry);
	}else{
		echo "<script>window.location = 'listarPeriodo.php3'</script>";
	}
}
echo "<script>window.location = 'listarPeriodo.php3'</script>";
?>