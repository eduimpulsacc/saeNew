<? $conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

$sql ="SELECT a.id_archivo, ar.nombre_archivo
FROM ano_escolar ae INNER JOIN curso c ON ae.id_ano=c.id_ano
INNER JOIN ramo r ON r.id_curso=c.id_curso
INNER JOIN adjunta a ON r.id_ramo=a.id_ramo
INNER JOIN archivo ar ON a.id_archivo=ar.id_archivo
WHERE ae.id_institucion=12838 and nro_ano=2010";
$result = pg_Exec($conn,$sql);

for($i=0;$i<pg_numrows($result);$i++){
	$fila = pg_fetch_array($result,$i);
	$nombre = trim($fila['nombre_archivo']);
	
	$ruta= 'tmp/'.$nombre;
	
	chmod ($ruta,0777);
	
	if(!unlink($ruta)){
		echo "No de puede eliminar el archivo";	
	}
	$qry="DELETE FROM ARCHIVO WHERE ID_ARCHIVO=".$_ARCHIVO;
	$result =@pg_Exec($conn,$qry);
	
	
}
 
echo "FIN PROCESO";

?>
