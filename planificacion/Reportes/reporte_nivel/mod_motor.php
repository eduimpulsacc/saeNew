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
	
	public function Ramo($conn,$ano,$curso){
		$sql="SELECT s.cod_subsector,nombre,id_ramo FROM ramo r INNER JOIN subsector s ON r.cod_subsector=s.cod_subsector WHERE id_curso=".$curso." ORDER BY id_orden ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	
	public function RamoUno($conn,$curso,$codramo){
		$sql="SELECT s.cod_subsector,nombre,id_ramo FROM ramo r INNER JOIN subsector s ON r.cod_subsector=s.cod_subsector WHERE id_curso=".$curso." and r.cod_subsector=$codramo ORDER BY id_orden ASC";
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
	
	public function Grados($conn,$ano){
		 $sql="select DISTINCT(c.ensenanza),c.grado_curso,e.nombre_tipo
from curso c
INNER JOIN tipo_ensenanza e on e.cod_tipo = c.ensenanza
where id_ano =$ano order by c.ensenanza,c.grado_curso";
		$result = pg_exec($conn,$sql);
return $result;	
	}
	
	public function cursoGrado($conn,$ano,$grado,$ensenanza){
	 $sql="select * from curso where
id_ano = $ano and ensenanza=$ensenanza
and grado_curso = $grado order by grado_curso,letra_curso";	
$result = pg_exec($conn,$sql);
return $result;	
	}
	
	
public function ramoGrado($conn,$ano,$ensenanza,$grado){
	 $sql="select DISTINCT(s.cod_subsector) as cod_subsector ,s.nombre from subsector s
inner join ramo r on r.cod_subsector = s.cod_subsector
inner join curso c on c.id_curso= r.id_curso
where
c.id_ano = $ano and c.ensenanza=$ensenanza
and c.grado_curso = $grado
order by s.cod_subsector";
$result = pg_exec($conn,$sql);
return $result;
	}
	
	
	public function Dicta($conn,$ramo){
		$sql="SELECT rut_emp FROM dicta where id_ramo=$ramo";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
}

?>