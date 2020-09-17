<?php 
		?>
		  <td width="163" valign="top">
		<?

	  /****************CURSOS************************************************/ 
//		$qry="select nombre_alu from alumno where rut_alumno < 10"; 
		//echo $qry;
//		$result =@pg_Exec($conn,$qry);
//		for($i=0 ; $i < @pg_numrows($result) ; $i++){
//		$fila = @pg_fetch_array($result,$i);
$conn = pg_connect("host=192.168.100.231 port=5432 dbname=coi_final user=postgres password=cole#newaccess");
$SQL="select nombre_alu from alumno where rut_alumno < 10";
$result = pg_query ($conn, $SQL ) or die("Error en la consulta SQL");
$registros= pg_num_rows($result);

for ($i=0;$i<$registros;$i++)
{
$row = pg_fetch_array ( $result,$i );
?>
Dato Numero <? echo $i ?>: <? echo $row["categoria"]; ?> <br>
<?
}

				
	 	
		/*******************FIN CURSOS***********************************/
						?></td>
  
</body>
</html>
