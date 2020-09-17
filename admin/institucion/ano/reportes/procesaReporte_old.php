<?php 	
	require('../../../../util/header.inc');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 3;
	
	if($ckboxCOLILLA=="") $ckboxCOLILLA=0;
	if($ckboxTALLER=="") $ckboxTALLER=0;
	if($ckboxANOTACION=="") $ckboxANOTACION=0;
	if($ckbox1=="") $ckbox1=0;
	if($ckbox2=="") $ckbox2=0;
	if($ckbox3=="") $ckbox3=0;
	if($ckbox4=="") $ckbox4=0;
	if($ckbox5=="") $ckbox5=0;
	if($ckbox6=="") $ckbox6=0;
	if($ckbox7=="") $ckbox7=0;
	if($ckbox8=="") $ckbox8=0;
	if($ckbox9=="") $ckbox9=0;
	if($ckbox10=="") $ckbox10=0;
	if($ckbox11=="") $ckbox11=0;
	if($ckbox12=="") $ckbox12=0;
	
	$ob_reporte= new Reporte();
	$ob_reporte->institucion	=$institucion;
	$ob_reporte->cmbREPORTE		=$cmbREPORTE;
	$ob_reporte->id_config		=$id_config;
	$ob_reporte->rbTITULO		=$rbTITULO;
	$ob_reporte->rbITEM			=$rbITEM;
	$ob_reporte->rbSUBITEM		=$rbSUBITEM;
	$ob_reporte->cmbLETRATITULO	=$cmbLETRATITULO;
	$ob_reporte->cmbLETRAITEM	=$cmbLETRAITEM;
	$ob_reporte->cmbLETRASUBITEM=$cmbLETRASUBITEM;
	$ob_reporte->ckboxCOLILLA	=$ckboxCOLILLA;
	$ob_reporte->ckboxTALLER	=$ckboxTALLER;
	$ob_reporte->ckboxANOTACION	=$ckboxANOTACION;
	$ob_reporte->cmbFIRMA1		=$cmbFIRMA1;
	$ob_reporte->cmbFIRMA2		=$cmbFIRMA2;
	$ob_reporte->cmbFIRMA3		=$cmbFIRMA3;
	$ob_reporte->cmbFIRMA4		=$cmbFIRMA4;
	$ob_reporte->ckbox1			=$ckbox1;
	$ob_reporte->ckbox2			=$ckbox2;
	$ob_reporte->ckbox3			=$ckbox3;
	$ob_reporte->ckbox4			=$ckbox4;
	$ob_reporte->ckbox5			=$ckbox5;
	$ob_reporte->ckbox6			=$ckbox6;
	$ob_reporte->ckbox7			=$ckbox7;
	$ob_reporte->ckbox8			=$ckbox8;
	$ob_reporte->ckbox9			=$ckbox9;
	$ob_reporte->ckbox10		=$ckbox10;
	$ob_reporte->ckbox11		=$ckbox11;
	$ob_reporte->ckbox12		=$ckbox12;
	$ob_reporte->cmbENSENANZA	=$cmbENSENANZA;
	
	if($caso!=1){
		$ob_reporte->InsertReporte($conn);
	}else{	
		$ob_reporte->ModificaReporte($conn);
	}
	
	
	echo "<SCRIPT>window.location='listaConfiguracionReporte.php'</script>";
	
pg_close($conn);
?>