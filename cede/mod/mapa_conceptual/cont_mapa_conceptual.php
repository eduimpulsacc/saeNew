<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_mapa_conceptual.php";

$objMembrete= new Membrete($_IPDB,$_ID_BASE);
$obj_Mapa = new MapaConceptual($_IPDB,$_ID_BASE);

$funcion = $_POST['funcion'];

	 /* if($funcion==ccurso){
	   $result = $obj_Mapa->carga_cursos($_ANO);
		if($result){
		$select = "<label>Seleccione Curso :&nbsp;&nbsp;&nbsp;&nbsp;<select name='selectCurso' id='selectCurso' onchange='cargarselect(this.value,2)'>
		<option value='0' select='select'  >Selecccionar</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$id_curso=$fila['id_curso'];
			$Curso_pal = $objMembrete->CursoPalabra($id_curso,1);
			$select .= "<option value='".$fila['id_curso']."'>".ucwords(strtolower(htmlentities(trim($Curso_pal))))."</option>";
			
		 }  // for 2 
		 $select .= "</select></label>"; 
		 echo $select;
			
		 }else{
            
		 echo 0;			
			
		 }
			
     }*/ // fin funcion combo_curso
	 
	 
	if($funcion == 2){
		$id_nivel = $_POST['id_nivel'];
		  $result = $obj_Mapa->carga_ramos($id_nivel);
		  if($result){
		$select = "<label>Seleccione Asignatura :&nbsp;&nbsp;&nbsp;&nbsp;<select name='selectRamo' id='selectRamo' onchange='cargarselect(this.value,4)'>
		<option value='0' select='select'  >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['cod_subsector']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre']))))."</option>";
				
				
		 }  // for 2 
				
		 $select .= "</select></label>"; 
		 echo $select;
			
		 }else{
            
		 echo 0;			
		 }
	}
	
	if($funcion == 3){
		$id_ramo = $_POST['id_ramo'];
		  $result = $obj_Mapa->carga_nivel($id_curso);
		  if($result){
		$select = "<label> Seleccione Nivel :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name='cmb_nivel' id='cmb_nivel' onchange='cargarselect(this.value,2)' style='margin-left:53px'>
		<option value='0' select='select'  >(Selecccionar Nivel)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_nivel']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre']))))."</option>";
				
				
				
		 }  // for 2 
				
		 $select .= "</select></label>"; 
		echo $select;
		 }else{
		 echo 0;			
		 }
	 }
		 
	if($funcion == 4){
		$subsector = $_POST['subsector'];
		  $result = $obj_Mapa->carga_funcion($subsector);
		 
		  if($result){
		$select = "<label> Seleccione Funcion : <select name='cmb_funcion' id='cmb_funcion' onchange='verregistros()' style='margin-left:45px'>
		<option value='0' select='select'  >(Selecccionar Funcion )</option>";
				
		for($i=0;$i<@pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_funcion']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre']))))."</option>";
				
		 }  // for 2 
				
		 $select .= "</select></label>"; 
		  echo $select.'&nbsp;&nbsp;<input type="button" name="" id=""  value="+" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" onclick="ventana_ingreso()"/>';
			
		 }else{
            
		 echo 0;			
			
		 }
		  
		 }
		 
		 
	if($funcion == 5){
		 $id_curso = $_POST['id_curso'];
		 $nombre_funcion = $_POST['nombre_funcion'];
		 $result = $obj_Mapa->guarda_funcion($id_curso,$nombre_funcion);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}
	
	
	if($funcion == 6){
		 $id_ramo = $_POST['id_ramo'];
		 $id_nivel = $_POST['id_nivel'];
		 $id_funcion = $_POST['id_funcion'];
		 $text_concepto = $_POST['text_concepto'];
		 $text_ejemplos = $_POST['text_ejemplos'];
		 $result = $obj_Mapa->guardad_mapacon($id_ramo,$id_nivel,$id_funcion,$text_concepto,$text_ejemplos);
		 
		 if($result){
		if(@pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				
				echo '<input id="_oberv" type="text" value="'.$fila['concepto'].'" />';
				echo '<input id="_ejempl" type="text" value="'.$fila['ejemplos'].'" />';
		 }else{
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
	   }
	  }
	 }
	}
	
	
	if($funcion == 7){
		 $id_ramo = $_POST['id_ramo'];
		 $id_nivel = $_POST['id_nivel'];
		 $id_funcion = $_POST['id_funcion'];
		
		 $result = $obj_Mapa->ver_reg_mapacon($id_ramo,$id_nivel,$id_funcion);
		 
		 if($result){
		if(@pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_conceptos" type="hidden" value="'.$fila['concepto'].'" />';
				echo '<input id="_ejemplos" type="hidden" value="'.$fila['ejemplos'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
  }
  
  
  
  	if($funcion==8){
						
		  $result = $obj_Mapa->carga_tabla();
		  if($result){
			    $table = '<table width="100%" border="1" style="border-collapse:collapse">
              <tr class="color_fondo" align="center" >
			  <th width="%" >NIVEL</th>
			  <th width="%" >ASIGNATURA</th>
			  <th width="%" >FUNCION</th>
			   <th width="%" >Ver</th>
			  
			</tr>
			<tbody>';
			
			for($e=0;$e<pg_numrows($result);$e++){
			  
				$fila = pg_fetch_array($result,$e);
		
					
	$table .= ' <tr align="center" >
	
	<td>'.'Nivel '.$fila['id_nivel'].'&nbsp;</td>
	<td>'.$fila['nombre_subsector'].'&nbsp;</td>
	<td>'.$fila['nombre_funcion'].'&nbsp;</td>
	<td>'.$modifica ="<input type='button' id='btn_modifica' name='btn_modifica' value='V' class='ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only' onclick='verregistros(".$fila['cod_subsector'].",".$fila['id_nivel'].",".$fila['id_funcion'].")'>".'&nbsp;</td>
	
				</tr>';
			}// fin for
			$table .= "<tbody></table>";
			echo $table;
				}else{ 
				   echo 0;
		}	
	}
  
	
	 ?>