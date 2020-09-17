<? $conn=@pg_connect("dbname=coe_traspaso host=200.2.201.33 port=1550 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

$sql  ="SELECT * FROM usuario ";
$rs_usuario =@pg_Exec($conn,$sql);

for($i=0;$i<@pg_numrows($rs_usuario);$i++){
	$fils = @pg_fetch_array($rs_usuario,$i);

	$sql = "UPDATE empleado SET id_usuario=".$fils['id_usuario']." WHERE rut_emp=".$fils['nombre_usuario'];
	$rs_empleado = @pg_exec($conn,$sql);

}


echo "FIN PROCESO DE EMPLEADO / USUARIO ";

?>