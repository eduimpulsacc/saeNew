<?
session_start();
require "mod_portafolio.php";
$ob_portafolio = new portafolio($_IPDB,$_ID_BASE);

$funcion = $_POST['funcion'];
 
 
    if($funcion==7){
	  
	   $result = $ob_portafolio->cargacargos();
         
		if($result){
			
		$select = "<label>Seleccionar Cargo : <select name='cmbCARGO' id='cmbCARGO'  onchange='cargartablaevaluados(this.value)' >
		<option value='0' select='select'  >Selecccionar</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
		
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_cargo']."'>".$fila['nombre_cargo']."</option>";
				
		 }  // for 2 
				
		 $select .= "</select></label>"; 
		 echo $select;
			
		 }else{
            
		 echo 0;			
			
		 }
			
     } // fin funcion 7
 
 
 
 
 	 if($funcion==8){
	
		$rbd = $_POST['rbd'];
		$nacional = $_SESSION['_NACIONAL'];
		
	   $result = $ob_portafolio->cargatipodocumentos($nacional);
			
		if($result){
			   
			$select = '<label>Seleccionar Documento : <select name="tipo_documento" id="tipo_documento" >';
			$select .= " <option value=0 select='select' >Selecccionar</option>";
								
			 for($e=0;$e<pg_numrows($result);$e++){
				   $fila = pg_fetch_array($result,$e);
				   $select .= " <option value='".$fila['id_tipo'].'/'.$fila['nombre']."'>".$fila['nombre']."</option>";
				 }  // for 1
					$select .=  " </select></label>";
					echo $select."<br><br>";
					}else{ 
					   echo 0; 
					}
			
	 } // fin funcion 8
	 
	 
	 
	 
	  if( $funcion==9 ){ // busca evaluados por Cargo

		  $result = $ob_portafolio->buscarevaluados($id_cargo);
		  
		  if($result ){
				
		   $table = '  <label for="listaevaluadores">Tabla Evaluadores</label>
		  <table id="flex2" style="display:none" >
		  <thead>
			<tr>
			  <th width="80" >Rut</th>
			  <th width="300" >Nombre Evaluado</th>
			  <th width="50" >Select</th>
			</tr>
			</thead>
			<tbody>';
						
			for($e=0;$e<pg_numrows($result);$e++){
			  
				$fila = pg_fetch_array($result,$e);

			    $check1 = "<input type='radio' id='clase' name='clase' value='".$fila['rut_evaluado']."' onclick='carga_rut(this.value)' >";
					
				$table .= '<tr>
				<td>'.$fila['rut_evaluado'].'</td>
				<td>'.$fila['nombre_emp']." ".$fila['ape_pat']." ".$fila['ape_mat'].'&nbsp;</td>
				<td>'.$check1.'&nbsp;</td>
				</tr>';
					   
			}// fin for
		   
			$table .= "<tbody></table><input type='hidden' id='rut_empleado' name='rut_empleado' value=''>";
			echo $table;
				
				}else{ 
				   echo 0;
				}
				
	 } // fin funcion 9
 
?>
