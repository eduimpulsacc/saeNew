<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../class_reporte/class_motor.php";

$ob_motor = new Motor($_IPDB,$_DBNAME);

$funcion 	= $_POST['funcion'];
$bloque		= $_POST['cargo'];
$ano	= $_ANO;

if($funcion=="empleado"){
	$rs_evaluado = $ob_motor->Evaluados($ano,$cargo);

	if($rs_evaluado){
		$select ="<select name='cmbEVALUADO' id='cmbEVALUADO'>
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






?>