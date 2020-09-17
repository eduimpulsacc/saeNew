<?		
	
	
class conectar{
	
	public function coi_usuario(){
 // Primero abrimos CONEXION en coi_usuario	
	 $connection=pg_connect("dbname=coi_usuario host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_Usuario ");
	 return $connection;
	}

	public function soporte(){
	  $conn=pg_connect("dbname=soporte host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final");	
	  return $conn;
	}


}
?>


