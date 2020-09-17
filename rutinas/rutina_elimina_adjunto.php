<? $conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

echo $sql ="SELECT a.id_archivo, ar.nombre_archivo
FROM ano_escolar ae INNER JOIN curso c ON ae.id_ano=c.id_ano
INNER JOIN ramo r ON r.id_curso=c.id_curso
INNER JOIN adjunta a ON r.id_ramo=a.id_ramo
INNER JOIN archivo ar ON a.id_archivo=ar.id_archivo
WHERE ae.id_institucion=12838 and nro_ano=2005 ";
$result = pg_Exec($conn,$sql);
echo "<br>cantidad registros".$cantidad=pg_numrows($result);

for($i=0;$i<=$cantidad;$i++){
	$fila = pg_fetch_array($result,$i);
	echo "<br>".$nombre = trim($fila['nombre_archivo']);
	
	echo "<br>".$ruta= "tmp/".$nombre;
	
	chmod ($nombre,0777);
	echo "<br>permisos-->".$permisos=fileperms($ruta);
	/******************/
	
	/*if (($permisos & 0xC000) == 0xC000) {
    // Socket
    $info = 's';
} elseif (($permisos & 0xA000) == 0xA000) {
    // Enlace Simbólico
    $info = 'l';
} elseif (($permisos & 0x8000) == 0x8000) {
    // Regular
    $info = '-';
} elseif (($permisos & 0x6000) == 0x6000) {
    // Especial Bloque
    $info = 'b';
} elseif (($permisos & 0x4000) == 0x4000) {
    // Directorio
    $info = 'd';
} elseif (($permisos & 0x2000) == 0x2000) {
    // Especial Carácter
    $info = 'c';
} elseif (($permisos & 0x1000) == 0x1000) {
    // Tubería FIFO
    $info = 'p';
} else {
    // Desconocido
    $info = 'u';
}

// Propietario
$info .= (($permisos & 0x0100) ? 'r' : '-');
$info .= (($permisos & 0x0080) ? 'w' : '-');
$info .= (($permisos & 0x0040) ?
            (($permisos & 0x0800) ? 's' : 'x' ) :
            (($permisos & 0x0800) ? 'S' : '-'));

// Grupo
$info .= (($permisos & 0x0020) ? 'r' : '-');
$info .= (($permisos & 0x0010) ? 'w' : '-');
$info .= (($permisos & 0x0008) ?
            (($permisos & 0x0400) ? 's' : 'x' ) :
            (($permisos & 0x0400) ? 'S' : '-'));

// Mundo
$info .= (($permisos & 0x0004) ? 'r' : '-');
$info .= (($permisos & 0x0002) ? 'w' : '-');
$info .= (($permisos & 0x0001) ?
            (($permisos & 0x0200) ? 't' : 'x' ) :
            (($permisos & 0x0200) ? 'T' : '-'));

echo "<br>".$info;*/
	///////////////**********************/

	if(!unlink($ruta)){
		echo "No de puede eliminar el archivo";	
	}else{	
		echo "archivo eliminado";
	echo "<br>".$qry="DELETE FROM ARCHIVO WHERE ID_ARCHIVO=".$fila['id_archivo'];
	$rs_delete =@pg_Exec($conn,$qry);
	}
	
	echo "<br>contador-->".$i;
	
}
 
echo "<br>FIN PROCESO";

?>
