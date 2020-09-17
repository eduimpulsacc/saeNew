<?
require('../../../../../../util/header.inc');
require("mod_informe.php");

$funcion = $_POST['funcion'];

$ob_alumno = new Alumno();

if($funcion==1){
	$rs_alumno =$ob_alumno->BuscaAlumno($conn,$id_curso);
?>
	<select name="cmbALUMNO" id="cmbALUMNO">
    	<option value="0">seleccione...</option>
<?		for($i=0;$i<pg_numrows($rs_alumno);$i++){
			$fila = pg_fetch_array($rs_alumno,$i);
?>
		<option value="<?=$fila['rut_alumno'].",".$fila['nombre'];?>"><?=$fila['nombre'];?></option>
<?        
		}
?>
	</select>
<?		
}
?>