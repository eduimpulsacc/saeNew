<script>
	function Refresca(){
		window.opener.location.reload();
		window.close();
	}
</script>
<?php 
	require('../../util/header.inc');
	$institucion	=$_INSTIT;



$db = pg_connect("dbname=coe user=postgres port=1550");
chmod($upload_file,"700");
$query = "update institucion set uniforme=lo_import('$upload_file') where rdb = ".$institucion."";
$result = pg_exec($db, $query);
if (!$result) {printf ("ERROR"); } else 
{ 
   printf("<title>UNIFORME INSERTADO...</title>EL UNIFORME HA SIDO INGRESADO CON EXITO </p><input type=button value=ACEPTAR onClick=Refresca()>"); }
pg_close($db);
?>