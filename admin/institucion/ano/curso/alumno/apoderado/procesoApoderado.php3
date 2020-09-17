<?php require('../../../../../../util/header.inc');?>
<?php

$alumno			=$_ALUMNO;
$ano            =$_ANO;
$institucion	=$_INSTIT;
$curso			=$_CURSO;




$pesta	=$_REQUEST['pesta'];
if(!isset($pesta)){
	$pesta=$_PESTA;
}

if($_PERFIL==0){
	$sql="select num_corp from corp_instit where rdb=".$institucion;
	$rs_corp=pg_exec($conn,$sql);
	$corporacion=pg_result($rs_corp,0);
}else{
	$corporacion=$_CORPORACION;
}
if($corporacion==1 || $corporacion==13 || $corporacion==14 || $corporacion==15 || $corporacion==16 || $corporacion==17 || $corporacion==18 || $corporacion==19 || $corporacion==20){
	$fecha ="fEs2En";
}else{
	$fecha ="fEs2En2";
}

if($pestaA!=""){
	$pesta=$_GET['pestaA'];
}

if (trim($pesta) == 5){
    // actualizamosm los datos dela pestaña Becas
	if($MUN)		$MUN=1;		else	$MUN=0;
	if($CPADRE)		$CPADRE=1;	else	$CPADRE=0;
    if($OTROS)      $OTROS=1;   else    $OTROS=0;
	if($SEG)        $SEG=1;     else    $SEG=0;
	if($BAJ)        $BAJ=1;     else    $BAJ=0;
	if($BCHS)       $BCHS=1;    else    $BCHS=0;
	if($SEP)       	$SEP=1;    	else    $SEP=0;
	if($FCI)       	$SEP=1;    	else    $FCI=0;
	
	
	
	
	$qry2="UPDATE matricula SET bool_baj ='".$BAJ."',bool_bchs ='".$BCHS."',bool_mun ='".$MUN."', bool_cpadre ='".$CPADRE."', bool_otros ='".$OTROS."', bool_seg='".$SEG."', ben_sep='".$SEP."', bool_fci='".$FCI."'  WHERE (((rut_alumno)='".trim($_ALUMNO)."') AND (ID_ANO='".trim($ano)."'));";
	$result2 = @pg_Exec($conn,$qry2);  
	if (!$result2) {
	    echo "Error, al intentar actualizar 111".$qry2;	
	    exit();       
	}else{
	    $_FRMMODO = "mostrar";
		echo "<script>window.location = '../alumno.php3?pesta=5'</script>";
	}
	
}	
	




if ($pesta == 3 and $_FRMMODO == "modificar"){

   // modificamos los antecedentes academicos
         if($RDG)		$RDG=1;		else	$RDG=0;
	     if($I)		    $I=1;		else	$I=0;
         if($AR)        $AR=1;      else    $AR=0;
		 if($ED)        $ED=1;      else    $ED=0;
		 if(pg_dbname($conn)=="coi_antofagasta"){
			$retiro= $FechaRetiro;
		 }else{
			 $retiro=fEs2En($FechaRetiro);
		 }
		 
	   if (($FechaRetiro !="") and ($AR==1)) {
	       		 $qry2="UPDATE matricula SET bool_rg ='".$RDG."', bool_i ='".$I."', bool_ar ='".$AR."', fecha_retiro = '".$retiro."', bool_ed='".$ED."',condicionalidad='".$condicional."'  WHERE rut_alumno='".trim($_ALUMNO)."' AND ID_ANO='".trim($ano)."' AND ID_CURSO='".trim($curso)."';";
		     
				  
	   }else{
	        
		    if (($FechaRetiro =="") or ($AR==0)) {
			      $qry2="UPDATE matricula SET  bool_rg ='".$RDG."', bool_i ='".$I."', bool_ar ='".$AR."', fecha_retiro = NULL, bool_ed='".$ED."',condicionalidad='".$condicional."'  WHERE rut_alumno='".trim($_ALUMNO)."' AND ID_ANO='".trim($ano)."' AND ID_CURSO='".trim($curso)."' ;";
			 }
	   }     

	   $result2 = @pg_Exec($conn,$qry2);  
	   if (!$result2) {
	       echo "Error, al intentar actualizar 222".$qry2;	
		   exit();       
	   }else{
	       $_FRMMODO = "mostrar";
		 echo   "<script>window.location = '../alumno.php3?pesta=3'</script>";
	   }	   
	       
}	   
	   	 




if ($caso == 9){ //Eliminamos un hermano

   $q1 = "delete from hermanos where rut_hermano = '$_HERMANOMOD'";
   $r1 = pg_Exec($conn,$q1);
   $q1 = "delete from relacion_hermanos where rut_hermano = '$_HERMANOMOD'";
   $r1 = pg_Exec($conn,$q1);   
   $_FRMMODOH = "mostrar";
   $_FRMMODO = "mostrar";
    echo "<script>window.location = '../alumno.php3?pesta=2'</script>";
}

$dd=substr($fecha_nac,0,2);
$mm=substr($fecha_nac,3,2);
$aa=substr($fecha_nac,6,4);
$fecha_nac="$dd-$mm-$aa";

		

if ($modh == 1){  // modificamos los datos de un hermano
 	 $qry = "update hermanos set nombre_hermano = '$nombre_hermano', ape_pat = '$ape_pat', ape_mat = '$ape_mat', estudios = '$estudios', fecha_nac = '$fecha_nac' where rut_hermano = '$_HERMANOMOD' and rut_alumno = '$_ALUMNO'";
		pg_Exec($conn,$qry);		
   $_FRMMODOH = "mostrar";
   $_FRMMODO = "mostrar";
   echo "<script>window.location = 'seteaHermano.php?caso=1&pesta=2'</script>";  
}	


//$pestah == 1

if ($pesta == 2){
if ($txtNOMBRE == NULL && $_APODERADO==NULL){ // proceso para los hermanos
   //VERIFICAR EXISTENCIA PREVIA
	
	
   if ($rut_hermano==NULL){
       echo "<script>alert('Atención Rut Hermano es nulo, vuelva a ingresar.');</script>";
	   echo "<script>window.location='../alumno.php3?pesta=2'</script>";
	   exit();
   }	   
   

	$qry="SELECT * FROM hermanos WHERE rut_hermano='".trim($rut_hermano)."' and rut_alumno = '".trim($_ALUMNO)."'";
	$result =@pg_Exec($conn,$qry);
	if (!$result){
	    echo "la qry es: $qry <br>";
		echo '<B> ERROR :</b>Error al acceder a la BD. (1)</B>'; exit;
	}else{
		if(pg_numrows($result) > 0 and $_FRMMODOH != "ingresar") {
			    // actualizamos la información exitente		
				$qry="UPDATE hermanos SET nombre_hermano = '".trim($nombre_hermano)."', ape_pat = '".trim($ape_pat)."', ape_mat = '".trim($ape_mat)."', fecha_nac = '".fEs2En($fecha_nac)."', estudios = '".trim($estudios)."', dig_rut = '".trim($dig_rut)."'WHERE (((rut_hermano)=".$rut_hermano."))";
				$result =@pg_Exec($conn,$qry);
				if(!$result){
					echo '<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$qry; exit;
				}else{
					$qry="SELECT * FROM relacion_hermanos WHERE rut_hermano=".$rut_hermano." AND RUT_ALUMNO='".trim($_ALUMNO)."'";
					$result =@pg_Exec($conn,$qry);
					if(!$result){
						echo '<B> ERROR :</b>Error al acceder a la BD. (33)</B>'.$qry; exit;
						}else{
						if(pg_numrows($result)==0){      
							$qry="INSERT INTO relacion_hermanos (rut_hermano,RUT_ALUMNO) VALUES ('".trim($rut_hermano)."','".$_ALUMNO."')";
							$result =@pg_Exec($conn,$qry);
							if (!$result){
								echo '<B> ERROR :</b>Error al acceder a la BD. (4)</B>'.$qry; exit;
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
				$_FRMMODO = "mostrar";
				
				
				echo "<INPUT TYPE=button value=CONTINUAR onClick=document.location=\"../alumno.php3?pesta=2\";>";
				echo "</center></body></html>";
			}else{
			    $dd=substr($fecha_nac,0,2);
				$mm=substr($fecha_nac,3,2);
				$aa=substr($fecha_nac,6,4);
				$fecha_nac="$mm-$dd-$aa";
				
			$qry="INSERT INTO hermanos ( rut_hermano,dig_rut,nombre_hermano,ape_pat,ape_mat,fecha_nac,estudios,rut_alumno) VALUES ('".trim($rut_hermano)."','".trim($dig_rut)."','".trim($nombre_hermano)."','".trim($ape_pat)."','".trim($ape_mat)."','".trim($fecha_nac)."','".trim($estudios)."','".trim($_ALUMNO)."')";
				$result =pg_Exec($conn,$qry);
				if (!$result) {
					echo "<B> ERROR :</b>Error al acceder a la BD. (50)</B>".$qry; exit;
				}else{
				    $_FRMMODOH = "mostrar";	
					echo "<script>window.location = '../alumno.php3?pesta=2'</script>";
				}				
				
				$qry="INSERT INTO relacion_hermanos (rut_hermano,rut_alumno) VALUES ('".trim($rut_hermano)."','".trim($_ALUMNO)."')";
				$result =@pg_Exec($conn,$qry);
				if (!$result){
					echo '<B> ERROR :</b>Error al acceder a la BD. (6)</B>'; exit;
				}else{
				    $_FRMMODOH = "mostrar";				
					echo "<script>window.location = '../alumno.php3?pesta=2'</script>";
				}
			}
		}
		
		
	
}else{  // el proceso es para el apoderado	
	
	$frmModo= $_FRMMODO;
	

	if ($_APODERADO == NULL){
		$_APODERADO	=	$apoderado;
	    if(!session_is_registered('_APODERADO')){
		   session_register('_APODERADO');
	    }
	}	

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
	
/*if($txtREG=="")
	$txtREG=1;
if($txtCIU=="")
	$txtCIU=1;
if($txtCOM=="")
	$txtCOM=1;
*/

if ($frmModo=="ingresar"){
	
    // determinar la ciudad y la region segun la comuna selecionada //
    $q10 = "select * from comuna where nom_com = '".trim($m4)."'"; 
	
		$r10 = pg_Exec($conn,$q10);
		if (!$r10){
		   echo "Error, no encontré la comuna <br>";
		   exit();
		}
		
			$f10 = pg_fetch_array($r10,0);
			$region = $f10['cod_reg'];
			$comuna = $f10['cor_com'];
			$ciudad = $f10['cor_pro']; 
	
	//VERIFICAR EXISTENCIA PREVIA
	$qry="SELECT * FROM APODERADO WHERE RUT_APO='".trim($txtRUT)."'";
	$result =@pg_Exec($conn,$qry);
	if (!$result){
	     echo "la qry es: $qry <br>";
	     error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	     exit();
		}else{
			if(pg_numrows($result)!=0){
			$dia_n = substr($txtNAC,0,2); 
			$mes_n = substr($txtNAC,3,2);
			$ano_n = substr($txtNAC,6,4);
			$txtNAC = "$ano_n-$mes_n-$dia_n";	
			
			if ($grupo_familiar==NULL || $grupo_familiar==""){
				$grupo_familiar=0;
			}
			if ($percapita==""){$percapita=0;}
			if ($ocupacion_actual==""){$ocupacion_actual="-";}
			if ($region==""){$region=0;}
			if ($ciudad==""){$ciudad=0;}
			if ($comuna==""){$comuna=0;}
			if ($situacion_familiar==""){$situacion_familiar="-";}
			if ($direccion_lab==""){$direccion_lab="-";}
			if ($cargo==""){$cargo="-";}
			if ($lugar_trabajo==""){$lugar_trabajo="-";}
			if ($nivel_edu==""){$nivel_edu="-";}
			if ($txtEMAIL==""){$txtEMAIL="-";}
			if ($txtTELEF==""){$txtTELEF="-";}
			if ($txtBLO==""){$txtBLO="-";}
			if ($txtVIL==""){$txtVIL="-";}
			if ($txtDEP==""){$txtDEP="-";}
			if ($txtNRO==""){$txtNRO="-";}
			if ($txtCALLE==""){$txtCALLE="-";}
			if ($txtDEP==""){$txtDEP="-";}
			
			
			
			
				if ($txtNAC=="--"){
				     // Actualizo sin fecha
					 $qry="UPDATE apoderado SET nombre_apo = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', telefono = '".trim($txtTELEF)."', relacion = ".trim($cmbRELACION).", email = '".trim($txtEMAIL)."', nivel_edu = '".$nivel_edu."', profesion = '".$profesion."', lugar_trabajo = '".$lugar_trabajo."', cargo = '".$cargo."', sexo = '".$cmbSEXO."', nacionalidad = '".$cmbNac."',nivel_social='".$nivelsocial."', direccion_lab = '".$direccion_lab."', situacion_familiar = '".$situacion_familiar."', comuna = ".trim($comuna).", ciudad = ".trim($ciudad).", region = ".trim($region).",grupo_familiar='".trim($grupo_familiar)."',percapita='".trim($percapita)."', ocupacion='".trim($ocupacion_actual)."'  WHERE rut_apo='".$txtRUT."'";
				}else{
				     // actualizo con fecha				
				    $qry="UPDATE apoderado SET nombre_apo = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', telefono = '".trim($txtTELEF)."', relacion = ".trim($cmbRELACION).", email = '".trim($txtEMAIL)."', nivel_edu = '".$nivel_edu."', profesion = '".$profesion."', lugar_trabajo = '".$lugar_trabajo."', cargo = '".$cargo."', fecha_nac = '".$txtNAC."', sexo = '".$cmbSEXO."', nacionalidad = '".$cmbNac."',nivel_social='".$nivelsocial."', direccion_lab = '".$direccion_lab."', situacion_familiar = '".$situacion_familiar."', comuna = ".trim($comuna).", ciudad = ".trim($ciudad).", region = ".trim($region).",grupo_familiar='".trim($grupo_familiar)."',percapita='".trim($percapita)."', ocupacion='".trim($ocupacion_actual)."'  WHERE rut_apo='".$txtRUT."'";
				} 
				
				$result = pg_Exec($conn,$qry);
				if(!$result){
					error('<b> ERROR :</b>Error al acceder a la BD. (31)'.$qry);
					exit();
				}else{
					$qry="SELECT * FROM TIENE2 WHERE RUT_APO=".$txtRUT." AND RUT_ALUMNO='".trim($_ALUMNO)."'";
					$result =@pg_Exec($conn,$qry);
					if(!$result){
						error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
						exit();
						}else{
						if(pg_numrows($result)==0){      
							$qry="INSERT INTO TIENE2 (RUT_APO,RUT_ALUMNO,RESPONSABLE, SOSTENEDOR) VALUES ('".trim($txtRUT)."','".$_ALUMNO."',".$chkRESP.", ".$chkSOS.")";
							$result =@pg_Exec($conn,$qry);
							if (!$result){
								error('<b> ERROR :</b>Error al acceder a la BD.(55)');
								exit();
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
				$_FRMMODO = "mostrar";
				echo "<INPUT TYPE=button value=CONTINUAR onClick=document.location=\"../alumno.php3?pesta=2\";>";
				
				echo "</center></body></html>";
			}else{
				if ($percapita==""){$percapita=0;}
			if ($ocupacion_actual==""){$ocupacion_actual="-";}
			if ($region==""){$region=0;}
			if ($ciudad==""){$ciudad=0;}
			if ($comuna==""){$comuna=0;}
			if ($situacion_familiar==""){$situacion_familiar="-";}
			if ($direccion_lab==""){$direccion_lab="-";}
			if ($cargo==""){$cargo="-";}
			if ($lugar_trabajo==""){$lugar_trabajo="-";}
			if ($nivel_edu==""){$nivel_edu="-";}
			if ($txtEMAIL==""){$txtEMAIL="-";}
			if ($txtTELEF==""){$txtTELEF="-";}
			if ($txtBLO==""){$txtBLO="-";}
			if ($txtVIL==""){$txtVIL="-";}
			if ($txtDEP==""){$txtDEP="-";}
			if ($txtNRO==""){$txtNRO="-";}
			if ($txtCALLE==""){$txtCALLE="-";}
			if ($txtDEP==""){$txtDEP="-";}
			if ($profesion==""){$profesion="-";}
					
				if($txtNAC=="")
				{
					 $qry="INSERT INTO APODERADO ( RUT_APO,DIG_RUT,NOMBRE_APO,APE_PAT,APE_MAT,CALLE,NRO,DEPTO,BLOCK,VILLA,REGION,CIUDAD,COMUNA,TELEFONO,RELACION,EMAIL, NIVEL_EDU, PROFESION, LUGAR_TRABAJO, CARGO, SEXO, NACIONALIDAD, DIRECCION_LAB, SITUACION_FAMILIAR,NIVEL_SOCIAL) VALUES ('".trim($txtRUT)."','".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtCALLE)."','".trim($txtNRO)."','".trim($txtDEP)."','".trim($txtBLO)."','".trim($txtVIL)."',".trim($region).",".trim($ciudad).",".trim($comuna).",'".trim($txtTELEF)."',".trim($cmbRELACION).",'".trim($txtEMAIL)."','".trim($nivel_edu)."','".trim($profesion)."','".trim($lugar_trabajo)."','".trim($cargo)."','".trim($cmbSEXO)."','".trim($cmbNac)."','".trim($direccion_lab)."','".trim($situacion_familiar)."','".trim($nivelsocial)."')";
				}else{	 		   	
					 $qry="INSERT INTO APODERADO ( RUT_APO,DIG_RUT,NOMBRE_APO,APE_PAT,APE_MAT,CALLE,NRO,DEPTO,BLOCK,VILLA,REGION,CIUDAD,COMUNA,TELEFONO,RELACION,EMAIL, NIVEL_EDU, PROFESION, LUGAR_TRABAJO, CARGO, FECHA_NAC, SEXO, NACIONALIDAD, DIRECCION_LAB, SITUACION_FAMILIAR,NIVEL_SOCIAL) VALUES ('".trim($txtRUT)."','".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtCALLE)."','".trim($txtNRO)."','".trim($txtDEP)."','".trim($txtBLO)."','".trim($txtVIL)."','".trim($region)."','".trim($ciudad)."','".trim($comuna)."','".trim($txtTELEF)."',".trim($cmbRELACION).",'".trim($txtEMAIL)."','".trim($nivel_edu)."','".trim($profesion)."','".trim($lugar_trabajo)."','".trim($cargo)."','".fEs2En($txtNAC)."','".trim($cmbSEXO)."','".trim($cmbNac)."','".trim($direccion_lab)."','".trim($situacion_familiar)."','".trim($nivelsocial)."')";
				}					
		
				$result =@pg_Exec($conn,$qry);

			   /* $qry2="insert into anxapoderado values ('$txtRUT','$cmbDIA','$_INSTIT')";
				@pg_Exec($conn,$qry2);
				
				if (!$result) {
				   echo "Error: ==> $qry2 <br>";
				   error('<b> ERROR :</b>Error al acceder a la BD.(1)');
				   exit();
				}else{  */ 
					 $qry="INSERT INTO TIENE2 (RUT_APO,RUT_ALUMNO,RESPONSABLE, SOSTENEDOR) VALUES ('".trim($txtRUT)."','".trim($alumno)."','".$chkRESP."','".$chkSOS."')";
					$result =@pg_Exec($conn,$qry);
					if (!$result) {
						error('<b> ERROR :</b>Error al acceder a la BD.(2)'.$qry);
					}else{
						//echo "location 7 <br>";
						$_FRMMODO = "mostrar";
						
						//if($_PERFIL==0){
						//	break;
						//}else{
						echo "<script>window.location = '../alumno.php3?pesta=2'</script>";
						//}
					}
					
				//}
			}
		}
}




if ($frmModo=="modificar") {

	$qry_comuna = "select * from comuna where nom_com = '$m3'";
	$res_comuna = pg_Exec($conn,$qry_comuna);
	$fila_comuna = pg_fetch_array($res_comuna);
	$cor_com = $fila_comuna['cor_com'];
	$cor_pro = $fila_comuna['cor_pro'];
	$cod_reg = $fila_comuna['cod_reg'];
	
	if ($grupo_familiar==NULL || $grupo_familiar==""){
	    $grupo_familiar=0;
	}
	if ($percapita==NULL || $percapita==""){
	    $percapita=0;
	}
	
	
	if($txtNAC==""){
	    $qry="UPDATE apoderado SET nombre_apo = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$cod_reg.", ciudad = ".$cor_pro.", comuna = ".$cor_com.", telefono = '".trim($txtTELEF)."', relacion = ".trim($cmbRELACION).", email = '".trim($txtEMAIL)."', nivel_edu = '".$nivel_edu."', profesion = '".$profesion."',nivel_social = '".trim($nivelsocial)."', lugar_trabajo = '".$lugar_trabajo."', cargo = '".$cargo."', sexo = '$cmbSEXO', nacionalidad = '$cmbNac', direccion_lab = '$direccion_lab', situacion_familiar = '$situacion_familiar',grupo_familiar='".trim($grupo_familiar)."',percapita='".trim($percapita)."', ocupacion='".trim($ocupacion_actual)."'  WHERE (((rut_apo)='".trim($_APODERADO)."'))";
	
	}else{
		$qry="UPDATE apoderado SET nombre_apo = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$cod_reg.", ciudad = ".$cor_pro.", comuna = ".$cor_com.", telefono = '".trim($txtTELEF)."', relacion = ".trim($cmbRELACION).", email = '".trim($txtEMAIL)."', nivel_edu = '".$nivel_edu."', profesion = '".$profesion."',nivel_social = '".trim($nivelsocial)."', lugar_trabajo = '".$lugar_trabajo."', cargo = '".$cargo."', fecha_nac = '".fEs2En($txtNAC)."', sexo = '$cmbSEXO', nacionalidad = '$cmbNac', direccion_lab = '$direccion_lab', situacion_familiar = '$situacion_familiar',grupo_familiar='".trim($grupo_familiar)."',percapita='".trim($percapita)."', ocupacion='".trim($ocupacion_actual)."'  WHERE (((rut_apo)='".trim($_APODERADO)."'))";	
		
	}
		
		$result =pg_Exec($conn,$qry);
		if (!$result) {
		    echo "$qry <br>";
		    error('<b> ERROR :</b>Error al acceder a la BD. (323)');
		}else{
			$qry="UPDATE TIENE2 SET SOSTENEDOR=".$chkSOS.", RESPONSABLE=".$chkRESP." WHERE RUT_ALUMNO='".trim($_ALUMNO)."' AND RUT_APO='".trim($_APODERADO)."'";
			$result =@pg_Exec($conn,$qry);
			
			echo "<script>window.location = 'seteaApoderado.php3?caso=1&apoderado=".trim($_APODERADO)."'</script>";
			
		}
}





if ($frmModo=="eliminar") {       
	$qry="SELECT * FROM USUARIO WHERE NOMBRE_USUARIO='".trim($_APODERADO)."' ";
	$result = @pg_Exec($conn,$qry);
	$fila	= @pg_fetch_array($result,0);
	$qry="SELECT * FROM ACCEDE WHERE ID_USUARIO=".trim($fila['id_usuario']);
	$result = @pg_Exec($conn,$qry);
	if (@pg_numrows($result)==0){ 
		//SI NO QUEDAN PERFILES SE BORRA EL USUARIO
		$qry="DELETE FROM USUARIO WHERE ID_USUARIO=".trim($fila['id_usuario']);
		$result = @pg_Exec($conn,$qry);

	}
	
	$sq1 = "select * from tiene2 where rut_apo = '".trim($_APODERADO)."'";
	$rs1 = @pg_Exec($conn,$sq1);
	$ns1 = @pg_numrows($rs1);
	
	
	if ($ns1 > 1){
		    // no borro de apoderado, por que pertenece tambien a otro alumno
	}else{	
	
		$qry="DELETE FROM ACCEDE WHERE ID_USUARIO=".trim($fila['id_usuario'])." AND RDB=".trim($_INSTIT); // BORRANDO LOS ACCESOS
		$result =@pg_Exec($conn,$qry);
	}
		
		
	$qry="DELETE FROM TIENE2 WHERE RUT_APO='".trim($_APODERADO)."' AND RUT_ALUMNO='".trim($_ALUMNO)."'";
	$result =pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al eliminar 333.'.$qry);
		exit();
	}else{
	
	    if ($ns1 > 1){
		    // no borro de apoderado, por que pertenece tambien a otro alumno
		}else{	
	    
			$qry="delete from apoderado where rut_apo = '".trim($_APODERADO)."'";
			$result = pg_Exec($conn,$qry);
			if (!$result){
			   echo "Error al eliminar apoderado ".$qry;
			   exit();
			}
		}	     
	
	    $_FRMMODO	=	"mostrar";
		@session_unregister('_APODERADO');
		@session_destroy('_APODERADO');		
		echo "<script>window.location = '../alumno.php3?pesta=2'</script>";
	}
	
}

}
}


if($caso==110){
	
	 $sql_elimina="delete from tiene2 where rut_alumno=$alumno and rut_apo=$apoderado";
	$result_elimina=pg_exec($conn,$sql_elimina)or die("xxx");
	if($result_elimina){
		echo "<script type=\"text/javascript\">alert(\"Datos Eliminados\");</script>";
		
		}
		  $_FRMMODO	=	"mostrar";
		@session_unregister('_APODERADO');
		@session_destroy('_APODERADO');	
	echo "<script>window.location = '../alumno.php3?pesta=1'</script>";
	
	}
?>