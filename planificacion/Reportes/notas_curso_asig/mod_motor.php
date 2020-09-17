<? 

class Motor{
	public function contruct(){
		
	}
	public function Curso($conn,$ano,$perfil,$rut){
		if($perfil==17){
			$sql="SELECT DISTINCT curso.id_curso,ensenanza,grado_curso,letra_curso  FROM dicta INNER JOIN ramo ON dicta.id_ramo=ramo.id_ramo INNER JOIN curso ON curso.id_curso=ramo.id_curso WHERE rut_emp=".$rut." AND id_ano=".$ano." ORDER BY ensenanza,grado_curso,letra_curso ASC";
		}else{
			$sql="SELECT id_curso FROM curso WHERE id_ano=".$ano." ORDER BY ensenanza,grado_curso,letra_curso ASC";
		}
		$result =pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function Unidad($conn,$ano,$curso,$ramo){
		$sql="SELECT * FROM planificacion.unidad WHERE id_ano=".$ano." AND id_curso=".$curso." AND id_ramo=".$ramo." ORDER BY fecha_inicio ASC";
		$result =pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function Ramo($conn,$ano,$curso,$perfil,$rut){
		if($perfil==17){
			$sql="SELECT s.cod_subsector,nombre,r.id_ramo FROM ramo r INNER JOIN subsector s ON r.cod_subsector=s.cod_subsector INNER JOIN dicta ON dicta.id_ramo=r.id_ramo WHERE id_curso=".$curso." AND rut_emp=".$rut." ORDER BY id_orden ASC";
		}else{
			$sql="SELECT s.cod_subsector,nombre,id_ramo FROM ramo r INNER JOIN subsector s ON r.cod_subsector=s.cod_subsector WHERE id_curso=".$curso." ORDER BY id_orden ASC";
		}
		$result = pg_exec($conn,$sql);
		
		
		return $result;	
	}
	
	public function Clase($conn,$ano,$curso,$unidad,$ramo){
		$sql="SELECT * FROM planificacion.clase WHERE id_curso=".$curso." AND id_ramo=".$ramo." and id_unidad=".$unidad." ORDER BY fecha_inicio ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function Periodo($conn,$ano){
		$sql="SELECT * FROM periodo WHERE id_ano=".$ano." ORDER BY fecha_inicio";
		$result =pg_exec($conn,$sql);
		
		return $result;
	}
	
	
}

?>