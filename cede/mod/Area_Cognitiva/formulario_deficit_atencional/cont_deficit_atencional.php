<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_deficit_atencional.php";

$objMembrete= new Membrete($_IPDB,$_ID_BASE);
$Obj_Area_cog = new AreaCog($_IPDB,$_ID_BASE);
$funcion = $_POST['funcion'];
		
	
	if($funcion==descarga){
	
		$nombre = "documento_oficial/FORMULARIO_DEFICIT_ATENCIONAL.doc"; // Nombre del archivo
		echo "mod/Area_Cognitiva/$nombre";
	}
	
	if($funcion==CargaTabla){
			$id_tipo=$_POST['id_tipo'];
			$rut_alumno=$_POST['rut_alumno'];
		  $result = $Obj_Area_cog->Carga_Area_Cognitiva($id_tipo,$rut_alumno);
		  if($result){
			    $table = '<table width="100%" border="1" style="border-collapse:collapse">
              <tr class="color_fondo">
			  <th width="%" >A&ntilde;o Escolar</th>
			  <th width="%" >Fecha</th>
			  <th width="%" >Observacion</th>
			   <th width="%" >Modifica</th>
			   <th width="%" >Elimina</th>
			   <th width="%" >Descargar</th>
			</tr>
			<tbody>';
			
			for($e=0;$e<pg_numrows($result);$e++){
			  
				$fila = pg_fetch_array($result,$e);
		
					$id_archivo=$fila['id_archivo'];
	//$Curso_pal = $objMembrete->CursoPalabra($id_curso,1);	
					
	$table .= ' <tr align="center" >
	
	<td>'.$fila['nro_ano'].'&nbsp;</td>
	<td>'.$fila['fecha'].'&nbsp;</td>
	<td>'.$fila['observacion'].'&nbsp;</td>
	<td>'.$modifica ="<a style='cursor:pointer' > <img src='Class/PNG-32/Modify.png' width='24' height='24' onclick='ModificaArchivofinal(".$fila['id_archivo'].")' /></a>".'</td>
    <td>'.$elimina ="<a style='cursor:pointer' > <img src='Class/PNG-32/Delete.png' width='24' height='24' onclick='EliminaArchivofinal(".$fila['id_archivo'].")'/></a>".'</td>
	<td>'.$descargar =" <a href='mod/Area_Cognitiva/formulario_deficit_atencional/descargar_archivo.php?id=".$fila['id_archivo']."'> <img src='Class/PNG-32/Save.png' width='22' height='24' /> </a>".'</td>
	
				</tr>';
			}// fin for
			$table .= "<tbody></table>";
			echo $table;
				}else{ 
				   echo 0;
		}	
	}
	
	
	if($funcion==descargafinal){
		
	$id_prof=$_POST['id_archivo'];
	
	  $result = $Obj_Area_cog->Descarga_Archivofinal($id_archivo);
	  if($result){
		  
		 for($e=0;$e<pg_numrows($result);$e++){
			  
				$fila = pg_fetch_array($result,0);
				
		$nombre = "archivos/".$fila['nombre']; // Nombre del archivo
		$contenido = 'Texto del archivo'; // Contenido del archivo
		header( "Content-Type: application/octet-stream");
		header( "Content-Disposition: attachment; filename=".$nombre."");
		//print($nombre);
		echo "mod/Area_Cognitiva/formulario_deficit_atencional/$nombre";
		 }
	  }
	}
	
	
	if($funcion == 2){
		 $id_archivo = $_POST['id_archivo'];
		$result = $Obj_Area_cog->Busca_area_cognitiva($id_archivo);
	if($result){
		if(@pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="id_archivo" type="hidden" value="'.$fila['id_archivo'].'" />';
				echo '<input id="_obser" type="hidden" value="'.$fila['observacion'].'" />';
				echo '<input id="_fecha" type="hidden" value="'.$fila['fecha'].'" />';
				echo '<input id="_id_tipo" type="hidden" value="'.$fila['id_tipo'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
 }
 
 
  if($funcion == 3){
		$id_archivo = $_POST['id_archivo'];
		 $_obser=$_POST['_obser'];
		$result = $Obj_Area_cog->Modifica_area_cognitiva($id_archivo,$_obser);
	if($result){
		echo 1;
		 }else{
		echo 0;			
		 }
    }
	
	
	if($funcion == 4){
		
		 $id_archivo = $_POST['id_archivo'];
		 $result = $Obj_Area_cog->eliminad_AreaCog($id_archivo);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}
	
?>