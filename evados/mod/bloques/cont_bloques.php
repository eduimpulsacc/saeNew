<?

session_start();
require "mod_bloques.php";
$ob_bloques = new Bloques($_IPDB,$_ID_BASE);


if($ob_bloques){
//echo "Se Creo OK";
}


$funcion = $_POST['funcion'];
$nombrebloque = $_POST['nombrebloque'];
$porcentajebloque = $_POST['porcentajebloque'];


	if($funcion==0){
		
		$result = $ob_bloques->insertarbloque($nombrebloque,$porcentajebloque,$tipo_evaluacion);
		
		if($result ){
		   echo 1;
		}else{ 
		   echo 0; 
		}
	
	 } // fin funcion 0


	if($funcion==3){
	
	$_ano = $_POST['ano'];
	$result = $ob_bloques->cargabloques($_ano);
			
		if($result){
			   
		   $table = '  <label for="listaevaluadores"><strong>Tabla Bloques</strong></label>
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
	
	
		$elimina = "<a href='#' onclick='Eliminabloque(".$fila['id_bloque'].")' ><img src='img/PNG-48/Delete.png' width='30' height='30' border='0' /></a>";
		
		$modificar = "<a href='#' onclick='buscarbloque(".$fila['id_bloque'].")' ><img src='img/PNG-48/Modify.png' width='30' height='30' border='0' /></a>";
		
			  $table .= '<tr align="center" >
			  <td>'.$fila['nombre'].'&nbsp;</td>
			  <td>'.$fila['porcentaje'].'%&nbsp;</td>
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
		$result = $ob_bloques->eliminarbloques($id_bloque);
		if($result ){
		   echo 1;
		}else{ 
		   echo 0; 
		}
	 } // fin funcion 4
 
 
 
	 if($funcion==5){
		$result = $ob_bloques->modificarbloques($id_bloque,$nombrebloque,$porcentajebloque,$tipo_evaluacion);
		if($result ){
		   echo 1;
		}else{ 
		   echo 0; 
		}
	 } // fin funcion 5
 
 
 
	  if($funcion==6){
		$result = $ob_bloques->buscarbloque($id_bloque);
			   if($result ){
				   $fila = pg_fetch_array($result,0);
				   echo json_encode($fila);
				}else{ 
				   echo 0; 
				}
	 } // fin funcion 6
 
 
?>
