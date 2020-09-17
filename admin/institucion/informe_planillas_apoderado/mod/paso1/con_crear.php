<?php require('../../../../../util/header.inc');
$institucion=$_INSTIT;
$ano = $_ANO;

session_start();
require "../../Class/mod_plantillas.php";
$obj_informe = new informeApo();


foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
    eval($asignacion); 
   
  
   
}
$activa=1;

$descripcion = (strlen($descripcion)>0)?$descripcion:"";

$fecha =date("Y-m-d");

$grado1=(isset($grado1))?1:0;
$grado2=(isset($grado2))?1:0;
$grado3=(isset($grado3))?1:0;
$grado4=(isset($grado4))?4:0;
$grado5=(isset($grado5))?1:0;
$grado6=(isset($grado6))?1:0;
$grado7=(isset($grado7))?1:0;
$grado8=(isset($grado8))?1:0;
$grado9=(isset($grado9))?1:0;
$grado10=(isset($grado10))?1:0;
$grado11=(isset($grado11))?1:0;
$grado12=(isset($grado12))?1:0;
$grado13=(isset($grado13))?1:0;
$grado14=(isset($grado14))?1:0;
$grado15=(isset($grado15))?1:0;


$tipo_ense = $ense;

//creo nuevo informe 
if($funcion==1){
	
	if(session_is_registered('_PLANTILLA_APO')){
		session_unregister('_PLANTILLA_APO');
	};
	
	
	
	$rs_registro=$obj_informe->nuevoInforme($conn,$institucion,$activa,$nombre_informe,$tipo_ense,$descripcion,$titulo,$grado1,$grado2,$grado3,$grado4,$grado5,$grado6,$grado7,$grado8,$grado9,$grado10,$grado11,$grado12,$grado13,$grado14,$grado15,$fecha,$cmbPlantilla);
	
	if($rs_registro){
	
	$rs_ultimo=$obj_informe->ultimo($conn,$institucion);
	if($rs_ultimo){
		
	$id_plantilla = pg_result($rs_ultimo,0);
	echo $id_plantilla;
		
	}
		
	}else{
		echo 0;
	}
}

//ingreso nuevo concepto de valores
if($funcion==2){
		$id_plantilla =$_POST['id_plantilla'];
	
	
	for($i=0;$i<count($_POST['nombre']);$i++){
		$nombre = $_POST['nombre'][$i];
		$sigla = $_POST['sigla'][$i];
		$glosa = $_POST['glosa'][$i];
		 
		
		
		$rs_ins_concepto =$obj_informe->ing_concepto($conn,$id_plantilla,$nombre,$sigla,$glosa);
	if($rs_ins_concepto){
		//echo 1;
		}else{
		echo 0;
	}
		
		
}
	
	
}


//actualizar concepto
if($funcion==3){
	$rs_up = $obj_informe->updateConcepto($conn,$id_concepto,$nombre,$sigla,$glosa,$orden);
	
	if($rs_up){
	echo 1;
	}else{
	echo 0;
	}
	
	
	}

//eliminar concepto
if($funcion==4){
	$rs_elim  =$obj_informe->deleteConcepto($conn,$id_concepto);
	
	
	if($rs_elim){
	echo 1;
	}else{
	echo 0;
	}
	
}

if($funcion==5){
//update plantilla	
//var_dump($_POST);
$rs_up = $obj_informe->updatePlantilla($conn,$id_plantilla,$nombre_informe,$tipo_ense,$descripcion,$titulo,$grado1,$grado2,$grado3,$grado4,$grado5,$grado6,$grado7,$grado8,$grado9,$grado10,$grado11,$grado12,$grado13,$grado14,$grado15,$cmbPlantilla);
//$rs_additem = $obj_informe->addItem($conn,$id_plantilla,$id_item,$nombre,$activo);
if($rs_up){
	echo $id_plantilla;
	}else{
	echo 0;
	}

}

if($funcion==6){
$rs_del = $obj_informe->delPlantilla($conn,$id_plantilla,$estado);
if($rs_del){
	echo 1;
	}else{
	echo 0;
	}
}

?>