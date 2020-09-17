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
				
				
			if($fila['nacionalidad']==2){$fila_al['pais_origen']=46;}
			
				
				
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
             <input type="hidden" id="porigen_hidden" value="<?=$fila_al['pais_origen']?>" />
              <input type="hidden" id="celular_hidden" value="<?=$fila_al['celular_hidden']?>" />
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
	if($txtPASAPORTE=="") $txtPASAPORTE='';
	
	if($bool_bautismo=="") $bool_bautismo=0;
	if($bool_pcomunion=="") $bool_pcomunion=0;
	if($bool_confirmacion=="") $bool_confirmacion=0;
	
	$cmbTIPOPARTO=0;
	
	if($religion=="") $religion='';
	
	
	if($cmbNACIONALIDAD==2)
	{
	 $pais_origen=46;
	}else{
	 $pais_origen=$_POST['cmbPAISORIGEN'];
	}
	
	if($txtCELULAR=="") $txtCELULAR='';

if(pg_numrows($rs_existe)==0){
	
	
	
	// REGISTRA ALUMNO
	 "<br>".$sql ="INSERT INTO alumno (rut_alumno, dig_rut, nombre_alu, ape_pat, ape_mat, fecha_nac, calle, telefono, region, ciudad, comuna, nacionalidad,sexo, telefono_recado, peso_nace, talla_nace,tipo_parto,edad_madre_nace,s_salud,cant_hermanos,num_hermano,estado_padres,sector,pais_origen,pasaporte,bool_bautismo,bool_pcomunion,bool_confirmacion,religion,celular) VALUES (".$txtRUT.",'".$txtDIGRUT."','".$txtNOMBRE."','".$txtAPEPAT."','".$txtAPEMAT."','".$txtFECHA_nac."','".$txtDIRECCION."','".$txtFONO."',".$region.",".$ciudad.",".$comuna.",".$cmbNACIONALIDAD.",".$cmbGENERO.",'".$txtFONORECADOS."','".$txtPESONACE."','".$txtTALLANACE."',".$cmbTIPOPARTO.",".$txtEDADPARTOLAUMNO.",$cmbSALUDP2,$cant_hermanos,$num_hermano,$cmbESTADO,'$txtSECTOR',$pais_origen,'$txtPASAPORTE',$bool_bautismo,$bool_pcomunion,$bool_confirmacion,'$religion','$txtCELULAR')";
	$rs_alumno = pg_exec($conn,$sql)or die("Fallo al ".$sql);
}else{
	  "<br>".$sql="UPDATE alumno SET nombre_alu='".$txtNOMBRE."',ape_pat='".$txtAPEPAT."',ape_mat='".$txtAPEMAT."',fecha_nac='".$txtFECHA_nac."',telefono='".$txtFONO."',region=".$region.",ciudad=".$ciudad.",comuna=".$comuna.",sexo=".$cmbGENERO.",telefono_recado='".$txtFONORECADOS."',peso_nace='".$txtPESONACE."',talla_nace='".$txtTALLANACE."',tipo_parto=".$cmbTIPOPARTO.",edad_madre_nace=".$txtEDADPARTOLAUMNO.",s_salud=$cmbSALUDP2,cant_hermanos=$cant_hermanos,num_hermano=$num_hermano,estado_padres=$cmbESTADO,sector='$txtSECTOR',pais_origen=$pais_origen,pasaporte='$txtPASAPORTE',bool_bautismo=$bool_bautismo,bool_pcomunion=$bool_pcomunion,bool_confirmacion=$bool_confirmacion,religion='$religion',celular='$txtCELULAR' WHERE rut_alumno=".$txtRUT;
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
	if($txtELECCION=="") $txtELECCION="";
	
	
	
	
	
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
	bool_exentomatricula,
	bool_cambioropa,
	bool_tomafoto,
	bool_facebook,
	txt_eleccion,
	rut_retira2,
	nombre_retira2,
	parentesco_retira2,
	fono_retira2,
	celular_retira2,
	rut_retira3,
	nombre_retira3,
	parentesco_retira3,
	fono_retira3,
	celular_retira3,
	enc_matricula,
		bool_pvision, 
bool_paudicion, 
bool_pcolumna, 
bool_gdiferencial, 
bool_fonoaudiologo, 
bool_psiquiatra,
aut_vacuna
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
	0,
	0,
	'$txtANORETIRADO',
	'$txtCAUSARETIROANT',
	'$txtmesembarazo',
	'$txtANOREPETIDO',
	'$txt_contactoemergencia',
	'$txt_fonocontactoemergencia',
	'$txt_tutor',
	'$txt_fonotutor',
	'$txt_enfcronica',
	0,
	'$txt_discapacidad',
	0,
	'',
	'$tramo_salud',
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	0,
	'$nivel_certificado',
	0,
	'$plazo_autorizacion',
	0,
	0,
	'0',
	0,
	$bool_cambioropa,
	$bool_tomafoto,
	$bool_facebook,
	'$txtELECCION',
	'$txtRUTRETIRA2',
	'$txtNOMBRERETIRA2',
	'$txtPARENTESCORETIRA2',
	'$txtFONORETIRA2',
	'$txtCELULARRETIRA2',
	'$txtRUTRETIRA3',
	'$txtNOMBRERETIRA3',
	'$txtPARENTESCORETIRA3',
	'$txtFONORETIRA3',
	'$txtCELULARRETIRA3',
	'$cmbENCMATRICULA',
	'$bool_pvision', 
	'$bool_paudicion', 
	'$bool_pcolumna', 
	'$bool_gdiferencial', 
	'$bool_fonoaudiologo', 
	'$bool_psiquiatra',
	'$aut_vacuna'
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

// REGISTRA FAMILIAR MADRE
	if($txtRUTM!=""){
		
		$rutaM=split(",",$cmbCOMUNAM);
		$regionM=$rutaM[0];
		$ciudadM=$rutaM[1];
		$comunaM=$rutaM[2];
		
		$sql ="SELECT * FROM apoderado WHERE rut_apo=".$txtRUTM;
		$rs_madre = pg_exec($conn,$sql);
		if($txtFECHAMADRE=="") $txtFECHAMADRE='01-01-1900';
		if($rdAPODERADO==1) $parentesco_madre="MADRE";
		if(pg_numrows($rs_madre)==0){
			
			
			$sql ="INSERT INTO apoderado (rut_apo, dig_rut, nombre_apo, ape_pat, ape_mat, fecha_nac, calle, region, ciudad, comuna, telefono, email, celular, ocupacion, religion, nivel_edu,sexo,sistema_salud,ultimo_ano_aprobado,edad_primer_parto,parentezco,lugar_trabajo,estado_civil,tipo_trabajo,nacionalidad,pais_origen) VALUES(".$txtRUTM.",'".$txtDIGRUTM."','".$txtNOMBREM."','".$txtAPEPATM."', '".$txtAPEMATM."', '".CambioFecha($txtFECHAMADRE)."','".$txtDIRECCIONM."', ".$regionM.", ".$ciudadM.", ".$comunaM.", '".$txtFONOM."', '".$txtMAILM."', '".$txtCELULARM."', '".$txtOCUPACIONM."','".$txtRELIGIONM."','".$txtESTUDIOSM."',2,".$cmbSALUDM.",'".$cmbULTIMOANOMADRE."',".$txtEDADPRIMERPARTO.",'".$parentesco_madre."','".$txtLUGARTRABAJOM."',".$cmbESTADOCIVILM.",".$cmbTIPOTRABAJOM.",".$cmbNACIONALIDADMADRE.",".$cmbPAISORIGENMADRE.")";
			$rs_madre = pg_exec($conn,$sql) or die("1 ".$sql);	
			
		}else{
			
			
			$sql="UPDATE apoderado SET nombre_apo='".$txtNOMBREM."', ape_pat='".$txtAPEPATM."', ape_mat='".$txtAPEMATM."', fecha_nac='".CambioFecha($txtFECHAMADRE)."', calle= '".$txtDIRECCIONM."', region=".$regionM.", ciudad=".$ciudadM.", comuna=".$comunaM.", telefono='".$txtFONOM."', email='".$txtMAILM."', celular='".$txtCELULARM."', ocupacion='".$txtOCUPACIONM."', religion='".$txtRELIGIONM."', nivel_edu='".$txtESTUDIOSM."', sistema_salud=".$cmbSALUDM.",ultimo_ano_aprobado='".$cmbULTIMOANOMADRE."',edad_primer_parto=".$txtEDADPRIMERPARTO.",lugar_trabajo='".$txtLUGARTRABAJOM."',estado_civil=".$cmbESTADOCIVILM.",tipo_trabajo=".$cmbTIPOTRABAJOM.",nacionalidad = ".$cmbNACIONALIDADMADRE.",pais_origen=".$cmbPAISORIGENMADRE." WHERE rut_apo=".$txtRUTM;
			$rs_madre = pg_exec($conn,$sql) or die("2 ".$sql);
		}
		
		/*if($rdAPODERADO==1) $sostenedor=1; else $sostenedor=0;
		
		if($rdAPODERADO==1) $responsable=0; else $responsable=1;
		
		if($suplente!=1) $suplente=0; else $suplente=1;*/
		
		$sostenedor=($rdAPODERADO==1)?1:0;
		$responsable=($rdAPODERADO==1)?0:1;
		$suplente=($suplente==1)?1:0;
			
		$sql ="INSERT INTO tiene2 (rut_apo, rut_alumno,responsable, sostenedor,suplente) VALUES ($txtRUTM,$txtRUT,$responsable,$sostenedor,$suplente)";
		$rs_tiene = pg_exec($conn,$sql);
	}
	
	// REGISTRA FAMILIAR PADRE
	if($txtRUTP!=""){
		
		$rutaP=split(",",$cmbCOMUNAP);
		$regionP=$rutaP[0];
		$ciudadP=$rutaP[1];
		$comunaP=$rutaP[2];
		
		$sql ="SELECT * FROM apoderado WHERE rut_apo=".$txtRUTP;
		$rs_padre = pg_exec($conn,$sql);
		
		if($txtFECHAPADRE=="") $txtFECHAPADRE='01-01-1900';
		if(pg_numrows($rs_padre)==0){
			$sql ="INSERT INTO apoderado (rut_apo, dig_rut, nombre_apo, ape_pat, ape_mat, fecha_nac, calle, region, ciudad, comuna, telefono, email, celular, ocupacion, religion, nivel_edu,sexo,sistema_salud,ultimo_ano_aprobado,lugar_trabajo,estado_civil,tipo_trabajo,nacionalidad,pais_origen) VALUES(".$txtRUTP.",'".$txtDIGRUTP."','".$txtNOMBREP."','".$txtAPEPATP."', '".$txtAPEMATP."', '".CambioFecha($txtFECHAPADRE)."','".$txtDIRECCIONP."', ".$regionP.", ".$ciudadP.", ".$comunaP.", '".$txtFONOP."', '".$txtMAILP."', '".$txtCELULARP."', '".$txtOCUPACIONP."','".$txtRELIGIONP."','".$txtESTUDIOSP."',1,".$cmbSALUDP.",'".$cmbULTIMOANOPADRE."','".$txtLUGARTRABAJOP."',".$cmbESTADOCIVILP.",".$cmbTIPOTRABAJOP.",".$cmbNACIONALIDADPADRE.",".$cmbPAISORIGENPADRE.")";
			$rs_padre = pg_exec($conn,$sql) or  die("3 ".$sql);	
		}else{
			$sql="UPDATE apoderado SET nombre_apo='".$txtNOMBREP."', ape_pat='".$txtAPEPATP."', ape_mat='".$txtAPEMATP."', fecha_nac='".CambioFecha($txtFECHAPADRE)."', calle= '".$txtDIRECCIONP."', region=".$regionP.", ciudad=".$ciudadP.", comuna=".$comunaP.", telefono='".$txtFONOP."', email='".$txtMAILP."', celular='".$txtCELULARP."', ocupacion='".$txtOCUPACIONP."', religion='".$txtRELIGIONP."', nivel_edu='".$txtESTUDIOSP."', sistema_salud=".$cmbSALUDP.",ultimo_ano_aprobado='".$cmbULTIMOANOPADRE."',lugar_trabajo='".$txtLUGARTRABAJOP."',estado_civil=".$cmbESTADOCIVILP.",tipo_trabajo=".$cmbTIPOTRABAJOP.",nacionalidad = ".$cmbNACIONALIDADPADRE.",pais_origen=".$cmbPAISORIGENPADRE." WHERE rut_apo=".$txtRUTP;
			$rs_padre = pg_exec($conn,$sql) or die("4 ".$sql);
		}

		/*//if($rdAPODERADO==1) $sostenedor=1; else $sostenedor=0;
		
		if($rdAPODERADO==2) $sostenedor=1; else $sostenedor=0;
		
		if($rdAPODERADO==2) $responsable=0; else $responsable=1;
		
		$sql ="INSERT INTO tiene2 (rut_apo, rut_alumno, responsable,sostenedor) VALUES (".$txtRUTP.",".$txtRUT.",".$responsable.",".$sostenedor.")";*/
		
		$sostenedor=($rdAPODERADO==2)?1:0;
		$responsable=($rdAPODERADO==2)?0:1;
		$suplente=($suplente==2)?1:0;
			
		$sql ="INSERT INTO tiene2 (rut_apo, rut_alumno,responsable, sostenedor,suplente) VALUES ($txtRUTM,$txtRUT,$responsable,$sostenedor,$suplente)";
		
		$rs_tiene = pg_exec($conn,$sql);
			
		
	}
	
	
	if($suplente==3){
	$sqlsuplente ="SELECT * FROM apoderado WHERE rut_apo=".$txtRUTSUPLENTE;
		$rs_suplente = pg_exec($conn,$sqlsuplente);
		
		$rutaS=split(",",$cmbCOMUNASUP);
		$regionS=$rutaS[0];
		$ciudadS=$rutaS[1];
		$comunaS=$rutaS[2];
		
			if(pg_numrows($rs_suplente)==0){
			$sql="insert into apoderado (rut_apo,dig_rut,nombre_apo,ape_pat,ape_mat,calle,telefono,region,ciudad,comuna,parentezco,ocupacion,lugar_trabajo,email,ultimo_ano_aprobado,nacionalidad,pais_origen) values($txtRUTSUPLENTE,'$txtDIGRUTSUPLENTE','$txtNOMBRESU','$txtAPEPATSUP','$txtAPEMATSUP','$txtDIRECCIONSUP','$txtFONOSUP',$regionS,$ciudadS,$comunaS,'$txtPARENTEZCOSUP','$txtOCUPACIONSUP','$txtLUGARTRABAJOSUP','$txtMAILSUP','$cmbULTIMOANOSUP',$cmbNACIONALIDADOTRO,$cmbPAISORIGENOTRO)"	;
			$rs_padre = pg_exec($conn,$sql) or die("5 ".$sql);
			}
			else{
				$sql="update apoderado set nombre_apo='$txtNOMBRESU',ape_pat='$txtAPEPATSUP',ape_mat='$txtAPEMATSUP',calle='$txtDIRECCIONSUP',telefono='$txtFONOSUP',region=$regionS,ciudad=$ciudadS,comuna=$comunaS,parentezco='$txtPARENTEZCOSUP',ocupacion='$txtOCUPACIONSUP',lugar_trabajo='$txtLUGARTRABAJOSUP',email='$txtMAILSUP',ultimo_ano_aprobado='$cmbULTIMOANOSUP',nacionalidad = ".$cmbNACIONALIDADOTRO.",pais_origen=".$cmbPAISORIGENOTRO." where rut_apo=$txtRUTSUPLENTE";
				$rs_padre = pg_exec($conn,$sql) or die("5 ".$sql);
			}
			
			$sql_sup ="INSERT INTO tiene2 (rut_apo, rut_alumno, suplente) VALUES (".$txtRUTSUPLENTE.",".$txtRUT.",1)";
		$rs_tiene_sup = pg_exec($conn,$sql_sup) ;
			
			
	}
	
	//hermanos
	for($h=0;$h<count($cmbCURSOHERMANO);$h++){
	if($cmbCURSOHERMANO[$h]!=0){
		//buscar datos hermano
		 $sql="select dig_rut,nombre_alu,ape_pat,ape_mat,fecha_nac from alumno where rut_alumno=".$alumno[$h];
		$rs_her =pg_exec($conn,$sql);
		$fila_her=pg_fetch_array($rs_her,0);
		
		 $sql_insh="insert into hermanos(rut_hermano,dig_rut,nombre_hermano,ape_pat,ape_mat,fecha_nac,rut_alumno,id_ano,id_curso) values(".$alumno[$h].",'".$fila_her['dig_rut']."','".$fila_her['nombre_alu']."','".$fila_her['ape_pat']."','".$fila_her['ape_mat']."','".$fila_her['fecha_nac']."',$txtRUT,$ano,".$cmbCURSOHERMANO[$h].")";
		 $rs_her=pg_exec($conn, $sql_insh);
		}
	
	}	
	
//if($_PERFIL==0){
	
//}else{
echo "<script>
window.open('fichanuevo.php?id_curso=$cmbCURSO&rut_alumno=$txtRUT','_blank');
window.location='nueva_ficha3.php'</script>";
//}

 
	}

?>
