<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../class_reporte/class_motor.php";

$ob_motor = new Motor($_IPDB,$_ID_BASE);

$funcion 	= $_POST['funcion'];
$rdb	 	= $_POST['rdb'];
$nacional	= $_NACIONAL;

if($funcion=="carga_ano"){
	
	
	
	$keywords = $rdb;
	$pieces = explode('_', $keywords);
	$n = count($pieces); // Number of Pieces
	
	if(!$pieces[1])
	{$rs_ano = $ob_motor->Anos($rdb);
	$i=0;}
	else
	{$rs_ano = $ob_motor->Anos_all(str_replace("|",",",$pieces[1]));
	$i=1;
	}
	if($rs_ano){
		$select ="<select name='cmbANO' id='cmbANO' onchange=cargar_cargo(this.value)>
					<option value=0>seleccione</option>";
					
					for($x=0; $x<pg_numrows($rs_ano); $x++){
						$fil = pg_fetch_array($rs_ano,$x); 
						if($i==0)
						$select .="<option value='".$fil['id_ano']."'>".$fil['nro_ano']."</option>";
						else $select .="<option value='".$fil['nro_ano']."'>".$fil['nro_ano']."</option>";							
					}
		$select .="</select>";
		echo $select;
	}else{
		echo 0;
	}
			
}

if($funcion=="carga_ano_all"){
	
	$rs_ano = $ob_motor->Anos_all($rdb);
	
	if($rs_ano){
		$select ="<select name='cmbANO' id='cmbANO' onchange=cargar_cargo(this.value)>
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


if($funcion=="institu_all"){
	$rs_intitut = $ob_motor->busca_institucion_all($num_corp,$nro_ano);
	
	if($rs_intitut){
		$select ="<select name='cmbINST' id='cmbINST' >
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

if($funcion=="carga_cargo"){
	$rs_cargo = $ob_motor->busca_cargo($inst);
	
	if($rs_cargo){
		$select ="<select name='cmbCARGO' id='cmbCARGO'  >
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