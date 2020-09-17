<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_entrevista_profesional.php";

$objMembrete= new Membrete($_IPDB,$_ID_BASE);
$obj_Entrevista_Prof = new EntrevistaProf($_IPDB,$_ID_BASE);
$funcion = $_POST['funcion'];


	if($funcion == selectProf){
		
		  $result = $obj_Entrevista_Prof->carga_profesionales();
		  if($result){
		$select = "<label>Seleccione Profesional :&nbsp;&nbsp;
		<select name='select_profesional' id='select_profesional'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_prof']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre']))))."</option>";
		 }  // for 2 
		 $select .= "</select></label>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	if($funcion==CargaTabla){
			$id_prof=$_POST['id_prof'];
			$id_ano =$_POST['id_ano'];
		  $result = $obj_Entrevista_Prof->Carga_Entrevista_Profesionales($id_prof,$id_ano);
		  if($result){
			    $table = '<table width="100%" border="1">
              <tr class="color_fondo">
			  <th width="%" >A&ntilde;o</th>
			  <th width="%" >Curso</th>
			  <th width="%" >Alumno</th>
			  <th width="%" >Fecha</th>
			   <th width="%" >Observacion</th>
			   <th width="%" >Modifica</th>
			   <th width="%" >Elimina</th>
			   <th width="%" >Descargar</th>
			</tr>
			<tbody>';
			
			for($e=0;$e<pg_numrows($result);$e++){
			  
				$fila = pg_fetch_array($result,$e);
		
					$id_curso=$fila['id_curso'];
	$Curso_pal = $objMembrete->CursoPalabra($id_curso,1);	
					
	$table .= ' <tr align="center" style="font-size:11px;" >
	
	<td>'.$fila['nro_ano'].'&nbsp;</td>
	<td>'.$Curso_pal.'&nbsp;</td>
	<td>'.$fila['nombre_alu'].' '.$fila['ape_pat'].' '.$fila['ape_mat'].'&nbsp;</td>
	<td>'.$fila['fecha'].'&nbsp;</td>
	<td>'.$fila['obs'].'&nbsp;</td>
	<td>'.$modifica ="<a style='cursor:pointer' > <img src='Class/PNG-32/Modify.png' width='24' height='24' onclick='ModificaArchivo(".$fila['id_entrevista'].")' /></a>".'</td>
    <td>'.$elimina ="<a style='cursor:pointer' > <img src='Class/PNG-32/Delete.png' width='24' height='24' onclick='EliminaArchivo(".$fila['id_entrevista'].','.$fila['id_prof'].")' /></a>".'</td>
	<td>'.$descargar =" <a href='mod/entrevista_profesional/descarga_archivo.php?id=".$fila['id_entrevista']."'> <img src='Class/PNG-32/Save.png' width='22' height='24' /> </a>".'</td>
			</tr>';
			}// fin for
			$table .= "<tbody></table>";
			echo $table;
		
				}else{ 
				   echo 0;
		}	
	}
	
	if($funcion==descarga){
	
		  
	$id_prof=$_POST['id_entrevista'];
	  $result = $obj_Entrevista_Prof->Descarga_Archivo($id_entrevista);
	  if($result){
		  
		 for($e=0;$e<pg_numrows($result);$e++){
			  
				$fila = pg_fetch_array($result,0);
				
		if (!isset($_GET['file']) || empty($_GET['file'])) {
    exit();
}
$root = "archivos/";
$file = basename($fila['archivo']);
$path = $root.$file;
$type = '';
 
if (is_file($path)) {
    $size = filesize($path);
    if (function_exists('mime_content_type')) {
        $type = mime_content_type($path);
    } else if (function_exists('finfo_file')) {
        $info = finfo_open(FILEINFO_MIME);
        $type = finfo_file($info, $path);
        finfo_close($info); 
    }
    if ($type == '') {
        $type = "application/force-download";
    }
    // Set Headers
    header("Content-Type: $type");
    header("Content-Disposition: attachment; filename=$file");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . $size);
    // Download File
    readfile($path);
} else {
    die("File not exist !!");
}		
				
				
				
				
	/*	$nombre = "archivos/".$fila['archivo']; // Nombre del archivo
		$contenido = 'Texto del archivo'; // Contenido del archivo
		header( "Content-Type: application/octet-stream");
		header( "Content-Disposition: attachment; filename=".$nombre."");
		//print($nombre);
		echo "mod/entrevista_profesional/$nombre";*/
		 }
	  }
	}
	
	
	if($funcion == 2){
		 $id_entrevista = $_POST['id_entrevista'];
		$result = $obj_Entrevista_Prof->Busca_Entrevista_Profesionales($id_entrevista);
	if($result){
		if(@pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id_entrevista" type="hidden" value="'.$fila['id_entrevista'].'" />';
				echo '<input id="_obser" type="hidden" value="'.$fila['obs'].'" />';
				echo '<input id="_fecha" type="hidden" value="'.$fila['fecha'].'" />';
				echo '<input id="_id_prof" type="hidden" value="'.$fila['id_prof'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
 }
 
 if($funcion == 3){
		$id_entrevista = $_POST['_id_entrevista'];
		 $_obser=$_POST['_obser'];
		$result = $obj_Entrevista_Prof->Modifica_Entrevista_Profesionales($id_entrevista,$_obser);
	if($result){
		echo 1;
		 }else{
		echo 0;			
		 }
    }
	
	if($funcion == 4){
		
		 $id_entrevista = $_POST['id_entrevista'];
		 $result = $obj_Entrevista_Prof->eliminad_Entrevista($id_entrevista);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}
	

?>