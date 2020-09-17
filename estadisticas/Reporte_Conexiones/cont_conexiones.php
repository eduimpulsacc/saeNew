<?
include('../../util/header.php');
require("mod_conexiones.php");
 

$ob_conexion = new Conexion();
echo $funcion = $_POST['funcion'];

if($funcion==1){

	$rs_conexion = $ob_conexion->Anos($conn,$rdb);
	
?>

	<select name="cmbANO" id="cmbANO">
<?	for($i=0;$i<pg_numrows($rs_conexion);$i++){
		$fila=pg_fetch_array($rs_conexion,$i);
?>
	<option value="<?=$fila['id_ano'];?>"><?=$fila['nro_ano'];?></option>
<?	} ?>

	</select>
 <?
}


?>