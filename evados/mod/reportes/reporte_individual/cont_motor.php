<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../class_reporte/class_motor.php";

$ob_motor = new Motor($_IPDB,$_DBNAME);

$funcion 	= $_POST['funcion'];
$bloque		= $_POST['bloque'];
$plantilla	= $_POST['plantilla'];
$area		= $_POST['area'];
$subarea	= $_POST['subarea'];
$nacional	= $_NACIONAL;

if($funcion=="pauta"){
	$rs_pauta = $ob_motor->Pauta_individual($bloque,$nacional);

	if($rs_pauta){
		$select ="<select name='cmbPAUTA' id='cmbPAUTA' onchange='cargar_dimension(this.value,$nacional)'>
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
	$rs_funcion = $ob_motor->Funcion_individual($nacional,$area,$plantilla);
	
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
	$rs_indicador = $ob_motor->Indicador_individual($nacional,$area,$subarea,$plantilla);
	
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


if($funcion=="institu"){
	$rs_intitut = $ob_motor->busca_institucion($num_corp,$nro_ano);
	
	if($rs_intitut){
		$select ="<select name='cmbINST' id='cmbINST' onchange='verificaInst(this.value)' >
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
		$select ="<select name='cmbCARGO' id='cmbCARGO' onchange='cargar_evaluado(this.value)' >
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


if($funcion=="carga_evaluado"){
	$rs_evaluado = $ob_motor->busca_evaluado($id_cargo,$num_corp,$id_ano_ins);
	
	if($rs_evaluado){
		$select ="<select name='cmbGRUPO' id='cmbGRUPO' >
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_evaluado); $x++){
						$fil = pg_fetch_array($rs_evaluado,$x); 
		$select .="<option value='".$fil['rut']."'>".$fil['nombre']."</option>";							
					}
		$select .="</select>";
		echo $select;	
	}else{
		echo 0; 
	}
}

if($funcion=="verifica_intit"){
	
	 $rs_int = $ob_motor->verifica_intitut($id_ano);
	if (pg_numrows($rs_int) > 0){
		echo 1;
	}else{
		
		echo 0;
	}
}
	
	
if($funcion=="verifica_corp"){
	 $rs_corp = $ob_motor->verifica_corpo($num_corp,$nro_ano);
	 
	if (pg_numrows($rs_corp) > 0){
		echo 1;
	}else{
		
		echo 0;
	}
}


?>