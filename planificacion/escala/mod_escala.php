<? 

class Escala{
	
	public function construct(){
		
	}
	
	public function Listado($conn,$ano){
		$sql="SELECT * FROM planificacion.escala WHERE id_ano=".$ano." ORDER BY termino DESC";	
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function GuardarEscala($conn,$ano,$nombre,$minimo,$maximo){
		$sql="INSERT INTO planificacion.escala (id_ano,nombre,inicio,termino) VALUES(".$ano.",'".utf8_decode($nombre)."',".$minimo.", ".$maximo.")";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function EliminaEscala($conn,$escala){
		echo $sql="DELETE FROM planificacion.escala WHERE id_escala=".$escala;
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function BuscaEscala($conn,$escala){
		$sql="SELECT * FROM planificacion.escala WHERE id_escala=".$escala;
		$result = pg_exec($conn,$sql);
		
		return $result;		
	}
	
	public function ModifcaEscala($conn,$escala,$ano,$nombre,$minimo,$maximo){
		$sql="UPDATE planificacion.escala SET nombre='".utf8_decode($nombre)."', inicio=".$minimo.", termino=".$maximo." WHERE id_escala=".$escala;
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
}


?>