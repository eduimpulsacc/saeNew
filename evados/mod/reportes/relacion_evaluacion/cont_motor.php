<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../class_reporte/class_motor.php";

$ob_motor = new Motor($_IPDB,$_ID_BASE);

$funcion 	= $_POST['funcion'];
$rdb	 	= $_POST['rdb'];
$nacional	= $_NACIONAL;

if($funcion=="carga_ano"){
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


if($funcion=="carga_intit"){
	$num_corp=$_POST['num_corp'];
	$rs_ins = $ob_motor->busca_institucion2($num_corp);

	if($rs_ins){
		$select ="<select name='cmbINST' id='cmbINST'  onchange='carga_anos(this.value)' >
					<option value=0>seleccione</option>";
					for($x=0; $x<pg_numrows($rs_ins); $x++){
						$fil = pg_fetch_array($rs_ins,$x); 
		$select .="<option value='".$fil['rdb']."'>".$fil['nombre_instit']."</option>";							
					}
		$select .="</select>";
		echo $select;
	}else{
		echo 0;
	}
			
}





?>