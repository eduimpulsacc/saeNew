<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "mod_plantillas.php";
$obj_Plantillas = new Plantillas($_IPDB,$_ID_BASE);
$funcion = $_POST['funcion'];

    
	  if($funcion==7){
	  
	  $result = $obj_Plantillas->cargacargos();
         
		if($result){
			
		$select = "<label>Seleccionar Cargo : <select name='selectbloque' id='selectbloque' onchange='cargarselect(this.value,9)'>
		
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
	
	
	 
/*	 if($funcion==8){
	
		$_ano = $_POST['ano'];
		$result1 = $obj_Plantillas->cargabloques($_ano);
			
		if($result1){
			   
	$select1 = '<label>Seleccionar Grupo Homog�neo : <select name="selectbloque" id="selectbloque" onchange="cargarselect(this.value,9)" >';
		   $select1 .= " <option value=0 select='select' >Selecccionar</option>";
						
		  for($e=0;$e<pg_numrows($result1);$e++){
		  
		        $fila = pg_fetch_array($result1,$e);
				
 	            $select1 .= " <option value='".$fila['id_bloque']."'>".$fila['nombre']."</option>";
		   
			 }  // for 1
		   
			$select1 .=  " </select></label>";
			echo $select1."<br>";
				   
			}else{ 
			   echo 0; 
			}
			
	 } // fin funcion 8*/
	 
	 
	 
	  if($funcion==9){
		
		$id_bloque = $_POST['id_bloque'];
		$result1 = $obj_Plantillas->cargaplantillas($id_bloque,$_NACIONAL);
			
		if($result1){
			   
		   $select1 = '<label>Seleccionar Pauta de Evaluaci�n :<select name="selectplantilla" id="selectplantilla" onchange="cargarselect(this.value,11)" >';
		   
		   $select1 .= "<option value=0 select='select' >Selecccionar</option>";
						
		  for($e=0;$e<pg_numrows($result1);$e++){
		  
		        $fila = pg_fetch_array($result1,$e);
				
 	            $select1 .= " <option value='".$fila['id_plantilla']."'>".$fila['nombre']."</option>";
		   
			 }  // for 1
		   
			$select1 .=  " </select></label>";
			
			echo $select1.'&nbsp;&nbsp;<input type="button" name="" id=""  value="+" class="botonXX" onclick="ventana_ingreso(13)"/>
			<input type="button" name="" id=""  value="=" class="botonXX" onclick="buscar_procesar(13,2)" />
			<input type="button" name="" id=""  value="-" class="botonXX" onclick="buscar_procesar(13,3)" />
			
			<input type="button" name="" id=""  value="Ver Plantilla" class="botonXX" onclick="vistaprevia(this.value,1)" /><br>';
				   
			}else{ 
			   echo 0; 
			}
			
	 } // fin funcion 9
	 
	 
	 
	 	if($funcion==10){
	
		//$id_plantilla = $_POST['id_plantilla'];
		$result1 = $obj_Plantillas->carga_areas($_NACIONAL);
			
		if($result1){
			   
		   $select1 = '<label>Seleccionar Dimenci�n :<select name="select_areas" id="select_areas" onchange="cargarselect(this.value,11)" >';
		   $select1 .= "<option value=0 select='select' >Selecccionar</option>";
						
		  for($e=0;$e<pg_numrows($result1);$e++){
		  
		        $fila = pg_fetch_array($result1,$e);
 	            $select1 .= " <option value='".$fila['id_area']."'>".$fila['nombre']."</option>";
		   
			 }  // for 1
		   
			$select1 .=  " </select></label>";
			
			echo $select1.'&nbsp;&nbsp;<input type="button" name="" id=""  value="+" class="botonXX" onclick="ventana_ingreso(14)" />
			<input type="button" name="" id=""  value="=" class="botonXX" onclick="buscar_procesar(14,2)" />
			<input type="button" name="" id=""  value="-" class="botonXX" onclick="buscar_procesar(14,3)" /><br>';
				   
			}else{ 
			   echo 0; 
			}
			
	 } // fin funcion 9
 
   
     
	 if($funcion==101){
	
		//$id_plantilla = $_POST['id_plantilla'];
		//$id_area = $_POST['id_area'];
		$result1 = $obj_Plantillas->carga_subareas($_NACIONAL);
			
		if($result1){
			   
		   $select1 = '<label>Seleccionar Funci�n :<select name="select_subareas" id="select_subareas" onchange="cargarselect(this.value,11)" >';
		   $select1 .= "<option value=0 select='select' >Selecccionar</option>";
						
		   for($e=0;$e<pg_numrows($result1);$e++){
		  
		        $fila = pg_fetch_array($result1,$e);
 	            $select1 .= " <option value='".$fila['id_subarea']."'>".$fila['nombre']."</option>";
		   
			 }  // for 1
		   
			 $select1 .=  " </select></label>";
			 
		echo $select1.'&nbsp;&nbsp;<input type="button" name="" id=""  value="+" class="botonXX" onclick="ventana_ingreso(15)" />
			<input type="button" name="" id=""  value="=" class="botonXX" onclick="buscar_procesar(155,2)" />
			<input type="button" name="" id=""  value="-" class="botonXX" onclick="buscar_procesar(155,3)" /><br>';
				   
			}else{ 
			
			   echo 0; 
			   
			}
			
	 } // fin funcion 101
   
	 
	if($funcion==11){
	
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
	
	if(isset($_POST['id_subarea'])){
	$id_subarea = $_POST['id_subarea'];
	}else{
	$id_subarea = 0;
	}


	$result = $obj_Plantillas->carga_items($_NACIONAL,$id_plantilla,$id_area,$id_subarea);
			
		if($result){
			   
		   $table = '<label >Tabla Indicadores</label>
		  <table id="flex1" style="display:none" >
		  <thead>
			<tr align="center" >
			  <th width="33" >Bloques</th>
			  <th width="33" >Id-Ind</th>
			  <th width="450" >Indicador</th>
			  <th width="33" >Editar</th>
			  <th width="33" >Eliminar</th>
			</tr>
			</thead>
			<tbody>';
						
		  for($e=0;$e<pg_numrows($result);$e++){
		  
		  $fila = pg_fetch_array($result,$e);

$elimina = "<a href='#' onclick='funcion_eliminar_datos(23,3,".$fila['id_item'].")' ><img src='img/PNG-48/Delete.png' width='18' height='18' border='0' /></a>";
$modificar = "<a href='#' onclick='buscar_procesar(24,".$fila['id_item'].")' ><img src='img/PNG-48/Modify.png' width='18' height='18' border='0' /></a>";
$bloques = "<a href='#' onclick='vistaprevia(".$fila['id_item'].",2)' ><img src='img/PNG-48/Add.png' width='18' height='18' border='0' /></a>";

			  $table .= '<tr>
			  <td>'.$bloques.'&nbsp;</td>
			  <td>'.$fila['id_item'].'&nbsp;</td>
			  <td>'.$fila['nombre'].'&nbsp;</td>
			  <td>'.$modificar.'&nbsp;</td>
			  <td>'.$elimina.'&nbsp;</td>
			</tr>';
		   
			 }// fin for
		   
			$table .= "<tbody></table>";
			echo $table;
			   
			}else{ 
			   echo 0; 
			}
	 } // fin funcion 11
	 
	 
	 
	 
	 if($funcion==13){
	
		$id_plantilla = $_POST['id_plantilla'];
		$proceso = $_POST['param'];
		if($proceso==2){ 
		$var="text";
		$detalle="Modificar Plantilla :";
		}else{
		$var="button";
		$detalle="Eliminar Plantilla :";
		}
				
		$result = $obj_Plantillas->buscar_plantilla($id_plantilla);
			
		if($result){
	       $fila = pg_fetch_array($result,0);

		   echo '<br><label>'.$detalle.'</label><input type="'.$var.'" name="nombre_plantilla" size="50" id="nombre_plantilla"  value="'.trim($fila['nombre']).'" />';
		   echo '<input type="hidden" name="id_plantilla" id="id_plantilla"  value="'.$fila['id_plantilla'].'"  />';
		}else{ 
		   echo 0; 
			}
			
	 } // fin funcion 13
	 
	 
	 
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
		  echo $detalle;
          echo '<br><input type="'.$var.'" name="nombre_area" id="nombre_area" size="50" value="'.trim($fila['nombre']).'" />';
		  echo '<input type="hidden" name="id_plantilla" id="id_plantilla"  value="'.$fila['id_area'].'"  />';
		}else{ 
		  echo 0; 
			}
			
	 } // fin funcion 14

	
	 if($funcion==155){
		
			$id_subarea = $_POST['id_subarea'];
			//$id_plantilla = $_POST['id_plantilla'];
			//$id_area = $_POST['id_area'];
			
	  $proceso = $_POST['param'];
			if($proceso==2){
			$var="text";
			$detalle="Modificar SubArea :";
			}else{
			$var="button";
			$detalle="Eliminar SubArea :";
			}
			
	$result = $obj_Plantillas->buscar_subarea($id_subarea);
				
	if($result){
		$fila = pg_fetch_array($result,0);
		
	echo $detalle;
	echo '<br><input type="'.$var.'" name="nombre_subarea" id="nombre_subarea"  size="50" value="'.trim($fila['nombre']).'" />';
	echo '<input type="hidden" name="id_subarea" id="id__subarea"  value="'.$fila['id_subarea'].'"  />';
	
	}else{ 
		  echo 0; 
		}
				
		} // fin funcion 155
		 
	
	 
	 if($funcion==15){
		//id_bloque = id_cargo...	
		$result = $obj_Plantillas->insertar_plantilla($_POST['id_bloque'],$_POST['nombre_plantilla'],$_NACIONAL);
			
		if($result){
	        echo 1;
	    }else{ 
		   echo 0; 
			}
			
	 } // fin funcion 15
	 
	 
	 
	  if($funcion==16){
			
		$result = $obj_Plantillas->actualizar_plantilla($_POST['id_plantilla'],$_POST['id_bloque'],$_POST['nombre_plantilla']);
			
		if($result){
	        echo 1;
	    }else{ 
		   echo 0; 
			}
			
	 } // fin funcion 16
	 
	 
	 
	  
	  if($funcion==17){
			
		$result = $obj_Plantillas->eliminar_plantilla($_POST['id_plantilla']);
			
		if($result){
	        echo 1;
	    }else{ 
		   echo 0; 
			}
			
	 } // fin funcion 16
	 
	 
	 
	 
	 if($funcion==18){
			
		$result = $obj_Plantillas->insertar_area($_POST['nombre_area'],$_NACIONAL);
			
		if($result){
	        echo 1;
	    }else{ 
		   echo 0; 
			}
			
	 } // fin funcion 18
	 
	 
	 
	 if($funcion==19){
			
		$result = $obj_Plantillas->actualizar_area($_NACIONAL,$_POST['nombre_area'],$_POST['id_area']);
			
		if($result){
	        echo 1;
	    }else{ 
		   echo 0; 
			}
			
	 } // fin funcion 16
	 
	 
	 
	  
	  if($funcion==20){
			
		$result = $obj_Plantillas->eliminar_area($_POST['id_area']);
			
		if($result){
	        echo 1;
	    }else{ 
		   echo 0; 
			}
			
	 } // fin funcion 16
	 
	 
	 
	 
	 	 if($funcion==182){
			
		$result = $obj_Plantillas->insertar_subarea($_NACIONAL,$_POST['nombre_subarea']);
			
		if($result){
	        echo 1;
	    }else{ 
		   echo 0; 
			}
			
	 } // fin funcion 182
	 
	 
	 
  if($funcion==192){
			
  $result = $obj_Plantillas->actualizar_subarea($_NACIONAL,$_POST['nombre_subarea'],$_POST['id_subarea']);
			
		if($result){
	        echo 1;
	    }else{ 
		   echo 0; 
			}
			
	 } // fin funcion 192
	 
	 
	 
	  
	  if($funcion==202){
			
		$result = $obj_Plantillas->eliminar_subarea($_POST['id_subarea']);
			
		if($result){
	        echo 1;
	    }else{ 
		   echo 0; 
			}
			
	 } // fin funcion 202
	 
	 
	 
	 
	 
	  if($funcion==21){
			
		$result = $obj_Plantillas->insertar_item($_POST['id_area'],$_POST['id_plantilla'],$_POST['id_subarea'],$_POST['nombre_item'],$_NACIONAL);
			
		if($result){
	        echo 1;
	    }else{ 
		   echo 0; 
			}
			
	 } // fin funcion 21
	 
	 
	 
	 if($funcion==22){
			
		$result = $obj_Plantillas->actualizar_item($_POST['id_plantilla'],$_POST['nombre_item'],$_POST['id_area'],$_POST['id_item'],$_POST['id_subarea']);
			
		if($result){
	        echo 1;
	    }else{ 
		   echo 0; 
			}
			
	 } // fin funcion 22
	 
	 
	 
	  
	  if($funcion==23){
			
		$result = $obj_Plantillas->eliminar_item($_POST['id_item']);
			
		if($result){
	        echo 1;
	    }else{ 
		   echo 0; 
			}
			
	 } // fin funcion 23
	 
	 
	 
	if($funcion==24){ 
	
	$result = $obj_Plantillas->buscar_items($_POST['id_item']);
	
		if($result){
		  $fila = pg_fetch_array($result,0);
		  echo '<label>Ingresar Indicador :</label><br> 
          <textarea name="ingresoitem" cols="70" rows="3" id="ingresoitem"  >'.trim($fila['nombre']).'</textarea>
          <div id="botton_proceso" >
          <input type="button" name="" id=""  value="=" class="botonXX" onclick="funcion_guardar_datos(22,3)" />
		  <input type="hidden" name="id_item" id="id_item"  value='.$fila['id_item'].' />
          </div>';
		}else{ 
		  echo 0; 
			}

         }
		 
		 
		if($funcion==25){
		echo  $obj_Plantillas->vistaprevia($_POST['id_plantilla']);
		}
		
		
		
		if($funcion==26){
		
		$result = $obj_Plantillas->relacion_bloques_item($_POST['id_item']);
			
		if($result){
			   
		   $table = '<label style="border:1 px solid;" >Indicador Seleccionado N� : '.$_POST['id_item'].'</label><br><br>
		  <table id="flex4" style="display:none" >
		  <thead>
			<tr align="center" >
			  <th width="450" >Nombre Bloque</th>
			  <th width="73" >Asignar Bloque</th>
			</tr>
			</thead>
			<tbody>';
						
		  for($e=0;$e<pg_numrows($result);$e++){
		  
		  $fila = pg_fetch_array($result,$e);
			
			$result_filtro=$obj_Plantillas->filtro_bloques_item($_POST['id_item'],$fila['id_bloque'],$_POST['id_plantilla'],$_POST['id_area'],$_POST['id_sub_area']);
			
			//echo "cuenta-->".pg_numrows($result_filtro);
			//if(pg_numrows($result_filtro)==1){
			$elimina = "<a href='#' onclick='vincular_bloque(28,".$fila['id_bloque'].",".$_POST['id_item'].")' ><img src='img/PNG-48/Delete.png' width='30' height='30' border='0' /></a>";
			//}else{
			$insertar = "<a href='#' onclick='vincular_bloque(27,".$fila['id_bloque'].",".$_POST['id_item'].")' ><img src='img/PNG-48/Add.png' width='30' height='30' border='0' /></a>";
			//}
			  $table .= '<tr align="center" >
			  <td>'.$fila['nombrebloque'].'&nbsp;</td>';
			  
			 if(pg_numrows($result_filtro)==1){
			   $table .= '<td>'.$elimina.'&nbsp;</td>';
			  }else{
			  $table .= '<td>'.$insertar.'&nbsp;</td>';
			  }
			  
			 $table .= '</tr>';
		   
			 }// fin for
		   
			$table .= "<tbody></table>";
			
			echo $table;
			   
			}else{ 
			   echo 0; 
			}
				
		}
		
		
	   if($funcion==27){
				
	   $result = $obj_Plantillas->insertar_itembloque($_POST['id_plantilla'],$_POST['id_area'],$_POST['id_subarea'],$_POST['id_item'],$_POST['id_bloque']);
		
		if($result){
	        echo 1;
	    }else{ 
		   echo 0; 
			}
				
		}
		
		
		if($funcion==28){
				
		$result = $obj_Plantillas->eliminar_itembloque($_POST['id_plantilla'],$_POST['id_area'],$_POST['id_subarea'],$_POST['id_item'],$_POST['id_bloque']);
		
		if($result){
	        echo 1;
	    }else{ 
		   echo 0; 
			}
				
		}
		
		 
	 
?>
