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
		$select ="<select name='cmbDIMENSION' id='cmbDIMENSION' >
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

if($funcion=="anos"){
	$rs_ano = $ob_motor->Anos($rdb);
	
	if($rs_ano){
		$select ="<select name='cmbANO' id='cmbANO'  onchange='cargar_periodo(this.value)'>
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_ano); $x++){
						$fil = pg_fetch_array($rs_ano,$x); 
		$select .="<option value='".$fil['id_ano'].",".$fil['nro_ano']."'>".$fil['nro_ano']."</option>";							
					}
		$select .="</select>";
		echo $select;	
	}else{
		echo 0;
	}
}


if($funcion=="institucion"){
	$rs_intitut = $ob_motor->busca_institucion2($num_corp);
	
	if($rs_intitut){
		$select ="<select name='cmbINST' id='cmbINST' onchange='cargar_ano(this.value)' >
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_intitut); $x++){
						$fil = pg_fetch_array($rs_intitut,$x); 
		$select .="<option value='".$fil['rdb']."'>".$fil['nombre_instit']."</option>";							
					}
		$select .="</select>";
		echo $select;	
	}else{
		echo 0;
	}
}

if($funcion=="periodo"){
	$rs_periodo = $ob_motor->busca_periodo($ano);
	
	if($rs_periodo){
		$select ="<select name='cmbPERIODO' id='cmbPERIODO' >
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_periodo); $x++){
						$fil = pg_fetch_array($rs_periodo,$x); 
		$select .="<option value='".$fil['id_periodo']."'>".$fil['nombre_periodo']."</option>";							
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
		$select ="<select name='cmbCARGO' id='cmbCARGO' onchange='carga_pauta(this.value)' >
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