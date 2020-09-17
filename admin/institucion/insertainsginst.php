<script>
	function Refresca(){
		window.opener.location.reload();
		window.close();
	}
</script>
<?php 


//chmod("../../tmp/","777");

	require('../../util/header.inc');
	$institucion	=$_INSTIT;
	//imprime_array($HTTP_POST_FILES);
$file = $upload_file;
$newfile = "../../tmp/".trim($institucion)."insignia";
$newfile2 = "../../tmp/".trim($institucion);
if(is_file($newfile)){
unlink($newfile);
}
//exit;
$error="";
//chmod($newfile,"777");

if (!copy($file, $newfile)) {
	$error="No se puede subir la insignia";

}
copy($file, $newfile2);


//echo $query = "update institucion set insignia=lo_import('/var/www/html') where rdb=".$institucion."";

//echo $query = "update institucion set insignia=lo_import('/tmp/tmp2/') where rdb=".$institucion."";
/*echo $query = "update institucion set insignia=lo_import('$newfile') where rdb=".$institucion."";
$result = pg_exec($conn, $query);*/
if ($error) {
	printf ("ERROR"); 
}
else{ 
   printf("<title>INSIGNIA INSERTADA...</title>LA INSIGNIA HA SIDO INGRESADO CON EXITO </p><input type=button value=ACEPTAR onClick=Refresca()>");
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