<?php require('../../../util/header.inc');?>
<?php
 	$frmModo		=$_FRMMODO;

	if($txtREG=="")
		$txtREG=1;
	if($txtCIU=="")
		$txtCIU=1;
	if($txtCOM=="")
		$txtCOM=1;


if ($frmModo=="ingresar"){
	//VERIFICAR EXISTENCIA PREVIA
	$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$txtRUT;
	$result =@pg_Exec($conn,$qry);
	if (!$result){error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if(pg_numrows($result)!=0){
			if($txtFECHA==""){
				  $qry="UPDATE empleado SET nombre_emp = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$txtREG.", ciudad = ".$txtCIU.", comuna = ".$txtCOM.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", titulo = '".trim($txtTITULO)."', email = '".trim($txtEMAIL)."', estado_civil = ".$cmbCIVIL." , estudios ='".$txtESTUDIOS."' ,nu_resol ='".trim($txtNROres)."', tipo_titulo=".$cmbTITULO." WHERE (((rut_emp)=".$txtRUT."))";
					}else{
				 $qry="UPDATE empleado SET nombre_emp = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$txtREG.", ciudad = ".$txtCIU.", comuna = ".$txtCOM.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", titulo = '".trim($txtTITULO)."', email = '".trim($txtEMAIL)."', estado_civil = ".$cmbCIVIL." , estudios ='".$txtESTUDIOS."' ,nu_resol ='".trim($txtNROres)."' ,fecha_resol ='".trim($txtFECHA)."' ,tipo_titulo=".$cmbTITULO." WHERE (((rut_emp)=".$txtRUT."))";
				}
				$result =@pg_Exec($conn,$qry);
				if (!$result){
					error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
				}else{
					$qry="SELECT * FROM TRABAJA WHERE RUT_EMP=".$txtRUT." AND RDB=".$_INSTIT;
					$result =@pg_Exec($conn,$qry);
					if(!$result){
						error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
					}else{
						if(pg_numrows($result)==0){
							$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($rdb).",".trim($txtRUT).",".$cmbCARGO.")";
							$result =@pg_Exec($conn,$qry);
							if (!$result) {error('<b> ERROR :</b>Error al acceder a la BD.(2)');}
						}else{
							$qry="UPDATE TRABAJA SET CARGO=".$cmbCARGO." WHERE (RDB=".$_INSTIT.") AND (RUT_EMP=".$txtRUT.")";
							$result =@pg_Exec($conn,$qry);
							if (!$result){error('<b> ERROR :</b>Error al acceder a la BD.(2)');}
						}
					}
				}
				echo "<html><title>ADVERTENCIA</title></head>";
				echo "<body><center>";
				echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
				echo "ADVERTENCIA: EL EMPLEADO YA SE ENCUENTRA PREVIAMENTE INGRESADO AL SISTEMA.";
				echo "<BR>";
				echo "LA INFORMACION HA SIDO ACTUALIZADA...";
				echo "<BR><BR><BR>";
				echo "<INPUT TYPE=button value=CONTINUAR onClick=document.location=\"listarEmpleado.php3\";>";
				echo "</center></body></html>";
			}else{
                 if($txtFECHA==""){
				$qry="INSERT INTO EMPLEADO (RUT_EMP, DIG_RUT, NOMBRE_EMP, APE_PAT, APE_MAT, CALLE, NRO, DEPTO, BLOCK, VILLA, REGION, CIUDAD, COMUNA, TELEFONO, SEXO, TITULO, EMAIL, ESTADO_CIVIL, ESTUDIOS, NU_RESOL, TIPO_TITULO) VALUES (".trim($txtRUT).",'".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtCALLE)."','".trim($txtNRO)."','".trim($txtDEP)."','".trim($txtBLO)."','".trim($txtVIL)."',".trim($txtREG).",".trim($txtCIU).",".trim($txtCOM).",'".trim($txtTELEF)."',".trim($cmbSEXO).",'".trim($txtTITULO)."','".trim($txtEMAIL)."',".$cmbCIVIL.",'".$txtESTUDIOS."','".trim($txtNROres)."',".$cmbTITULO.")";
				}else{
				$qry="INSERT INTO EMPLEADO (RUT_EMP, DIG_RUT, NOMBRE_EMP, APE_PAT, APE_MAT, CALLE, NRO, DEPTO, BLOCK, VILLA, REGION, CIUDAD, COMUNA, TELEFONO, SEXO, TITULO, EMAIL, ESTADO_CIVIL, ESTUDIOS, NU_RESOL, FECHA_RESOL, TIPO_TITULO) VALUES (".trim($txtRUT).",'".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtCALLE)."','".trim($txtNRO)."','".trim($txtDEP)."','".trim($txtBLO)."','".trim($txtVIL)."',".trim($txtREG).",".trim($txtCIU).",".trim($txtCOM).",'".trim($txtTELEF)."',".trim($cmbSEXO).",'".trim($txtTITULO)."','".trim($txtEMAIL)."',".$cmbCIVIL.",'".$txtESTUDIOS."','".trim($txtNROres)."','".trim($txtFECHA)."',".$cmbTITULO.")";
				}
				$result =@pg_Exec($conn,$qry);
				if (!$result){
					error('<b> ERROR :</b>Error al acceder a la BD.(1)'.$qry);
				}else{
					$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($rdb).",".trim($txtRUT).",".$cmbCARGO.")";
					$result =@pg_Exec($conn,$qry);
					if (!$result){error('<b> ERROR :</b>Error al acceder a la BD.(2)');}else{echo "<script>window.location = 'listarEmpleado.php3'</script>";}
				}
			}
		}
}
if ($frmModo=="modificar") {
		if($txtFECHA==""){
		$qry="UPDATE empleado SET nombre_emp = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$txtREG.", ciudad = ".$txtCIU.", comuna = ".$txtCOM.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", titulo = '".trim($txtTITULO)."', email = '".trim($txtEMAIL)."', estado_civil = ".$cmbCIVIL." , estudios ='".$txtESTUDIOS."' ,nu_resol ='".trim($txtNROres)."' , tipo_titulo = ".$cmbTITULO." WHERE (((rut_emp)=".$_EMPLEADO."))";
		}else{
		$qry="UPDATE empleado SET nombre_emp = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$txtREG.", ciudad = ".$txtCIU.", comuna = ".$txtCOM.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", titulo = '".trim($txtTITULO)."', email = '".trim($txtEMAIL)."', estado_civil = ".$cmbCIVIL." , estudios ='".$txtESTUDIOS."' ,nu_resol ='".trim($txtNROres)."' ,fecha_resol =to_date('" . $txtFECHA . "','DD MM YYYY'), tipo_titulo = ".$cmbTITULO." WHERE (((rut_emp)=".$_EMPLEADO."))";
         }
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
		}else{

			$qry="UPDATE TRABAJA SET CARGO=".$cmbCARGO." WHERE (RDB=".$_INSTIT.")AND(RUT_EMP=".$_EMPLEADO.")";
			$result =@pg_Exec($conn,$qry);
			if (!$result) {
				error('<b> ERROR :</b>Error al acceder a la BD.(2)');
			}else{
				echo "<script>window.location = 'seteaEmpleado.php3?caso=1&empleado=".$_EMPLEADO."'</script>";
			}
		}
}

if ($frmModo=="eliminar"){
	$qry="SELECT * FROM USUARIO WHERE NOMBRE_USUARIO=".$_EMPLEADO;
	$result = @pg_Exec($conn,$qry);
	$fila	= @pg_fetch_array($result,0); 

// BORRANDO LOS ACCESOS

//-----> AQUI EXISTE UN ERROR EN EL ID_USUARIO DEL DELETE!!!!!!!------------//
	$qry="DELETE FROM ACCEDE WHERE ID_USUARIO=".$fila['id_usuario']." AND RDB=".$_INSTIT; 
	$result =@pg_Exec($conn,$qry);
//	echo $qry;

	/*$qry="SELECT * FROM ACCEDE WHERE ID_USUARIO=".$fila['id_usuario'];
	$result = @pg_Exec($conn,$qry);
	if (@pg_numrows($result)==0){ 
		//SI NO QUEDAN PERFILES SE BORRA EL USUARIO
		$qry="DELETE FROM USUARIO WHERE ID_USUARIO=".$fila['id_usuario'];
		$result = @pg_Exec($conn,$qry);

		//DESLIGAR EL USUARIO
		$qry="UPDATE EMPLEADO SET ID_USUARIO=NULL";
		$result = @pg_Exec($conn,$qry);
	} */

	$qry="DELETE FROM TRABAJA WHERE RUT_EMP=".$_EMPLEADO." AND RDB=".$_INSTIT;
	$result =@pg_Exec($conn,$qry);
	echo "<center><font face=arial><b>Eliminando...</b></font></center>";
//	exit();
	if (!$result) {
		error('<b> ERROR :</b>Error al eliminar.');
	}else{
		echo "<script>window.location = 'listarEmpleado.php3'</script>";
	}
}
?>