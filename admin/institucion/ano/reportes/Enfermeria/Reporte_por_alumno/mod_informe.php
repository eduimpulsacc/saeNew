<? 

class Alumno{
	public function BuscaAlumno($conn,$id_curso){
		$sql="SELECT a.rut_alumno, ape_pat||' '|| ape_mat ||' '|| nombre_alu AS nombre FROM alumno a INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno WHERE id_curso=".$id_curso;
		$rs_alumno =pg_exec($conn,$sql);
		
		return $rs_alumno;
		
	}
}

?>