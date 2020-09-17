<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_alumnos_por_apoderado.php";

$obj_AlumnosApoderado = new  AlumnosApoderado($conn);
$funcion = $_POST['funcion'];
	
	
	if($funcion == 1){
			
		   $id_ano=$_POST['id_ano'];	
		  $result = $obj_AlumnosApoderado->carga_cursos($id_ano);
		  if($result){
		$select = "<select name='select_cursos' id='select_cursos'  onchange='carga_apo(this.value)'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$id_curso=$fila['id_curso'];
			$nombre_curso = CursoPalabra($id_curso,0,$conn);
			
			$select .= "<option value='".$id_curso."' >".trim($nombre_curso)."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	if($funcion == 2){
			
		   $id_curso=$_POST['id_curso'];	
		  $result = $obj_AlumnosApoderado->carga_apo($id_curso);
		  if($result){
		$select = "<select name='select_apo' id='select_apo'  onchange='carga_tabla_datos(this.value)'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$rut_apo=$fila['rut_apo'];
			$nombre_apo=$fila['nombre_apo'];
			
			$select .= "<option value='".$rut_apo."' >".trim($nombre_apo)."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	if($funcion==3)
	{
		$rut_apo=$_POST['rut_apo'];	
		$result=$obj_AlumnosApoderado->carga_datos($rut_apo);
		if($result)
		{
			for($i=0;$i<pg_numrows($result);$i++){	
			$fila = pg_fetch_array($result,$i);
			?>
            	<table width="90%" align="center" border="1" style="border-collapse:collapse">
                <tr>
                <td width="19%" class="cuadro02">Rut Apoderado</td>
                <td width="81%" class="cuadro01"><?=$fila['rut_apo']?></td>
                </tr>
                <tr>
                <td width="19%" class="cuadro02">Nombre Apoderado</td>
                <td width="81%" class="cuadro01"><?=$fila['nombre_apo']?></td>
                </tr>
                <tr>
                <td width="19%" class="cuadro02">Direcci&oacute;n</td>
                <td width="81%" class="cuadro01"><?=$fila['direccion_apo']?></td>
                </tr>
                 <tr>
                <td width="19%" class="cuadro02">Telefono</td>
                <td width="81%" class="cuadro01"><?=$fila['telefono']?></td>
                </tr>
                <tr>
                <td width="19%" class="cuadro02">Mail</td>
                <td width="81%" class="cuadro01"><?=$fila['email']?></td>
                </tr>              
                </table>
            <?
			}
		}
	}
	
	
		if($funcion==4)
	{
		$rut_apo=$_POST['rut_apo'];	
		$id_ano=$_POST['id_ano'];
		$result=$obj_AlumnosApoderado->carga_datos_alumnos($rut_apo,$id_ano);
		if($result)
		{
			?>
            <table width="90%" align="center" border="1" style="border-collapse:collapse">
                <tr>
                <td width="14%" class="cuadro02">Rut Alumno</td>
                <td width="33%" class="cuadro02">Nombre</td>
                <td width="53%" class="cuadro02">Curso</td>
                </tr> 
            <?
			for($i=0;$i<pg_numrows($result);$i++){	
			$fila = pg_fetch_array($result,$i);
			$id_curso = $fila['id_curso'];
			$nombre_curso = CursoPalabra($id_curso,0,$conn);
			?>
            	
                 <tr>
                <td width="14%" class="cuadro01"><?=$fila['rut_alumno']?></td>
                <td width="33%" class="cuadro01"><?=$fila['nombre_alumno']?></td>
                 <td width="53%" class="cuadro01"><?=$nombre_curso;?></td>
                </tr>                     
                
            <?
			}
			?>
            </table>
            <?
		}
	}
	
	
	
	
	
