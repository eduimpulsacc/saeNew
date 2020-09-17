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
//$ano		= $_ANO;



if($funcion=="ano"){
	$rs_ano = $ob_motor->Anos($rdb);
	
	if($rs_ano){
		$select ="<select name='cmbANO' id='cmbANO' onchange='carga_periodo(this.value)' >
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_ano); $x++){
						$fil = pg_fetch_array($rs_ano,$x); 
		$select .="<option value='".$fil['id_ano']."'>".$fil['nro_ano']."</option>";							
					}
		$select .="</select>";
		echo $select;
	}else{
		echo 0;
	}
	
}

if($funcion=="empleado"){
	$rs_empleado = $ob_motor->carga_empleado($cargo,$rdb,$ano,$periodo);

	if($rs_empleado){
		$select ="<select name='cmbEMPLEADO' id='cmbEMPLEADO' onchange='carga_pauta(this.value,$cargo)' >
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
	$rs_pauta = $ob_motor->Pauta_Cargo_Empleado($cargo,$rut,$ano);

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

if($funcion=="periodo"){
	$rs_periodo = $ob_motor->periodo($ano1);
	if($rs_periodo){
		$select ="<select name='cmbPERIODO' id='cmbPERIODO''>
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





?>