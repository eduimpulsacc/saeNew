<?
class Categoria{
	public function construct(){
		
	}

	public function Agregar($conn,$nombre,$rdb){
		$sql="INSERT INTO biblio.categoria (nombre,rdb) VALUES('".strtoupper(utf8_decode($nombre))."',$rdb)";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function Listado($conn,$rdb){
		$sql="SELECT * FROM biblio.categoria where rdb=$rdb order by nombre";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function dcategoria($conn,$id){
		 $sql="SELECT * FROM biblio.categoria where id_categoria=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function upcategoria($conn,$id,$nombre){
		 $sql="update biblio.categoria set nombre='".utf8_decode($nombre)."' where id_categoria=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
}
?>