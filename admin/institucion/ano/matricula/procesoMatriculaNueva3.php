<?php
require('../../../../util/header.inc');

/*if($_PERFIL==0){
echo"<pre>";
print_r($_POST);
echo"</pre>";
}*/

//echo pg_dbname();
$funcion = $_POST['funcion'];




if($funcion==1){
	
	
	 	
			$sql_al="select * from alumno where rut_alumno=$rut_alumno";
			$rs_dt_alumno = pg_exec($conn,$sql_al)or die("fallo");
			?>
            <?
			
			for($i=0;$i< pg_numrows($rs_dt_alumno);$i++){
				$fila_al = pg_fetch_array($rs_dt_alumno,$i);
				
				
			
				
				
			//if(pg_dbname()=='coi_final_vina' || pg_dbname()=='coi_final'){
			//$fecha_nac = $txtFECHA;	
			$separa_fecha = explode('-',$fila_al['fecha_nac']);
			$fecha =$separa_fecha[2].'-'.$separa_fecha[1].'-'.$separa_fecha[0];	
           // }
				
			/*if(pg_dbname()=='coi_final_vina'){	
		    $separa_fecha = explode('-',$fila_al['fecha_nac']);
		    $fecha = $separa_fecha[2].'-'.$separa_fecha[1].'-'.$separa_fecha[0];	
			}*/
			?>
            
            
            <input type="hidden" id="nombre_hidden" value="<?=trim($fila_al['nombre_alu'])?>" /> 
            <input type="hidden" id="ape_pat_hidden" value="<?=trim($fila_al['ape_pat'])?>" /> 
            <input type="hidden" id="ape_mat_hidden" value="<?=trim($fila_al['ape_mat'])?>" /> 
            
            <input type="hidden" id="fecha_hidden" value="<?=trim($fecha)?>" /> 
            <input type="hidden" id="direccion_hidden" value="<?=trim($fila_al['calle']).''.$fila_al['nro']?>" /> 
            <input type="hidden" id="comuna_hidden" value="<?=$fila_al['region'].','.$fila_al['ciudad'].','.$fila_al['comuna']?>" /> 
            <input type="hidden" id="fono_hidden" value="<?=trim($fila_al['telefono'])?>" /> 
            <input type="hidden" id="nac_hidden" value="<?=$fila_al['nacionalidad']?>" /> 
            <input type="hidden" id="sexo_hidden" value="<?=$fila_al['sexo']?>" />
            <input type="hidden" id="estado_civil_hidden" value="<?=$fila_al['estado_civil']?>" />
            <input type="hidden" id="edad_hidden" value="<?=$fila_al['edad']?>" />
            <input type="hidden" id="email_hidden" value="<?=$fila_al['email']?>" />
            <input type="hidden" id="canthijos_hidden" value="<?=$fila_al['cant_hijos']?>" />
            <input type="hidden" id="etnia_hidden" value="<?=$fila_al['txt_etnia']?>" />
            <input type="hidden" id="padre_hidden" value="<?=$fila_al['bool_padre']?>" />
            <input type="hidden" id="madre_hidden" value="<?=$fila_al['bool_madre']?>" />
            <input type="hidden" id="etnia_hidden" value="<?=$fila_al['txt_etnia']?>" />
             <input type="hidden" id="celular_hidden" value="<?=$fila_al['celular']?>" />
			<?
			}
				
				
				
				
	}else{
$institucion 	= $_INSTIT;
$ano			= $_ANO;

//print_r($_POST);
//if($btnGuardarSige){
if($_CONVENIOID!=""){
	include_once('alumno_sige.php');
}

$sql ="SELECT nro_ano FROM ano_Escolar WHERE id_ano=".$ano;
$rs_ano = pg_exec($conn,$sql);
$nro_ano = pg_result($rs_ano,0);

$sql ="SELECT * FROM alumno WHERE rut_alumno=".$txtRUT;
$rs_existe = pg_exec($conn,$sql);

$ruta=split(",",$cmbCOMUNA);
$region=$ruta[0];
$ciudad=$ruta[1];
$comuna=$ruta[2];


$fecha_nac = $txtFECHA;

function CambioFecha($fecha)   //    cambia fecha del tipo  dd/mm/aaaa  ->  aaaa/mm/dd    para poder hacer insert y update
{
	$retorno="";
	if(strlen($fecha) !=10)
		return $retorno;
	$d=substr($fecha,0,2);
	$m=substr($fecha,3,2);
	$a=substr($fecha,6,4);
	if (checkdate($m,$d,$a))
		$retorno=$a."-".$m."-".$d;
	else
		$retorno="";
	return $retorno;
}


/*if(pg_dbname()=='coi_antofagasta'){
//$fecha_nac = fEs2En2($txtFECHA);

//$fecha_nac = Cfecha($txtFECHA);

$separa_fecha = explode('-',$txtFECHA);

$fecha_nac = $separa_fecha[2].'-'.$separa_fecha[0].'-'.$separa_fecha[1];

$separa_fecha_mat = explode('-',$txtFECHAMAT);

$txtFECHAMAT =$separa_fecha_mat[2].'-'.$separa_fecha_mat[0].'-'.$separa_fecha_mat[1];


}*/
/**************FECHAS VIÑA*****************************************************/
if(pg_dbname()=='coi_final_vina'){
//$fecha_nac = $txtFECHA;	
/*$separa_fecha_nac = explode('-',$txtFECHA);
$txtFECHA_nac =$separa_fecha_nac[2].'-'.$separa_fecha_nac[1].'-'.$separa_fecha_nac[0];*/	

$txtFECHA_nac =CambioFecha($txtFECHA);
}

if(pg_dbname()=='coi_final_vina'){
/*$separa_fecha_mat = explode('-',$txtFECHAMAT);
$txtFECHAMAT =$separa_fecha_mat[2].'-'.$separa_fecha_mat[1].'-'.$separa_fecha_mat[0];	
*/
$txtFECHAMAT = CambioFecha($txtFECHAMAT);
}
/**************************FECHAS CORPORACIONES*****************************************************/
if(pg_dbname()=='coi_corporaciones'){
/*$separa_fecha_mat = explode('-',$txtFECHAMAT);
$txtFECHAMAT =$separa_fecha_mat[2].'-'.$separa_fecha_mat[1].'-'.$separa_fecha_mat[0];	*/

$txtFECHAMAT = CambioFecha($txtFECHAMAT);
}

if(pg_dbname()=='coi_corporaciones'){
/*//$fecha_nac = $txtFECHA;	
$separa_fecha_nac = explode('-',$txtFECHA);
$txtFECHA_nac =$separa_fecha_nac[2].'-'.$separa_fecha_nac[1].'-'.$separa_fecha_nac[0];	*/

$txtFECHA_nac =CambioFecha($txtFECHA);
}

/*******************FECHAS COI FINAL********************************************/

if(pg_dbname()=='coi_final'){
/*$separa_fecha_nac = explode('-',$txtFECHA);
$txtFECHA_nac =$separa_fecha_nac[2].'-'.$separa_fecha_nac[1].'-'.$separa_fecha_nac[0];	*/

$txtFECHA_nac =CambioFecha($txtFECHA);
}

if(pg_dbname()=='coi_final'){
/*$separa_fecha_mat = explode('-',$txtFECHAMAT);
$txtFECHAMAT =$separa_fecha_mat[2].'-'.$separa_fecha_mat[1].'-'.$separa_fecha_mat[0];	*/
$txtFECHAMAT = CambioFecha($txtFECHAMAT);
}




if(pg_dbname()=='coi_final1'){
/*$separa_fecha_mat = explode('-',$txtFECHAMAT);
$txtFECHAMAT =$separa_fecha_mat[2].'-'.$separa_fecha_mat[1].'-'.$separa_fecha_mat[0];	*/

$txtFECHAMAT = CambioFecha($txtFECHAMAT);
}

if(pg_dbname()=='coi_final1'){
//$fecha_nac = $txtFECHA;	
/*$separa_fecha_nac = explode('-',$txtFECHA);
$txtFECHA_nac =$separa_fecha_nac[2].'-'.$separa_fecha_nac[1].'-'.$separa_fecha_nac[0];	*/


}



	


/*********************************************************************************/

/***********************FECHAS ANTOFAGASTA****************************************/
if(pg_dbname()=='coi_antofagasta'){
//$txtFECHAMAT =$txtFECHAMAT;	
/*$separa_fecha_mat = explode('-',$txtFECHAMAT);
$txtFECHAMAT =$separa_fecha_mat[2].'-'.$separa_fecha_mat[1].'-'.$separa_fecha_mat[0];*/

$txtFECHAMAT = CambioFecha($txtFECHAMAT);
}

if(pg_dbname()=='coi_antofagasta'){
//$txtFECHA_nac =$txtFECHA;	
/*$separa_fecha_nac = explode('-',$txtFECHA);
$txtFECHA_nac =$separa_fecha_nac[2].'-'.$separa_fecha_nac[1].'-'.$separa_fecha_nac[0];*/

$txtFECHA_nac =CambioFecha($txtFECHA);
}
/*********************************************************************************/

    if($txtCONQUIENESTUDIA=="") $txtCONQUIENESTUDIA='Null';
	if($txtFIGPATERNA=="") $txtFIGPATERNA='Null';
	if($txtINGRESOGRUPO=="") $txtINGRESOGRUPO='0';
	if($txtOCUPJEFEHOGAR=="") $txtOCUPJEFEHOGAR='Null';
	if($txtNUMGRUPOFAMILAR=="") $txtNUMGRUPOFAMILAR='0';
	if($txtPESONACE=="") $txtPESONACE='';
	if($txtTALLANACE=="") $txtTALLANACE='';
	if($txtEDADPARTOLAUMNO=="") $txtEDADPARTOLAUMNO='0';
	if($txtEDADPRIMERPARTO=="") $txtEDADPRIMERPARTO='0';
	
	if($obse_general=="") $obse_general='';
	if($txtORGANIZACION=="") $txtORGANIZACION='0';
	if($txtCANTDORM=="") $txtCANTDORM='0';
	if($txtCANTBANO=="") $txtCANTBANO='0';
	if($cant_hermanos=="") $cant_hermanos='0';
	if($num_hermano=="") $num_hermano='0';
	
	if($material_vivienda=="") $material_vivienda='';
	if($estado_vivienda=="") $estado_vivienda='';
	if($txt_fichaps=="") $txt_fichaps='';
	
	if($txt_causajuzgado=="") $txt_causajuzgado='';
	if($txt_subsidio=="") $txt_subsidio='';
	if($txt_otratamiento=="") $txt_otratamiento='';
	if($txttratactual=="") $txttratactual='';
	if($txt_trastornosaprendizaje=="") $txt_trastornosaprendizaje='';
	if($numboleta=="") $numboleta=0;
	if($apvol_cgp=="") $apvol_cgp=0;
	if($cantfotos=="") $cantfotos=0;
	
	if($textSEGURO=="") $SEGURO='';
	if($txtNOMBRERETIRA=="") $txtNOMBRERETIRA='';
	if($txtRUTRETIRA=="") $txtRUTRETIRA='';
	if($txtSECTOR=="") $txtSECTOR='';
	if($cmbESTADO=="") $cmbESTADO=0;
	if($txtCELULAR=="") $txtCELULAR='';
	
	
	$cmbTIPOPARTO=0;

if(pg_numrows($rs_existe)==0){
	
	
	
	// REGISTRA ALUMNO
	 "<br>".$sql ="INSERT INTO alumno (rut_alumno, dig_rut, nombre_alu, ape_pat, ape_mat, fecha_nac, calle, telefono, region, ciudad, comuna, nacionalidad,sexo, telefono_recado, peso_nace, talla_nace,tipo_parto,edad_madre_nace,s_salud,cant_hermanos,num_hermano,estado_padres,sector,txt_etnia,celular) VALUES (".$txtRUT.",'".$txtDIGRUT."','".$txtNOMBRE."','".$txtAPEPAT."','".$txtAPEMAT."','".$txtFECHA_nac."','".$txtDIRECCION."','".$txtFONO."',".$region.",".$ciudad.",".$comuna.",".$cmbNACIONALIDAD.",".$cmbGENERO.",'".$txtFONORECADOS."','".$txtPESONACE."','".$txtTALLANACE."',".$cmbTIPOPARTO.",".$txtEDADPARTOLAUMNO.",$cmbSALUDP2,$cant_hermanos,$num_hermano,$cmbESTADO,'$txtSECTOR','$txt_etnia','$txtCELULAR')";
	$rs_alumno = pg_exec($conn,$sql)or die("Fallo al ".$sql);
}else{
	  "<br>".$sql="UPDATE alumno SET nombre_alu='".$txtNOMBRE."',ape_pat='".$txtAPEPAT."',ape_mat='".$txtAPEMAT."',fecha_nac='".$txtFECHA_nac."',telefono='".$txtFONO."',region=".$region.",ciudad=".$ciudad.",comuna=".$comuna.",sexo=".$cmbGENERO.",telefono_recado='".$txtFONORECADOS."',peso_nace='".$txtPESONACE."',talla_nace='".$txtTALLANACE."',tipo_parto=".$cmbTIPOPARTO.",edad_madre_nace=".$txtEDADPARTOLAUMNO.",s_salud=$cmbSALUDP2,cant_hermanos=$cant_hermanos,num_hermano=$num_hermano ,estado_padres = $cmbESTADO,sector='$txtSECTOR',txt_etnia='$txt_etnia' WHERE rut_alumno=".$txtRUT;
	$rs_alumno = pg_exec($conn,$sql)or die("Fallo al ".$sql);	
}
	

	// MATRICULA ALUMNO
	if($SEP=="") 			$SEP=0;
	if($PIE=="") 			$PIE=0;
	if($RETOS=="") 			$RETOS=0;
	if($INDIGENA=="") 		$INDIGENA=0;
	if($EMBARAZADA=="") 	$EMBARAZADA=0;
	if($PUENTE=="") 		$PUENTE=0;
	if($FINANCIMIENTO=="") 	$FINANCIMIENTO=0;
	if($txtCONQUIENVIVE=="")$txtCONQUIENVIVE="Null";
	if($observacion=="")$observacion="Null";
	if($observacion_salud=="")$observacion_salud="Null";
	if($datos_de_interes=="")$datos_de_interes="Null";
	if($txtNROMATRICULA=="") $txtNROMATRICULA=0;
	
	$controlsano=($controlsano=="")?"1111-11-11":CambioFecha($controlsano);
	
	$AUTORIZA=0;
	
	if($txt_contactoemergencia=="") $txt_contactoemergencia='Null';
	if($txt_fonocontactoemergencia=="") $txt_fonocontactoemergencia='Null';
	if($txt_tutor=="") $txt_tutor='Null';
	if($txt_fonotutor=="") $txt_fonotutor='Null';
	if($txt_enfcronica=="") $txt_enfcronica='Null';
	if($txt_discapacidad=="0") $txt_discapacidad='Null';
	if($txt_centroatencion=="") $txt_centroatencion='Null';
	
	if($tramo_salud=="") $tramo_salud='Null';
	
	if($nivel_certificado=="") $nivel_certificado='Null';
	if($plazo_autorizacion=="") $plazo_autorizacion='Null';
	if($abono_matricula=="") $abono_matricula='Null';
	
	if($txtaporteCGP=="") $txtaporteCGP=0;
	
	if($txtNUMGRUPOFAMILAR=="") $txtNUMGRUPOFAMILAR=0;
	
	if($txtINGRESOGRUPO=="") $txtINGRESOGRUPO=0;
	if($txtJEFEHOGAR=="") $txtJEFEHOGAR='Null';
	if($txt_tratactual=="") $txt_tratactual='Null';
	
	
	
	$rdCURSOREP=0;
	$TRANSPORTE=0;
	
	
	
	
	//matricula p2
	 "<br>".$sql="INSERT INTO matricula (rut_alumno,
	id_ano,
	id_curso,
	rdb,
	fecha,
	num_mat,
	bool_ar,
	ben_sep,
	ben_pie,
	bool_retos,
	con_quien_vive,
	bool_aoi,
	bool_ae,
	ben_puente,
	bool_fci,
	enfermedad,
	cirugia,
	medicamento,
	alergia,
	fisica,
	fiebre,
	seguro,
	autoriza_emergencia,
	rut_retira,
	nombre_retira,
	parentesco_retira,
	fono_retira,
	celular_retira, 
	viaja_furgon,
	nombre_tio,
	fono_furgon,
	curso_rep,
	proced_alumno,
	trat_especialista,
	observacion,
	datos_interes,
	observacion_salud,
	bool_pdentales,
	bool_controldental,
	controlsano,
	bool_famenfermo,
	jefe_hogar,
	num_grupofamiliar,
	ocup_jefehogar,
	ingresos,
	tipo_vivienda,
	figura_paterna,
	bool_aporta_figura_paterna,
	bool_espacio_estudio,
	bool_espacio_juego,
	bool_hizo_jardin,
	carinoso,
	curioso,
	sociable,
	con_quien_estudia,
	bool_baj,
	obse_general,
	cant_dormitorios,
	cant_banos,
	org_participa,
	material_vivienda,
	estado_vivienda,
	txt_fichaps,
	txt_causajuzgado,
	txt_subsidio,
	bool_tieneluz,
	bool_tieneagua,
	bool_tienealcantarillado,
	bool_neurologo,
	bool_psicopedagogo,
	bool_psicologo,
	bool_otratamiento,
	txt_otratamiendo,
	bool_tastornosaprendizaje,
	txt_tastornosaprendizaje,
	bool_tratactual,
	txt_tratactual,
	bool_retirosolo,
	bool_traecertificados,
	bool_traeinfnotas,
	bool_traecertificadosant,
	numboleta,
	apvol_cgp,
	cantfotos,
	bool_infperso,
	bool_examenvalidacion,
	bool_estudio_anoant,
	txt_anosretiro,
	txt_causaretiroant,
	txt_mesembarazo,
	txt_anosrepetidos,
	txt_contactoemergencia,
	txt_fonocontactoemergencia,
	txt_tutor,
	txt_fonotutor,
	txt_enfcronica,
	bool_discapacidad,
	txt_discapacidad,
	bool_carnetdiscapacidad,
	txt_centroatencion,
	tramo_salud,
	bool_integracion,
	bool_ccc,
	bool_vif,
	bool_saludmental,
	bool_drogas,
	bool_sename,
	bool_sernam,
	bool_junaeb,
	nivel_certificado,
	bool_secreduc,
	plazo_autorizacion,
	bool_manualconvivencia,
	bool_pagomatricula,
	abono_matricula,
	bool_exentomatricula

	
	
	
	
	
	) VALUES (
	".$txtRUT.",
	".$ano.",
	".$cmbCURSO.",
	".$institucion.",
	'".$txtFECHAMAT."',
	".$txtNROMATRICULA.",
	0,
	".$SEP.",
	".$PIE.",
	0,
	'".$txtCONQUIENVIVE."',
	".$INDIGENA.",
	".$EMBARAZADA.",
	".$PUENTE.",
	".$FINANCIMIENTO.",
	'".$txtENFERMEDAD."',
	'".$txtCIRUGIA."',
	'".$txtMEDICAMENTO."',
	'".$txtALERGIA."',
	'".$txtFISICA."',
	'".$textFIEBRE."',
	'".$SEGURO."',
	".$AUTORIZA.",
	'".$txtRUTRETIRA."',
	'".$txtNOMBRERETIRA."',
	'".$txtPARENTESCORETIRA."',
	'".$txtFONORETIRA."',
	'".$txtCELULARRETIRA."',
	'".$TRANSPORTE."',
	'".$txtTIOFURGON."',
	'".$txtFONOFURGON."',
	'".$rdCURSOREP."',
	'".$txtPROCEDENCIA."',
	'".$cmbESPEC."',
	'".$observacion."',
	'".$datos_de_interes."',
	'".$observacion_salud."',
	0,
	0,
	'$controlsano',
	0,
	'$txtJEFEHOGAR',
	$txtNUMGRUPOFAMILAR,
	'$txtOCUPJEFEHOGAR',
	$txtINGRESOGRUPO,
	0,
	'$txtFIGPATERNA',
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	'$txtCONQUIENESTUDIA',
	0,
	'$obse_general',
	0,
	0,
	'$txtORGANIZACION',
	'$material_vivienda',
	'$estado_vivienda',
	'$txt_fichaps',
	'$txt_causajuzgado',
	'$txt_subsidio',
	0,
	0,
	0,
	0,
	0,
	$bool_psicologo,
	0,
	'$txt_otratamiento',
	$bool_trastornosaprendizaje,
	'$txt_trastornosaprendizaje',
	0,
	'$txt_tratactual',
	0,
	$bool_traecertificados,
	0,
	$bool_traecertificadosant,
	$numboleta,
	$apvol_cgp,
	$cantfotos,
	0,
	$bool_examenvalidacion,
	$bool_estudioanoant,
	'$txtANORETIRADO',
	'$txtCAUSARETIROANT',
	'$txtmesembarazo',
	'$txtANOREPETIDO',
	'$txt_contactoemergencia',
	'$txt_fonocontactoemergencia',
	'$txt_tutor',
	'$txt_fonotutor',
	'$txt_enfcronica',
	$bool_discapacidad,
	'$txt_discapacidad',
	$bool_carnetdiscapacidad,
	'$txt_centroatencion',
	'$tramo_salud',
	$bool_integracion,
	$bool_ccc,
	$bool_vif,
	$bool_saludmental,
	$bool_drogas,
	$bool_sename,
	$bool_sernam,
	$bool_junaeb,
	'$nivel_certificado',
	$bool_secreduc,
	'$plazo_autorizacion',
	$bool_manualconvivencia,
	$bool_pagomatricula,
	'$abono_matricula',
	$bool_exentomatricula
	)";
	//sacar despues el die
	$rs_matricula = pg_exec($conn,$sql) or die("fallo insert matricula:".$sql."-".pg_last_error());
	//$rs_matricula = pg_exec($conn,$sql) or die(pg_last_error());
	
	//die($sql);
/*	
	if($_PERFIL==0){
		echo $sql;
		exit;
	}*/
	
	$sql ="SELECT id_ramo FROM ramo WHERE id_curso=".$cmbCURSO;
	$rs_ramo = pg_exec($conn,$sql);
	
	// INSCRIBE EN EL RAMO
	for($i=0;$i<pg_numrows($rs_ramo);$i++){
		$fila_ramo =pg_fetch_array($rs_ramo);
		$sql = "INSERT INTO tiene$nro_ano (rut_alumno,id_ramo,id_curso) VALUES (".$txtRUT.",".$fila_ramo['id_ramo'].",".$cmbCURSO.")";
		$rs_inscribe = pg_exec($conn,$sql);
	}

	
	
		
//if($_PERFIL==0){
	
//}else{
echo "<script>
window.location='nueva_ficha3.php'</script>";
//}

 
	}

?>
