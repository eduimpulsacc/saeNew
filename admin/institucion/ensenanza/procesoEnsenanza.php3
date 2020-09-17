<?php require('../../../util/header.inc');

//print_r($_POST);

 	$frmModo	= $_FRMMODO;
	
	
	$_JMT = $_JMT_2;
	
	
	if ($txtFECHA == NULL){
	   $txtFECHA = "01-01-2000";
	}
	if ($txtNUME2 == NULL){
	   $txtNUME2 = 1;
	}  	
    if ($txtNumDife==NULL){
	   $txtNumDife=0;
	}	
	// dar vuelta la fecha
	$dd = substr($txtFECHA,0,2);
	$mm = substr($txtFECHA,3,2);
	$aa = substr($txtFECHA,6,4);
	
	$txtFECHA = "$aa-$mm-$dd";
	
	
if ($frmModo=="ingresar"){
	
	
		//include_once('Servicio_TipoEnseSige.php');	
	
	
        if($ecp)	$ecp=1;		else	$ecp=0;
	    if($pj)		$pj=1;		else	$pj=0;
		$qry="INSERT INTO TIPO_ENSE_INST (RDB,COD_TIPO,ESTADO,NU_RESOLUCION,FECHA_RES,NU_GRUPOS_DIF, BOOL_ECP, BOOL_PJ) VALUES ('".trim($rdb)."',".$cmbTipoEnse.",".$cmbESTADO.",'".trim($txtNUME2)."','" . $txtFECHA . "','".trim($txtNumDife)."','".trim($ecp)."','".trim($pj)."')";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)');
		  }else{
			echo "<script>window.location = '../atributos/listarTiposEnsenanza.php3?modo=ini'</script>";
		 }

}
if ($frmModo=="modificar"){
	
		if($btnGuardarSige){
		include_once('Servicio_TipoEnseSige.php');	
		}
	
 $plan= $_PLAN;

	 $qry= "SELECT * FROM tipo_ense_inst WHERE ((rdb='".trim($rdb)."')and (cod_tipo=".$_ENSENANZA.") and (cod_decreto=".$plan."))";
          $result=@pg_Exec($conn,$qry);
			if (@pg_numrows($result)==0){;
		if($ecp)	$ecp=1;		else	$ecp=0;
	    if($pj)		$pj=1;		else	$pj=0;
            if ($_ENSENANZA==110){
			    if ($txtFECHA!=NULL){									
				
				    $qry="INSERT INTO TIPO_ENSE_INST (RDB,COD_TIPO,ESTADO,NU_RESOLUCION,FECHA_RES,NU_GRUPOS_DIF, BOOL_ECP, BOOL_PJ, COD_DECRETO) VALUES ('".trim($rdb)."',".$_ENSENANZA.",".$cmbESTADO.",'".trim($txtNUME2)."','".trim($txtFECHA)."','".trim($txtNumDife)."','".trim($ecp)."','".trim($pj)."', '".trim($plan)."')";
			    }else{
				    $qry="INSERT INTO TIPO_ENSE_INST (RDB,COD_TIPO,ESTADO,NU_RESOLUCION,NU_GRUPOS_DIF, BOOL_ECP, BOOL_PJ, COD_DECRETO) VALUES ('".trim($rdb)."',".$_ENSENANZA.",".$cmbESTADO.",'".trim($txtNUME2)."','".trim($txtNumDife)."','".trim($ecp)."','".trim($pj)."', '".trim($plan)."')";
				}	
			}else{
			    if ($txtFECHA!=NULL){
		            $qry="INSERT INTO TIPO_ENSE_INST (RDB,COD_TIPO,ESTADO,NU_RESOLUCION,FECHA_RES, BOOL_ECP, BOOL_PJ, COD_DECRETO) VALUES ('".trim($rdb)."',".$_ENSENANZA.",".$cmbESTADO.",'".trim($txtNUME2)."','".trim($txtFECHA)."','".trim($ecp)."','".trim($pj)."', '".trim($plan)."')";
                }else{
				    $qry="INSERT INTO TIPO_ENSE_INST (RDB,COD_TIPO,ESTADO,NU_RESOLUCION, BOOL_ECP, BOOL_PJ, COD_DECRETO) VALUES ('".trim($rdb)."',".$_ENSENANZA.",".$cmbESTADO.",'".trim($txtNUME2)."','".trim($ecp)."','".trim($pj)."', '".trim($plan)."')";
				}
			}
		
		$result =pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
		}else{
			echo "<script>window.location = '../atributos/listarTiposEnsenanza.php3?modo=ini'</script>";
		}
	} else{
           
        if($ecp)	    $ecp=1 ; 		else	$ecp=0;
	    if($pj) 		$pj=1 ;  		else	$pj=0;
        if($_JM)		$_JM=1; 		else	$_JM=0; 
        if($_JT)		$_JT=1; 		else	$_JT=0;
        if($_JMT==1)   	$_JMT=1;		else	$_JMT=0;
        if($_JVN)   	$_JVN=1;		else	$_JVN=0;
            
        if(($txtFECHAcierre!="") and ($txtNUM3!="")){
 		$qry="UPDATE tipo_ense_inst SET estado ='".$cmbESTADO."', nu_resolucion ='".$txtNUME2."', fecha_res ='" . $txtFECHA. "', nu_resolucion_cierre ='".$txtNUM3."',fecha_res_cierre =to_date('" . $txtFECHAcierre . "','DD MM YYYY'), nu_grupos_dif='".$txtNumDife."', bool_ecp ='".$ecp."', bool_pj='".$pj."' WHERE (((cod_tipo)=".$_ENSENANZA.") and ((rdb)=".$_INSTIT.") and ((cod_decreto)=".$_PLAN."))";
		$result =@pg_Exec($conn,$qry);
               }else if(($txtFECHAcierre=="") or ($txtNUM3=="")) {
         		$qry="UPDATE tipo_ense_inst SET estado ='".$cmbESTADO."', nu_resolucion ='".$txtNUME2."', fecha_res ='" . $txtFECHA . "', nu_resolucion_cierre =NULL,fecha_res_cierre = NULL, nu_grupos_dif='".$txtNumDife."', bool_ecp ='".$ecp."', bool_pj='".$pj."' WHERE (((cod_tipo)=".$_ENSENANZA.") and ((rdb)=".$_INSTIT.") and ((cod_decreto)=".$_PLAN."))";
		         $result =@pg_Exec($conn,$qry);}
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
		}else{
                   $qryA= "SELECT * FROM tipo_ense_inst as tei WHERE (((cod_tipo)=".$_ENSENANZA.") and ((rdb)=".$_INSTIT.") and ((cod_decreto)=".$_PLAN."))";
                     $resultA	=@pg_Exec($conn,$qryA);
                       if (@pg_numrows($resultA)!=0){;
                         $filaA = @pg_fetch_array($resultA,0);
                         $var = $filaA['corre'];
                           }
                       
                  
//       $qryH= "SELECT * FROM hora_jm, tipo_ense_inst WHERE ((tipo_ense_inst.corre=hora_jm.corre)and (((cod_tipo)=".$_ENSENANZA.") and ((rdb)=".$_INSTIT.")) and ((cod_decreto)=".$_PLAN.") and ((hora_jm.corre)=".$var."))";
	   $qryH= "SELECT * FROM (hora_jm inner join tipo_ense_inst on tipo_ense_inst.corre=hora_jm.corre) where tipo_ense_inst.cod_tipo=".$_ENSENANZA." and tipo_ense_inst.rdb=".$_INSTIT." and tipo_ense_inst.cod_decreto=".$_PLAN." and hora_jm.corre=".$var;
          $resultH=@pg_Exec($conn,$qryH);
                             

                          if ((@pg_numrows($resultH)!=0) and ($_JM==0))  {
                            $qryD="DELETE FROM hora_jm WHERE corre =".$var;
                               $resultD =@pg_Exec($conn,$qryD); 
                              
                               }
                       

                         if ((@pg_numrows($resultH)!=0) and ($_JM==1)) { 
						  
                         $qryE= "UPDATE hora_jm SET hora_ini= '".$txtHoraIni."', hora_ter='".$txtHoraFin."' WHERE corre = '".$var."'";
							$resultE =@pg_Exec($conn,$qryE);
                             }

                
                          if ((@pg_numrows($resultH)==0) and ($_JM==1) and (($txtHoraIni!="")or($txtHoraFin!=""))) { 
			              $qryF="INSERT INTO hora_jm (corre, hora_ini, hora_ter) VALUES ('".trim($filaA['corre'])."','".trim($txtHoraIni)."','".trim($txtHoraFin)."')";
				             $resultF =@pg_Exec($conn,$qryF);
                             
                               }
                  
                         
                 
           $qryE= "SELECT * FROM hora_jt INNER JOIN tipo_ense_inst ON (tipo_ense_inst.corre=hora_jt.corre)WHERE (((cod_tipo)=".$_ENSENANZA.") and ((rdb)=".$_INSTIT.") and ((cod_decreto)=".$_PLAN.") and ((hora_jt.corre)=".$var.") )";
                $resultE=@pg_Exec($conn,$qryE);
                                      
                         
                             if (($_JT==0) and (($txtHoraIniT!="")or($txtHoraFinT!=""))) { 
                            $qryG="DELETE FROM hora_jt WHERE corre = '".$var."'";
                             $resultG =@pg_Exec($conn,$qryG);
                               
                                    }
                              

                        if ((@pg_numrows($resultE)!=0) and ($_JT==1)) { 
                          $qryH= "UPDATE hora_jt SET hora_ini= '".$txtHoraIniT."', hora_ter='".$txtHoraFinT."' WHERE corre = '".$var."'";
				            $resultH =@pg_Exec($conn,$qryH);
                             
                             }
                      

                              if ((@pg_numrows($resultE)==0) and ($_JT=1)and (($txtHoraIniT!="")or($txtHoraFinT!=""))){ 
 			                $qryJ="INSERT INTO hora_jt (corre, hora_ini, hora_ter) VALUES (".trim($filaA['corre']).",'".trim($txtHoraIniT)."','".trim($txtHoraFinT)."')";
				             $resultJ =@pg_Exec($conn,$qryJ);
                              
                              }



               $qryMT= "SELECT * FROM hora_mt, tipo_ense_inst WHERE ((tipo_ense_inst.corre=hora_mt.corre)and (((cod_tipo)=".$_ENSENANZA.") and ((rdb)=".$_INSTIT.")) and ((cod_decreto)=".$_PLAN.") and ((hora_mt.corre)=".$var."))";
                 $resultMT=@pg_Exec($conn,$qryMT);
           
                        if ((@pg_numrows($resultMT)!=0) and ($_JMT==1)) {   
                          $qryK= "UPDATE hora_mt SET hora_ini= '".$txtHoraIniMT."', hora_ter='".$txtHoraFinMT."' WHERE corre = '".$var."'";
				            $resultK =@pg_Exec($conn,$qryK);
                             
                        }

                          if ((@pg_numrows($resultMT)==0) and ($_JMT==1)and (($txtHoraIniMT!="")or($txtHoraFinMT!=""))) { 
			                $qryL="INSERT INTO hora_mt (corre, hora_ini, hora_ter) VALUES (".trim($filaA['corre']).",'".trim($txtHoraIniMT)."','".trim($txtHoraFinMT)."')";
				             $resultL =@pg_Exec($conn,$qryL);
                              
                         }

                      if ((@pg_numrows($resultMT)!=0) and ($_JMT==0)) { 
                            $qryZ="DELETE FROM hora_mt WHERE corre = '".$var."'";
                             $resultZ =@pg_Exec($conn,$qryZ);
                       }
					   
					   if ($_JMT==0){
					         $qryZ="DELETE FROM hora_mt WHERE corre = '".$var."'";
                             $resultZ =@pg_Exec($conn,$qryZ);
					   }
					   



              $qryVN= "SELECT * FROM hora_vn, tipo_ense_inst WHERE ((tipo_ense_inst.corre=hora_vn.corre)and (((cod_tipo)=".$_ENSENANZA.") and ((rdb)=".$_INSTIT.")) and ((cod_decreto)=".$_PLAN.") and ((hora_vn.corre)=".$var."))";
                $resultVN=@pg_Exec($conn,$qryVN);
           
                        if ((@pg_numrows($resultVN)!=0) and ($_JVN==1)) {   
                          $qryX= "UPDATE hora_vn SET hora_ini= '".$txtHoraIniVN."', hora_ter='".$txtHoraFinVN."' WHERE corre = '".$var."'";
				            $resultX =@pg_Exec($conn,$qryX);
                             
                               }
                                  
                         if ((@pg_numrows($resultVN)==0) and ($_JVN==1) and (($txtHoraIniVN!="")or($txtHoraFinVN!=""))) { 
			                $qryC="INSERT INTO hora_vn (corre, hora_ini, hora_ter) VALUES (".trim($filaA['corre']).",'".trim($txtHoraIniVN)."','".trim($txtHoraFinVN)."')";
				             $resultC =@pg_Exec($conn,$qryC);
                              
                              }

                       if ((@pg_numrows($resultVN)!=0) and ($_JVN==0)) { 
                            $qryV="DELETE FROM hora_vn WHERE corre = '".$var."'";
                             $resultV =@pg_Exec($conn,$qryV);
                               
                                }
			 echo  "<script>window.location = '../atributos/seteaTipoEnse.php3?caso=1&ensenanza=".$_ENSENANZA."&plan=".$_PLAN."'</script>";
                   }
              } //cierre el update      
	}



 if ($frmModo=="eliminar"){
	    $qry="DELETE FROM tipo_ense_inst WHERE(((cod_tipo)=$_ENSENANZA) and ((rdb)=$_INSTIT) and ((cod_decreto)=$_PLAN))";
	    $result =@pg_Exec($conn,$qry);
	    if (!$result) {
		   error('<b> ERROR :</b>Error al eliminar.'.$qry);
	     }else{
           echo "OK";
		    echo "<script>window.location = '../atributos/listarTiposEnsenanza.php3'</script>";
	          }
         }
 ?>