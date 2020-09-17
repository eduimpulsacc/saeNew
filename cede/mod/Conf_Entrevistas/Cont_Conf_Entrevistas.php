<? header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require "Mod_Conf_Entrevistas.php";
$obj_Plantillas = new Plantillas($_IPDB,$_ID_BASE);
$funcion = $_POST['funcion'];
  
/*****************ADMINISTRA ENSANANZA*****************************/  
	  if($funcion==7){
	   	
	   $result = $obj_Plantillas->carga_ensenanzas($_INSTIT);
		  
		if($result){
		$select = "<label>".htmlentities("Seleccionar Enseñanza",ENT_QUOTES,'UTF-8')." &nbsp;:&nbsp; <select name='selectbloque' id='selectbloque' onchange='cargarselect(this.value,9)'>
		<option value='0' select='select'  >Selecccionar</option>";
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['cod_decreto']."'>Cod Resol.".trim($fila['cod_decreto'])."&nbsp;=&nbsp;".
			ucwords(strtolower(htmlentities(trim($fila['nombre_tipo']))))."</option>";
		 }  // for 2 
		 $select .= "</select></label>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
     } // fin funcion 7
/**************************************************************/

	 
//**************CARGA CONCEPTOS***********************//
	 if($funcion==1122){
		$result1 = $obj_Plantillas->carga_conceptos($_POST['id_plantilla']);
		if($result1){
		   $select1 = '<label>Seleccionar Concepto&nbsp;:&nbsp; &nbsp;&nbsp; <select name="selectConcepto" id="selectConcepto" onchange="" >';
		   $select1 .= "<option value=0 select='select' >Selecccionar</option>";
		   for($e=0;$e<pg_numrows($result1);$e++){
		        $fila = pg_fetch_array($result1,$e);
 	            $select1 .= " <option value='".$fila['id_concepto']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre']))))."</option>";
			 }  // for 1
			 $select1 .=  " </select></label>";
		echo $select1.'&nbsp;&nbsp;<input type="button" name="" id=""  value="+" onclick="ventana_ingreso(15)" />
			<input type="button" name="" id=""  value="=" onclick="buscar_procesar(155,2)" />
			<input type="button" name="" id=""  value="-"  onclick="buscar_procesar(155,3)" /><br>';
			}else{ 
			   echo 0; 
			}
		 }
		 
	 if($funcion==192){
	 $result = $obj_Plantillas->inserta_concepto($_POST["id_plantilla"],$_POST["glosa_concepto"],$_POST[
	 "nombre_concepto"],$_POST["sigla_concepto"]);	
	 if($result){ echo 1; }else{ echo 0; }
	 }
	    
	 if($funcion==193){
	 	
 	 $result = $obj_Plantillas->actualizar_concepto($_POST['id_concepto'],$_POST['nombre_concepto'],$_POST[   
	 'sigla_concepto'],$_POST['glosa_concepto']); if($result){ echo 1; }else{  echo 0; } } 
   
     if($funcion==194){
     $result = $obj_Plantillas->eliminar_concepto($_POST['id_concepto']);
     if($result){ echo 1; }else{  echo 0; }	 } 
  

	 if($funcion==155){
	 $id_concepto = $_POST['id_concepto'];
	 $proceso = $_POST['param'];
	if($proceso==2){ 
	$var="text";
	$detalle="Modificar Concepto :";
	}else{
	$var="button";
	$detalle="Eliminar Concepto :";
	}
	$result = $obj_Plantillas->buscar_concepto($id_concepto);
	if($result){ $fila = pg_fetch_array($result,0);
	echo '<fieldset><legend>'.$detalle.'</legend>
		<label>Nombre Concepto : </label><input type="'.$var.'" name="nombre_concepto" 
		id="nombre_concepto"  value="'.ucwords(strtolower(htmlentities(trim($fila['nombre'])))).'" />
		<br/><label>Nombre Glosa : </label><input type="'.$var.'" name="glosa_concepto" id="glosa_concepto"  value="'.ucwords(strtolower(htmlentities(trim($fila['glosa'])))).'" />
		<br/><label>Nombre Sigla : </label><input type="'.$var.'" name="sigla_concepto" id="sigla_concepto"  value="'.ucwords(strtolower(htmlentities(trim($fila['sigla'])))).'" />
		</fieldset>';
		}else{ 
		echo 0; 
		} } 
	  	 
//*************************************************///

	 
/**********************ADMINISTRA PLANTILLAS*********************************/
	 
  if($funcion==9){
  	
		$id_bloque = $_POST['id_bloque'];
		
		$result1 = $obj_Plantillas->cargaplantillas($id_bloque,$_NACIONAL);
		if($result1){
		   $select1 = '<label>Seleccionar Plantilla &nbsp;:&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="selectplantilla" id="selectplantilla" onchange="cargarselect(this.value,11)" >';
		   $select1 .= "<option value=0 select='select' >Selecccionar</option>";
		  for($e=0;$e<pg_numrows($result1);$e++){
		  	
		        $fila = pg_fetch_array($result1,$e);
		        
 	            $select1 .= " <option value='".$fila['id_plantilla']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre']))))."&nbsp-&nbsp( ". $fila['persona']."  )</option>";
			 }  // for 1
			$select1 .=  " </select></label>";
			echo $select1.'&nbsp;&nbsp;
			<input type="button" value="+" onclick="ventana_ingreso(13)"/>
			<input type="button" value="=" onclick="buscar_procesar(13,2)" />
			<input type="button" value="-"  onclick="buscar_procesar(13,3)" />
			<input type="button" value="Ver Plantilla" onclick="vistaprevia(this.value,1)" /><br>';
			}else{ 
			   echo 0; 
			}
	
	 } // fin funcion 9
	 
	 
	 if($funcion==13){
	
		$id_plantilla = $_POST['id_plantilla'];
		$proceso = $_POST['param'];
		$rdb=$_POST['rdb'];
		if($proceso==2){ 
		$var="text";
		$detalle="Modificar Plantilla :";
		}else{
		$var="button";
		$detalle="Eliminar Plantilla :";
		}
				
		$result = $obj_Plantillas->buscar_plantilla($id_plantilla,$rdb);
			
		if($result){
	       $fila = pg_fetch_array($result,0);
		   echo '<br><fieldset><legend>'.$detalle.'</legend><input type="'.$var.'" name="nombre_plantilla" size="50" id="nombre_plantilla"  
		   value="'.ucwords(strtolower(htmlentities(trim($fila['nombre'])))).'" /></fieldset>';
		   echo '<input type="hidden" name="id_plantilla" id="id_plantilla"  value="'.$fila['id_plantilla'].'"  />';
		}else{ 
		   echo 0; 
			}
			
	 } // fin funcion 13
	 
  if($funcion==15){
  $result = $obj_Plantillas->insertar_plantilla($_POST['id_bloque'],$_POST['nombre_plantilla'],$_INSTIT,$_POST['tipo_plantilla'],$_POST['persona']);
  if($result){ echo 1; }else{ echo 0;  } } 
	 
  if($funcion==16){
  $result = $obj_Plantillas->actualizar_plantilla($_POST['id_plantilla'],$_POST['id_bloque'],$_POST['nombre_plantilla'],$_POST['tipo_plantilla'],$_POST['persona']);
  if($result){ echo 1; }else{ echo 0; }	 } 
	  
  if($funcion==17){
  $result = $obj_Plantillas->eliminar_plantilla($_POST['id_plantilla']);
  if($result){ echo 1; }else{  echo 0; }	 } 
	
/********************************************************************************/

	 
/******************ADMINISTRA AREAS******************************/
	 
	 if($funcion==18){
		$result = $obj_Plantillas->insertar_area($_POST["id_plantilla"],$_POST['nombre_area']);
		if($result){ echo 1; }else{ echo 0; } 			
	 } 
	 
	 
	 if($funcion==19){
		$result = $obj_Plantillas->actualizar_area($_POST['nombre_area'],$_POST['id_area']);
		if($result){ echo 1; }else{  echo 0; }
	 } 

    
	if($funcion==20){
	$result = $obj_Plantillas->eliminar_area($_POST['id_area']);
	if($result){ echo 1;  }else{  echo 0; }}
	
	
	if($funcion==14){
	
		$id_area = $_POST['id_area'];
		$proceso = $_POST['param'];
		if($proceso==2){
		$var="text";
		$detalle="Modificar Area :";
		}else{
		$var="button";
		$detalle="Eliminar Area :";
		}
		
		$result = $obj_Plantillas->buscar_area($id_area);
			
		if($result){
		  $fila = pg_fetch_array($result,0);
          echo '<br><fieldset><legend>'.$detalle.'</legend><br><input type="'.$var.'" 
          name="nombre_area" id="nombre_area" size="50" value="'.ucwords(strtolower(htmlentities(trim($fila['nombre'])))).'" /></fieldset>';
		  echo '<input type="hidden" name="id_plantilla" id="id_plantilla"  value="'.$fila['id_area'].'"  />';
		}else{ 
		  echo 0; 
			}
			
	 } // fin funcion 14
	
	
	if($funcion==1123){
		$id_plantilla = $_POST['id_plantilla'];
		$result1 = $obj_Plantillas->carga_areas($id_plantilla);
		if($result1){
		  $select1 = '<label>Seleccionar Area &nbsp;:&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="select_areas" id="select_areas" >';
		  $select1 .= "<option value=0 select='select' >Selecccionar</option>";
		  for($e=0;$e<pg_numrows($result1);$e++){
		    
			$fila = pg_fetch_array($result1,$e);
 	        $select1 .= " <option value='".$fila['id_area']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre']))))."</option>";
			}  // for 1
			$select1 .=  " </select></label>";
			
			echo $select1.'&nbsp;&nbsp;<input type="button" name="" id=""  value="+" onclick="ventana_ingreso(14)" />
			<input type="button" name="" id=""  value="=" onclick="buscar_procesar(14,2)" />
			<input type="button" name="" id=""  value="-" onclick="buscar_procesar(14,3)" /><br>';
			
			}else{ 
			   echo 0; 
			}
	 } 
	 
	/****************************************************************/
	
	
	
	//*********ADMINISTRA ITEMS****************************  

	if($funcion==21){
	
	if($_POST['id_plantilla']==0){ echo 0; return; }
	if($_POST['id_area']==0){ echo "Seleccionar Area"; return; }
	
	$result = $obj_Plantillas->insertar_item($_POST['id_area'],$_POST['id_plantilla'],$_POST['nombre_item'],$_POST['rdb']);
	if($result){ echo 1;  }else{  echo 0; }} // fin funcion 21
	 
	if($funcion==22){
	$result = $obj_Plantillas->actualizar_item($_POST['nombre_item'],$_POST['id_item']);
	if($result){  echo 1; }else{  echo 0; }} //fin funcion 22
	 
	if($funcion==23){
	$result = $obj_Plantillas->eliminar_item($_POST['id_item']);
	if($result){  echo 1; }else{  echo 0; }} //fin funcion 23
	 
	if($funcion==24){ 
	$result = $obj_Plantillas->buscar_items($_POST['id_item']);
		if($result){
		  $fila = pg_fetch_array($result,0);
		  
echo '<div id="botton_proceso" style="float:right; margin:2px; ">
<input type="submit" name="btn_guardar2" id="btn_guardar2"  value="=" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" onclick="funcion_guardar_datos(22,3)" />
<input type="hidden" name="id_item" id="id_item"  value='.$fila['id_item'].' />
</div>
<label>Modificar Item:
<textarea name="ingresoitem" cols="70" rows="3" id="ingresoitem" class="required" >'.ucwords(strtolower(htmlentities(trim($fila['nombre'])))).'</textarea>
</label>';
		  
		}else{ 
		  echo 0; 
			}
         }


	if($funcion==11){ //TABLA DATA GRID DE ITEMS
	
	if(isset($_POST['id_plantilla'])){
	$id_plantilla = $_POST['id_plantilla'];
	}else{
	$id_plantilla = 0;
	}
	
	if(isset($_POST['id_area'])){
	$id_area = $_POST['id_area'];
	}else{
	$id_area = 0;
	}

	$result = $obj_Plantillas->carga_items($_INSTIT,$id_plantilla,$id_area);
			
		if($result){
			   
		   $table = '<label >Tabla Indicadores</label>
		  <table id="flex1" style="display:none" >
		  <thead>
			<tr align="center" >
			  <th width="40" >Id</th>
			  <th width="400" >Items</th>
			  <th width="40" >Editar</th>
			  <th width="40" >Eliminar</th>
			</tr>
			</thead>
			<tbody>';
						
		  for($e=0;$e<pg_numrows($result);$e++){
		  
		  $fila = pg_fetch_array($result,$e);

			$elimina = "<a href='#' onclick='funcion_eliminar_datos(23,3,".$fila['id_item'].")' >El</a>";
			$modificar = "<a href='#' onclick='buscar_procesar(24,".$fila['id_item'].")' >Ed</a>";

			  $table .= '<tr>
			  <td>'.$fila['id_item'].'&nbsp;</td>
			  <td>'.ucwords(strtolower(htmlentities(trim($fila['nombre'])))).'&nbsp;</td>
			  <td>'.$modificar.'&nbsp;</td>
			  <td>'.$elimina.'&nbsp;</td>
			</tr>';
		   
			 }		// fin for
		   
			$table .= "<tbody></table>";
			
			echo $table;
			   
			}else{ 
			   echo 0; 
			}
	 } // fin funcion 11


//***********************FIN***************************************//
		 
		 
		 
		if($funcion==25){
		echo  $obj_Plantillas->vistaprevia($_POST['id_plantilla']);
		}
		

	 
?>
