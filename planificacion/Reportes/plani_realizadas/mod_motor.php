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
	
}

?>