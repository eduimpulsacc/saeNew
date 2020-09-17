<?php require('../../../../util/header.inc');
//require_once("../../../clases/soap/consultas_webservices_mineduc.php");


	
	
 	$frmModo		=$_FRMMODO;
	
	$qry="select region,ciudad,comuna from institucion where RDB=".$_INSTIT."";
	$result = pg_Exec($conn,$qry);
	$fila_2	= pg_fetch_array($result,0);
	$cod_reg=trim($fila_2['region']);
	$cod_prov=trim($fila_2['ciudad']);
	$cod_comuna=trim($fila_2['comuna']);
	

	if(trim($txtREG)=="") $txtREG=$cod_reg;
	if(trim($txtCIU)=="") $txtCIU=$cod_prov;
	if(trim($txtCOM)=="" OR trim($txtCOM)==0) $txtCOM=$cod_comuna."_".$cod_prov."_".$cod_reg;
	if(trim($NumerMatric)=="")  $NumerMatric=0;
	if(trim($txtNRO)=="") $txtNRO="0";
	if(trim($txtBLO)=="") $txtBLO="0";
	
	if ($txtSALUD==NULL){
	    $txtSALUD=".";
	}
	if ($txtREL==NULL){
	    $txtREL=".";
	}	
		
	if ($prioritario==NULL){
	    $prioritario=0;
	}
	
	$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$_ANO;
	$result = pg_Exec($conn,$qry);
	$fila	= pg_fetch_array($result,0);
	$ano_act=$fila['nro_ano'];


if ($frmModo=="ingresar") {
	$sqlnumMat = "select max(nro_lista)as nro from matricula where id_curso=".$cmbCURSO;
	$resultnumMat = pg_Exec($conn,$sqlnumMat);
	$filanumMat = pg_fetch_array($resultnumMat,0);
	$numero=$filanumMat['nro'];
	$num = $numero + 1;


	//VERIFICAR EXISTENCIA PREVIA
	 $qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".trim($txtRUT);
	$result =pg_Exec($conn,$qry);
	if (!$result)
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	else{
		if(pg_numrows($result)!=0){
			    $dd = substr($txtNAC,0,2);
				$mm = substr($txtNAC,3,2);
				$aa = substr($txtNAC,6,4);
				
				$txtNAC = "$aa-$mm-$dd";
				
				$separa = explode("_",$txtCOM);
				$qry="UPDATE alumno SET nombre_alu = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$separa[2].", ciudad = ".$separa[1].", comuna = ".$separa[0].", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", email = '".trim($txtEMAIL)."', fecha_nac = '".$txtNAC."', nacionalidad=" . $cmbNac . ", salud = '$txtSALUD', religion = '$txtREL', colegioprocedencia = '$txtCOLEGIOPROCEDENCIA', cursosrep = '$txtCURSOSREP', junaeb= '$txtJUNAEB', ingestab = '$txtINGESTAB', pasaporte='".trim($txtPASAPORTE)."', prioritario = '$prioritario' WHERE (((rut_alumno)=".$txtRUT."));";
				$result =@pg_Exec($conn,$qry);
				
				
				$qry="SELECT * FROM MATRICULA WHERE RUT_ALUMNO=".$txtRUT." AND RDB=".$_INSTIT." AND ID_ANO=".$_ANO;
				$result =pg_Exec($conn,$qry);

				if(pg_numrows($result)==0){
					
					$qry="INSERT INTO MATRICULA (RUT_ALUMNO,RDB,ID_ANO,ID_CURSO,FECHA,NUM_MAT,BOOL_BAJ,BOOL_BCHS,BOOL_AOI,BOOL_RG,BOOL_AE,BOOL_I,BOOL_GD,BOOL_AR,NRO_LISTA) VALUES (".trim($txtRUT).",".trim($_INSTIT).",".$_ANO.",".$cmbCURSO.",to_date('" . $FechaMatric . "','DD MM YYYY'),".$NumerMatric.",0,0,0,0,0,0,0,0,".$num.")";
					$result =pg_Exec($conn,$qry);
					
/////////////////					
										
					$qryA="Select * from matricula where rut_alumno=".$txtRUT." and id_ano=".$ano;
					$resultA =pg_Exec($conn,$qryA);
					$filaA	= pg_fetch_array($resultA,0);
						
					if ($filaA['id_curso']!=$cmbCURSO){
							
						$qryE="INSERT INTO tiene$ano_act (RUT_ALUMNO,ID_RAMO,ID_CURSO)VALUES(".trim($txtRUT).",$ramo,$cmbCURSO)"; 
						$resultE =pg_Exec($conn,$qryE);
					
					}	
					
					$qryC="Select * from ramo where id_curso=".$cmbCURSO;
					$resultC =pg_Exec($conn,$qryC);
					if (!$resultC) {
						error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qryC);
					} 
								   
					if (pg_numrows($resultC)!=0){ 
						for($i=0 ; $i < pg_numrows($resultC) ; $i++){
							$filaC = pg_fetch_array($resultC,$i);
							$ramo=$filaC['id_ramo'];
												
							$qryE="INSERT INTO tiene$ano_act (RUT_ALUMNO,ID_RAMO,ID_CURSO)VALUES(".trim($txtRUT).",$ramo,$cmbCURSO)"; 
							$resultE =pg_Exec($conn,$qryE);
						}
					}
				}
				else {
					 $qryA="Select * from matricula where rut_alumno=".$txtRUT." and id_ano=".$ano;
					$resultA =pg_Exec($conn,$qryA);
					$filaA	= pg_fetch_array($resultA,0);
					
					if ($filaA['id_curso']!=$cmbCURSO){
						$qryE="DELETE FROM tiene$ano_act WHERE rut_alumno=".$txtRUT;
						$resultE =pg_Exec($conn,$qryE);
					}
													
					$qry = "UPDATE MATRICULA SET ID_CURSO=" . $cmbCURSO . ", FECHA=to_date('" . $FechaMatric . "','DD MM YYYY'), nro_lista=".$num." WHERE (RDB=".$_INSTIT.") AND (RUT_ALUMNO=".$txtRUT.") AND (ID_ANO=".$_ANO.")";
					$result =pg_Exec($conn,$qry);

					$qryC="Select * from ramo where id_curso=".$cmbCURSO;
					$resultC =pg_Exec($conn,$qryC);
					if (!$resultC) {
						error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qryC);
					}
					if (pg_numrows($resultC)!=0){ 
						for($i=0 ; $i < pg_numrows($resultC) ; $i++){
							$filaC = pg_fetch_array($resultC,$i);
							$ramo=$filaC['id_ramo'];
																
							$qryE="INSERT INTO tiene$ano_act (RUT_ALUMNO,ID_RAMO,ID_CURSO)VALUES(".trim($txtRUT).",$ramo,$cmbCURSO)"; 
							$resultE =@pg_Exec($conn,$qryE);
						}
					}
				}

				//ALUMNO-CALIFICA-RAMO	
				echo "<html><title>ADVERTENCIA</title><head>";
				echo "<link href='../../../../../../".$_ESTILO."' rel='stylesheet' type='text/css'>";
				echo "</head><body><center>";
				echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
				echo "<span class='tableindex'>ADVERTENCIA: EL ALUMNO YA SE ENCUENTRA PREVIAMENTE INGRESADO AL SISTEMA.</span>";
				echo "<BR>";
				echo "<span class='tableindex'>LA INFORMACION HA SIDO ACTUALIZADA...</span>";
				echo "<BR><BR><BR>";
				echo "<INPUT TYPE=button value=CONTINUAR onClick=document.location=\"listarMatricula.php3\";>";
				echo "</center></body></html>";
				
				
			}else{
			    $dd = substr($txtNAC,0,2);
				$mm = substr($txtNAC,3,2);
				$aa = substr($txtNAC,6,4);
				
				$txtNAC = "$aa-$mm-$dd";
			
				if((intval(trim($cmbNac)))==1){
					$separa = explode("_",$txtCOM);
					$qry="INSERT INTO ALUMNO (RUT_ALUMNO, NOMBRE_ALU, APE_PAT, APE_MAT, CALLE, NRO, DEPTO, BLOCK, VILLA, REGION, CIUDAD, COMUNA, TELEFONO, SEXO, EMAIL, FECHA_NAC, NACIONALIDAD,SALUD,RELIGION,COLEGIOPROCEDENCIA, CURSOSREP, JUNAEB, INGESTAB, prioritario) VALUES (".trim($txtRUT).",'".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtCALLE)."','".trim($txtNRO)."','".trim($txtDEP)."','".trim($txtBLO)."','".trim($txtVIL)."',".trim($separa[2]).",".trim($separa[1]).",".trim($separa[0]).",'".trim($txtTELEF)."',".trim($cmbSEXO).",'".trim($txtEMAIL)."','".$txtNAC."'," . intval(trim($cmbNac)) .",'$txtSALUD','$txtREL','$txtCOLEGIOPROCEDENCIA', '$txtCURSOSREP', '$txtJUNAEB', '$txtINGESTAB','$prioritario')";
					$result =@pg_Exec($conn,$qry);
				}else{
					
					/*--------------------------------------VALIDA VACANTES------------VALPARAISO-------------------------------------------------
					
				 	$sqlcurso="select grado_curso from curso where ID_CURSO=".$cmbCURSO;
					$resultcurso =@pg_Exec($conn,$sqlcurso);
					$filaCurso = pg_fetch_array($resultcurso,0);
				 
					$sqlvac="select vac_dis from vacantes where grado=".$filaCurso["grado_curso"];
					$resultvac =@pg_Exec($conn,$sqlvac);
					$filavac = pg_fetch_array($resultvac,0);
					
					if($filavac["vac_dis"]==0){*/
					 ?>
					 <script language="javascript">
						/*alert("Curso ya no tiene Vacantes");
					 	var pagina = 'matricula.php3';
				    	document.location.href=pagina;*/
					 </script>
					 <?
					/*}else{
						 consulta principal*/ 
						$separa = explode("_",$txtCOM);
						$qry="INSERT INTO ALUMNO (RUT_ALUMNO, DIG_RUT, NOMBRE_ALU, APE_PAT, APE_MAT, CALLE, NRO, DEPTO, BLOCK, VILLA, REGION, CIUDAD, COMUNA, TELEFONO, SEXO, EMAIL, FECHA_NAC, NACIONALIDAD, SALUD, RELIGION, COLEGIOPROCEDENCIA, CURSOSREP, JUNAEB, INGESTAB, PASAPORTE, prioritario) VALUES (".trim($txtRUT).",'".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtCALLE)."','".trim($txtNRO)."','".trim($txtDEP)."','".trim($txtBLO)."','".trim($txtVIL)."',".trim($separa[2]).",".trim($separa[1]).",".trim($separa[0]).",'".trim($txtTELEF)."',".trim($cmbSEXO).",'".trim($txtEMAIL)."','".$txtNAC."'," . intval(trim($cmbNac)) .",'$txtSALUD','$txtREL', '$txtCOLEGIOPROCEDENCIA','$txtCURSOSREP','$txtJUNAEB','$txtINGESTAB','".trim($txtPASAPORTE)."','$prioritario')";
						/*$resta= $filavac["vac_dis"]-1;
						$sqlvacantes="UPDATE vacantes SET vac_dis =".$resta." WHERE grado=".$filaCurso["grado_curso"];
						$result2 =@pg_Exec($conn,$sqlvacantes);*/
						$result =@pg_Exec($conn,$qry);
						/*
					}
					---------------------------------------------------------------------------------------------------------------------------------
					*/
				}
				
				/* consulta*/
				$qry="INSERT INTO MATRICULA (RUT_ALUMNO,RDB,ID_ANO,ID_CURSO,FECHA,NUM_MAT,BOOL_BAJ,BOOL_BCHS,BOOL_AOI,BOOL_RG,BOOL_AE,BOOL_I,BOOL_GD,BOOL_AR) VALUES ('".trim($txtRUT)."',".$rdb.",".$ano.",".$cmbCURSO.",to_date('" . $FechaMatric . "','DD MM YYYY'),".$NumerMatric.",0,0,0,0,0,0,0,0)";
				$result =@pg_Exec($conn,$qry);
				
	
	
	/////////////////////////ALUMNO-CALIFICA-RAMO
				
							
							
				$qryC="select * from ramo where id_curso=".$cmbCURSO;
				$resultC =@pg_Exec($conn,$qryC);
				if (!$resultC) {
					error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qryC);
				}
				if (pg_numrows($resultC)!=0){ 
					for($i=0 ; $i < pg_numrows($resultC) ; $i++){
						$filaC = pg_fetch_array($resultC,$i);
						$ramo=$filaC['id_ramo'];
						
						$qryE="INSERT INTO tiene$ano_act (RUT_ALUMNO,ID_RAMO,ID_CURSO) VALUES(".trim($txtRUT).",$ramo,$cmbCURSO)"; 
						$resultE =@pg_Exec($conn,$qryE);
					}
				}
				
				
				

				echo "<script>window.location = 'listarMatricula.php3'</script>";
			}
		}
}



if ($frmModo=="modificar") {
   if ($txtCOLEGIOPROCEDENCIA==NULL){
       $txtCOLEGIOPROCEDENCIA = ".";
   }
   if ($txtCURSOSREP==NULL){
       $txtCURSOSREP = ".";
   }	   

if($txtCOM==0) $txtCOM = "0_0_0";
$separa = explode("_",$txtCOM);
$direc = str_replace("'","",$txtCALLE);
	if ($txtNAC==""){
	  $qry="UPDATE alumno SET nombre_alu = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($direc)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".trim($separa[2]).", ciudad = ".trim($separa[1]).", comuna = ".trim($separa[0]).", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", email = '".trim($txtEMAIL)."', fecha_nac = Null, nacionalidad=" . $cmbNac . ", salud = '$txtSALUD', religion = '$txtREL', colegioprocedencia = '$txtCOLEGIOPROCEDENCIA', cursosrep = '$txtCURSOSREP', junaeb = '$txtJUNAEB', ingestab = '$txtINGESTAB', prioritario = '$prioritario'  WHERE (((rut_alumno)=".$txtRUT."));";
	
	 }else{		
	 
	    $dd = substr($txtNAC,0,2);
		$mm = substr($txtNAC,3,2);
		$aa = substr($txtNAC,6,4);
		
		$txtNAC = "$aa-$mm-$dd";
	 
	 		
	  $qry="UPDATE alumno SET nombre_alu = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($direc)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".trim($separa[2]).", ciudad = ".trim($separa[1]).", comuna = ".trim($separa[0]).", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", email = '".trim($txtEMAIL)."', fecha_nac = '".$txtNAC."', nacionalidad=" . $cmbNac . ", salud = '$txtSALUD', religion = '$txtREL', colegioprocedencia = '$txtCOLEGIOPROCEDENCIA', cursosrep = '$txtCURSOSREP', junaeb = '$txtJUNAEB', ingestab = '$txtINGESTAB', pasaporte='".trim($txtPASAPORTE)."', prioritario = '$prioritario' WHERE (((rut_alumno)=".$txtRUT."));";
	 

	}
	$result =pg_Exec($conn,$qry);
		if (!$result)
		error('<b> ERROR :</b>Error al acceder a la BD. (33)'.$qry);
		else {
		
	$qryA="Select * from matricula where rut_alumno=".$txtRUT ." and id_ano=".$ano;
	$resultA =pg_Exec($conn,$qryA);
	$filaA	= pg_fetch_array($resultA,0);
			if ($filaA['id_curso']!=$cmbCURSO){
				$qryE="DELETE FROM tiene$ano_act WHERE rut_alumno=".$txtRUT;
				$resultE =pg_Exec($conn,$qryE);
			}
			$qryC="Select * from ramo where id_curso=".$cmbCURSO;
			$resultC =pg_Exec($conn,$qryC);
			  	if (!$resultC) {
					error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qryC);
			   	}
				if (pg_numrows($resultC)!=0){ 
				for($i=0 ; $i < pg_numrows($resultC) ; $i++){
					$filaC = pg_fetch_array($resultC,$i);
					$ramo=$filaC['id_ramo'];
					
					$qryE="INSERT INTO tiene$ano_act (RUT_ALUMNO,ID_RAMO,ID_CURSO) VALUES(".trim($alumno).",$ramo,".$cmbCURSO.")"; 
					$resultE = @pg_Exec($conn,$qryE);
					//----------- ULTIMO CAMBIO PARA LA ACTUALIZACION DE LAS NOTAS EN EL CASO DEL CAMBIO DE CURSO--------------
					$qry="";
					$qry = "SELECT id_ramo FROM ramo WHERE id_curso=".$filaA['id_curso']." AND cod_subsector=".$filaC['cod_subsector'];
					$resultNot = pg_exec($conn,$qry);
					$filsNot = @pg_fetch_array($resultNot,0);
					
					if(pg_numrows($resultNot)!=0){
					$qry="";
					//------------- $qry ="UPDATE notas$ano_act SET id_ramo=".$ramo." WHERE id_ramo=".$filsNot['id_ramo'];
					$qry ="UPDATE notas$ano_act SET id_ramo=".$ramo." WHERE id_ramo=".$filsNot['id_ramo']." AND rut_alumno=".$alumno."";
					$Rs_Notas = pg_exec($conn,$qry);
					}
					//--------------- FIN CAMBIO

					}
				}
							
				}
			
	$qry="UPDATE MATRICULA SET ID_CURSO=".$cmbCURSO.", FECHA=to_date('" . $FechaMatric . "','DD MM YYYY'), num_mat=".$NumerMatric." WHERE RUT_ALUMNO=".$alumno." AND RDB=".$rdb." AND ID_ANO =".$ano;
	$result =pg_Exec($conn,$qry);
	if (!$result)
		error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
		else
			echo "<script>window.location = 'listarMatricula.php3'</script>";
		}

if ($frmModo=="eliminar") {

	//$qry="SELECT * FROM USUARIO WHERE RUT_ALUMNO=".$_ALUMNO;
	$qry="SELECT * FROM USUARIO WHERE nombre_usuario='".$_ALUMNO."'";
	$result = @pg_Exec($conn,$qry);
	$fila	= @pg_fetch_array($result,0);

	$qryU="SELECT * FROM ACCEDE WHERE ID_USUARIO=".$fila['id_usuario']." AND RDB=".$_INSTIT; 
	$resultU = @pg_Exec($conn,$qryU);
	
	 if (@pg_numrows($resultU)!=0){ 
		for($i=0 ; $i < pg_numrows($resultU) ; $i++){
		 $filaU = pg_fetch_array($resultU,$i);

	$qry="DELETE FROM ACCEDE WHERE ID_USUARIO=".$filaU['id_usuario']." AND RDB=".$_INSTIT; // BORRANDO LOS ACCESOS
	$result =pg_Exec($conn,$qry);
	
		}
	}

	$qry="SELECT * FROM MATRICULA WHERE RUT_ALUMNO=".$_ALUMNO." AND ID_ANO=".$_ANO;
	$result = pg_Exec($conn,$qry);
	$fila	= @pg_fetch_array($result,0);
		
	 if (pg_numrows($result)!=0){ 
		for($i=0 ; $i < pg_numrows($result) ; $i++){
		 $filat = pg_fetch_array($result,$i);
		 $curso = $filat['id_curso'];

		$qry="DELETE FROM tiene$ano_act WHERE RUT_ALUMNO=".$_ALUMNO." AND ID_CURSO=".$curso;
		$result =pg_Exec($conn,$qry);
		if (!$result){
			error('<b> ERROR :</b>Error al acceder a la BD. (3)');
		}
      }
	} 
	$qry="DELETE FROM MATRICULA WHERE RUT_ALUMNO=".$_ALUMNO." AND RDB=".$_INSTIT." AND ID_ANO =".$_ANO;
	$result =pg_Exec($conn,$qry);
	if (!$result){
		error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
	}else{

		/*echo "<script>window.location = 'listarMatricula.php3'</script>";*/
	}
}
?>