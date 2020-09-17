<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_ciclos.php";

//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$obj_Ciclos = new Ciclos($conn);
$funcion = $_POST['funcion'];


	if($funcion == ano){
		  $rdb=$_POST['rdb'];	
		  $result = $obj_Ciclos->carga_ano($rdb);
		  if($result){
				$select = "<select name='cmbANO' id='cmbANO' onChange='carga_ciclos(this.value)'>
				<option value='0' select='select' >(Selecccionar)</option>";
				for($i=0;$i<pg_numrows($result);$i++){
					$fila=pg_fetch_array($result,$i);
					$select .= "<option value='".$fila['id_ano']."' >".$fila['nro_ano']."</option>";
				 }  // for 2 
				 $select .= "</select>"; 
				 echo $select;
		 }else{
				 echo 0;			
		 }
	}
	if($funcion == ciclo){
		  $ano=$_POST['ano'];	
		  $result = $obj_Ciclos->carga_ciclos($ano);
		  if($result){
				$select = "<select name='cmbCICLO' id='cmbCICLO' onChange='carga_curso(this.value)'>
				<option value='0' select='select' >(Selecccionar)</option>";
				for($i=0;$i<pg_numrows($result);$i++){
					$fila=pg_fetch_array($result,$i);
					$select .= "<option value='".$fila['id_ciclo']."' >".$fila['nomb_ciclo']."</option>";
				 }  // for 2 
				 $select .= "</select>"; 
				 echo $select;
		 }else{
				 echo 0;			
		 }
	}
	
	if($funcion == periodo){
		  $ano=$_POST['ano'];	
		  $result = $obj_Ciclos->carga_periodos($ano);
		  if($result){
				$select = "<select name='cmbPERIODO' id='cmbPERIODO' >
				<option value='0' select='select' >(Selecccionar)</option>";
				for($i=0;$i<pg_numrows($result);$i++){
					$fila=pg_fetch_array($result,$i);
					$select .= "<option value='".$fila['id_periodo']."' >".$fila['nombre_periodo']."</option>";
				 }  // for 2 
				 $select .= "</select>"; 
				 echo $select;
		 }else{
				 echo 0;			
		 }
	}
	
	if($funcion == nivel){
		  $result = $obj_Ciclos->carga_nivel();
		  if($result){
				$select = "<select name='cmbNIVEL' id='cmbNIVEL' >
				<option value='0' select='select' >(Selecccionar)</option>";
				for($i=0;$i<pg_numrows($result);$i++){
					$fila=pg_fetch_array($result,$i);
					$select .= "<option value='".$fila['id_nivel']."' >".$fila['nombre']."</option>";
				 }  // for 2 
				 $select .= "</select>"; 
				 echo $select;
		 }else{
				 echo 0;			
		 }
	}


	
	
 

?>