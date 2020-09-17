<? 

class Motor{
	public function contruct(){
		
	}
	public function Curso($conn,$ano){
		$sql="SELECT id_curso FROM curso WHERE id_ano=".$ano." ORDER BY ensenanza,grado_curso,letra_curso ASC";
		$result =pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function Unidad($conn,$ano,$curso,$ramo){
		$sql="SELECT * FROM planificacion.unidad WHERE id_ano=".$ano." AND id_curso=".$curso." AND id_ramo=".$ramo." ORDER BY fecha_inicio ASC";
		$result =pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function Periodo($conn,$ano,$curso){
		$sql="SELECT id_periodo, nombre_periodo FROM periodo WHERE id_ano=".$ano." ORDER BY id_periodo ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function Clase($conn,$ano,$curso,$unidad,$ramo){
		$sql="SELECT * FROM planificacion.clase WHERE id_curso=".$curso." AND id_ramo=".$ramo." and id_unidad=".$unidad." ORDER BY fecha_inicio ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	
	
	
}

?>