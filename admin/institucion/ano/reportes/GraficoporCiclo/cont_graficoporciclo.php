<?
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require('../../../../../util/header.inc');
require "mod_graficoporciclo.php";


$obj_graficoporciclo = new graficoporciclo($conn);

$funcion = $_POST['funcion'];


	if($funcion == 'anos'){
		
		   $rdb=$_POST['rdb'];	
		  $result = $obj_graficoporciclo->carga_anos($rdb);
		  
		  if($result){
		$select = "<select name='select_ano' id='select_ano' onChange='carga_periodos(this.value)'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			
			$select .= "<option value='".$fila['id_ano'].'/'.$fila['nro_ano']."' >".$fila['nro_ano']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}


	
	if($funcion == 'carga_periodo' ){
		
		  $id_ano=explode('/',$_POST['id_ano']);
		  
		  $result = $obj_graficoporciclo->carga_periodos($id_ano[0]);
	
	if($result){
	
	$select = "<select name='select_periodos' id='select_periodos' 
	onChange='carga_ciclos(this.value)'>
	<option value='0' select='select' >(Selecccionar)</option>";
	
	for($i=0;$i<pg_numrows($result);$i++){
	
	$fila=pg_fetch_array($result,$i);
	
	$select .= "<option value='".$fila['id_periodo'].'/'.$fila['nombre_periodo']."'>".$fila['nombre_periodo']."</option>";
	
	 }  // for 2 
	
	 $select .= "</select>"; 
	
	   echo $select;
	
	 }else{
	
	   echo 0;			
	
	 }
	 
    }
	
	
	
	
	if($funcion == 'carga_ciclos' ){
		
		  $id_periodo=explode('/',$_POST['id_periodo']);
		  
		  $result = $obj_graficoporciclo->carga_ciclos($id_periodo[0]);
		  
	if($result){
		
	$select = "<select name='select_ciclos' id='select_ciclos' 
	onChange='carga_selects(this.value)'>
	<option value='0' select='select' >(Selecccionar)</option>";
	
	for($i=0;$i<pg_numrows($result);$i++){
		
		$fila=pg_fetch_array($result,$i);
		
		$select .= "<option value='".$fila['id_ciclo'].'/'.$fila['nomb_ciclo']."'>".$fila['nomb_ciclo']."</option>";
		
	 }  // for 2 
	 
	 $select .= "</select>"; 
	 
	   echo $select;
	   
	 }else{
		 
	   echo 0;	
	   		
	 }
    }
	
	
	if($funcion == 'carga_subsectores' ){
		
	  $id_ciclo=explode('/',$_POST['id_ciclo']);
		  
	  $result = $obj_graficoporciclo->carga_subsectores($id_ciclo[0]);
		  
	if($result){
		
	$select = "<select name='select_subsector' id='select_subsector'>
	<option value='0' select='select' >(Selecccionar)</option>";
	
	for($i=0;$i<pg_numrows($result);$i++){
		
		$fila=pg_fetch_array($result,$i);
		
		$select .= "<option value='".$fila['cod_subsector'].'/'.$fila['nombre']."'>".$fila['nombre']."</option>";
		
	 }  // for 2 
	 
	 $select .= "</select>"; 
	 
	   echo $select;
	   
	 }else{
		 
	   echo 0;	
	   		
	 }
    }
	
	
	
	
    if($funcion == 'carga_grados' ){
		
	  $id_ciclo=explode('/',$_POST['id_ciclo']);
		  
	  $result = $obj_graficoporciclo->carga_grados($id_ciclo[0]);
		  
	if($result){
		
	$select = "<select name='select_grado' id='select_grado'>
	<option value='0' select='select' >(Selecccionar)</option>";
	
	for($i=0;$i<pg_numrows($result);$i++){
		
		$fila=pg_fetch_array($result,$i);
		
		$select .= "<option value='".$fila['grado_curso'].'/'.$fila['grado_curso']."'>".$fila['grado_curso']."-Grado</option>";
		
	 }  // for 2 
	 
	 $select .= "</select>"; 
	 
	   echo $select;
	   
	 }else{
		 
	   echo 0;	
	   		
	 }
    }
	
	
	
	
   if($funcion == 'carga_niveles' ){
		
	  $id_ciclo=explode('/',$_POST['id_ciclo']);
		  
	  $result = $obj_graficoporciclo->carga_niveles($id_ciclo[0]);
		  
	if($result){
		
	$select = "<select name='select_niveles' id='select_niveles'>
	<option value='0' select='select' >(Selecccionar)</option>";
	
	for($i=0;$i<pg_numrows($result);$i++){
	  
	  $fila=pg_fetch_array($result,$i);
	  $select .= "<option value='".$fila['id_nivel'].'/'.$fila['nombre']."'>".$fila['nombre']."</option>";
	 
	 }  // for 2 
	 
	 $select .= "</select>"; 
	 
	   echo $select;
	   
	 }else{
		 
	   echo 0;	
	   		
	 }
    }
	
	
	
	
	
	

	

	
	


?>