<?php require('../../../util/header.inc');?>
<?php
 	$frmModo		=$_FRMMODO;

/*print_r($tipo_titulo);
print_r($cod_subsector);
echo $cod_subsector;*/

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/
$cmbTITULO=0;
$habilitado_para=serialize($cod_subsector);
if (!$cmbCARGO2){$cmbCARGO2=0;}
if (!$cmbCARGO1){$cmbCARGO1=0;}
if (!$tipo_titulo){$tipo_titulo=array();}
if (in_array("1",$tipo_titulo)){$habilitado=1;}else{$habilitado=0;}
if (in_array("2",$tipo_titulo)){$titulado=1;}else{$titulado=0;}
if (in_array("3",$tipo_titulo)){$tit_otras=1;}else{$tit_otras=0;}

if (!isset($txtNROres)){ $txtNROres=0;}
//if (is_array($tipo_titulo)){}else{echo "no es un arreglo";} 
//exit();

	if($txtREG=="")
		$txtREG=1;
	if($txtCIU=="")
		$txtCIU=1;
	if($txtCOM=="")
		$txtCOM=1;
if ($txtNROres==""){ $txtNROres=0;}
if ($txtEXPERIENCIA==""){ $txtEXPERIENCIA=0;}
//txtEXPERIENCIA
//echo $txtNROres;
//echo $txtEXPERIENCIA;
if ($frmModo=="ingresar"){
	//VERIFICAR EXISTENCIA PREVIA
	$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$txtRUT;
	$result =@pg_Exec($conn,$qry);
	if (!$result){error('<B> ERROR :</b>Error al acceder a la BD. (65)</B>');
		}else{
			if(pg_numrows($result)!=0){/*-----PREGUNTA SI EXISTE EL EMPLEADO-----*/
			
			if($txtFECHA==""){
				 $qry="UPDATE empleado 	SET nombre_emp = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$txtREG.", ciudad = ".$txtCIU.", comuna = ".$txtCOM.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", titulo = '".trim($txtTITULO)."', email = '".trim($txtEMAIL)."', estado_civil = ".$cmbCIVIL." , estudios ='".$txtESTUDIOS."' ,nu_resol ='".trim($txtNROres)."', tipo_titulo=".$cmbTITULO.", telefono2 = '".trim($txtTELEF2)."', telefono3 = '".trim($txtTELEF3)."', idiomas='".trim($txtIDIOMAS)."', anos_exp='".trim($txtEXPERIENCIA)."', nacionalidad=".$cmbNac.", atencion = '".$txtAtencion."' WHERE (((rut_emp)=".$txtRUT."))";
					}else{
				 $qry="UPDATE empleado SET nombre_emp = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$txtREG.", ciudad = ".$txtCIU.", comuna = ".$txtCOM.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", titulo = '".trim($txtTITULO)."', email = '".trim($txtEMAIL)."', estado_civil = ".$cmbCIVIL." , estudios ='".$txtESTUDIOS."' ,nu_resol ='".trim($txtNROres)."' ,fecha_resol ='".trim($txtFECHA)."' ,tipo_titulo=".$cmbTITULO.", telefono2 = '".trim($txtTELEF2)."', telefono3 = '".trim($txtTELEF3)."', idiomas='".trim($txtIDIOMAS)."', anos_exp='".trim($txtEXPERIENCIA)."', nacionalidad=".$cmbNac.", atencion = '".$txtAtencion."' WHERE (((rut_emp)=".$txtRUT."))";
				}
				$result =@pg_Exec($conn,$qry);
				if (!$result){
					error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
				}else{
					 $qry="SELECT * FROM TRABAJA WHERE RUT_EMP=".$txtRUT." AND RDB=".$_INSTIT;
					$result =@pg_Exec($conn,$qry);
					if(!$result){
						error('<B> ERROR :</b>Error al acceder a la BD. (60)</B>');
					}else{
					
					$qry="SELECT * FROM TRABAJA WHERE RUT_EMP=".$txtRUT." AND RDB=".$_INSTIT;
					$result =@pg_Exec($conn,$qry);
					if(!$result){
						error('<B> ERROR :</b>Error al acceder a la BD. (61)</B>');
					}else{
					
						
						if(pg_numrows($result)==0){
						
							if ($cmbCARGO1!=0){
							$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($_INSTIT).",".trim($txtRUT).",".$cmbCARGO1.")";
							$result =@pg_Exec($conn,$qry);
							}
							if ($cmbCARGO2!=0){
							$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($_INSTIT).",".trim($txtRUT).",".$cmbCARGO2.")";
								$result =@pg_Exec($conn,$qry);
							}
							//echo "vhs";
						}	
					

						 
					}
					
				
					/*	if(pg_numrows($result)==0){
							$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($rdb).",".trim($txtRUT).",".$cmbCARGO1.")";
							$result =@pg_Exec($conn,$qry);
							if (!$result) {error('<b> ERROR :</b>Error al acceder a la BD.(2)'.$qry);}
						}else{
							for ($i=0;$i<=pg_numrows($result);$i++){
								$row_cargo=pg_fetch_array($result);
								$arreglo_cargo[]=$row_cargo[cargo];
							}
							 $qry="UPDATE TRABAJA SET CARGO=".$cmbCARGO1." WHERE (RDB=".$_INSTIT.") AND (RUT_EMP=".$txtRUT.") and cargo=$arreglo_cargo[0]";
							$result =@pg_Exec($conn,$qry);
							if (!$result){error('<b> ERROR :</b>Error al acceder a la BD.(2)'.$qry);}
							}
							
						 if (($cmbCARGO2)&&(!$arreglo_cargo[1])){ //si no exite en la db
 						echo 	$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($rdb).",".trim($txtRUT).",".$cmbCARGO2.")";
							$result =@pg_Exec($conn,$qry);
						 }
						 if (($cmbCARGO2)&&($arreglo_cargo[1])){ //si  exite en la db
							echo $qry="UPDATE TRABAJA SET CARGO=".$cmbCARGO1." WHERE (RDB=".$_INSTIT.") AND (RUT_EMP=".$txtRUT.") and cargo=$arreglo_cargo[1]";
							$result =@pg_Exec($conn,$qry);
						 }
					*/

						 
					}
				}
////COMO ESTA INGRESADO VERIFICA LOS TITULOS, ETC....///////
				$sql_del_tit="delete from empleado_estudios where rut_empleado='".$_EMPLEADO."'";
				$res_del_tit = pg_exec($conn, $sql_del_tit);
				if (!$res_del_tit)
							error('<b> ERROR :</b>Error al acceder a la BD.(34)');

/// ---TITULOS tipo=1///
				for($k_tit=1 ; $k_tit<=3 ; $k_tit++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					if (trim($txtTITULO[$k_tit])!=""){
						$sql_orden_tit = "SELECT MAX(orden) AS orden_tit from empleado_estudios where rut_empleado='".trim($txtRUT)."' AND tipo=1";
						//exit;
						$res_orden_tit = pg_exec($conn, $sql_orden_tit);
						$fila_orden_tit = pg_fetch_array($res_orden_tit, 0);
						$new_orden_tit = $fila_orden_tit['orden_tit'] + 1;
							
							$sql_tit = "INSERT INTO empleado_estudios (rut_empleado, nombre, institucion, ano, tipo, orden) ";
							$sql_tit = $sql_tit . "VALUES ('".trim($txtRUT)."', '".trim($txtTITULO[$k_tit])."', '".trim($institucion[$k_tit])."', '".trim($año[$k_tit])."' ";
							$sql_tit = $sql_tit . ", 1, ".$new_orden_tit.")";
							$res_tit = pg_exec($conn, $sql_tit);
							if (!$res_tit)
								error('<b> ERROR :</b>Error al acceder a la BD.(35)');

					}
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---POSTITULOS tipo=2///
				for($k_postit=1 ; $k_postit<=2 ; $k_postit++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					if (trim($txtPOSTITULO[$k_postit])!=""){
						$sql_orden_postit = "SELECT MAX(orden) AS orden_postit FROM empleado_estudios WHERE rut_empleado='".trim($txtRUT)."' AND tipo=2";
						$res_orden_postit = pg_exec($conn, $sql_orden_postit);
						$fila_orden_postit = pg_fetch_array($res_orden_postit, 0);
						$new_orden_postit = $fila_orden_postit['orden_postit'] + 1;
							
							$sql_postit = "INSERT INTO empleado_estudios (rut_empleado, nombre, tipo, orden) ";
							$sql_postit = $sql_postit . "VALUES ('".trim($txtRUT)."', '".trim($txtPOSTITULO[$k_postit])."' ";
							$sql_postit = $sql_postit . ", 2, ".$new_orden_postit.")";
							$res_postit = pg_exec($conn, $sql_postit);
							if (!$res_postit)
								error('<b> ERROR :</b>Error al acceder a la BD.(36)');
					
					}

				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---POSTGRADOS tipo=3///
				for($k_posgra=1 ; $k_posgra<=2 ; $k_posgra++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					if (trim($txtPOSTGRADO[$k_posgra])!=""){
						$sql_orden_posgra = "SELECT MAX(orden) AS orden_posgra from empleado_estudios where rut_empleado='".trim($txtRUT)."' AND tipo=3";
						$res_orden_posgra = pg_exec($conn, $sql_orden_posgra);
						$fila_orden_posgra = pg_fetch_array($res_orden_posgra, 0);
						$new_orden_posgra = $fila_orden_posgra['orden_posgra'] + 1;

							$sql_posgra = "INSERT INTO empleado_estudios (rut_empleado, nombre, tipo, orden) ";
							$sql_posgra = $sql_posgra . "VALUES ('".trim($txtRUT)."', '".trim($txtPOSTGRADO[$k_posgra])."' ";
							$sql_posgra = $sql_posgra . ", 3, ".$new_orden_posgra.")";
							$res_posgra = pg_exec($conn, $sql_posgra);
							if (!$res_posgra)
								error('<b> ERROR :</b>Error al acceder a la BD.(37)');
					}
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)

/// ---CURSOS RECONOCIDOS tipo=4///
				for($k_cu=1 ; $k_cu<=4 ; $k_cu++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
				if (trim($txtCURSO[$k_cu])!=""){
					$sql_orden_cu = "SELECT MAX(orden) AS orden_cu from empleado_estudios where rut_empleado='".trim($txtRUT)."' AND tipo=4";
					$res_orden_cu = pg_exec($conn, $sql_orden_cu);
					$fila_orden_cu = pg_fetch_array($res_orden_cu, 0);
					$new_orden_cu = $fila_orden_cu['orden_cu'] + 1;

							$sql_cu = "INSERT INTO empleado_estudios (rut_empleado, nombre, ano, horas, tipo, orden) ";
							$sql_cu = $sql_cu . "VALUES ('".trim($txtRUT)."', '".trim($txtCURSO[$k_cu])."', '".trim($año[$k_cu])."' ";
							$sql_cu = $sql_cu . ", '".$horas[$k_cu]."', 4, ".$new_orden_cu.")";
							$res_cu = pg_exec($conn, $sql_cu);
							if (!$res_cu)
								error('<b> ERROR :</b>Error al acceder a la BD.(38)');
				}

				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)



				
				echo "<html><title>ADVERTENCIA</title></head>";
				echo "<body><center>";
				echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
				echo "ADVERTENCIA: EL EMPLEADO YA SE ENCUENTRA PREVIAMENTE INGRESADO AL SISTEMA.";
				echo "<BR>";
				echo "LA INFORMACION HA SIDO ACTUALIZADA...";
				echo "<BR><BR><BR>";
				echo "<INPUT TYPE=button value=CONTINUAR onClick=document.location=\"listarEmpleado.php3\";>";
				echo "</center></body></html>";
				/*----------TERMINA DE ACTUALIZAR UANDO YA EXISTIA--------------*/
			}else{/*----------COMIENZA A INSERTAR CUANDO NO EXISTE--------------*/
			$cmbTITULO=0;
                if($txtFECHA==""){
					$qry="INSERT INTO EMPLEADO (RUT_EMP, DIG_RUT, NOMBRE_EMP, APE_PAT, APE_MAT, CALLE, NRO, DEPTO, BLOCK, VILLA, REGION, CIUDAD, COMUNA, TELEFONO, SEXO, TITULO, EMAIL, ESTADO_CIVIL, ESTUDIOS, NU_RESOL, TIPO_TITULO, IDIOMAS, ANOS_EXP, NACIONALIDAD, ATENCION,habilitado,titulado,tit_otras,habilitado_para) VALUES (".trim($txtRUT).",'".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtCALLE)."','".trim($txtNRO)."','".trim($txtDEP)."','".trim($txtBLO)."','".trim($txtVIL)."',".trim($txtREG).",".trim($txtCIU).",".trim($txtCOM).",'".trim($txtTELEF)."',".trim($cmbSEXO).",'".trim($txtTITULO)."','".trim($txtEMAIL)."',".$cmbCIVIL.",'".$txtESTUDIOS."','".trim($txtNROres)."',".$cmbTITULO.", '".trim($txtIDIOMAS)."', '".trim($txtEXPERIENCIA)."', ".$cmbNac.",'".$txtAtencion."','$habilitado','$titulado','$tit_otras','$habilitado_para')";
				}else{
					$qry="INSERT INTO EMPLEADO (RUT_EMP, DIG_RUT, NOMBRE_EMP, APE_PAT, APE_MAT, CALLE, NRO, DEPTO, BLOCK, VILLA, REGION, CIUDAD, COMUNA, TELEFONO, SEXO, TITULO, EMAIL, ESTADO_CIVIL, ESTUDIOS, NU_RESOL, FECHA_RESOL, TIPO_TITULO, IDIOMAS, ANOS_EXP, NACIONALIDAD, ATENCION,habilitado,titulado,tit_otras,habilitado_para) VALUES (".trim($txtRUT).",'".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtCALLE)."','".trim($txtNRO)."','".trim($txtDEP)."','".trim($txtBLO)."','".trim($txtVIL)."',".trim($txtREG).",".trim($txtCIU).",".trim($txtCOM).",'".trim($txtTELEF)."',".trim($cmbSEXO).",'".trim($txtTITULO)."','".trim($txtEMAIL)."',".$cmbCIVIL.",'".$txtESTUDIOS."','".trim($txtNROres)."','".trim($txtFECHA)."',".$cmbTITULO.", '".trim($txtIDIOMAS)."', '".trim($txtEXPERIENCIA)."', ".$cmbNac.", '".$txtAtencion."','$habilitado','$titulado','$tit_otras','$habilitado_para')";
				}
				$result =@pg_Exec($conn,$qry);
				if (!$result){
					error('<b> ERROR :</b>Error al acceder a la BD.(63)'.$qry);
				}else{
//				vhs
					 $qry="SELECT * FROM TRABAJA WHERE RUT_EMP=".$txtRUT." AND RDB=".$_INSTIT;
					$result =@pg_Exec($conn,$qry);
					if(!$result){
						error('<B> ERROR :</b>Error al acceder a la BD. (81)</B>');
					}else{
					
						
					if ($cmbCARGO1!=0){
							 $qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($_INSTIT).",".trim($txtRUT).",".$cmbCARGO1.")";
							$result =@pg_Exec($conn,$qry);
							}
					if ($cmbCARGO2!=0){
							 	$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($_INSTIT).",".trim($txtRUT).",".$cmbCARGO2.")";
							$result =@pg_Exec($conn,$qry);
						}
							//echo "vhs";
					}	

				}
					
				}

/////******COMIENZA A INSERTAR TITULOS, POSTGRADOS, ETC*******/////
				
/// ---TITULOS tipo=1///
				for($k_tit=1 ; $k_tit<=3 ; $k_tit++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					$sql_orden_tit = "SELECT MAX(orden) AS orden_tit from empleado_estudios where rut_empleado='".trim($txtRUT)."' AND tipo=1";
					//exit;
					$res_orden_tit = pg_exec($conn, $sql_orden_tit);
					$fila_orden_tit = pg_fetch_array($res_orden_tit, 0);
					$new_orden_tit = $fila_orden_tit['orden_tit'] + 1;
						if (trim($txtTITULO[$k_tit])!=""){
							$sql_tit = "INSERT INTO empleado_estudios (rut_empleado, nombre, institucion, ano, tipo, orden) ";
							$sql_tit = $sql_tit . "VALUES ('".trim($txtRUT)."', '".trim($txtTITULO[$k_tit])."', '".trim($institucion[$k_tit])."', '".trim($año[$k_tit])."', ";
							$sql_tit = $sql_tit . " 1, ".$new_orden_tit.")";
							$res_tit = pg_exec($conn, $sql_tit);
							if (!$res_tit)
								error('<b> ERROR :</b>Error al acceder a la BD.(21)');
						}
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---POSTITULOS tipo=2///
				for($k_postit=1 ; $k_postit<=2 ; $k_postit++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					$sql_orden_postit = "SELECT MAX(orden) AS orden_postit from empleado_estudios where rut_empleado='".trim($txtRUT)."' AND tipo=2";
					$res_orden_postit = pg_exec($conn, $sql_orden_postit);
					$fila_orden_postit = pg_fetch_array($res_orden_postit, 0);
					$new_orden_postit = $fila_orden_postit['orden_postit'] + 1;
						if (trim($txtPOSTITULO[$k_postit])!=""){
							$sql_postit = "INSERT INTO empleado_estudios (rut_empleado, nombre, tipo, orden) ";
							$sql_postit = $sql_postit . "VALUES ('".trim($txtRUT)."', '".trim($txtPOSTITULO[$k_postit])."' ";
							$sql_postit = $sql_postit . ", 2, ".$new_orden_postit.")";
							$res_postit = pg_exec($conn, $sql_postit);
							if (!$res_postit)
								error('<b> ERROR :</b>Error al acceder a la BD.(22)');
						}
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---POSTGRADOS tipo=3///
				for($k_posgra=1 ; $k_posgra<=2 ; $k_posgra++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					$sql_orden_posgra = "SELECT MAX(orden) AS orden_posgra from empleado_estudios where rut_empleado='".trim($txtRUT)."' AND tipo=3";
					$res_orden_posgra = pg_exec($conn, $sql_orden_posgra);
					$fila_orden_posgra = pg_fetch_array($res_orden_posgra, 0);
					$new_orden_posgra = $fila_orden_posgra['orden_posgra'] + 1;
						if (trim($txtPOSTGRADO[$k_posgra])!=""){
							$sql_posgra = "INSERT INTO empleado_estudios (rut_empleado, nombre, tipo, orden) ";
							$sql_posgra = $sql_posgra . "VALUES ('".trim($txtRUT)."', '".trim($txtPOSTGRADO[$k_posgra])."' ";
							$sql_posgra = $sql_posgra . ", 3, ".$new_orden_posgra.")";
							$res_posgra = pg_exec($conn, $sql_posgra);
							if (!$res_posgra)
								error('<b> ERROR :</b>Error al acceder a la BD.(23)');
						}
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---CURSOS RECONOCIDOS tipo=4///
				for($k_cu=1 ; $k_cu<=4 ; $k_cu++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					$sql_orden_cu = "SELECT MAX(orden) AS orden_cu from empleado_estudios where rut_empleado='".trim($txtRUT)."' AND tipo=4";
					$res_orden_cu = pg_exec($conn, $sql_orden_cu);
					$fila_orden_cu = pg_fetch_array($res_orden_cu, 0);
					$new_orden_cu = $fila_orden_cu['orden_cu'] + 1;
						if (trim($txtCURSO[$k_cu])!=""){
							$sql_cu = "INSERT INTO empleado_estudios (rut_empleado, nombre, ano, horas, tipo, orden) ";
							$sql_cu = $sql_cu . "VALUES ('".trim($txtRUT)."', '".trim($txtCURSO[$k_cu])."', '".trim($año[$k_cu])."' ";
							$sql_cu = $sql_cu . ", '".$horas_curso[$k_cu]."', 4, ".$new_orden_cu.")";
							$res_cu = pg_exec($conn, $sql_cu);
							if (!$res_cu)
								error('<b> ERROR :</b>Error al acceder a la BD.(24)');
						}
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)

				
				/////******TERMINA DE INSERTAR TITULOS, POSTGRADOS, ETC*******/////

/*vhs				echo "<script>window.location = 'listarEmpleado.php3'</script>";*/
echo "<script>window.location = 'listarEmpleado.php3'</script>";

			}/*----------TERMINA DE INSERTAR CUANDO NO EXISTE--------------*/
		}

if ($frmModo=="modificar") {
		if($txtFECHA==""){
	 	$qry="UPDATE empleado SET nombre_emp = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$txtREG.", ciudad = ".$txtCIU.", comuna = ".$txtCOM.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", titulo = '".trim($txtTITULO)."', email = '".trim($txtEMAIL)."', estado_civil = ".$cmbCIVIL." , estudios ='".$txtESTUDIOS."' ,nu_resol ='".trim($txtNROres)."' , telefono2 = '".trim($txtTELEF2)."', telefono3 = '".trim($txtTELEF3)."', idiomas='".trim($txtIDIOMAS)."', anos_exp='".trim($txtEXPERIENCIA)."', nacionalidad=".$cmbNac.", atencion = '".$txtAtencion.
		"', habilitado='$habilitado', titulado='$titulado',tit_otras='$tit_otras',habilitado_para='$habilitado_para'	
		 WHERE (((rut_emp)=".$_EMPLEADO."))";
		}else{
	 	$qry="UPDATE empleado SET nombre_emp = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$txtREG.", ciudad = ".$txtCIU.", comuna = ".$txtCOM.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", titulo = '".trim($txtTITULO)."', email = '".trim($txtEMAIL)."', estado_civil = ".$cmbCIVIL." , estudios ='".$txtESTUDIOS."' ,nu_resol ='".trim($txtNROres)."' ,fecha_resol =to_date('" . $txtFECHA . "','DD MM YYYY'), telefono2 = '".trim($txtTELEF2)."', telefono3 = '".trim($txtTELEF3)."', idiomas='".trim($txtIDIOMAS)."', anos_exp='".trim($txtEXPERIENCIA)."', nacionalidad=".$cmbNac.", atencion = '".$txtAtencion.
		"', habilitado='$habilitado', titulado='$titulado',tit_otras='$tit_otras',habilitado_para='$habilitado_para'	
		WHERE (((rut_emp)=".$_EMPLEADO."))";
         }
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
		}else{

		/*	$qry="UPDATE TRABAJA SET CARGO=".$cmbCARGO1." WHERE (RDB=".$_INSTIT.")AND(RUT_EMP=".$_EMPLEADO.")";
			$result =@pg_Exec($conn,$qry);
			if (!$result) {
				error('<b> ERROR :</b>Error al acceder a la BD.(2)'.$qry);
			}else{
				/*echo "<script>window.location = 'seteaEmpleado.php3?caso=1&empleado=".$_EMPLEADO."'</script>";*/
			//}
					$qry="SELECT * FROM TRABAJA WHERE RUT_EMP=".$_EMPLEADO." AND RDB=".$_INSTIT;
					$result =@pg_Exec($conn,$qry);
					if(!$result){
						error('<B> ERROR :</b>Error al acceder a la BD. (68)</B>');
					}else{
					
						
						if(pg_numrows($result)==0){
							$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($rdb).",".trim($_EMPLEADO).",".$cmbCARGO1.")";
							$result =@pg_Exec($conn,$qry);
							if (!$result) {error('<b> ERROR :</b>Error al acceder a la BD.(2)'.$qry);}
						}else{
							for ($i=0;$i<=pg_numrows($result);$i++){
								$row_cargo=pg_fetch_array($result);
								$arreglo_cargo[]=$row_cargo[cargo];
							}
						 	$qry="UPDATE TRABAJA SET CARGO=".$cmbCARGO1." WHERE (RDB=".$_INSTIT.") AND (RUT_EMP=".$_EMPLEADO.") and cargo=$arreglo_cargo[0]";
							$result =@pg_Exec($conn,$qry);
							if (!$result){error('<b> ERROR :</b>Error al acceder a la BD.(2)'.$qry);}
							}
							
						 if (($cmbCARGO2)&&(!$arreglo_cargo[1])){ //si no exite en la db
  							$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($rdb).",".trim($_EMPLEADO).",".$cmbCARGO2.")";
							$result =@pg_Exec($conn,$qry);
						 }
						 if (($cmbCARGO2)&&($arreglo_cargo[1])){ //si  exite en la db
							$qry="UPDATE TRABAJA SET CARGO=".$cmbCARGO2." WHERE (RDB=".$_INSTIT.") AND (RUT_EMP=".$_EMPLEADO.") and cargo=$arreglo_cargo[1]";
							$result =@pg_Exec($conn,$qry);
						 }
						 if ((!$cmbCARGO2)&&($arreglo_cargo[1])){ //si  exite en la db
							 $qry="delete from  TRABAJA WHERE (RDB=".$_INSTIT.") AND (RUT_EMP=".$_EMPLEADO.") and cargo=$arreglo_cargo[1]";
							$result =@pg_Exec($conn,$qry);
						 }

						 
					}
		}
		
/// ---TITULOS tipo=1///
				$sql_del_tit="delete from empleado_estudios where rut_empleado='".$_EMPLEADO."'";
				$res_del_tit = pg_exec($conn, $sql_del_tit);
				if (!$res_del_tit)
							error('<b> ERROR :</b>Error al acceder a la BD.(33)');

				for($k_tit=1 ; $k_tit<=3 ; $k_tit++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					
					if (trim($txtTITULO[$k_tit])!=""){
						$sql_orden_tit = "SELECT MAX(orden) AS orden_tit from empleado_estudios where rut_empleado='".trim($_EMPLEADO)."' AND tipo=1";
						$res_orden_tit = pg_exec($conn, $sql_orden_tit);
						$fila_orden_tit = pg_fetch_array($res_orden_tit, 0);
						$new_orden_tit = $fila_orden_tit['orden_tit'] + 1;
						
						$sql_tit = "INSERT INTO empleado_estudios (rut_empleado, nombre, institucion, ano, tipo, orden) ";
							$sql_tit = $sql_tit . "VALUES ('".trim($_EMPLEADO)."', '".trim($txtTITULO[$k_tit])."', '".trim($institucion[$k_tit])."', '".trim($año[$k_tit])."' ";
							$sql_tit = $sql_tit . ", 1, ".$new_orden_tit.")";
							$res_tit = pg_exec($conn, $sql_tit);
							if (!$res_tit)
								error('<b> ERROR :</b>Error al acceder a la BD.(33)');		
					}//fin if (trim($txtTITULO[$k_tit])!=""){
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---POSTITULOS tipo=2///
				for($k_postit=1 ; $k_postit<=2 ; $k_postit++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					if (trim($txtPOSTITULO[$k_postit])!=""){
						$sql_orden_postit = "SELECT MAX(orden) AS orden_postit FROM empleado_estudios WHERE rut_empleado='".trim($_EMPLEADO)."' AND tipo=2";
						$res_orden_postit = pg_exec($conn, $sql_orden_postit);
						$fila_orden_postit = pg_fetch_array($res_orden_postit, 0);
						$new_orden_postit = $fila_orden_postit['orden_postit'] + 1;

							$sql_postit = "INSERT INTO empleado_estudios (rut_empleado, nombre, tipo, orden) ";
							$sql_postit = $sql_postit . "VALUES ('".trim($_EMPLEADO)."', '".trim($txtPOSTITULO[$k_postit])."' ";
							$sql_postit = $sql_postit . ", 2, ".$new_orden_postit.")";
							$res_postit = pg_exec($conn, $sql_postit);
							if (!$res_postit)
								error('<b> ERROR :</b>Error al acceder a la BD.(35)');


					}

				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---POSTGRADOS tipo=3///
				for($k_posgra=1 ; $k_posgra<=2 ; $k_posgra++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					if (trim($txtPOSTGRADO[$k_posgra])!=""){
						$sql_orden_posgra = "SELECT MAX(orden) AS orden_posgra from empleado_estudios where rut_empleado='".trim($_EMPLEADO)."' AND tipo=3";
						$res_orden_posgra = pg_exec($conn, $sql_orden_posgra);
						$fila_orden_posgra = pg_fetch_array($res_orden_posgra, 0);
						$new_orden_posgra = $fila_orden_posgra['orden_posgra'] + 1;

							$sql_posgra = "INSERT INTO empleado_estudios (rut_empleado, nombre, tipo, orden) ";
							$sql_posgra = $sql_posgra . "VALUES ('".trim($_EMPLEADO)."', '".trim($txtPOSTGRADO[$k_posgra])."' ";
							$sql_posgra = $sql_posgra . ", 3, ".$new_orden_posgra.")";
							$res_posgra = pg_exec($conn, $sql_posgra);
							if (!$res_posgra)
								error('<b> ERROR :</b>Error al acceder a la BD.(37)');

					}

				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---CURSOS RECONOCIDOS tipo=4///
				for($k_cu=1 ; $k_cu<=4 ; $k_cu++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					if (trim($txtCURSO[$k_cu])!=""){
						$sql_orden_cu = "SELECT MAX(orden) AS orden_cu from empleado_estudios where rut_empleado='".trim($_EMPLEADO)."' AND tipo=4";
						$res_orden_cu = pg_exec($conn, $sql_orden_cu);
						$fila_orden_cu = pg_fetch_array($res_orden_cu, 0);
						$new_orden_cu = $fila_orden_cu['orden_cu'] + 1;
					
							$sql_cu = "INSERT INTO empleado_estudios (rut_empleado, nombre, ano, horas, tipo, orden) ";
							$sql_cu = $sql_cu . "VALUES ('".trim($_EMPLEADO)."', '".trim($txtCURSO[$k_cu])."', '".trim($año_curso[$k_cu])."' ";
							$sql_cu = $sql_cu . ", '".$horas_curso[$k_cu]."', 4, ".$new_orden_cu.")";
							$res_cu = pg_exec($conn, $sql_cu);
							if (!$res_cu)
								error('<b> ERROR :</b>Error al acceder a la BD.(39)');
				
					}
					
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)
		
/*vhs 		echo "<script>window.location = 'seteaEmpleado.php3?caso=1&empleado=".$_EMPLEADO."'</script>";*/
echo "<script>window.location = 'seteaEmpleado.php3?caso=1&empleado=".$_EMPLEADO."'</script>";
}//FIN MODIFICAR

if ($frmModo=="eliminar"){
	$qry="SELECT * FROM USUARIO WHERE NOMBRE_USUARIO='".$_EMPLEADO."'";
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

	$qry="DELETE FROM TRABAJA WHERE RUT_EMP='".$_EMPLEADO."' AND RDB=".$_INSTIT;
	$result =@pg_Exec($conn,$qry);
	
	$sql_del_tit="DELETE FROM empleado_estudios WHERE rut_empleado='".$_EMPLEADO."'";
	$result = pg_exec($conn, $sql_del_tit);

	echo "<center><font face=arial><b>Eliminando...</b></font></center>";
//	exit();
	if (!$result) {
		error('<b> ERROR :</b>Error al eliminar.');
	}else{
/*vhs 		echo "<script>window.location = 'listarEmpleado.php3'</script>";*/
		echo "<script>window.location = 'listarEmpleado.php3'</script>";
	}
}
?>