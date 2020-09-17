<?
$db = pg_connect("dbname=coe user=postgres port=1550");
chmod($upload_file,"700");
$query = "update noticia set foto=lo_import('$upload_file') , agrupacion=1 where rdb='".$rut."'";
$result = pg_exec($db, $query);
if (!$result) {printf ("ERROR"); } else 
{ 
   printf("<title>IMAGEN INSERTADA...</title>LA IMAGEN HA SIDO INSERTADA CON EXITO </p><input type=button value=ACEPTAR onClick=window.close()>"); }
pg_close($db);
?>