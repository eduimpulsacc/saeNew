<?

class Conexion{
	
	
	public function contructor(){
			
	}
	public function Anos($conn,$rdb){
		echo $sql="SELECT id_ano, nro_ano FROM ano_escolar WHERE id_institucion=".$rdb;
		$result = pg_exec($conn,$sql);	
		
		return $result;
	}
}