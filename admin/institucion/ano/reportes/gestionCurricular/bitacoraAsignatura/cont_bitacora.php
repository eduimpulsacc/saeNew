<?
require('../../../../../../util/header.inc');
require("mod_bitacora.php");

$funcion = $_POST['funcion'];

$ob_bitacora = new Bitacora();


if($funcion==1){
	//show($_POST);
	//exit;
	$rs_asig =$ob_bitacora->BuscaAsignatura($conn,$id_curso);
?>
	<select name="cmbAsignatura" id="cmbAsignatura">
    	<option value="0">(Seleccione Asignatura)</option>
<?		for($i=0;$i<pg_numrows($rs_asig);$i++){
			$fila = pg_fetch_array($rs_asig,$i);
?>
		<option value="<?=$fila['id_ramo']?>"><?=$fila['nombre'];?></option>
<?        
		}
?>
	</select>
<?		
}
?>