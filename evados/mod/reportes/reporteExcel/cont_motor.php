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
		$select ="<select name='cmbINST' id='cmbINST'  >
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



?>