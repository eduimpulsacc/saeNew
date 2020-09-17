<?
  session_start();
  require "mod_agruparevaluados.php";
	
  $obj_Re_agrupaevaluados = new Relacion_agrupaevaluados($_IPDB,$_ID_BASE);
	
  $funcion = $_POST['funcion'];
  $nombrebloque = $_POST['nombrebloque'];
  $porcentajebloque = $_POST['porcentajebloque'];

  if($funcion==0){
  $result = $obj_Re_agrupaevaluados->insertarevaluado($_POST['id_bloque'],$_POST['rut_evaluado'],$_POST['id_cargo']);
		if($result ){
		   echo 1;
		}else{ 
		   echo 0; 
		}
   } // fin funcion 0

	if($funcion==3){
	
		$result1 = $obj_Re_agrupaevaluados->cargabloques();
		$result2 = $obj_Re_agrupaevaluados->cargacargos();
			
		if($result1 && $result2){
			   
		   $select1 = '<label>Seleccionar Grupo Evaluados : <select name="selectbloque" id="selectbloque">';
		   $select1 .= " <option value=0 select='select' >Selecccionar</option>";
						
		  for($e=0;$e<pg_numrows($result1);$e++){
		  
		        $fila = pg_fetch_array($result1,$e);
				
 	            $select1 .= " <option value='".$fila['id_bloq_evaluado']."'>".$fila['nombre_bloq_eva']."</option>";
		   
			 }  // for 1
		   
			$select1 .=  " </select></label>";
			echo $select1."<br><br>";
				 
			$select2 = "<label>Seleccionar Cargo Evaluador : <select name='cmbCARGO' id='cmbCARGO' onchange='cargartablaevaluados(this.value)' >
			<option value='0' select='select'  >Selecccionar</option>";
				
			for($i=0;$i<pg_numrows($result2);$i++){
		
					$fila=pg_fetch_array($result2,$i);
					$select2 .= "<option value='".$fila['id_cargo']."'>".$fila['nombre_cargo']."</option>";
				
				}  // for 2 
				
			$select2 .= "</select></label>"; 
			echo $select2;
				   
			}else{ 
			   echo 0; 
			}
			
	 } // fin funcion 3

 
	  if($funcion==6){
		
		$result = $obj_Re_agrupaevaluados->buscarevaluadores($_POST['id_cargo'],$_ANO,$_INSTIT);
		  
		  if($result ){
				
		   $table = '  <label for="listaevaluadores">Tabla Evaluados:</label>
		  <table id="flex1" style="display:none" >
		  <thead>
			<tr align="center" >
			  <th width="300" >Nombre Completo</th>
			  <th width="100" >Cargo</th>
			  <th width="100" >Nombre Bloque</th>
			  <th width="30" >Agregar</th>
			</tr>
			</thead>
			<tbody>';
						
			for($e=0;$e<pg_numrows($result);$e++){
			  
			$fila = pg_fetch_array($result,$e);

			if($fila['id_bloq_evaluado']){
			$check = "<a href='#' onclick='eliminarevaluado(".$fila['rut_evaluado'].",".$fila['id_bloq_evaluado'].")' ><img src='img/PNG-48/Delete.png' width='22' height='22' border='0' /></a>";
					}else{
            $check = "<a href='#' onclick='insertarevaluado(".$fila['rut_evaluado'].")' ><img src='img/PNG-48/Add.png' width='22' height='22' border='0' /></a>";
			}
					
		$table .= '<tr align="center" >
		<td>'.ucwords(strtolower($fila['nombre_emp']." ".$fila['ape_pat']." ".$fila['ape_mat'])).'&nbsp;</td>
		<td>'.ucwords(strtolower($fila['nombre_cargo'])).'</td>
		<td>'.ucwords(strtolower($fila['nombre_bloq_eva'])).'</td>
		<td>'.$check .'</td>
		</tr>';
		
		      }// fin for
		   
			$table .= "<tbody></table>";
			
			echo $table;
				
				}else{ 
				   echo 0; 
				}
				
				
	 } // fin funcion 6
	 


	if($funcion==4){
	
  $result = $obj_Re_agrupaevaluados->eliminarevaluado($_POST['id_bloque'],$_POST['rut_evaluado'],$_POST['id_cargo']);
		
		if($result){
		   echo 1;
		}else{ 
		   echo 0; 
		}
	 
	 } // fin funcion 4
 
?>
