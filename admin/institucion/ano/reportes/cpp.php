<?php 
echo "PHP para conectarse a POSTGRES <br>";

// conexion a la base de datos
//$dbconn = pg_connect("host=192.168.100.231 port=5432 dbname=coi_final user=postgres password=cole#newaccess")

$conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
de conexion Coi_final");	

//consulta sencilla
$query = "select nombre_alu from alumno where rut_alumno < 10";
echo $query;
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

$rows = pg_numrows($result);
echo "<h1>cantidad de rows $rows </h1>";

echo "<table border =1>";
echo "<tr>NOMBRE</tr>";

//mostrar los datos
for($i=0;$i<=$rows; $i++){
$line = pg_fetch_array($result, null, PGSQL_ASSOC);
echo "\t<tr>\n";
echo "\t\t<td>$line[id]</td>\n";
echo "\t</tr>\n";
}
echo "</table>\n";
echo "<hr>";
// Free resultset
pg_free_result($result);
// Closing connection
pg_close($dbconn);
?>



</body>
</html>
