<?php require('../../../../../../util/header.inc');?>
<?php
	echo $frmModo		=$_FRMMODO;
	exit;

if($chkSOS=="") $chkSOS=0;

if($chkRESP=="")
	$chkRESP=0;
	else{
		$qry="SELECT apoderado.rut_apo FROM alumno INNER JOIN (apoderado INNER JOIN tiene2 ON apoderado.rut_apo = tiene2.rut_apo) ON alumno.rut_alumno = tiene2.rut_alumno WHERE (((alumno.rut_alumno)='".$_ALUMNO."'))";
		$result =@pg_Exec($conn,$qry);
		for($i=0;$i<@pg_numrows($result);$i++){
			$fila = @pg_fetch_array($result,0);
			$qry="UPDATE TIENE2 SET RESPONSABLE=0 WHERE RUT_ALUMNO='".$_ALUMNO."' " ;
			$result =@pg_Exec($conn,$qry);
		}
	}
if($txtREG=="")
	$txtREG=1;
if($txtCIU=="")
	$txtCIU=1;
if($txtCOM=="")
	$txtCOM=1;


if ($frmModo=="ingresar"){
	//VERIFICAR EXISTENCIA PREVIA
	$qry="SELECT * FROM APODERADO WHERE RUT_APO='".trim($txtRUT)."'";
	$result =@pg_Exec($conn,$qry);
	if (!$result){error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if(pg_numrows($result)!=0){
				$qry="UPDATE apoderado SET nombre_apo = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".trim($txtREG).", ciudad = ".trim($txtCIU).", comuna = ".trim($txtCOM).", telefono = '".trim($txtTELEF)."', relacion = ".trim($cmbRELACION).", email = '".trim($txtEMAIL)."', celular = '".$txtCelular."', nivel_edu = '".$nivel_edu."', profesion = '".$profesion."', lugar_trabajo = '".$lugar_trabajo."', cargo = '".$cargo."' WHERE (((rut_apo)='".$txtRUT."'))";
				$result =@pg_Exec($conn,$qry);
				if(!$result){
					error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
				}else{
					$qry="SELECT * FROM TIENE2 WHERE RUT_APO=".$txtRUT." AND RUT_ALUMNO='".trim($_ALUMNO)."'";
					$result =@pg_Exec($conn,$qry);
					if(!$result){
						error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
						}else{
						if(pg_numrows($result)==0){      
							$qry="INSERT INTO TIENE2 (RUT_APO,RUT_ALUMNO,RESPONSABLE, SOSTENEDOR) VALUES ('".trim($txtRUT)."','".$_ALUMNO."',".$chkRESP.", ".$chkSOS.")";
							$result =@pg_Exec($conn,$qry);
							if (!$result){
								error('<b> ERROR :</b>Error al acceder a la BD.(5)');
							}
						}
					}
				}
				echo "<html><title>ADVERTENCIA</title></head>";
				echo "<body><center>";
				echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
				echo "ADVERTENCIA: EL APODERADO YA SE ENCUENTRA PREVIAMENTE INGRESADO AL SISTEMA.";
				echo "<BR>";
				echo "LA INFORMACION HA SIDO ACTUALIZADA...";
				echo "<BR><BR><BR>";
				echo "<INPUT TYPE=button value=CONTINUAR onClick=document.location=\"listarApoderado.php3\";>";
				echo "</center></body></html>";
			}else{
					$qry="INSERT INTO APODERADO ( RUT_APO,DIG_RUT,NOMBRE_APO,APE_PAT,APE_MAT,CALLE,NRO,DEPTO,BLOCK,VILLA,REGION,CIUDAD,COMUNA,TELEFONO,RELACION,EMAIL, CELULAR, NIVEL_EDU, PROFESION, LUGAR_TRABAJO, CARGO) VALUES ('".trim($txtRUT)."','".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtCALLE)."','".trim($txtNRO)."','".trim($txtDEP)."','".trim($txtBLO)."','".trim($txtVIL)."',".trim($txtREG).",".trim($txtCIU).",".trim($txtCOM).",'".trim($txtTELEF)."',".trim($cmbRELACION).",'".trim($txtEMAIL)."','".trim($txtCelular)."', '".$lugar_trabajo."','".$profesion."','".$lugar_trabajo."','".$cargo."')";

				$result =@pg_Exec($conn,$qry);

				$qry2="insert into anxapoderado values ('$txtRUT','$cmbDIA','$_INSTIT')";
				@pg_Exec($conn,$qry2);
				
				if (!$result) {
					error('<b> ERROR :</b>Error al acceder a la BD.(1)');
				}else{   
					$qry="INSERT INTO TIENE2 (RUT_APO,RUT_ALUMNO,RESPONSABLE, SOSTENEDOR) VALUES ('".trim($txtRUT)."','".trim($alumno)."',".$chkRESP.",".$chkSOS.")";
					$result =@pg_Exec($conn,$qry);
					if (!$result) {
						error('<b> ERROR :</b>Error al acceder a la BD.(2)'.$qry);
					}else{
					    pg_close($conn);
						echo "<script>window.location = 'listarApoderado.php3'</script>";
					}
				}
			}
		}
}

if ($frmModo=="modificar") {
		echo "Actualizando...";
		echo $qry="UPDATE apoderado SET nombre_apo = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".trim($txtREG).", ciudad = ".trim($txtCIU).", comuna = ".trim($txtCOM).", telefono = '".trim($txtTELEF)."', relacion = ".trim($cmbRELACION).", email = '".trim($txtEMAIL)."', celular = '".$txtCelular."', nivel_edu = '".$nivel_edu."', profesion = '".$profesion."', lugar_trabajo = '".$lugar_trabajo."', cargo = '".$cargo."', ocupacion='".trim($ocupacion_actual)."'  WHERE (((rut_apo)='".trim($_APODERADO)."'))";
exit;
		$res =@pg_Exec($conn,"update anxapoderado set fecha='$cmbDIA',rdb='$_INSTIT' where rdb='$_INSTIT' and rut_apo='$_APODERADO'");
				
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)');
		}else{
			$qry="UPDATE TIENE2 SET SOSTENEDOR=".$chkSOS.", RESPONSABLE=".$chkRESP." WHERE RUT_ALUMNO='".trim($_ALUMNO)."' AND RUT_APO='".trim($_APODERADO)."'";
			$result =@pg_Exec($conn,$qry);
			//exit;
			pg_close($conn);
			echo "<script>window.location = 'seteaApoderado.php3?caso=1&apoderado=".trim($_APODERADO)."'</script>";
			
		}
}

if ($frmModo=="eliminar") {
	$qry="SELECT * FROM USUARIO WHERE NOMBRE_USUARIO='".$_APODERADO."' ";
	$result = @pg_Exec($conn,$qry);
	$fila	= @pg_fetch_array($result,0);


	$qry="DELETE FROM ACCEDE WHERE ID_USUARIO=".$fila['id_usuario']." AND RDB=".$_INSTIT; // BORRANDO LOS ACCESOS
	$result =@pg_Exec($conn,$qry);
    
	$qry="SELECT * FROM ACCEDE WHERE ID_USUARIO=".$fila['id_usuario'];
	$result = @pg_Exec($conn,$qry);
	if (@pg_numrows($result)==0){ 
		//SI NO QUEDAN PERFILES SE BORRA EL USUARIO
		$qry="DELETE FROM USUARIO WHERE ID_USUARIO=".$fila['id_usuario'];
		$result = @pg_Exec($conn,$qry);

	}
	
	$qry="DELETE FROM TIENE2 WHERE RUT_APO='".trim($_APODERADO)."' AND RUT_ALUMNO='".trim($_ALUMNO)."'";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al eliminar.'.$qry);
	}else{
	    pg_close($conn);
		echo "<script>window.location = 'listarApoderado.php3'</script>";
	}
}
?>