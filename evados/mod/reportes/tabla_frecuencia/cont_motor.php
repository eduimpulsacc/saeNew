<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../class_reporte/class_motor.php";

$ob_motor = new Motor($_IPDB,$_ID_BASE);

$funcion 	= $_POST['funcion'];
$bloque		= $_POST['bloque'];
$plantilla	= $_POST['plantilla'];
$area		= $_POST['area'];
$subarea	= $_POST['subarea'];
$nacional	= $_NACIONAL;

if($funcion=="institu"){
	$rs_intitut = $ob_motor->busca_institucion($num_corp,$nro_ano);
	
	if($rs_intitut){
		$select ="<select name='cmbINST' id='cmbINST' onchange='cargar_cargo(this.value)' >
					<option value=0>Todas Las Intituciones</option>";
					for($x=0; $x<pg_numrows($rs_intitut); $x++){
						$fil = pg_fetch_array($rs_intitut,$x); 
		$select .="<option value='".$fil['id_ano']."'>".$fil['nombre_instit']."</option>";							
					}
		$select .="</select>";
		echo $select;	
	}else{
		echo 0;
	}
}


if($funcion=="carga_cargo"){
	$rs_cargo = $ob_motor->busca_cargo($inst);
	
	if($rs_cargo){
		$select ="<select name='cmbCARGO' id='cmbCARGO'>
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_cargo); $x++){
						$fil = pg_fetch_array($rs_cargo,$x); 
		$select .="<option value='".$fil['id_cargo']."'>".$fil['nombre_cargo']."</option>";							
					}
		$select .="</select>";
		echo $select;	
	}else{
		echo 0;
	}
}





?>