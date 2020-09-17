<? $conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");


if ($sw!="1"){

    $sql = "SELECT * FROM notas2006 LIMIT 10";
    $rs_tiene = @pg_exec($conn,$sql);

    echo "hago la consulta... <br>";

}else{
     
	echo "hago el ciclo.... <br>";

    /*
	for($i=0; $i<pg_numrows($rs_tiene); $i++){
		$fila = pg_fetch_array($rs_tiene,$i);
	
		$sql = "INSERT INTO notas2006_new (rut_alumno, id_ramo, id_periodo, nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14, nota15, nota16,nota17,nota18,nota19,nota20,promedio) VALUES (".$fila['rut_alumno'].",".$fila['id_ramo'].",".$fila['id_periodo'].",'".$fila['nota1']."','".$fila['nota2']."','".$fila['nota3']."','".$fila['nota4']."','".$fila['nota5']."','".$fila['nota6']."','".$fila['nota7']."','".$fila['nota8']."','".$fila['nota9']."','".$fila['nota10']."','".$fila['nota11']."','".$fila['nota12']."','".$fila['nota13']."','".$fila['nota14']."','".$fila['nota15']."','".$fila['nota16']."','".$fila['nota17']."','".$fila['nota18']."','".$fila['nota19']."','".$fila['nota20']."','".$fila['promedio']."')";
		$result = pg_exec($conn,$sql);
		
	
	}
	*/
}	


?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilo1.css" rel="stylesheet" type="text/css">
</head>
<script language="javascript1.1">
function recarga(f){
    document.form.submit();
}
</script>
<body onLoad="recarga(this.form)">
<form name="form" method="post" action="">

<input name="sw" type="hidden" value="1">
</form>
</body>
</html>






