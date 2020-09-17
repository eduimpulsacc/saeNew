<?
class Editorial{
	public function construct(){
		
	}

	public function Agregar($conn,$nombre,$rdb){
		$sql="INSERT INTO biblio.editorial (nombre,rdb) VALUES('".strtoupper(utf8_decode($nombre))."',$rdb)";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function Listado($conn,$rdb){
		$sql="SELECT * FROM biblio.editorial where rdb=$rdb order by nombre";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function deditorial($conn,$id){
		 $sql="SELECT * FROM biblio.editorial where id_editorial=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function upeditorial($conn,$id,$nombre){
		 $sql="update biblio.editorial set nombre='".utf8_decode($nombre)."' where id_editorial=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	
}
?>