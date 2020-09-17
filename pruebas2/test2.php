<?
	$conn =  pg_connect("dbname=coi_final host=10.132.10.36 user=postgres password=cole#newaccess port=5432 ") or die('connection failed');
	
	$sql = "select nombre_alu from alumno where rut_alumno = '".$valor."'";
	$res = pg_Exec($conn, $sql);
	
	if (@pg_numrows($res)>0){
	     $fila = @pg_fetch_array($res);
		 $nombre = trim($fila['nombre_alu']); 
		 echo $nombre;
	}else{
		 echo "&nbsp;";
	}	

?>
