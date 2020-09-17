<?

$db = pg_connect("dbname=coe user=postgres port=1550");
chmod($upload_file,"700");
$query = "update institucion set img_uniforme=lo_import('$upload_file') where rdb='$rut'";
$result = pg_exec($db, $query);
if (!$result) {printf ("ERROR"); } else 
{ 
   printf("<title>IMAGEN INSERTADO...</title>LA IMAGEN HA SIDO INGRESADA CON EXITO </p><input type=button value=ACEPTAR onClick=window.close()>"); }
pg_close($db);

?>

