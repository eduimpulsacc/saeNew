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

if($funcion=="pauta"){
	$rs_pauta = $ob_motor->Pauta($_NACIONAL);

	if($rs_pauta){
		$select ="<select name='cmbPAUTA' id='cmbPAUTA' onchange='cargar_dimension(this.value)'>
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_pauta); $x++){
						$fil = pg_fetch_array($rs_pauta,$x); 
		$select .="<option value='".$fil['id_plantilla']."'>".$fil['nombre']."</option>";							
					}
		$select .="</select>";
		echo $select;
	}else{
		echo 0;
	}
			
}

if($funcion=="dimension"){
	$rs_dimension = $ob_motor->Dimension($plantilla,$nacional);
	
	if($rs_dimension){
		$select ="<select name='cmbDIMENSION' id='cmbDIMENSION' onchange='cargar_funcion(this.value,$nacional)'>
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_dimension); $x++){
						$fil = pg_fetch_array($rs_dimension,$x); 
		$select .="<option value='".$fil['id_area']."'>".$fil['nombre']."</option>";							
					}
		$select .="</select>";
		echo $select;	
	}else{
		echo 0;
	}
}

if($funcion=="funciones"){
	$rs_funcion = $ob_motor->Funcion($nacional,$area);
	
	if($rs_funcion){
		$select ="<select name='cmbFUNCION' id='cmbFUNCION' onchange='cargar_indicador(this.value,$nacional)'>
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_funcion); $x++){
						$fil = pg_fetch_array($rs_funcion,$x); 
		$select .="<option value='".$fil['id_subarea']."'>".$fil['nombre']."</option>";							
					}
		$select .="</select>";
		echo $select;	
	}else{
		echo 0;
	}
}

if($funcion=="indicador"){
	$rs_indicador = $ob_motor->Indicador($plantilla,$area,$subarea);
	
	if($rs_indicador){
		$select ="<select name='cmbINDICADOR' id='cmbINDICADOR'>
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_indicador); $x++){
						$fil = pg_fetch_array($rs_indicador,$x); 
		$select .="<option value='".$fil['id_item']."'>".$fil['nombre']."</option>";							
					}
		$select .="</select>";
		echo $select;	
	}else{
		echo 0;
	}
}



?>