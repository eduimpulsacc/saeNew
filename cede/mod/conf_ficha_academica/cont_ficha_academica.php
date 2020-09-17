<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_ficha_academica.php";

$objMembrete= new Membrete($_IPDB,$_ID_BASE);
$Obj_FichaAcademica = new FichaAcademica($_IPDB,$_ID_BASE);
$funcion = $_POST['funcion'];




	if($funcion == 1){
		$id_ramo = $_POST['id_ramo'];
		  $result = $Obj_FichaAcademica->carga_nivel($id_curso);
		  if($result){
		$select = "<label> Seleccione Nivel :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name='cmb_nivel' id='cmb_nivel' onchange='cargarselect(this.value,2)'>
		<option value='0' select='select'  >(Selecccionar Nivel)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_nivel']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre']))))."</option>";
		 }  // for 2 
				
		 $select .= "</select></label>"; 
		echo $select;
		 }else{
		 echo 0;			
		 }
	 }
	 
	 
	 if($funcion == 2){
		$id_nivel = $_POST['id_nivel'];
		  $result = $Obj_FichaAcademica->carga_ramos($id_nivel);
		  if($result){
		$select = "<label>Seleccione Asignatura :&nbsp;<select name='selectRamo' id='selectRamo' onchange='cargarselect(this.value,3)'>
		<option value='0' select='select'  >(Selecccionar Asignatura)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['cod_subsector']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre']))))."</option>";
		 }  // for 2 
		 $select .= "</select></label>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	
	 if($funcion == 3){
		$ano = $_POST['ano'];
		  $result = $Obj_FichaAcademica->carga_periodo($ano);
		  if($result){
		$select = "<label>Seleccione Periodo:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name='selectPeriodo' id='selectPeriodo'>
		<option value='0' select='select'  >(Selecccionar Periodo)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_periodo']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre_periodo']))))."</option>";
		 }  // for 2 
		 $select .= "</select></label>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	
	if($funcion == 4){
		$ano_academ = $_POST['ano_academ'];
		  $result = $Obj_FichaAcademica->carga_ano_acad($ano_academ);
		  if($result){
		$select = "<label>A&ntilde;o Academico:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,0);
			$fila['nro_ano'];
		 }  // for 2 
		 $select .= $fila['nro_ano']."</label>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}


		if($funcion==5){
			$rdb=$_POST['rdb'];
			
		  $result = $Obj_FichaAcademica->tabla_ficha_acad($rdb);
		  if($result){
			    $table = '<table width="100%" border="1">
              <tr class="color_fondo">
			  <th width="%">A&ntilde;o Escolar</th>
			  <th width="%">Nivel</th>
			  <th width="%">Ramo</th>
			  <th width="%">Periodo</th>
			  <th width="%">Nombre Conf</th>
			   <th width="%" >Nota Inicial</th>
			  <th width="%" >Nota Final</th>
			  <th width="%" >Promedio</th>
			  <th width="%" >Modificar</th>
			  <th width="%" >Eliminar</th>
			   
			  
			</tr>
			<tbody>';
			
			for($e=0;$e<pg_numrows($result);$e++){
			  
				$fila = pg_fetch_array($result,$e);
					
	$table .= ' <tr align="center" >
	
	<td>'.$fila['nro_ano'].'&nbsp;</td>
	<td>'.$fila['id_nivel'].'&nbsp;</td>
	<td>'.$fila['nombre'].'&nbsp;</td>
	<td>'.$fila['nombre_periodo'].'&nbsp;</td>
	<td>'.$fila['nombre_conf'].'&nbsp;</td>
	<td>'.$fila['nota_inicial'].'&nbsp;</td>
	<td>'.$fila['nota_final'].'&nbsp;</td>
	<td>'.$fila['promedio'].'&nbsp;</td>
	<td>'.$modifica ="<input type='button' id='btn_modifica' name='btn_modifica' value='M' onclick='BuscaFichaCad(".$fila['id_conf'].")'>".'&nbsp;</td>
	<td>'.$elimina ="<input type='button' id='btn_elimina' name='btn_elimina' value='E' onclick='EliminarFichaAcad(".$fila['id_conf'].")'>".'&nbsp;</td>
	
				</tr>';
			}// fin for
			$table .= "<tbody></table>";
			echo $table;
				}else{ 
				   echo 0;
		}	
	}
	
	 if($funcion==6){
		 $ano=$_POST['ano'];
		$id_nivel = $_POST['id_nivel'];
		$id_ramo=$_POST['id_ramo'];
		$id_periodo=$_POST['id_periodo'];
		$nota_inicial=$_POST['nota_inicial'];
		$nota_final=$_POST['nota_final'];
		$chk_promedio=$_POST['chk_promedio'];
		 $rdb=$_POST['rdb'];
		 $nombre_conf=$_POST['nombre_conf'];
		 
	$result = $Obj_FichaAcademica->InsertaFichaAcademica($rdb,$ano,$id_periodo,$nota_inicial,$nota_final,$chk_promedio,$id_nivel,$id_ramo,$nombre_conf);
	if($result){
		echo 1;
		 }else{
		echo 0;			
		 }
    }
	
	if($funcion == 7){
		 $id_conf = $_POST['id_conf'];
		$result = $Obj_FichaAcademica->Busca_ficha_acad($id_conf);
	if($result){
		if(@pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id_conf" type="hidden" value="'.$fila['id_conf'].'" />';
				echo '<input id="_id_periodo" type="hidden" value="'.$fila['id_periodo'].'" />';
				echo '<input id="_nombre_conf" type="hidden" value="'.$fila['nombre_conf'].'" />';
				echo '<input id="_id_nivel" type="hidden" value="'.$fila['id_nivel'].'" />';
				echo '<input id="_nota_inicial" type="hidden" value="'.$fila['nota_inicial'].'" />';
				echo '<input id="_nota_final" type="hidden" value="'.$fila['nota_final'].'" />';
				echo '<input id="_promedio" type="hidden" value="'.$fila['promedio'].'" />';
				echo '<input id="_cod_subsector" type="hidden" value="'.$fila['cod_subsector'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
 }
 
 
 if($funcion==8){
		$_id_conf=$_POST['_id_conf'];
		$id_nivel = $_POST['id_nivel'];
		$id_ramo=$_POST['id_ramo'];
		$id_periodo=$_POST['id_periodo'];
		$nota_inicial=$_POST['nota_inicial'];
		$nota_final=$_POST['nota_final'];
		$chk_promedio=$_POST['chk_promedio'];
		$nombre_conf=$_POST['nombre_conf'];
		 
	$result = $Obj_FichaAcademica->ModificaFichaAcademica($_id_conf,$id_periodo,$nota_inicial,$nota_final,$chk_promedio,$id_nivel,$id_ramo,$nombre_conf);
	if($result){
		echo 1;
		 }else{
		echo 0;			
		 }
    }
	
	if($funcion == 9){
		
		 $_id_conf = $_POST['_id_conf'];
		 $result = $Obj_FichaAcademica->eliminad_FichaAcad($_id_conf);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}	
 
	
		

?>