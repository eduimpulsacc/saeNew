<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_promedios_subsector.php";

//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$obj_PromSub = new PromSub($conn);
$funcion = $_POST['funcion'];


	if($funcion=="carga_periodo"){
	$id_ano =$_POST['id_ano'];
	
	$result = $obj_PromSub->carga_periodo($id_ano);
	if($result){
		$select ="<select name='cmbPERIODO'	id='cmbPERIODO'>
		<option value='0' select='select' >(Selecccionar)</option>";
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
		
		$select .= "<option value='".$fila['id_periodo']."'>".$fila['nombre_periodo']."</option>";
		 }  
		 $select .= "</select>"; 
		 echo $select;
	}else{ 
		 echo 0;	
	}
}
	
	if($funcion==carga_ramos){
			$id_ano =$_POST['id_ano'];
		  $result = $obj_PromSub->carga_ramo($id_ano);
		  if($result){
		$select = "<select name='select_ramos' id='select_ramos'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
		
			$select .= "<option value='".$fila['cod_subsector']."'>".$fila['nombre']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
				}else{ 
				   echo 0;
		}	
	}
	
	
	



?>