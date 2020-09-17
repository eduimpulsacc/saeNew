<?
class Idioma{
	public function construct(){
		
	}

	public function Agregar($conn,$nombre,$rdb){
		$sql="INSERT INTO biblio.idioma (nombre,rdb) VALUES('".utf8_decode(strtoupper($nombre))."',$rdb)";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function Listado($conn,$rdb){
		$sql="SELECT * FROM biblio.idioma where rdb=$rdb";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	
	public function didioma($conn,$id){
		 $sql="SELECT * FROM biblio.idioma where id_idioma=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function upidioma($conn,$id,$nombre){
		 $sql="update biblio.idioma set nombre='".utf8_decode($nombre)."' where id_idioma=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
}
?>