<?
session_start();

require('mod_evaluados.class.php');

$obj_Evaluado = new Evaluados($_IPDB,$_ID_BASE);

$funcion 	= $_POST['frmModo'];
$ano 		= $_ANO;
$rdb		= $_INSTIT;
$cargo		= $_POST['cmbCARGO'];
$periodo	= $_PERIODO;

if($funcion=="mostrar"){ // Muestra listado de Personal a Evaluar 
	
	$result = $obj_Evaluado->listadoEvaluados($rdb,$cargo);
	
	$tabla = '<table id="flex1" style="display:none">
				<thead>
				<tr>
					<th width="50" class=textonegrita>Asignar</th>
					<th width="80" class=textonegrita>RUT</th>
					<th width="300" class=textonegrita>NOMBRE</th>
					<th width="50" class=textonegrita>Eliminar</th>
				</thead>
				<tbody>';
				
			for($i=0;$i<@pg_numrows($result);$i++){
				
				$fila = @pg_fetch_array($result,$i);
				
				$rs_existe =$obj_Evaluado->existeEvaluados($fila['rut_emp'],$ano,$cargo,$periodo);
				
				if(@pg_numrows($rs_existe)==1){
					$check = '&nbsp;';
					$elimina = "<a href='#' onclick='EliminaDocente(".$fila['rut_emp'].")' ><img src='img/PNG-48/Delete.png' width='30' height='30' border='0' /></a>";
				}else{
					$check = "<a href='#' onclick='InsertaDocente(".$fila['rut_emp'].")' ><img src='img/PNG-48/Add.png' width='30' height='30' border='0' /></a>";
					$elimina = "&nbsp;";
				}
	$tabla.='<tr>
				<td>'.$check.'</td>
				<td class=textosimple>'.$fila['rut_emp'].'-'.$fila['dig_rut'].'&nbsp;&nbsp;</td>
				<td class=textosimple>&nbsp;'.$fila['nombre'].'</td>
				<td>'.$elimina.'</td>
				</tr>';
			}
	$tabla.='</tbody></table>';
	echo $tabla;
	
 }
  
 
if($funcion=="insertar"){ // Inserta docente 
	
	 $result = $obj_Evaluado->InsertaDocente($_POST['rut'],$ano,$_POST['id_cargo'],$rdb,$periodo);
	
		if($result == true){
		    echo 1;	
		}else{
			 echo 0;
		}
    
	 }
	 

if($funcion=="eliminar"){ // Elimina Docente
	 $result = $obj_Evaluado->EliminaDocente($_POST['rut'],$ano,$_POST['id_cargo'],$periodo);
		if($result == true){
		    echo 1;	
		}else{
			 echo 0;
		}
}
 
  

if($funcion=="mostrarevaluados"){ // Elimina Docente
	 
	 $result = $obj_Evaluado->mostrarevaluados($ano,$periodo);
	 
	 $tabla = '<div id="reporte_evaluados"  style="width:850px;" align="center" >
	  <table  align="center"><tr><td>
	  <h2 align="center" >Sistema Evaluacion Docente</h2>';
		   
	  $fila = $obj_Evaluado->institucion($_INSTIT);
	  
	  $tabla .= "<spam align='center' >Instituci&oacuten : ".$fila['nombre_instit']."</spam>";
      $tabla .= "<br><spam align='center' >Direccion : ".$fila['calle']." ".$fila['nro']." ".$fila['nom_com']."</spam>";
      $tabla .= "<br><spam align='center' >Telefono : ".$fila['telefono']."</spam>";
      
	  $fila = $obj_Evaluado->anoescolar($_INSTIT);
      
	  $tabla .= "<br><spam align='center' >A&ntildeo Escolar : ".$fila['nro_ano']."</spam>";
	  
	  $fila_p =$obj_Evaluado->periodo($ano);
		 
	  $tabla .= "<br><spam align='center' >Periodo : ".$fila_p['nombre_periodo']."</spam></br></br>";
		   
	 $tabla .= '<h3 align="center" >Reporte de Evaluados</h3>
	 <table border="1" width="800" style="border-collapse:collapse" >
				<thead>
				<tr>
					<th width="60">Rut</th>
					<th width="60">Cargo</th>
					<th width="120">Nombre</th>
					<th width="90">Ape Pat</th>
					<th width="90">Ape Mat</th>
				</tr>	
				</thead>
				<tbody>';
				
			for($i=0;$i<@pg_numrows($result);$i++){
			
				//$report->tilde();
				$fila = @pg_fetch_array($result,$i);
				$tabla.='<tr>
				<td>'.$fila[0].'-'.$fila[1].'</td>
				<td>'.$fila[2].'</td>
				<td>'.$fila[3].'</td>
				<td>'.$fila[4].'</td>
				<td>'.$fila[5].'</td>
				</tr>';
		    
			 }
			
			$tabla.='</tbody></table></td></tr></table></div>';
			echo $tabla;
          
		  }

		  
		  // Copia de Relacionados Año Anterior
		  if($_POST['funcion']==11)
		 {  
	 
		$result = $obj_Evaluado->CopiarEvaluados($_ANO,$_INSTIT,$periodo);
		     
		 if($result){ echo 1;}else{echo 0;}
		 
		 }
		 

?>
	
