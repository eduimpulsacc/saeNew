<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_nivel_logro.php";

$objMembrete= new Membrete($_IPDB,$_ID_BASE);
$obj_Nivel = new NivelDeLogro($_IPDB,$_ID_BASE);
$funcion = $_POST['funcion'];


if($funcion == 1){
		 $id_nivel = $_POST['id_nivel'];
		 $text_concepto = $_POST['concepto'];
		 $notaminima = $_POST['notaminima'];
		 $notamaxima = $_POST['notamaxima'];
		 $id_ano = $_POST['id_ano'];
		 $descrip = $_POST['descrip'];
		 $result = $obj_Nivel->guardad_nivelLogro($id_nivel,$text_concepto,$notaminima,$notamaxima,$id_ano,$descrip,$_INSTIT);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}
	
	
	if($funcion==2){
	$_ano = $_POST['ano'];
	$result = $obj_Nivel->cargaNivelLogro($_INSTIT);
			
		if($result){
			   
		   $table = '
		  <table  width="100%"  border="1">
		 
			<tr align="center" class="color_fondo" >
			  <th width="200" >Nivel</th>
			  <th width="295" >Concepto</th>
			  <th width="100" >Nota Minima</th>
			  <th width="100" >Nota Maxima</th>
			  <th width="100" >Modificar</th>
			  <th width="100" >Eliminar</th>
			</tr>
			
			<tbody>';
						
		  for($e=0;$e<@pg_numrows($result);$e++){
		  
		  $fila = pg_fetch_array($result,$e);
		  $id_nivel=$fila['id_nivel'];
		  if($id_nivel==1){
			 $id_nivel="Nivel Logrado";
			  }else if($id_nivel==2){
			  	$id_nivel="Nivel Por Lograr";
			  }else if($id_nivel==3){
				$id_nivel="Nivel Intermedio";  
			  }	
	
$elimina ="<input type='button' id='elimina' name='btn_elimina' title='Eliminar' value='X' onclick='EliminarNivelLogro(".$fila['id'].")'>";				
		
$modificar ="<input type='button' id='modificar' name='btn_modificar' title='Modificar' value='M' onclick='BuscaNivelLogro(".$fila['id'].")'>";

		
			  $table .= '<tr align="center" id="botones" >
			  <td>'.$id_nivel.'&nbsp;</td>
			  <td>'.$fila['concepto'].'&nbsp;</td>
			  <td><input type="text" id="nota_minima'.$e.'"   disabled=disabled size="1" value="'.$fila['nota_minima'].'">&nbsp;</td>
			  <td><input type="text" id="nota_maxima'.$e.'"   disabled=disabled size="1" value="'.$fila['nota_maxima'].'">&nbsp;</td>
			  <td>'.$modificar.'&nbsp;</td>
			  <td >'.$elimina.'&nbsp;</td>
			</tr>';
		   
			 }// fin for
		   
			$table .= "<tbody></table>";
			echo $table;
			
			
			   
			}else{ 
			   echo 0; 
			}
	 } // fin funcion 2
	 
	 
	 
	 if($funcion == 3){
		 $id = $_POST['id'];
		$result = $obj_Nivel->Busca_nivelLogro($id);
	if($result){
		if(@pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id" type="hidden" value="'.$id.'" />';
				echo '<input id="_id_nivel" type="hidden" value="'.$fila['id_nivel'].'" />';
				echo '<input id="_concepto" type="hidden" value="'.trim($fila['concepto']).'" />';
				echo '<input id="_notaMinima" type="hidden" value="'.$fila['nota_minima'].'" />';
				echo '<input id="_notaMaxima" type="hidden" value="'.$fila['nota_maxima'].'" />';
				echo '<input id="_descripcion" type="hidden" value="'.$fila['descripcion'].'" />';
				echo '<input id="_id_ano" type="hidden" value="'.$fila['id_ano'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
 }
		
		
	if($funcion == 4){
		 $id_nivel = $_POST['id_nivel'];
		echo $text_concepto = $_POST['concepto'];
		 $notaminima = $_POST['notaminima'];
		 $notamaxima = $_POST['notamaxima'];
		 $id_ano = $_POST['id_ano'];
		 $id = $_POST['id'];
		 $result = $obj_Nivel->modificad_nivelLogro($id_nivel,$text_concepto,$notaminima,$notamaxima,$_INSTIT,$id);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}	
	
	
	if($funcion == 5){
		
		 $id = $_POST['id'];
		 $result = $obj_Nivel->eliminad_nivelLogro($id);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}	
	 
	
	
	 ?>