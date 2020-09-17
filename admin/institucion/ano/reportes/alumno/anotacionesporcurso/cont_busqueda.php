<?php require('../../../../../../util/header.inc');

$funcion=$_POST['funcion'];
if($funcion==1){
	//show($_POST);

$sql_curso= "SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ";
		$sql_curso.= "curso.ensenanza, curso.cod_decreto ";
		$sql_curso.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql_curso.= "WHERE curso.id_ano=".$ano." ";
		
		
		 $sql_curso.= " ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
		 //echo $sql_curso;
		$resultado_curso = pg_exec($conn,$sql_curso) or die ("Select falló: " .$sql_curso);
		
	
	?>
	<select name="cmb_curso"  class="ddlb_9_x" >
	    <option value=0 selected>(Seleccione Curso)</option>
	    <?
		  for($i=0 ; $i < @pg_numrows($resultado_curso) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_curso,$i); 
		 
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		 
          } ?>
	    </select>
        <?
}
?>