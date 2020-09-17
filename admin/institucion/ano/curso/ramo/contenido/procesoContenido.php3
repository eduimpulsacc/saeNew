<?php require('../../../../../../util/header.inc');?>

<?php
 	$frmModo		=$_FRMMODO;

	if ($frmModo=="ingresar") {

	
	$largo = strlen($_FILES['txtUPLOAD']['name']) ;
	
	if($largo==0){
		
	//	echo "Error en el Archivo";
		 	
		/*//echo "<script>window.location = 'listarContenidos.php3'</script>";
		//	$txtNOMBRE = sanear_string(trim($txtDESCRIPCION));
		//return;	*/	
		
		}
		
	
	  // $tamano_archivo = $HTTP_POST_FILES['txtUPLOAD']['size']; 
		$tamano_archivo = $_FILES["txtUPLOAD"]["size"];
	/*  echo "Nombre: " . $_FILES['txtUPLOAD']['name'] . "<br>";
	  echo "Tipo: " . $_FILES['txtUPLOAD']['type'] . "<br>";
	  echo "Tamaño: " . ($_FILES["txtUPLOAD"]["size"] / 1024) . " kB<br>";
	  echo "Carpeta temporal: " . $_FILES['txtUPLOAD']['tmp_name'];

	  exit;*/
	   if($tamano_archivo < 10485760)
	   {

		
		$qry="SELECT MAX(ID_ARCHIVO) AS CANT FROM ARCHIVO";
		$result =@pg_Exec($conn,$qry);
		$fila = @pg_fetch_array($result,0);
		
	$txtNOMBRE = sanear_string(trim($_FILES['txtUPLOAD']['name']));
		
	$EXT = $_FILES['txtUPLOAD']['type'];
	
	
	$largo = strlen($txtNOMBRE);

	if($_PERFIL==0){
		//echo $EXT;
		//exit;
	}
		
	if( 
	$EXT == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' or 
	$EXT == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' or
	$EXT == 'application/vnd.openxmlformats-officedocument.presentationml.presentation' or 
	$EXT == 'application/vnd.openxmlformats-officedocument.presentationml.slideshow' or
	$EXT == 'application/octet-stream' 
	 )
	{
		$hasta = $largo - 5;
		
		}else{
			
			$hasta = $largo - 4;
			
			}	
	
	    $nombrearchivo = trim(substr($txtNOMBRE,0,$hasta));
		$iniext = $hasta;
        $extencion = substr($txtNOMBRE,$iniext,$largo);
		 
		$newID = trim($fila['cant']);
		$newID++;
		
		$ip = $_SERVER['REMOTE_ADDR'];
		$usuario = $_NOMBREUSUARIO;
		
		$txtNOMBRE=($largo>0)?trim($txtNOMBRE):"";

		$txtDESCRIPCION = (strlen($txtDESCRIPCION)>0)?trim($txtDESCRIPCION):" ";
		
		$txtTITULO = (strlen($txtTITULO)>0)?trim($txtTITULO):" ";
		
		$txtFECHAENTREGA = (strlen($txtFECHAENTREGA)>0)?"'".CambioFE($txtFECHAENTREGA)."'":"null";
		
$qry="INSERT INTO ARCHIVO ( NOMBRE_ARCHIVO, DESCRIPCION_ARCHIVO, USUARIO, IP, WEB1, WEB2, WEB3,TITULO,FECHA_ENTREGA) 
VALUES ('".trim($txtNOMBRE)."','".$txtDESCRIPCION."','".$usuario."','".$ip."','".trim($txtWEB1)."','".trim($txtWEB2)."','".trim($txtWEB3)."','$txtTITULO',$txtFECHAENTREGA)";


//año escolar
$sql_nano = "SELECT NRO_ANO FROM ANO_ESCOLAR WHERE ID_ANO=".$_ANO;
$rs_nano = pg_exec($conn,$sql_nano) or die (pg_last_error($conn));
$nano = pg_result($rs_nano,0);




if($_PERFIL==0){
	//	echo $qry;
		//exit;
	}

		$result = pg_Exec($conn,$qry) or die (pg_last_error($conn));
		
		$qry2 = "select id_archivo from archivo order by id_archivo desc limit 1";
		$r2   = pg_Exec($conn,$qry2);
		$f2   = pg_fetch_array($r2,0);
		
		
		$sql   = "SELECT nro_ano FROM ano_escolar WHERE id_ano = ".$_ANO." ";
		$reg  = pg_Exec($conn,$sql);
		$fila  = pg_fetch_array($reg,0);
		$numero_ano = $fila['nro_ano'];		
		
	    $idarchivo = $f2['id_archivo'];	
		
		$archivofinal = ($largo>0)?"$nombrearchivo"."_"."$idarchivo"."_"."$numero_ano"."$extencion":"";
				
		$qry3="update archivo set nombre_archivo = '$archivofinal' ,TITULO='$txtTITULO', FECHA_ENTREGA =$txtFECHAENTREGA where id_archivo = '$idarchivo'";
		$r3  = pg_Exec($conn,$qry3);		
		
				
$file = $txtUPLOAD;
//$file = $_FILES['txtUPLOAD']['name'];


 $newfile = "../../../../../../tmp/$archivofinal";


if (!copy($file, $newfile)) {
	$error="No se puede subir el archivo";
}

		
//	chmod($txtUPLOAD,"700");
//	$query = "UPDATE ARCHIVO SET ARCHIVO=lo_import('".$txtUPLOAD."') WHERE ID_ARCHIVO=".$newID;
//	$result = pg_exec($conn, $query);

  	$qry="INSERT INTO ADJUNTA (ID_ARCHIVO,ID_RAMO) VALUES (".$newID.",".$ramo_new.")";
	$result =@pg_Exec($conn,$qry);
	
	
	//guardamos loa slumnos  para el archivo
	$sql_insarcchivo ="insert into archivo_alumno_visto".$nano."  (id_archivo,rut_alumno) (select ".$newID.",rut_alumno from tiene".$nano." where id_ramo = ".$_RAMO." and rut_alumno IN
(select rut_alumno from matricula where id_curso  = ".$_CURSO." and bool_ar=0))";
$result_insarchivo =@pg_Exec($conn,$sql_insarcchivo);
	
	}// tamaño de archivo .
	

 	echo "<script>window.location = 'listarContenidos.php3'</script>";
	
		   
	   }  //fin de ingresar 
	   
	   
	

	if ($frmModo=="modificar"){
		
		$txtTITULO = (strlen($txtTITULO)>0)?trim($txtTITULO):" ";
		
		$txtFECHAENTREGA = (strlen($txtFECHAENTREGA)>0)?CambioFE($txtFECHAENTREGA):"";
		
	 	$query = "UPDATE ARCHIVO SET DESCRIPCION_ARCHIVO='".trim($txtDESCRIPCION)."',WEB1='".trim($txtWEB1)."', WEB2='".trim($txtWEB2)."', WEB3='".trim($txtWEB3)."',TITULO='$txtTITULO' ,FECHA_ENTREGA ='$txtFECHAENTREGA' WHERE ID_ARCHIVO=".$_ARCHIVO;
		$result = pg_exec($conn, $query);
		echo "<script>window.location = 'seteaContenido.php3?caso=1&archivo=".$_ARCHIVO."'</script>";
	}

	if ($frmModo=="eliminar") {
		$qry="DELETE FROM ARCHIVO WHERE ID_ARCHIVO=".$_ARCHIVO;
		$result =@pg_Exec($conn,$qry);
		
		$qry="DELETE FROM adjunta WHERE ID_ARCHIVO=".$_ARCHIVO." AND id_ramo=".$ramo_new;
		$result =@pg_Exec($conn,$qry);
		
		
		$qry="DELETE FROM archivo_alumno_visto WHERE ID_ARCHIVO=".$_ARCHIVO." AND id_ramo=".$ramo_new;
		$result =@pg_Exec($conn,$qry);
		
		echo "<script>window.location = 'listarContenidos.php3'</script>";
	}
?>