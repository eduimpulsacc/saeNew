<?
session_start();

require_once("../../class/curso_palabra.php");
require "mod_relacion_ee_class.php";

$obj_Relacion_ee = new Relacion_ee($_IPDB,$_ID_BASE);

$funcion = $_POST['funcion'];
$nombrebloque = $_POST['nombrebloque'];
$porcentajebloque = $_POST['porcentajebloque'];
$periodo = $_PERIODO;



	if($funcion==0){
       
     $Arreglo_RutevaluadoresCargos = explode("-",$_POST['Arreglo_RutevaluadoresCargos']);
	 
    $result = $obj_Relacion_ee->insertar_relacion_ee($Arreglo_RutevaluadoresCargos,$_POST['rut_evaluado'],$_POST['cargo_evaluado'],$_ANO,$periodo);
		 
		if($result){
		   echo 1;
		}else{ 
		   echo 0; 
		}
	
	 } // fin funcion 0



   if($funcion==2){
	  
	     $result2 = $obj_Relacion_ee->cargacargos();
         
		if($result2){
			
		 $select2 = "<label>Seleccionar Cargo : <select name='cmbCARGO' id='cmbCARGO'  onchange='cargartablaevaluados(this.value)' >
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
			
     } // fin funcion 2


	if($funcion==3){
	
		$_ano = $_POST['ano'];
		$result1 = $obj_Relacion_ee->cargabloques($_ano);
			
		if($result1){
			   
		   $select1 = '<label>Seleccionar Bloque : <select name="selectbloque" id="selectbloque" onchange="cargartablaevaluadores(this.value)" >';
		   $select1 .= " <option value=0 select='select' >Selecccionar</option>";
						
		  for($e=0;$e<pg_numrows($result1);$e++){
		  
		        $fila = pg_fetch_array($result1,$e);
				
 	            $select1 .= " <option value='".$fila['id_bloque']."'>".$fila['nombre']."</option>";
		   
			 }  // for 1
		   
			$select1 .=  " </select></label>";
			echo $select1."<br><br>";
				   
			}else{ 
			   echo 0; 
			}
			
	 } // fin funcion 3

 
	  if($funcion==6){ // busca evaluadores por bloque

		$result = $obj_Relacion_ee->buscarevaluadores($id_bloque,$_ANO,$periodo);
		  //echo "bloque->".$_ANO;
		  if($result ){
				
		   $table = '  <label for="listaevaluadores">Tabla Evaluadores</label>
		  <table id="flex1" style="display:none" >
		  <thead>
			<tr>
			  <th width="60" class="textonegrita" >Rut</th>
			  <th width="260" class="textonegrita" >Nombre Evaluador</th>';
			  if($id_bloque==15 or $id_bloque==14){
				  
			 $table.='<th width="250" class="textonegrita" >Curso</th>';
			  }
			  
			 $table .='<th width="30"  class="textonegrita">Edit</th>
			</tr>
			</thead>
			<tbody>';
						
			  for($e=0;$e<pg_numrows($result);$e++){
			  
			  $fila = pg_fetch_array($result,$e);
			  
		$Curso_pal = CursoPalabra($fila['id_curso'], 1,$obj_Relacion_ee->Conec->conectar());

					$table .= '<tr>
					<td class="textosimple">'.$fila['rut_evaluador'].'</td>
					<td class="textosimple">'.$fila['ape_pat']." ".$fila['ape_mat']." ".$fila['nombre_emp'].'&nbsp;</td>';
					 if($id_bloque==15 or $id_bloque==14){
				  
			 $table.='<td  class="textosimple">'.$Curso_pal.'</td>';
			  }
					
					
					$table.='<td class="textosimple"><input id="cargar_evaluador'.$e.'" type="checkbox" value="'.$e.'" onchange="cargar_evaluador('.$e.','.$fila['rut_evaluador'].','.$fila['id_cargo'].')" />&nbsp;</td>
					</tr>';
					   
						 }// fin for
		   
			$table .= "<tbody></table>";
			echo $table;
				
				}else{ 
				   echo 0; 
				}
				
	 } // fin funcion 6
	 



	  if( $funcion==7 ){ // busca evaluados por Cargo

		$result = $obj_Relacion_ee->buscarevaluados($id_cargo,$_ANO,$_INSTIT);
		  
		  if($result){
				
		   $table = '<label>Tabla Evaluados</label>
		  <table id="flex2" style="display:none" >
		  <thead>
			<tr>
			  <th width="60" class="textonegrita" >Rut</th>
			  <th width="260" class="textonegrita" >Nombre Evaluado</th>
			  <th width="30" class="textonegrita" >Crear</th>
			  <th width="30" class="textonegrita" >Ver</th>
			</tr>
			</thead>
			<tbody>';
						
					  for($e=0;$e<pg_numrows($result);$e++){
			  
					  $fila = pg_fetch_array($result,$e);

						$check1 = "<a href='#' onclick='buscar_relacion(".$fila['rut_evaluado'].",".$fila['id_cargo'].")' ><img src='img/PNG-48/Search.png' width='22' height='22' border='0' /></a>";

                        $check2 = "<a href='#' onclick='insertar_relacion(".$fila['rut_evaluado'].",".$fila['id_cargo'].")' ><img src='img/PNG-48/Add.png' width='22' height='22' border='0' /></a>";
					
					$table .= '<tr>
					<td class="textosimple">'.$fila['rut_evaluado'].'</td>
					<td class="textosimple">'.$fila['ape_pat']." ".$fila['ape_mat']." ".$fila['nombre_emp'].'&nbsp;</td>
					<td>'.$check2.'&nbsp;</td>
					<td>'.$check1.'&nbsp;</td>
					</tr>';
					   
						 }// fin for
		   
						$table .= "<tbody></table>";
						echo $rut_del_evaluado = '<input type="hidden" id="rut_evaluado" name="rut_evaluado" value="'.$fila['rut_evaluado'].'">';
						echo $table;
						echo $rut_del_evaluado;
				}else{ 
				
				   echo 0;
				   
				}
				
	 } // fin funcion 7
	 
	 
	 
	 
	 
	  if( $funcion==8 ){ // busca evaluados por Cargo

		  $result = $obj_Relacion_ee->buscarevaluadoresrelacionados($rut_evaluado,$_ANO,$periodo,$id_cargo_evaluado);
		  
		  if($result ){
				
		   $table = '<br><table id="flex3" style="display:none" >
		  <thead>
			<tr>
			  <th width="80" class="textosimple" >Rut</th>
			  <th width="220" class="textosimple" >Nombre Evaluador</th>
			  <th width="100" class="textosimple" >Cargo</th>
			  <th width="50" class="textosimple" >Eliminar</th>
			</tr>
			</thead>
			<tbody>';
						
					  for($e=0;$e<pg_numrows($result);$e++){
							  $fila = pg_fetch_array($result,$e);

if($fila['fecha_evaluacion']!=NULL){

$check1 =	'&nbsp;';
	
	}else{

$check1 = "<a href='#' onclick='eliminar_relacion(".$fila['rut_evaluador'].",".$fila['id_cargo'].",".$fila['rut_evaluado'].",".$fila['cargo_evaluado'].")' ><img src='img/PNG-48/Delete.png' width='22' height='22' border='0' /></a>";
					
					}
					
					$table .= '<tr>
					<td class="textosimple">'.$fila['rut_evaluador'].'</td>
					<td class="textosimple">'.$fila['nombre_emp']." ".$fila['ape_pat']." ".$fila['ape_mat'].'&nbsp;</td>
					<td class="textosimple">'.$fila['nombre_cargo'].'</td>
					<td class="textosimple">'.$check1.'&nbsp;</td> 
					</tr>';
					
					   
						 }// fin for
						 
		   
			$table .= "<tbody></table>";
			echo $table;
			
				
				}else{ 
				
				   echo 0;
				   
				}
				
	 } // fin funcion 8
	 
	 
	 //pachacho :D
	 if($funcion==9){
		 
		 $result = $obj_Relacion_ee->eliminar_relacion($_POST['rut_evaluador'],$_POST['id_cargo'],$_POST['rut_evaluado'],$_POST['cargo_evaluado']);
		  
		  if($result){
		  
		  echo 1; //verdadero 
		  
		  }else{ 
		  
		  echo 0;  // falso
		  
		  }
		 
		 }

	 
	 if($funcion==10){  //Reporte de Relacionados
	 
	 $result = $obj_Relacion_ee->mostrar_evaluadores($_ANO,$periodo);
	 
	 $tabla = '<div id="Reporte_Relacionados"  style="width:850px;" align="center" >
	  <table  align="center"><tr><td>
	  <h2 align="center" >Sistema Evaluacion Docente</h2>';
		   
	  $fila = $obj_Relacion_ee->institucion($_INSTIT);
	  
	  $tabla .= "<spam align='center' >Instituci&oacuten : ".$fila['nombre_instit']."</spam>";
      $tabla .= "<br><spam align='center' >Direccion : ".$fila['calle']." ".$fila['nro']." ".$fila['nom_com']."</spam>";
      $tabla .= "<br><spam align='center' >Telefono : ".$fila['telefono']."</spam>";
      
	  $fila = $obj_Relacion_ee->anoescolar($_INSTIT);
      
	  $tabla .= "<br><spam align='center' >A&ntildeo Escolar : ".$fila['nro_ano']."</spam>";

   	  $fila_p = $obj_Relacion_ee->periodo($periodo);
      $tabla .= "<br><spam align='center' >Periodo : ".$fila_p['nombre_periodo']."</spam>";
	  
	  $porcentaje = $obj_Relacion_ee->Avance($_ANO,$periodo);
	  $tabla .= "<br><spam align='center' >Estado de Avance: ".$porcentaje."%</spam></br></br>";
		   
	 $tabla .= '<h3 align="center" >Reporte de Relacionados Evaluador Evaluados</h3>';
					
			for($i=0;$i<@pg_num_rows($result);$i++){
			
				$fila = @pg_fetch_array($result,$i);
				
				$tabla.='<table border="1" width="800" style="border-collapse:collapse" >
								<thead>
								<tr bgcolor="#6699FF" >
									<th width="200">Nombre Evaluador</th>
									<th width="100">Rut</th>
									<th width="100">Cargo</th>
									
								</tr>	
								</thead>
								<tbody>';
				
				$tabla.='<tr>
				<td>'.$fila[3].' '.$fila[4].' '.$fila[5].'</td>
				<td align="center" >'.$fila[0].'-'.$fila[1].'</td>
				<td>'.$fila[2].'</td>
				</tr><tr><td colspan="5" ></br>';
				
				$tabla .= '<table border="1" width="800" style="border-collapse:collapse" >
								<thead>
								<tr bgcolor="#FFFF99" >
								    <th width="140">Nombre Evaluado</th>
									<th width="80">Rut</th>
									<th width="80">Cargo</th>
									<th width="80">Estado</th>
									<th width="80">Fecha</th>
								</tr>	
								</thead>
								<tbody>';
				
			echo $result2 = $obj_Relacion_ee->mostrar_evaluados($fila[0],$_ANO,$periodo,$fila[7]);
				
			for($i2=0;$i2<@pg_num_rows($result2);$i2++){
			
			$fila2 = @pg_fetch_array($result2,$i2);
						
			$tabla.='<tr>
			<td>'.$fila2[4].' '.$fila2[5].' '.$fila2[3].'</td>
			<td align="center" >'.$fila2[0].'-'.$fila2[1].'</td>
			<td>'.$fila2[2].'</td>
			<td>'.$fila2[6].'</td>
			<td>'.$fila2[7].'</td>
			</tr>';
			
			}

			$tabla.='</tbody></table>';			
				
			$tabla.='</br></td></tr></tbody></table>';	
				 		    
	        }
					
			$tabla.='</td></tr></table></div>';
			  
			echo $tabla;
          
		    }
	


		 if($funcion==11)
		 {  // Copia de Relacionados Año Anterior
	 
		$result = $obj_Relacion_ee->CopiarRelacionados($_ANO,$_INSTIT,$periodo);
		     
		 if($result){ echo 1;}else{echo 0;}
		 
		 }
		 
		 if($funcion==12){ // busca evaluadores por bloque
		 
		 $idano=$_ANO;

		$result = $obj_Relacion_ee->buscarevaluadorestodos($id_bloque,$cargo_evaluado,$idano,$periodo,$rut_evaluado);
		
		  $todos_los_rut=0;
		  
		  if($result){
			  echo 1;
		 }else{
			 echo 0;
			 }
		 
		}
		 
		 
		 
	
?>
