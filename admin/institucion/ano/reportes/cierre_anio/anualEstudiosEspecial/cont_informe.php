<?php session_start();

require "mod_informe.php";

//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$obj_ensayoSimce = new ensayoSimce($conn);
$funcion = $_POST['funcion'];

if($funcion == 1){
			
		   $rdb=$_POST['rdb'];	
		  $result = $obj_ensayoSimce->carga_anos($rdb);
		  if($result){
			  ?>
		<select name='select_anos' id='select_anos' onchange='carga_curso(this.value)'>
		<option value='0' select='select' >(Seleccionar)</option>
		<?
		
		
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			?>
			<option value="<?php echo $fila['id_ano'] ?>" <?php echo ($fila['id_ano']==$_ANO)?"selected":"" ?>><?php echo $fila['nro_ano'] ?></option>;
		 <?
         }  
		?>
		</select> 
		 <?
		 }else{
		 echo 0;			
		 }
	}

if($funcion == 2){
			
		 $id_ano=$_POST['anio'];	
		 $result = $obj_ensayoSimce->carga_cursos($id_ano);
		  if($result){
		?>
        <select name='select_cursos' id='select_cursos' onchange="carga_alumno(this.value)">
		<option value='0' select='select' >(Seleccionar)</option>
				<?
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn)?>
			<option value="<?php echo $fila['id_curso'] ?>" ><?php echo $Curso_pal ?></option>";
		
         <?php } ?>  
		 </select> 
		
		<? }else{
		 echo 0;			
		 }
	}
	if($funcion==3){
			//var_dump($_POST);
		 $id_curso=$_POST['id_curso'];	
		 $result = $obj_ensayoSimce->carga_alumno($id_curso);
		  if($result){
		?>
        <select name='cmb_alumno' id='cmb_alumno' >
		<option value='0'  >(TODOS LOS ALUMNOS)</option>
				<?
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			?>
			<option value="<?php echo $fila['rut_alumno'] ?>" ><?php echo $fila['nombre_alu'];?> <?php echo $fila['ape_pat'];?> <?php echo $fila['ape_mat'];?></option>";
		
         <?php } ?>  
		 </select> 
		
		<? }else{
		 echo 0;			
		 }
	}
	
	

?>
