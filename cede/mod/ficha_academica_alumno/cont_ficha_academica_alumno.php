<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();



require "mod_ficha_academica_alumno.php";

$objMembrete= new Membrete($_IPDB,$_ID_BASE);
$Obj_FichaAcademica_alumno = new FichaAcademica_alumno($_IPDB,$_ID_BASE);
$funcion = $_POST['funcion'];



		if($funcion==1){
		$id_ano = $_POST['id_ano'];
		$rut_alumno=$_POST['rut_alumno'];
		$result = $Obj_FichaAcademica_alumno->carga_ficha_alumno($id_ano,$rut_alumno);	
			
			if($result){
			for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,0);
			$Curso_pal = $objMembrete->CursoPalabra($fila['id_curso'],1);	
		 }  // for 2 	
			?>	
        <table width="100%" border="0" align="left" cellpadding="3" cellspacing="0" style="margin-left:2%;">
        <tr>
        <td width="14%" >a&ntilde;o Academico:&nbsp;&nbsp;</td>
        <td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$fila['nro_ano'];?>
        <input type="hidden" id="nro_ano" value="<?=$fila['nro_ano'];?>">
        </td>
        <td width="13%">&nbsp; Rut Alumno: </td>
        <td width="43%"><input type="text" name="txt_rut" id="txt_rut" size="10" value="<?=$fila['rut_alumno'];?>"/>-<input type="text" name="txt_rut" id="txt_dig_rut" size="1" maxlength="1" value="<?=$fila['dig_rut'];?>"/></td>
        
        </tr>
        <br>
        <tr>
        <td width="14%" >Curso: </td>
        <td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$Curso_pal?><input type="hidden" id="id_curso" value="<?=$fila['id_curso']?>"></td>
        <td>Nombre Alumno:</td>
        <td><?=$fila['nombre_alu']?></td>
        </tr>
        <tr>
        <td width="14%">Configuraci&oacute;n:</td>
        <td width="30%">
        <select name='cmbCONF' id='cmbCONF' onchange='cargaSubsector(this.value)'>
		<option value='0' select='select'  >(Selecccionar Configuraci&oacute;n)</option>
		<?		
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			?>
		<option value="<?=$fila['id_ramo']?>,<?=$fila['id_conf']?>,<?=$fila['id_periodo']?>,<?=$fila['nota_inicial']?>,<?=$fila['nota_final']?>,<?=$fila['id_nivel']?>"><?=ucwords(strtolower(htmlentities(trim($fila['nombre_conf']))))?></option>
		<?
		 } ?>  
		 </select>
        
        </td>
        <td>Asignatura:</td>
        <td><div id="nombre_subsector">&nbsp;</div></td>
        </tr>
        </table>
            <? 
			}	
		}
	
	 	
	if($funcion == 2){
		$id_ramo = $_POST['id_ramo'];
		  $result = $Obj_FichaAcademica_alumno->carga_subsector($id_ramo);
		  if($result){
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,0);
			$cod_subsector=$fila['cod_subsector'];
		 }  
		 $cod_subsector ='<input type="hidden" id="cod_subsector" value="'.$cod_subsector.'">';
		 $subsector .= $fila['nombre']."</label>"; 
		 echo $subsector;
		 echo $cod_subsector;
		 }else{
		 //echo 0;			
		 }
	}
		
		
		if($funcion==4){
			$id_conf=$_POST['id_conf'];
			$id_periodo=$_POST['id_periodo'];
			$id_ramo=$_POST['id_ramo'];
			$rut_alumno=$_POST['rut_alumno'];
			$nota_inicial=$_POST['nota_inicial'];
			$nota_final=$_POST['nota_final'];
			$nro_ano=$_POST['nro_ano'];
			
			if($nota_final!=0){
				for($i=$nota_inicial;$i<=$nota_final;$i++){
					$variable=$variable."nt.nota".$i." || '-' || ";
				//$suma=$suma."cast(nt.nota".$i." as integer)+";
				 
				 }
				$cadena_notas = substr ($variable, 0, -10);
				$notas = $cadena_notas."as notas";
			}else{
				$notas = "nt.promedio as notas";	
			}
		  $result = $Obj_FichaAcademica_alumno->tabla_ficha_acad_alumno($id_conf,$id_periodo,$id_ramo,$rut_alumno,$notas,$nro_ano);
		  if($result){
			    $table = '<table width="100%" border="1" cellpadding="2" cellspacing="1">
              <tr class="color_fondo">
			  <th width="%">Notas</th>
			  <th width="%">Promedio Inicial</th>
			  <th width="%">Nivel Inicial</th>
			  <th width="%">Nota Externa</th>
			  <th width="%">Promedio Final</th>
			   <th width="%" >Nivel Final</th>
			  <th width="%" >Observaci&oacute;nes</th>
			 
			   
			  
			</tr>
			<tbody>';
			
			for($e=0;$e<@pg_numrows($result);$e++){
			  
				$fila = pg_fetch_array($result,$e);
				$nivel= $Obj_FichaAcademica_alumno->Niveles($fila['id_nivel_interno']);
				$nivel_externo=$Obj_FichaAcademica_alumno->Niveles($fila['id_nivel_externo']);
				
				/*if($nivel==1){
					$nivel="Nivel Inicial";
				}else if($nivel==2){
					$nivel="Nivel Intermedio";	
				}else if($nivel==3){
					$nivel="Nivel Avanzado";
				}
				
				if($nivel_externo==1){
					$nivel_externo="Nivel Inicial";
					}else if($nivel_externo==2){
					$nivel_externo="Nivel Intermedio";	
					 }else if($nivel_externo==3){
						 $nivel_externo="Nivel Avanzado";
						 }		 
					*/
	$table .= ' <tr  align="center" >
	
	<td>'.$fila['notas'].'&nbsp;</td>
	<td>'.$fila['prom_interno'].'&nbsp;</td>
	<td>'.$nivel.'&nbsp;</td>
	<td>'.$fila['notas_externas'].'&nbsp;</td>
	<td>'.$fila['promedio_final'].'&nbsp;</td>
	<td>'.$nivel_externo.'&nbsp;</td>
	<td>'.$fila['observaciones'].'&nbsp;</td>
	
		
				</tr>';
			}// fin for
			$table .= "<tbody></table>";
			echo $table;
				}else{ 
		    //echo 0;
		}	
	}
	
	if($funcion==5){
			$id_curso=$_POST['id_curso'];
			$cod_subsector=$_POST['cod_subsector'];
			$id_ano=$_POST['id_ano'];
			$id_nivel=$_POST['id_nivel'];
			
			
		  $result = $Obj_FichaAcademica_alumno->tabla_mapa_conceptual($id_curso,$cod_subsector,$id_ano,$id_nivel);
		  
		  for($e=0;$e<@pg_numrows($result);$e++){
			  
				$fila = pg_fetch_array($result,$e);
		  }
		  
		?>
        
    <div id="mapa_conceptual">
    <br>
    <div id="selectcurso">
    <label>Nombre Nivel:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?=$fila['nombre_nivel'];?>
    </label>
    </div>
    <br>  
    <div id="selectfuncion">
    <label>Nombre Funcion:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?=$fila['nombre_funcion']?>
    </label>
    </div><br>
    
    <div id="textConcepto" style="width:100%;">
    <label>Concepto:
    <textarea name="text_concepto" cols="100" rows="4" id="text_concepto" style="margin-left:60px"><?=$fila['concepto']?></textarea>
    </label>
    </div><br><br>
    
    <div id="textEjemplos">
    <label >Ejemplos:
     <textarea name="text_ejemplos" cols="100" rows="4" id="text_ejemplos" style="margin-left:60px"><?=$fila['ejemplos']?></textarea>
    </label>
    </div>	
    </div>
        <br><br>
        <?  
		  
		
			  
	}
	
	
	

		 ?>
	
	