<?
$db = pg_connect("dbname=coe user=postgres port=1550");
chmod($upload_file,"700");
$query = "update institucion set mapa=lo_import('$upload_file') where rdb='$rut'";
$result = pg_exec($db, $query);
if (!$result) {printf ("ERROR"); } else 
{ 
   printf("<title>MAPA INSERTADO...</title>EL MAPA HA SIDO INGRESADO CON EXITO </p><input type=button value=ACEPTAR onClick=window.close()>"); }
pg_close($db);
?>