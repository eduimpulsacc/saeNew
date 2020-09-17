<script>
	function Refresca(){
		window.opener.location.reload();
		window.close();
	}
</script>
<?php 
	require('../../../util/header.inc');
	$institucion	=$_INSTIT;
	
$file = $upload_file;
$ruta_file = $_FILES['upload_file']['tmp_name'];
$nombre_file = $institucion."_".$_FILES['upload_file']['name'];

$newfile = "archivos/".$nombre_file;


$error="";
if (!copy($file, $newfile)) {
	$error="No se puede subir el manual";
	
}else{
	$sql ="UPDATE institucion SET manual_convivencia='".$nombre_file."' WHERE rdb=".$institucion;
	$result = @pg_exec($conn,$sql);
	printf("<title>MANUAL DE CONVIVENCIA ALMACENADO...</title>EL MANUAL HA SIDO INGRESADO CON EXITO </p><input type=button value=ACEPTAR onClick=Refresca()>");
}


?>
