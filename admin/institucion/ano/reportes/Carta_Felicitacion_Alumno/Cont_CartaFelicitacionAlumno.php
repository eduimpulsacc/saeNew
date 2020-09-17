<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "Mod_CartaFelicitacionAlumno.php";

//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$obj_CartaFelAlumno = new CartaFelAlumno($conn);
$funcion = $_POST['funcion'];


	if($funcion == 1){
			
		   $rdb=$_POST['rdb'];	
		  $result = $obj_CartaFelAlumno->carga_anos($rdb);
		  if($result){
		$select = "<select name='select_anos' id='select_anos' onchange='carga_curso(this.value)'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_ano']."'>".$fila['nro_ano']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	if($funcion == 2){
			
		 $id_ano=$_POST['id_ano'];	
		 $result = $obj_CartaFelAlumno->carga_cursos($id_ano,$perfil,$curso,$usuario,$rdb);
		  if($result){
		$select = "<select name='select_cursos' id='select_cursos' onchange='carga_ramos(this.value)'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
			$select .= "<option value='".$fila['id_curso']."' >".$Curso_pal."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	if($funcion==carga_ramos){
			$id_curso=$_POST['id_curso'];
		  $result = $obj_CartaFelAlumno->carga_ramos($id_curso);
		  if($result){
			    $table = '<table width="100%" border="1"  align="left" style="border-collapse:collapse;">
              <tr class="color_fondo">
			  <th width="%" >Ramo</th>
			  <th width="%" >Seleccionar</th>
			</tr>
			<tbody>';
			for($e=0;$e<pg_numrows($result);$e++){
				$fila = pg_fetch_array($result,$e);
				if($fila['cod_subsector']==13){
				echo $txt_rel="<input type='hidden' id='txt_religion' name='txt_religion'  value=".$fila['id_ramo'].">";
				continue;	
				}
				
	$table .= ' <tr align="left" style="font-size:11px;" >
	<td width="%">'.$fila['nombre'].'&nbsp;</td>
	<td width="%">'.$modifica ="<input type='checkbox' id='chk_ramos".$e."' name='chk_ramos".$e."'  value=".$fila['id_ramo']." onclick='dime_valor(this.value)' >".'&nbsp;    </td>
				</tr>'; 
			}// fin for
			$table .= "<tbody></table>";
			echo $table;
				}else{ 
				   echo 0;
		}	
	}
	
	
	
	if($funcion==CargaTabla){
			$id_prof=$_POST['id_prof'];
		  $result = $obj_Entrevista_Prof->Carga_Entrevista_Profesionales($id_prof);
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
	<td>'.$modifica ="<input type='button' id='btn_modifica' name='btn_modifica' value='M' onclick='ModificaArchivo(".$fila['id_entrevista'].")'>".'&nbsp;</td>
	<td>'.$elimina ="<input type='button' id='btn_elimina' name='btn_elimina' value='E' onclick='EliminaArchivo(".$fila['id_entrevista'].','.$fila['id_prof'].")'>".'&nbsp;</td>
	<td>'.$descargar ="<input type='button' id='btn_descarga' name='btn_descarga' value='D' onclick='DescargaArchivo(".$fila['id_entrevista'].")'>".'&nbsp;</td>
	
				</tr>';
			}// fin for
			$table .= "<tbody></table>";
			echo $table;
				}else{ 
				   echo 0;
		}	
	}
	
	
	
	/*if($funcion == 2){
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
 }*/
 

?>