<?php 	
	require('../../../../util/header.inc');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 3;
	$caso;

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
	if($ckbox13=="") $ckbox13=0;
	if($ckbox14=="") $ckbox14=0;
	if($ckbox15=="") $ckbox15=0;
	if($ckbox16=="") $ckbox16=0;
	if($ckboxtim=="") $ckboxtim=0;
	if($ckboxfir1=="") $ckboxfir1=0;
	if($ckboxfir2=="") $ckboxfir2=0;
	if($ckboxfir3=="") $ckboxfir3=0;
	if($ckboxfir4=="") $ckboxfir4=0;
	if($ckbox23=="") $ckbox23=0;
	if($ckbox24=="") $ckbox24=0;
	if($ckbox25=="") $ckbox25=0;
	if($ckbox32=="") $ckbox32=0;
	if($ckbox33=="") $ckbox33=0;
	if($ckbox31=="") $ckbox31=0;
	
	$cmbREPORTE = $_POST['cmbREPORTE'];
	
	
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
	$ob_reporte->cmbEMPLEADO1	=$cmbEMPLEADO1;
	$ob_reporte->cmbEMPLEADO2	=$cmbEMPLEADO2;
	$ob_reporte->cmbEMPLEADO3	=$cmbEMPLEADO3;
	$ob_reporte->cmbEMPLEADO4	=$cmbEMPLEADO4;
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
	$ob_reporte->ckbox13		=$ckbox13;
	$ob_reporte->ckbox14		=$ckbox14;
	$ob_reporte->ckbox15		=$ckbox15;
	$ob_reporte->ckbox16		=$ckbox16;
	$ob_reporte->ckbox23		=$ckbox23;
	$ob_reporte->ckbox24		=$ckbox24;
	$ob_reporte->ckbox25		=$ckbox25;
	$ob_reporte->ckbox31		=$ckbox31;
	$ob_reporte->ckbox32		=$ckbox32;
	$ob_reporte->ckbox33		=$ckbox33;
	$ob_reporte->cmbENSENANZA	=$cmbENSENANZA;
	$ob_reporte->poner_timbre	=$ckboxtim;
	$ob_reporte->firmadig1	=$ckboxfir1;
	$ob_reporte->firmadig2	=$ckboxfir2;
	$ob_reporte->firmadig3	=$ckboxfir3;
	$ob_reporte->firmadig4	=$ckboxfir4;
	

	
	if($caso!=1){
		$ob_reporte->InsertReporte($conn);
	}else{	
			if($eliminar=="si"){
			
			$ob_reporte->id_config=$_GET['id_config'];
			$ob_reporte->id_item=$_GET['id_item'];
			 
			
			$ob_reporte->EliminaReporte($conn);
			
			
			
			}else{
		
			$ob_reporte->ModificaReporte($conn);
			}
	}
	
	
	echo "<SCRIPT>window.location='listaConfiguracionReporte.php'</script>";
	
pg_close($conn);
?>