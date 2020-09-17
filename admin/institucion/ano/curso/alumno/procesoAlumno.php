<?php require('../../../../../util/header.inc');?>
<?php
	$frmModo		=$_FRMMODO;
	$ano            =$_ANO;
	
	if($txtREG=="")
		$txtREG=1;
	if($txtCIU=="")
		$txtCIU=1;
	if($txtCOM=="")
		$txtCOM=1;
if ($frmModo=="modificar"){
         if($BAJ)	    $BAJ=1;		else	$BAJ=0;
	     if($BCHS)		$BCHS=1;	else	$BCHS=0;
	     if($AOI)		$AOI=1;		else	$AOI=0;
	     if($RDG)		$RDG=1;		else	$RDG=0;
	     if($AE)	    $AE=1;		else	$AE=0;
	     if($GRD)		$GRD=1;		else	$GRD=0;
         if($I)		    $I=1;		else	$I=0;
         if($AR)        $AR=1;      else    $AR=0;
         
		      $qry="UPDATE alumno SET nombre_alu = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$txtREG.", ciudad = ".$txtCIU.", comuna = ".$txtCOM.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", email = '".trim($txtEMAIL)."', fecha_nac = '".fEs2En($txtNAC)."', nacionalidad= ". intval(trim($cmbNac)) ." WHERE (((rut_alumno)='".trim($_ALUMNO)."'));";
		      $result = @pg_Exec($conn,$qry);
					
			  if (($FechaRetiro !="") and ($AR=1)) {
				  $qry2="UPDATE matricula SET  bool_baj ='".$BAJ."', bool_bchs ='".$BCHS."', bool_aoi ='".$AOI."', bool_rg ='".$RDG."', bool_ae = '".$AE."', bool_gd ='".$GRD."', bool_i ='".$I."', bool_ar ='".$AR."', fecha_retiro = '".fEs2En($FechaRetiro)."'  WHERE (((rut_alumno)='".trim($_ALUMNO)."') AND (ID_ANO='".trim($ano)."'));";
		      }else{
				  if (($FechaRetiro =="") or ($AR=0)) {
		              $qry2="UPDATE matricula SET  bool_baj ='".$BAJ."', bool_bchs ='".$BCHS."', bool_aoi ='".$AOI."', bool_rg ='".$RDG."', bool_ae = '".$AE."', bool_gd ='".$GRD."', bool_i ='".$I."', bool_ar ='".$AR."', fecha_retiro = NULL  WHERE (((rut_alumno)='".trim($_ALUMNO)."') AND (ID_ANO='".trim($ano)."'));";
				  }
			  }
			  $result2 = @pg_Exec($conn,$qry2); 
		     
			  if (!$result2) {
			       error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry2);
		      }else{
			       pg_close($conn);
			       echo "<script>window.location = 'seteaAlumno.php3?caso=1&alumno=".trim($_ALUMNO)."'</script>";
		      }
}
?>