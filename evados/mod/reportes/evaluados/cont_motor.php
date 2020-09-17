<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../class_reporte/class_motor.php";

$ob_motor = new Motor($_IPDB,$_ID_BASE);

$funcion 	= $_POST['funcion'];
//$ano	 	= $_POST['cmbANO'];
$nacional	= $_NACIONAL;

if($funcion=="carga_ano"){
	$rs_ano = $ob_motor->carga_ano($ano);

	if($rs_ano){
		$select ="<select name='cmbANO' id='cmbANO' >
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
if($funcion=="periodo"){
	$rs_periodo = $ob_motor->periodo($ano);

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





?>