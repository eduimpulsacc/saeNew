<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "Mod_ReportePromediosInsuficientes_curso.php";

//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$obj_CPromediosInsuficientesCurso = new PromediosInsuficientesCurso($conn);
$funcion = $_POST['funcion'];
	
	
	if($funcion == 0){
			
		   $id_ano=$_POST['id_ano'];	
		  $result = $obj_CPromediosInsuficientesCurso->carga_periodos($id_ano);
		  if($result){
		$select = "<select name='select_periodos' id='select_periodos' onchange='carga_nivel($id_ano)'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_periodo']."'>".$fila['nombre_periodo']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	
	if($funcion == 1){
			
		   $id_ano=$_POST['id_ano'];	
		  $result = $obj_CPromediosInsuficientesCurso->carga_nivel($id_ano);
		  if($result){
		$select = "<select name='select_niveles' id='select_niveles' onchange='carga_curso(this.value)'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_nivel']."'>".$fila['nombre']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	
	
	if($funcion == 2){
			
		   $id_ano=$_POST['id_ano'];	
		   $id_nivel=$_POST['id_nivel'];
		  $result = $obj_CPromediosInsuficientesCurso->carga_cursos($id_ano,$id_nivel);
		  if($result){
		$select = "<select name='select_cursos' id='select_cursos' onchange='carga_asignatura(this.value)'>
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
	
	
	if($funcion == 3){
			
		   $id_curso=$_POST['id_curso'];	
		  $result = $obj_CPromediosInsuficientesCurso->carga_asignatura($id_curso);
		  if($result){
		$select = "<select name='select_asignatura' id='select_asignatura'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_ramo']."'>".$fila['nombre']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	
	
	if($funcion == 4){
			
		   $id_nivel=$_POST['id_nivel'];	
		   $id_ano=$_POST['id_ano'];
		  $result = $obj_CPromediosInsuficientesCurso->carga_ramos_nivel($id_nivel,$id_ano);
		  if($result){
		$select = "<select name='select_ramos_niveles' id='select_ramos_niveles'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['cod_subsector']."'>".$fila['nombre']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	
	
	

	/*if($funcion == 1){
			
		   $rdb=$_POST['rdb'];	
		  $result = $obj_CPromediosInsuficientesCurso->carga_anos($rdb);
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
		  $result = $obj_CPromediosInsuficientesCurso->carga_cursos($id_ano);
		  if($result){
		$select = "<select name='select_cursos' id='select_cursos' onchange='carga_alumnos(this.value)'>
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
	
	
	
		if($funcion == carga_alumnos){
			$id_curso=$_POST['id_curso'];
			 $id_ano=$_POST['id_ano'];
		  $result = $obj_CPromediosInsuficientesCurso->carga_alumnos($id_curso,$id_ano);
		  
		  
		  if($result){
		$select = "<select name='select_alumno' id='select_alumno'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			
			$select .= "<option value='".$fila['rut_alumno']."' >".$fila['nombre_alumno']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}*/
	
	
	
	
	
	
?>