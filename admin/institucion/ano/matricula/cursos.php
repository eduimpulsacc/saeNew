<?php  require('../../../../util/header.inc'); 

$ano=$_ANO;

//var_dump($_POST);

//cargar lista de alumnos
if($funcion==1){
	
	 $sql =" select matricula.rut_alumno,
  alumno.ape_pat, alumno.ape_mat, 
  alumno.nombre_alu from matricula, 
  alumno where 
  alumno.rut_alumno = matricula.rut_alumno
  and matricula.id_curso=$curso order by alumno.ape_pat, alumno.ape_mat,alumno.nombre_alu ";
$rs_curso = pg_exec($conn,$sql);

?>
<select name="alumno[]" id="alumno<?php echo $indice ?>">
<?
for($i=0;$i<pg_numrows($rs_curso);$i++){
	$fila=pg_fetch_array($rs_curso,$i);
	?>
<option value="<?php echo $fila['rut_alumno'] ?>"><?php echo $fila['ape_pat'] ?> <?php echo $fila['ape_mat'] ?>,<?php echo $fila['nombre_alu'] ?></option>
<?	
}
?>
</select>
<?
}


?>