<? 

class Motor{
	public function contruct(){
		
	}
	public function Curso($conn,$ano){
		$sql="SELECT id_curso FROM curso WHERE id_ano=".$ano." ORDER BY ensenanza,grado_curso,letra_curso ASC";
		$result =pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function Docente($conn,$ano,$curso,$perfil,$rut){
		if($perfil==17){
			$sql="SELECT e.rut_emp, nombre_emp ||' '|| ape_pat ||' '|| ape_mat as nombres FROM empleado e WHERE e.rut_emp=".$rut;	
		}else{
			$sql="SELECT DISTINCT e.rut_emp, nombre_emp ||' '|| ape_pat ||' '|| ape_mat as nombres FROM empleado e INNER JOIN dicta d ON e.rut_emp=d.rut_emp INNER JOIN ramo r ON r.id_ramo=d.id_ramo WHERE id_curso in(SELECT id_curso FROM curso WHERE id_ano=".$ano." ";
			if($curso!=0){
				$sql.="AND id_curso=".$curso." ";
			}
			$sql.=") ORDER BY 2";
		}
		$result =pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function Periodo($conn,$ano){
		$sql="SELECT * FROM periodo WHERE id_ano=".$ano." ORDER BY fecha_inicio";
		$result =pg_exec($conn,$sql);
		
		return $result;
	}
	
}

?>