<?
session_start();
require "mod_relacion_e_b.php";
$obj_Relacion_e_b = new Relacion_e_b($_IPDB,$_ID_BASE);

$funcion = $_POST['funcion'];
$nombrebloque = $_POST['nombrebloque'];
$porcentajebloque = $_POST['porcentajebloque'];


   if($funcion==0){
	  // var_dump($_POST);

   $result = $obj_Relacion_e_b->insertarevaluador($_POST['id_bloque'],$_POST['rut_evaluador'],$_POST['id_cargo'],$_POST['id_periodo']);
		if($result){
		   echo 1;
		}else{ 
		   echo 0; 
		}

   } // fin funcion 0


	if($funcion==3){
	
		$_ano = $_POST['ano'];
		$result1 = $obj_Relacion_e_b->cargabloques($_ano);
		$result2 = $obj_Relacion_e_b->cargacargos();
			
		if($result1 && $result2){
			   
		   $select1 = '<label>Seleccionar Bloque : <select name="selectbloque" id="selectbloque" onchange="aviso(this.value)">';
		   $select1 .= " <option value=0 select='select' >Selecccionar</option>";
						
		  for($e=0;$e<pg_numrows($result1);$e++){
		  
		        $fila = pg_fetch_array($result1,$e);
				
 	            $select1 .= " <option value='".$fila['id_bloque']."'>".$fila['nombre']."</option>";
		   
			 }  // for 1
		   
			$select1 .=  " </select></label>";
			echo $select1."<br><br>";
				 
			$select2 = "<label>Seleccionar Cargo Evaluador : <select name='cmbCARGO' id='cmbCARGO' onchange='cargartablaevaluadores(this.value)' >
			<option value='0' select='select'  >Selecccionar</option>
			<option value='100' >Alumnos</option>
			<option value='101' >Apoderados</option>";
				
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
		
		$id_periodo=$_POST['id_periodo'];
		$result = $obj_Relacion_e_b->buscarevaluadores($_POST['id_cargo'],$_ANO,$_INSTIT,$id_periodo);
		  
		  if($result ){
				
		   $table = '  <label for="listaevaluadores">Tabla Evaluadores</label>
		   <br />
<input name="selt" type="checkbox" id="selt" value="" onclick="selevat()" /> Seleccionar Todos<br />

		  <table id="flex1" style="display:none" height="500">
		  <thead>
			<tr align="center" >
			  <th width="300" >Nombre Completo</th>
			  <th width="100" >Cargo</th>
			  <th width="100" >Nombre Bloque</th>
			  <th width="30" >Edit</th>
			</tr>
			</thead>
			<tbody>';
					
			$cadreva="";			
			for($e=0;$e<pg_numrows($result);$e++){
			  
			$fila = pg_fetch_array($result,$e);
			
			$cadreva.=$fila['rut_evaluador'].",";
			
			$rs_busca = $obj_Relacion_e_b->bloqueesta($fila['id_bloque'],$fila['rut_evaluador'],$_POST['id_cargo'],$id_periodo);
			$esta=pg_result($rs_busca,0);

			if($esta>0){
			$check = "<a href='#' onclick='eliminarevaluador(".$fila['rut_evaluador'].")' ><img src='img/PNG-48/Delete.png' width='22' height='22' border='0' /></a>";
					}else{
            $check = "<a href='#' onclick='insertarevaluador(".$fila['rut_evaluador'].")' ><img src='img/PNG-48/Add.png' width='22' height='22' border='0' /></a>";
			}
					
					$table .= '<tr align="center" >
					<td  class=textosimple>'.$fila['nombre_emp']." ".$fila['ape_pat']." ".$fila['ape_mat'].'&nbsp;</td>
					<td class=textosimple>'.$fila['nombre_cargo'].'</td>
					<td class=textosimple>'.$fila['nombre'].'<input type="hidden" id="id_bloque_evaluador" value="'.$fila['id_bloque'].'" /></td>
					<td>'.$check .'</td>
					</tr>';
					   
						 }// fin for
		   
			$table .= "<tbody></table>";
			$cadreva= substr($cadreva, 0, -1);
			$table.='<input type="hidden" id="cadeva" value="'.$cadreva.'">';
			echo $table;

				
				}else{ 
				   echo 0; 
				}
				
				
	 } // fin funcion 6
	 


	if($funcion==4){
	
 $result = $obj_Relacion_e_b->eliminarevaluador($_POST['id_bloque'],$_POST['rut_evaluador'],$_POST['id_cargo'],$_POST['id_periodo'] );
		if($result){
		   echo 1;
		}else{ 
		   echo 0; 
		}
	 } // fin funcion 4
 
 if($funcion==7){
	 //var_dump($_POST);
	 $result1 = $obj_Relacion_e_b->eliminarevaluadorTodo($idbloque,$idcargo,$idperiodo );
	 $rute = explode(",",$cadeva);
	 if($result1){
	 	for($i=0;$i<count($rute);$i++){
			$rut_evaluador=$rute[$i];
			$result2 =$obj_Relacion_e_b->insertarevaluador($idbloque,$rut_evaluador,$idcargo,$idperiodo);
			
	
		}
		
		   echo 1;
		}else{ 
		   echo 0; 
		}
	 
	}
?>
