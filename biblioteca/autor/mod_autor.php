<?
class Autor{
	public function construct(){
		
	}

	public function Agregar($conn,$nombre,$nacionalidad,$rdb){
		 $sql="INSERT INTO biblio.autor (nombre,nacionalidad,rdb,estado) VALUES('".strtoupper(utf8_decode($nombre))."','".strtoupper(utf8_decode($nacionalidad))."',$rdb,1)";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function Listado($conn,$rdb){
		$sql="SELECT * FROM biblio.autor where rdb=$rdb and estado =1 order by nombre";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function autor($conn,$id){
		$sql="SELECT * FROM biblio.autor where id_autor=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function upautor($conn,$id,$nombre,$nac){
		$sql="update biblio.autor set nombre='".utf8_decode($nombre)."', nacionalidad='".utf8_decode($nac)."' where id_autor=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function eliautor($conn,$id){
	$sql1="update biblio.ejemplares set estado=3 where id_libro IN(select id_libro from biblio.libro where autor=$id)";
	$sql2="update biblio.libro set estado=3 where autor=$id";
	$sql3="update biblio.autor set estado=0 where id_autor=$id";
	$result = pg_exec($conn,$sql1);
	$result = pg_exec($conn,$sql2);
	$result = pg_exec($conn,$sql3);
		
		return $result;	

	}
}
?>