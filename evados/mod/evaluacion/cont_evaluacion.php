<? header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require "mod_evaluacion.php";

$periodo	= $_PERIODO;
$obj_Pautaeva = new Pautaeva($_IPDB,$_ID_BASE);
$funcion = $_POST['funcion'];
$rut = trim($_POST['rut_evaluador']);
//echo $_ANO."  ".$periodo;

	if($funcion==1){

	  	$result = $obj_Pautaeva->evaluadosporevaluador($rut,$_ANO,$_INSTIT,$periodo);   // variable de seccion rut y ano
		
		$result2 = $obj_Pautaeva->fechas_periodo_evaluacion($_ANO);
		$fila_validafechaperiodo = pg_fetch_array($result2,0);
			
		if($result){
		   $table = '<table id="flex1" style="display:none" >
		  <thead>
			<tr align="center" >
			  <th width="100" >Pauta eval.'.$_ANO.'</th>
			  <th width="360" >Nombre</th>
			  <th width="140" >Cargo</th>
			  <th width="100" >Cargo Evaluador</th>
			  <th width="100" >Evidencias</th>
			 
			</tr>
			</thead>
			<tbody>';
						
		  for($e=0;$e<pg_numrows($result);$e++){
			  
			  
		  $fila = pg_fetch_array($result,$e);
		  $cargo_evaluador = $obj_Pautaeva->cargos($fila['idcargoevaluador']);

		  $modificar = "<a href='#'  alt='Mostrar Evidencias' onclick='cargar_portafolios(".$fila['rut_evaluado'].")' ><img src='img/PNG-48/Modify.png' width='34' height='34' border='0' /></a>";
		  
         if ( ($fila['fecha_evaluacion']!='') ){
	
	    $bloques = "<img src='img/PNG-48/ok.png' width='34' height='34' border='0' title='Evaluacion Cerrada' />";	
		
        	}else{
	
	 if($fila_validafechaperiodo['bool']=1){
	
		$bloques = "<a href='#' onclick='vistaprevia(".$fila['rut_evaluador'].",".$fila['rut_evaluado'].",".$fila['id_cargo'].",".$fila['idcargoevaluador'].",".$fila['bloqueevaluador'].")' >
				 	<img src='img/PNG-48/Add.png' width='24' height='24' border='0'  alt='Abrir Evaluacion'  /></a><a href='#'></a>"; /*<img src='img/PNG-48/Delete.png' width='24' height='24' border='0'  title='Eliminar Relacion' onclick='EliminaRelacion(".$fila['rut_evaluador'].",".$fila['rut_evaluado'].",".$fila['id_cargo'].",".$fila['idcargoevaluador'].")'  />*/
	 }else{
	
	 	$bloques = "<a href='#' onclick='fechafueraderango()'><img src='img/PNG-48/Add.png' width='34' height='34' border='0'  alt='Abrir Evaluacion'  /></a>";
	
		 }
	
	      }

	        $table .= '<tr>	  
						  <td class=textosimple>'.$bloques.'&nbsp;</td>
						  <td class=textosimple>'.$fila['ape_pat'].' '.$fila['ape_mat'].' '.$fila['nombre_emp'].'&nbsp;</td>
						  <td class=textosimple>'.$fila['nombre_cargo'].'&nbsp;</td>
						  <td class=textosimple>'.$cargo_evaluador.'&nbsp;</td>
						  <td class=textosimple>'.$modificar.'&nbsp;</td>
						 
						</tr>';
		   
			 }	// fin for
		   
			$table .= "<tbody></table>";
			echo $table;
			   
			}else{ 
			   echo 0; 
			}
			
	 } 	// fin funcion 1
	 
	 
	 if($funcion==2){

		  $obj_Pautaeva->putaevaluacion($_POST['rutevador'],$_POST['rutevado'],$_POST['cargo_evaluado'],$_POST['cargo_evaluador'],$_POST['bloqueevaluador'],$_NACIONAL,$_ANO,$_PERIODO);
		 
		 }
		 
		 
		if($funcion==3){

		$result = $obj_Pautaeva->cargadorportafolio($_POST['rut_evaluado'],$_ANO);
		 
		 if($result){

		   $table = '<table id="flex11" style="display:none" >
		   <thead>
			<tr align="center" >
			  <th width="300" >Nombre Archivo</th>
			  <th width="100" >Tipo Archivo</th>
			</tr>
			</thead>
			<tbody>';
		    
		  for($e=0;$e<pg_numrows($result);$e++){
		  
		  $fila = pg_fetch_array($result,$e);
              
			  $fila['rut_evaluado'];
			    
              $table .= "<tr>
			  <td><a href='?archivo=".$fila['nombre_archivo']."' >".$fila['nombre_archivo']."</a></td>
			  <td>".$fila['tipo_doc']."&nbsp;</td>
			  </tr>";
		   
			 }// fin for
		   
			$table .= "<tbody></table>";
			echo $table;
			   
			}else{ 
			   echo 0; 
			}
		 
		 } 
		 


	if($_POST['tableevaluacion']==1){}  

        for($e=1;$e<=count($_POST['conceptos']);$e++){
			
			if($_POST['conceptos'][$e]!=0){	
			
			$datos = explode(",",$_POST['ids_pauta'][$e]);
			
			$result = $obj_Pautaeva->insert_evaluacion($datos,$_POST['conceptos'][$e],$_ANO,$_POST['_cargo_evaluado'],$_POST['_cargo_evaluador'],$_PERIODO);
			if(!$result) echo "Error";
			
		   //$result = $obj_Pautaeva->fechaevaluacion($_ANO,$datos[5],$datos[4],$_POST['_cargo_evaluado'],$_POST['_cargo_evaluador']);
		   $result = $obj_Pautaeva->fechaevaluacion($_ANO,$datos[5],$datos[4],$_POST['_cargo_evaluado'],$_POST['_cargo_evaluador']);
		   if(!$result) echo "Error";	
		   
			 }
			
      } 
	  
	  
	
	  echo 1;
	
	
	
	if($funcion==5){
		$rs_elimina=$obj_Pautaeva->EliminaRelacion($rutevaluado,$rutevaluador,$cargoevaluado,$cargo_evaluador,$periodo);	
		
		if($rs_elimina){
			echo 1;
		}else{
			echo 0;	
		}
	}

?>
