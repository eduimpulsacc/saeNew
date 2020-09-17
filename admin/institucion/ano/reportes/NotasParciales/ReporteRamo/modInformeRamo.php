<? 
session_start();

class InfRamo{
	
	public function periodo($conn,$ano){
		 $sql="select * from periodo where id_ano=$ano order by fecha_inicio asc";
		$result = pg_exec($conn,$sql) or die("ERROR");
		
		return $result;
	}
	
	public function ensenanza($conn,$ano){
	 $sql=" select * from tipo_ensenanza where cod_tipo in(select distinct(ensenanza) from curso where id_ano =$ano) and cod_tipo>109 order  by cod_tipo ";
	$result = pg_exec($conn,$sql) or die("ERROR");
		
		return $result;
	
	}
	
	
	public function escala($conn,$ano,$rdb){
	$sql = "SELECT id,nombre_concepto,valor_numerico,rango_x,rango_y 
		  	FROM  public.modulo_conceptos WHERE id_ano=$ano AND id_rdb=$rdb ORDER BY id;";
		$result = pg_exec($conn,$sql) or die("ERROR");
		
		return $result;
	}
	
	public function subsector($conn,$ano){
		$sql = "select distinct(r.cod_subsector), s.nombre 
from ramo r
inner join subsector s on s.cod_subsector = r.cod_subsector  
inner join curso c on c.id_curso = r.id_curso
where c.id_ano = $ano
order by r.cod_subsector";
		$result = pg_exec($conn,$sql) or die("ERROR");
		
		return $result;
	
	}
	
}//fin clase
?>