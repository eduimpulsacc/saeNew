<?
session_start();
require('mod_evaluador.class.php');

$obj_Evaluador = new Evaluador($_IPDB,$_ID_BASE);

$funcion 	= $_POST['frmModo'];
$ano 		= $_ANO;
$rdb		= $_INSTIT;
$cargo		= $_POST['cmbCARGO'];
$porc		= $_POST['porcentaje'];
$curso    	= $_POST['id_curso'];
$ente      	= $_POST['ente'];
$periodo	= $_PERIODO;

if($funcion=="mostrar"){ // Muestra listado de Personal a Evaluar 

	if($_POST['ente']=='1'){
	$result = $obj_Evaluador->listadoEvaluados($rdb,$cargo,$ano,$periodo);
	}elseif($_POST['ente']=='2'){
	$result = $obj_Evaluador->listadoalumnos($ano,$curso,$cargo,$periodo); 
	}elseif($_POST['ente']=='3'){
	$result = $obj_Evaluador->listadoapoderados($ano,$curso ,$cargo);
	}

	$tabla = '<table id="flex1" style="display:none"><thead>
				<tr>
					<th width="50" align="center">ASIGNAR</th>
					<th width="70">RUT</th>
					<th width="250">NOMBRE</th>
					<th width="50" align="center">ELIMINAR</th>
				 </tr></thead><tbody>';
				
			for($i=0;$i<@pg_numrows($result);$i++){
				$fila = @pg_fetch_array($result,$i);
				
				if($fila['rut'] != NULL ){
				
				$rs_existe = $obj_Evaluador->existeEvaluados($fila['rut'],$ano,$cargo,$periodo);
				
				if(pg_numrows($rs_existe)==1){
					$check = '&nbsp;';

					$elimina = "<a href='#' onclick='EliminaDocente(".$fila['rut'].")' ><img src='img/PNG-48/Delete.png' width='30' height='30' border='0' /></a>";

					$porcentaje = $fila['porcentaje'];
					
				}else{

					$check = "<a href='#' onclick='InsertaDocente(".$fila['rut'].",".$i.")' ><img src='img/PNG-48/Add.png' width='30' height='30' border='0' /></a>";

					$elimina = "&nbsp;";

					$porcentaje = "<input type='text' id='txtPORC".$i."' value='' size='5' maxlength='2'/>";
					//".$fila['porcentaje']."

				}
				
$tabla.='<tr>
				<td>'.$check.'</td>
				<td class="textosimple">'.$fila['rut'].'-'.$fila['dv'].'&nbsp;&nbsp;</td>
				<td class="textosimple">&nbsp;'.$fila['nombre'].'</td>
				<td>'.$elimina.'</td>
				</tr>';
			}
		
		}
		
	$tabla.='</tbody></table>';
	echo $tabla;
	
 }
  
 
	if($funcion=="insertar"){ // Inserta docente 
	
		$result = $obj_Evaluador->InsertaDocente($rut,$ano,$porc,$cargo,$rdb,$curso,$ente,$periodo);
		
		//echo $result;
		
		if($result){
		  echo 1;	
		}else{
		  echo 0;
		}
		
	 }
	
	
	if($funcion=="eliminar"){ // Elimina Docente
	
		$result = $obj_Evaluador->EliminaDocente($rut,$ano,$cargo,$rdb,$periodo);
		
		if($result == true){
		 echo 1;	
		}else{
		 echo 0;
		}
		
	  }
 


	if($funcion=="mostrarevaluados"){   // Elimina Docente
	
		 $result = $obj_Evaluador->mostrarevaluados($ano,$periodo);
	
		 $tabla = '<div id="reporte_evaluadores"  style="width:850px;" align="center" >
		 <table  align="center"><tr><td>
		 <h2 align="center" >Sistema Evaluacion Docente</h2>';
	
		 $fila = $obj_Evaluador->institucion($_INSTIT);
	
		 $tabla .= "<spam align='center' >Instituci&oacuten : ".$fila['nombre_instit']."</spam>";
		 
		 $tabla .= "<br><spam align='center' >
		 Direccion : ".$fila['calle']." ".$fila['nro']." ".$fila['nom_com']."</spam>";
		 
		 $tabla .= "<br><spam align='center' >Telefono : ".$fila['telefono']."</spam>";
	
		 $fila = $obj_Evaluador->anoescolar($_INSTIT);
	
		 $tabla .= "<br><spam align='center' >A&ntildeo Escolar : ".$fila['nro_ano']."</spam>";
		 
		 $fila_p =$obj_Evaluador->periodo($periodo);
		 
		 $tabla .= "<br><spam align='center' >Periodo : ".$fila_p['nombre_periodo']."</spam></br></br>";
	
		 $tabla .= '<h3 align="center" >Reporte de Evaluadores</h3>
		 <table border="1" width="800" style="border-collapse:collapse" >
				<thead>
	 			<tr>
	 			<th width="60">Rut</th>
	 			<th width="60">Cargo</th>
	 			<th width="120">Nombre</th>
	 			<th width="90">Ape. Pat.</th>
	 			<th width="90">Ape. Mat.</th>
				<th width="5">Elim.</th>
	 			</tr>	
	 			</thead>
	 			<tbody>';
	 		
			for($i=0;$i<@pg_num_rows($result);$i++){
				
	 		$fila = @pg_fetch_array($result,$i);
				
			$elimina = "<a href='#' 
			onclick='EliminaEvaluador(".$fila[0].",".$fila['id_cargo'].")' >
			<img src='img/PNG-48/Delete.png' width='30' height='30' border='0' /></a>";
				
			$tabla.='<tr>
			<td align="center" >'.$fila[0].'-'.$fila[1].'</td>
			<td>'.$fila[2].'</td>
			<td>'.$fila[3].'</td>
			<td>'.$fila[4].'</td>
			<td>'.$fila[5].'</td>
			<td align="center">'.$elimina.'</td>
			</tr>';
			
				
			}
				
			$tabla.='</tbody></table></td></tr></table></div>';
			
			echo $tabla;
          
		  }
 
      
		 if($_POST['funcion']==11)
		 {  // Copia de Relacionados Año Anterior
	 
		$result = $obj_Evaluador->CopiarEvaluadores($_ANO,$_INSTIT,$periodo);
		     
		 if($result){ echo 1;}else{echo 0;}
		 
		 }
		 
  
  	if($_POST['funcion']==15){
		$rs_consulta=$obj_Evaluador->consulta_cargo($rut,$_ANO,$_PERIODO);	
		echo $cargo = pg_result($rs_consulta,0);
		
	}
?>
	
