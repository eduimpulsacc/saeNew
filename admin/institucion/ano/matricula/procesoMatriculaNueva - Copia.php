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


if(pg_numrows($rs_existe)==0){
	// REGISTRA ALUMNO
	 "<br>".$sql ="INSERT INTO alumno (rut_alumno, dig_rut, nombre_alu, ape_pat, ape_mat, fecha_nac, calle, telefono, region, ciudad, comuna, nacionalidad,sexo) VALUES (".$txtRUT.",'".$txtDIGRUT."','".$txtNOMBRE."','".$txtAPEPAT."','".$txtAPEMAT."','".$txtFECHA_nac."','".$txtDIRECCION."','".$txtFONO."',".$region.",".$ciudad.",".$comuna.",".$cmbNACIONALIDAD.",".$cmbGENERO.")";
	$rs_alumno = pg_exec($conn,$sql)or die("Fallo al ".$sql);
}else{
	  "<br>".$sql="UPDATE alumno SET nombre_alu='".$txtNOMBRE."',ape_pat='".$txtAPEPAT."',ape_mat='".$txtAPEMAT."',fecha_nac='".$txtFECHA_nac."',telefono='".$txtFONO."',region=".$region.",ciudad=".$ciudad.",comuna=".$comuna.",sexo=".$cmbGENERO." WHERE rut_alumno=".$txtRUT;
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
	observacion_salud
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
	".$RETOS.",
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
	".$AUTORIZA.",'".$txtRUTRETIRA."','".$txtNOMBRERETIRA."','".$txtPARENTESCORETIRA."','".$txtFONORETIRA."','".$txtCELULARRETIRA."','".$TRANSPORTE."','".$txtTIOFURGON."','".$txtFONOFURGON."','".$rdCURSOREP."','".$txtPROCEDENCIA."','".$cmbESPEC."','".$observacion."','".$datos_de_interes."','".$observacion_salud."')";
	$rs_matricula = pg_exec($conn,$sql);
	
	//die($sql);
	
	/*if($_PERFIL==0){
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
		
		if(pg_numrows($rs_madre)==0){
			
			
			$sql ="INSERT INTO apoderado (rut_apo, dig_rut, nombre_apo, ape_pat, ape_mat, fecha_nac, calle, region, ciudad, comuna, telefono, email, celular, ocupacion, religion, nivel_edu,sexo,sistema_salud) VALUES(".$txtRUTM.",'".$txtDIGRUTM."','".$txtNOMBREM."','".$txtAPEPATM."', '".$txtAPEMATM."', '".CambioFecha($txtFECHAMADRE)."','".$txtDIRECCIONM."', ".$regionM.", ".$ciudadM.", ".$comunaM.", '".$txtFONOM."', '".$txtMAILM."', '".$txtCELULARM."', '".$txtOCUPACIONM."','".$txtRELIGIONM."','".$txtESTUDIOSM."',2,".$cmbSALUDM.")";
			$rs_madre = pg_exec($conn,$sql) or die("1 ".$sql);	
			
		}else{
			
			
			$sql="UPDATE apoderado SET nombre_apo='".$txtNOMBREM."', ape_pat='".$txtAPEPATM."', ape_mat='".$txtAPEMATM."', fecha_nac='".CambioFecha($txtFECHAMADRE)."', calle= '".$txtDIRECCIONM."', region=".$regionM.", ciudad=".$ciudadM.", comuna=".$comunaM.", telefono='".$txtFONOM."', email='".$txtMAILM."', celular='".$txtCELULARM."', ocupacion='".$txtOCUPACIONM."', religion='".$txtRELIGIONM."', nivel_edu='".$txtESTUDIOSM."', sistema_salud=".$cmbSALUDM." WHERE rut_apo=".$txtRUTM;
			$rs_madre = pg_exec($conn,$sql) or die("2 ".$sql);
		}
		if($rdAPODERADO==1) $sostenedor=1; else $sostenedor=0;
			
		$sql ="INSERT INTO tiene2 (rut_apo, rut_alumno, sostenedor) VALUES (".$txtRUTM.",".$txtRUT.",".$sostenedor.")";
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
		
		if(pg_numrows($rs_padre)==0){
			$sql ="INSERT INTO apoderado (rut_apo, dig_rut, nombre_apo, ape_pat, ape_mat, fecha_nac, calle, region, ciudad, comuna, telefono, email, celular, ocupacion, religion, nivel_edu,sexo,sistema_salud) VALUES(".$txtRUTP.",'".$txtDIGRUTP."','".$txtNOMBREP."','".$txtAPEPATP."', '".$txtAPEMATP."', '".CambioFecha($txtFECHAPADRE)."','".$txtDIRECCIONP."', ".$regionP.", ".$ciudadP.", ".$comunaP.", '".$txtFONOP."', '".$txtMAILP."', '".$txtCELULARP."', '".$txtOCUPACIONP."','".$txtRELIGIONP."','".$txtESTUDIOSP."',1,".$cmbSALUDP.")";
			$rs_padre = pg_exec($conn,$sql) or  die("3 ".$sql);	
		}else{
			$sql="UPDATE apoderado SET nombre_apo='".$txtNOMBREP."', ape_pat='".$txtAPEPATP."', ape_mat='".$txtAPEMATP."', fecha_nac='".CambioFecha($txtFECHAPADRE)."', calle= '".$txtDIRECCIONP."', region=".$regionP.", ciudad=".$ciudadP.", comuna=".$comunaP.", telefono='".$txtFONOP."', email='".$txtMAILP."', celular='".$txtCELULARP."', ocupacion='".$txtOCUPACIONP."', religion='".$txtRELIGIONP."', nivel_edu='".$txtESTUDIOSP."', sistema_salud=".$cmbSALUDP." WHERE rut_apo=".$txtRUTP;
			$rs_padre = pg_exec($conn,$sql) or die("4 ".$sql);
		}

		if($rdAPODERADO==1) $sostenedor=1; else $sostenedor=0;
		
		$sql ="INSERT INTO tiene2 (rut_apo, rut_alumno, sostenedor) VALUES (".$txtRUTP.",".$txtRUT.",".$sostenedor.")";
		$rs_tiene = pg_exec($conn,$sql);
			
		
	}
	
		
//if($_PERFIL==0){
	
//}else{
echo "<script>window.location='nueva_ficha3.php'</script>";
//}
	}

?>
