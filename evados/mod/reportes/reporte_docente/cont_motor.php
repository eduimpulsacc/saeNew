<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../class_reporte/class_motor.php";

$ob_motor = new Motor($_IPDB,$_ID_BASE);

$funcion 	= $_POST['funcion'];
$empleado 	= $_POST['empleado'];
$cargo		= $_POST['cargo'];
$bloque		= $_POST['bloque'];
$nacional	= $_NACIONAL;
$ano		= $_ANO;
$rdb 		= $_POST['rdb'];

if($funcion=="empleado"){
	$rs_empleado = $ob_motor->carga_empleado_pauta($cargo,$plantilla,$ano1,$periodo);

	if($rs_empleado){
		$select ="<select name='cmbEMPLEADO' id='cmbEMPLEADO' >
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_empleado); $x++){
						$fil = pg_fetch_array($rs_empleado,$x); 
		$select .="<option value='".$fil['rut_emp']."'>".$fil['nombre']."</option>";							
					}
		$select .="</select>";
		echo $select;
	}else{
		echo 0;
	}
			
}
if($funcion=="pauta"){
	$rs_pauta = $ob_motor->Pautas_Institucion($ano1,$periodo);

	if($rs_pauta){
		$select ="<select name='cmbPAUTA' id='cmbPAUTA' onchange='carga_cargos(this.value)'>
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_pauta); $x++){
						$fil = pg_fetch_array($rs_pauta,$x); 
		$select .="<option value='".$fil['id_plantilla']."-".$fil['id_bloque']."'>".$fil['nombre']."</option>";							
					}
		$select .="</select>";
		echo $select;
	}else{
		echo 0;
	}
			
}
if($funcion=="periodo"){
	$rs_periodo = $ob_motor->periodo($ano1);
	if($rs_periodo){
		$select ="<select name='cmbPERIODO' id='cmbPERIODO' onchange='carga_pauta()'>
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_periodo); $x++){
						$fil = pg_fetch_array($rs_periodo,$x); 
		$select .="<option value='".$fil['id_periodo']."-".$fil['nombre_periodo']."'>".$fil['nombre_periodo']."</option>";							
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
		$select ="<select name='cmbANO' id='cmbANO' onchange='carga_periodo(this.value)'>
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_ano); $x++){
						$fil = pg_fetch_array($rs_ano,$x); 
		$select .="<option value='".$fil['id_ano']."-".$fil['nro_ano']."'>".$fil['nro_ano']."</option>";							
					}
		$select .="</select>";
		echo $select;
	}else{
		echo 0;	
	}
}


if($funcion=="cargos"){
	$rs_cargo =$ob_motor->carga_cargos($cargo);
	if($rs_cargo){
		$select ="<select name='cmbCARGO' id='cmbCARGO' onchange='carga_empleado(this.value)'>
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_cargo); $x++){
						$fil = pg_fetch_array($rs_cargo,$x); 
		$select .="<option value='".$fil['id_cargo']."-".$fil['nombre_cargo']."'>".$fil['nombre_cargo']."</option>";							
					}
		$select .="</select>";
		echo $select;
	}else{
		echo 0;	
	}
		
}



?>