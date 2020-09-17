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
	$qry="SELECT MAX(ID_PERIODO) AS CANT FROM QUIZ_PERIODOS";
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
		
		
		$qry="INSERT INTO QUIZ_PERIODOS (ID_PERIODO, NOMBRE_PERIODO, FECHA_INICIO, FECHA_TERMINO, ID_ANO, CERRADO, POSICION_NOTA
	) VALUES 
		(".$newID.",'".$txtPER."','".$txtFECHAINI."','".$txtFECHATER."',".$ano.",0,'".$txtPOSICION."')";
		
		
				
		$result =@pg_Exec($conn,$qry);
		
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)');
		}else{
			echo "<script>window.location = 'listarPeriodoQuiz.php'</script>";
		}
	}
}
if ($frmModo=="modificar") {

$qry="UPDATE QUIZ_PERIODOS SET nombre_periodo = '".$txtPER."', 
fecha_inicio = '".$txtFECHAINI."', fecha_termino = '".$txtFECHATER."', POSICION_NOTA = ".$txtPOSICION." 
WHERE id_periodo=".$_PERIODO;

	
	$result =@pg_Exec($conn,$qry) or die (pg_last_error($conn));


	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
	}else{
		echo "<script>window.location = 'seteaPeriodo.php3?caso=1&periodo=".$_PERIODO."'</script>";
	}
}

if ($frmModo=="eliminar") {
	
	//verificar primero si tengo notas ingresadas
	 $qry1 ="select count(*) as conteo from quiz_notas where ID_PERIODO=".$_PERIODO;
	$result1 =@pg_Exec($conn,$qry1);
	$fila1 = @pg_fetch_array($result1,0);	
	
	if($fila1['conteo']<=0){
	
	$qry="DELETE FROM QUIZ_PERIODOS WHERE ID_PERIODO=".$_PERIODO;
	
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al eliminar.'.$qry);
		}else{
			echo "<script>
			alert('Periodo eliminado correctamente');
			window.location = 'listarPeriodoQuiz.php'</script>";
		}
	
	}else{
		echo "<script>
			alert('Periodo se encuentra con notas ingresadas, por lo tanto no puede ser eliminado');
			window.location = 'listarPeriodoQuiz.php'</script>";
		
	}
	
}
/*echo "<script>window.location = 'listarPeriodoQuiz.php'</script>";*/
?>