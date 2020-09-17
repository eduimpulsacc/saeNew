<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_ficha_academica_curso.php";

$objMembrete= new Membrete($_IPDB,$_ID_BASE);
$Obj_FichaAcademica_curso = new FichaAcademica_curso($_IPDB,$_ID_BASE);
$funcion = $_POST['funcion'];




	if($funcion == 1){
		$id_ano = $_POST['id_ano'];
		  $result = $Obj_FichaAcademica_curso->carga_configuracion($id_ano);
		  if($result){
		$select = "<label> Seleccione Configuracion :&nbsp;&nbsp;<select name='cmb_conf' id='cmb_conf' onchange='cargarselect(this.value,2)'>
		<option value='0' select='select'  >(Selecccionar Configuracion)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value=".$fila['id_nivel'].",".$fila['id_conf'].">".ucwords(strtolower(htmlentities(trim($fila['nombre_conf']))))."</option>";
		 }  // for 2 
				
		 $select .= "</select></label>"; 
		echo $select;
		 }else{
		 echo 0;			
		 }
	 }
	 
	 
	 if($funcion == 2){
		$id_nivel = $_POST['id_nivel'];
		
		  $result = $Obj_FichaAcademica_curso->carga_curso($id_nivel,$ano);
		  if($result){
		$select = "<label>Seleccione Curso :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name='selectCurso' id='selectCurso' onchange='cargarselect(this.value,3)'>
		<option value='0' select='select'  >(Selecccionar Curso)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			
		$Curso_pal = $objMembrete->CursoPalabra($fila['id_curso'],1);
	      $select  .=  "<option value=".$fila['id_curso'].">".ucwords(strtolower(htmlentities(trim($Curso_pal))))."</option>";
		 }  // for 2 
		 $select .= "</select></label>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	
	 if($funcion == 3){
		$id_curso = $_POST['id_curso'];
		$ano = $_POST['ano'];
		  $result = $Obj_FichaAcademica_curso->carga_ramo($id_curso,$ano);
		  if($result){
		$select = "<label>Seleccione Asignatura:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name='selectRamo' id='selectRamo' onchange='cargaTabla(this.value)'>
		<option value='0' select='select'  >(Selecccionar Asignatura)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value=".$fila['id_ramo'].",".$fila['nota_inicial'].",".$fila['nota_final'].",".$fila['id_periodo'].",".$fila['promedio'].">".ucwords(strtolower(htmlentities(trim($fila['nombre']))))."</option>";
		 }  // for 2 
		 $select .= "</select></label>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	
	if($funcion == 4){
		$ano_academ = $_POST['ano_academ'];
		  $result = $Obj_FichaAcademica_curso->carga_ano_acad($ano_academ);
		  if($result){
		$select = "<label>A&ntilde;o Academico:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,0);
			$fila['nro_ano'];
		 }  // for 2 
		 $select .= $fila['nro_ano']."</label>";
		 $nro_ano= $fila['nro_ano'];
		 echo $select.'<input type="hidden" id="nro_ano" value='.$nro_ano.'>';
		 }else{
		 echo 0;			
		 }
	}


		if($funcion==5){
			
			$rdb=$_POST['rdb'];
			$id_ramo=$_POST['id_ramo'];
			$nota_inicial=$_POST['nota_inicial'];
			$nota_final=$_POST['nota_final'];
			$nro_ano=$_POST['nro_ano'];
			$id_periodo=$_POST['id_periodo'];
			$promedio_final=$_POST['promedio'];
			
			
			for($i=$nota_inicial;$i<=$nota_final;$i++){
				
				$variable=$variable."nt.nota".$i.",";
			    $suma=$suma."cast(nt.nota".$i." as integer)+";
			 
			 }
			 
			 $j=$i-1;
			$promedioOK=substr ($suma, 0, -1);
		    $promedio="(".$promedioOK.")"."/".$j;
			$notas = substr ($variable, 0, -1);
			
		  $result = $Obj_FichaAcademica_curso->tabla_ficha_acad_curso($rdb,$id_ramo,$notas,$promedio,$nro_ano,$id_periodo,$promedio_final);
		  if($result){
			  ?>
			  <table width="100%" border="1">
              <tr class="color_fondo">
			  <th width="%">Rut Alumno</th>
			  <th width="%">Nombre</th>
			  <th width="%">Notas</th>
			  <th width="%">Nivel Interno</th>
			  <th width="%">Nota Ext.</th>
			   <th width="%" >Promedio</th>
			  <th width="%" >Nivel Final</th>
			  <th width="%" >Diferencia</th>
			  <th width="%" >Observaciones</th>
			</tr>
			<?
			for($e=0;$e<pg_numrows($result);$e++){
			  
				$fila = pg_fetch_array($result,$e);
			    $nivel=$fila['nivel'];	
				if($nivel==1){
				$nivel="Nivel Inicial";	
				 }else if($nivel==2){
					 $nivel="Nivel Intermedio";
				}else{
					$nivel="Nivel Avanzado";
				}
				?>
	<tr align="center" >
	<td> <input type="text" disabled="disabled" id="rut_alu<?=$e?>" value="<?=$fila['rut'];?>" size="10">
    <input type="hidden" id="notaminima1" size="2" maxlength="2" value="<?=$fila['nota_minima'];?>">
    <input type="hidden" id="notamaxima1" size="2" maxlength="2" value="<?=$fila['nota_maxima'];?>">
    <input type="hidden" id="notaminima2" size="2" maxlength="2" value="<?=$fila['nota_minima2'];?>">
    <input type="hidden" id="notamaxima2" size="2" maxlength="2" value="<?=$fila['nota_maxima2'];?>">
    <input type="hidden" id="notaminima3" size="2" maxlength="2" value="<?=$fila['nota_minima3'];?>">
    <input type="hidden" id="notamaxima3" size="2" maxlength="2" value="<?=$fila['nota_maxima3'];?>">
    </td>
	<td><?=$fila['nombre'];?></td>
	<td><input type="text" align="center" id="promedio<?=$e;?>" size="2" maxlength="2" value="<?=$fila['prom'];?>" disabled="disabled" ></td>
	<td><?=$fila['concepto'];?><input type="hidden" id="id_nivel<?=$e?>" size="2" maxlength="2" value="<?=$fila['id']?>"></td>
	<td><input type="text" id="notaex<?=$e;?>" size="2" maxlength="2" onkeyup="enviar(<?=$e?>)"></td>
	<td><input type="text" id="promediotot<?=$e;?>" size="2" maxlength="2" disabled="disabled"></td>
	<td><input type="text" id="nivel_logroExt<?=$e;?>" size="5" maxlength="20" disabled="disabled"></td>
	<td><input type="text" id="diferencia<?=$e;?>" size="2" maxlength="2" disabled="disabled">
    <input type="hidden" id="idnivelext<?=$e;?>" size="2" maxlength="2">
    </td>
	<td><textarea id="observacion<?=$e;?>" cols="25" rows="2" disabled="disabled" ></textarea></td>
	
				</tr>
			<? }?> 
			</table>
            <input type='button' id='guardar' value='Guardar' onclick='guardarficha(<?=$e;?>)'>
			<?	   
		}	
	} 
	
	if($funcion==6){
		$prom = $_POST['promedio'];	
		
		echo $promedio = $Obj_FichaAcademica_curso->Logro($prom,$_INSTIT);
	}
	
	?>
	
	