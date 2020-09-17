<script>
	function Refresca(){
		window.opener.location.reload();
		window.close();
	}
</script>
<?php 
	require('../../util/header.inc');
	$institucion	=$_INSTIT;
	//imprime_array($HTTP_POST_FILES);
$file = $upload_file;
$newfile = "../../tmp/".trim($institucion)."mapa";

$error="";
if (!copy($file, $newfile)) {
	$error="No se puede subir el mapa";

}
//chmod($newfile,"777");

//echo $query = "update institucion set insignia=lo_import('/var/www/html') where rdb=".$institucion."";

//echo $query = "update institucion set insignia=lo_import('/tmp/tmp2/') where rdb=".$institucion."";
/*echo $query = "update institucion set insignia=lo_import('$newfile') where rdb=".$institucion."";
$result = pg_exec($conn, $query);*/
if ($error) {
	printf ("ERROR"); 
}
else{ 
   printf("<title>MAPA  INSERTADO...</title>EL MAPA HA SIDO INGRESADO CON EXITO </p><input type=button value=ACEPTAR onClick=Refresca()>");
}
?>
<? /*<script>
	function Refresca(){
		window.opener.location.reload();
		window.close();
	}
</script>
<?php 
	require('../../util/header.inc');
	$institucion	=$_INSTIT;

chmod($upload_file,"700");
$query = "update institucion set insignia=lo_import('$upload_file') where rdb=".$institucion."";
$result = pg_exec($conn, $query);
if (!$result) {
	printf ("ERROR"); 
}
else{ 
   printf("<title>INSIGNIA INSERTADA...</title>LA INSIGNIA HA SIDO INGRESADO CON EXITO </p><input type=button value=ACEPTAR onClick=Refresca()>");
}*/
?>