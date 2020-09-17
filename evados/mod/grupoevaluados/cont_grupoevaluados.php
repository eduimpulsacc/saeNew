<?

session_start();
require "mod_grupoevaluados.php";

$ob_grupoevaluados = new grupoevaluados($_IPDB,$_ID_BASE);

$funcion = $_POST['funcion'];
$nombrebloque = $_POST['nombrebloque'];
$porcentajebloque = $_POST['porcentajebloque'];


	if($funcion==0){
		
		$result = $ob_grupoevaluados->insertargrupoevaluados($nombrebloque,$porcentajebloque);
		
		if($result ){
		   echo 1;
		}else{ 
		   echo 0; 
		}
	
	 } // fin funcion 0


	if($funcion==3){
	
	$_ano = $_POST['ano'];
	$result = $ob_grupoevaluados->cargagrupoevaluados($_ano);
			
		if($result){
			   
		   $table = '  <label for="listaevaluadores"><strong>Tabla Grupo Evaluados</strong></label>
		  <table id="flex1" style="display:none" >
		  <thead>
			<tr align="center" >
			  <th width="300" >Nombre</th>
			  <th width="100" >Porcentaje</th>
			  <th width="100" >Modificar</th>
			  <th width="100" >Eliminar</th>
			</tr>
			</thead>
			<tbody>';
						
		  for($e=0;$e<pg_numrows($result);$e++){
		  
		  $fila = pg_fetch_array($result,$e);
	
		$elimina = "<a href='#' onclick='Eliminagrupo(".$fila['id_bloq_evaluado'].")' ><img src='img/PNG-48/Delete.png' width='30' height='30' border='0' /></a>";
		
		$modificar = "<a href='#' onclick='buscargrupo(".$fila['id_bloq_evaluado'].")' ><img src='img/PNG-48/Modify.png' width='30' height='30' border='0' /></a>";
		
			  $table .= '<tr align="center" >
			  <td>'.$fila['nombre_bloq_eva'].'&nbsp;</td>
			  <td>'.$fila['porcentaje_bloq_eva'].'%&nbsp;</td>
			  <td>'.$modificar.'&nbsp;</td>
			  <td>'.$elimina.'&nbsp;</td>
			</tr>';
		   
			 }// fin for
		   
			$table .= "<tbody></table>";
			echo $table;
			   
			}else{ 
			   echo 0; 
			}
	 } // fin funcion 3



	if($funcion==4){
		$result = $ob_grupoevaluados->eliminarbloques($id_bloque);
		if($result ){
		   echo 1;
		}else{ 
		   echo 0; 
		}
	 } // fin funcion 4
 
 
 
	 if($funcion==5){
		$result = $ob_grupoevaluados->modificargrupoevaluados($id_bloque,$nombrebloque,$porcentajebloque);
		if($result ){
		   echo 1;
		}else{ 
		   echo 0; 
		}
	 } // fin funcion 5
 
 
 
	if($funcion==6){
	
		$result = $ob_grupoevaluados->buscargrupoevaluados($id_bloq_evaluado);
		
			if($result ){
			
			$fila = pg_fetch_array($result,0);
							   
echo '<input name="id_bloq_evaluado" id="id_bloq_evaluado" type="hidden"  value="'.$fila['id_bloq_evaluado'].'" />				<input name="nombre_bloq_eva" id="nombre_bloq_eva" type="hidden" value="'.$fila['nombre_bloq_eva'].'" />
<input name="porcentaje_bloq_eva" id="porcentaje_bloq_eva" type="hidden" value="'.$fila['porcentaje_bloq_eva'].'" />';
			  
			}else{ 
			
			echo 0; 
			
			}
		
		} // fin funcion 6
 
 
?>
