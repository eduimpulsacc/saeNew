<?php require('../../../../util/header.inc');?> 
<?php
 	$frmModo		=$_FRMMODO;
	
	$institucion	=$_INSTITUCION;

	if(trim($txtREG)=="") $txtREG=1;
	if(trim($txtCIU)=="") $txtCIU=1;
	if(trim($txtCOM)=="") $txtCOM=1;
	
	if ($int)	$int=1; 	else	$int=0;
	if ($aoi)	$aoi=1; 	else	$aoi=0;
	
	if ($aoi=="")
		$aoi=0;
	if ($txtTITULO=="")
		$txtTITULO=0;

if ($frmModo=="ingresar") {
	//VERIFICAR EXISTENCIA PREVIA
	$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO='".$txtRUT."'";
	$result =@pg_Exec($conn,$qry);
	if (!$result)
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
		else{
			if(pg_numrows($result)!=0){
				$qry="UPDATE alumno SET nombre_alu = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$txtREG.", ciudad = ".$txtCIU.", comuna = ".$txtCOM.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", email = '".trim($txtEMAIL)."', fecha_nac = '".fEs2En($txtNAC)."', nacionalidad=" . $cmbNac . " WHERE (((rut_alumno)='".$txtRUT."'))";
				$result =@pg_Exec($conn,$qry);
				if (!$result)
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$qry);
				
				$qry="SELECT * FROM MATRICULATPSINCURSO WHERE RUT_ALUMNO='".$txtRUT."' AND RDB=".$_INSTIT." AND ID_ANO=".$_ANO;
				$result =@pg_Exec($conn,$qry);
				if (!$result)
				error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$qry);

				if(pg_numrows($result)==0){
					$qry="INSERT INTO MATRICULATPSINCURSO (RUT_ALUMNO,RDB,ID_ANO,FECHA,INTEGRADO,INDIGENA,ESTADO,TITULO,COD_TIPO,COD_SECTOR,COD_ESP) VALUES ('".trim($txtRUT)."',".trim($_INSTIT).",".$_ANO.",to_date('" . $FechaMatric . "','DD MM YYYY'),".$int.",".$aoi.",".$enP.",".$txtTITULO.",".$cmbENS.",".$cmbSEC.",".$cmbESP.")";
					}else
						//$qry = "UPDATE MATRICULATPSINCURSO SET INTEGRADO=".$int.",INDIGENA=".$aoi.",ESTADO=".$enP.",TITULO=".$txtNRO.",FECHA=to_date('" . $FechaMatric . "','DD MM YYYY') WHERE (RDB=".$_INSTIT.") AND (RUT_ALUMNO=".$txtRUT.") AND (ID_ANO=".$_ANO.")";
					$qry = "UPDATE MATRICULATPSINCURSO SET RDB=".$rdb.", ID_ANO=".$ano.", FECHA=to_date('" . $FechaMatric . "','DD MM YYYY'), INTEGRADO=".$int.", INDIGENA=".$aoi.", ESTADO=".$enP.", TITULO=".$txtTITULO.", COD_TIPO=".$cmbENS.", COD_SECTOR=".$cmbSEC.", COD_ESP=".$cmbESP." WHERE (RDB=".$_INSTIT.") AND (RUT_ALUMNO='".$txtRUT."') AND (ID_ANO=".$_ANO.")";
					$result =@pg_Exec($conn,$qry);
					if (!$result)
					error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>'.$qry);

				//ALUMNO-CALIFICA-RAMO	
				echo "<html><title>ADVERTENCIA</title></head>";
				echo "<body><center>";
				echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
				echo "ADVERTENCIA: EL ALUMNO YA SE ENCUENTRA PREVIAMENTE INGRESADO AL SISTEMA.";
				echo "<BR>";
				echo "LA INFORMACION HA SIDO ACTUALIZADA...";
				echo "<BR><BR><BR>";
				echo "<INPUT TYPE=button value=CONTINUAR onClick=document.location=\"listarMatricula.php3\";>";
				echo "</center></body></html>";
			}else{
				$qry="INSERT INTO ALUMNO (RUT_ALUMNO, DIG_RUT, NOMBRE_ALU, APE_PAT, APE_MAT, CALLE, NRO, DEPTO, BLOCK, VILLA, REGION, CIUDAD, COMUNA, TELEFONO, SEXO, EMAIL, FECHA_NAC, NACIONALIDAD) VALUES ('".trim($txtRUT)."','".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtCALLE)."','".trim($txtNRO)."','".trim($txtDEP)."','".trim($txtBLO)."','".trim($txtVIL)."',".trim($txtREG).",".trim($txtCIU).",".trim($txtCOM).",'".trim($txtTELEF)."',".trim($cmbSEXO).",'".trim($txtEMAIL)."','".trim(fEs2En($txtNAC))."'," . intval(trim($cmbNac)) .")";
				$result =@pg_Exec($conn,$qry);
				if (!$result)
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>'.$qry);
				$qry="INSERT INTO MATRICULATPSINCURSO (RUT_ALUMNO,RDB,ID_ANO,FECHA,INTEGRADO,INDIGENA,ESTADO,TITULO,COD_TIPO,COD_SECTOR,COD_ESP) VALUES ('".trim($txtRUT)."',".$rdb.",".$ano.",to_date('" . $FechaMatric . "','DD MM YYYY'),".$int.",".$aoi.",".$enP.",".$txtTITULO.",".$cmbENS.",".$cmbSEC.",".$cmbESP.")";
				$result =@pg_Exec($conn,$qry);
				if (!$result)
				error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>'.$qry);
				//ALUMNO-CALIFICA-RAMO	
				echo "<script>window.location = 'listarMatricula.php3'</script>";
			}
		}
}

if ($frmModo=="modificar") {

	$qry="UPDATE alumno SET nombre_alu = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$txtREG.", ciudad = ".$txtCIU.", comuna = ".$txtCOM.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", email = '".trim($txtEMAIL)."', fecha_nac = '".fEs2En($txtNAC)."', nacionalidad=" . $cmbNac . " WHERE (((rut_alumno)='".$txtRUT."'))";
	$result =@pg_Exec($conn,$qry);
	if (!$result)
	error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>'.$qry);

	$qry = "UPDATE MATRICULATPSINCURSO SET RDB=".$rdb.", ID_ANO=".$ano.", FECHA=to_date('" . $FechaMatric . "','DD MM YYYY'), INTEGRADO=".$int.", INDIGENA=".$aoi.", ESTADO=".$enP.", TITULO=".$txtTITULO.", COD_TIPO=".$cmbENS.", COD_SECTOR=".$cmbSEC.", COD_ESP=".$cmbESP." WHERE (RDB=".$_INSTIT.") AND (RUT_ALUMNO='".$txtRUT."') AND (ID_ANO=".$_ANO.")";
	$result =@pg_Exec($conn,$qry);
	if (!$result)
		error('<b> ERROR :</b>Error al acceder a la BD. (8)'.$qry);
		else
			echo "<script>window.location = 'listarMatricula.php3'</script>";
}

if ($frmModo=="eliminar") {

	$qry="SELECT * FROM USUARIO WHERE RUT_ALUMNO='".$_ALUMNO."'";
	$result = @pg_Exec($conn,$qry);
	$fila	= @pg_fetch_array($result,0);

	$qryU="SELECT * FROM ACCEDE WHERE ID_USUARIO=".$fila['id_usuario']." AND RDB=".$_INSTIT; 
	$resultU = @pg_Exec($conn,$qryU);
	
	 if (@pg_numrows($resultU)!=0){ 
		for($i=0 ; $i < @pg_numrows($resultU) ; $i++){
		 $filaU = @pg_fetch_array($resultU,$i);

	$qry="DELETE FROM ACCEDE WHERE ID_USUARIO=".$filaU['id_usuario']." AND RDB=".$_INSTIT; // BORRANDO LOS ACCESOS
	$result =@pg_Exec($conn,$qry);
	
		}
	}
	
	$qry="DELETE FROM MATRICULATPSINCURSO WHERE RUT_ALUMNO='".$_ALUMNO."' AND RDB=".$_INSTIT." AND ID_ANO =".$_ANO;
	$result =@pg_Exec($conn,$qry);
	if (!$result){
		error('<b> ERROR :</b>Error al acceder a la BD. (14)'.$qry);
	}else{
		echo "<script>window.location = 'listarMatricula.php3'</script>";
	}
}
?>