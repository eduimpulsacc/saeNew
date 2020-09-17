<?php  

class Asig{
	
	public function contructor(){
			
	}

public function subs($conn,$ano,$doc){
	 $sql="select DISTINCT(s.cod_subsector),s.nombre
from subsector s
inner join ramo r on s.cod_subsector = r.cod_subsector
inner join dicta d on d.id_ramo = r.id_ramo
inner join curso c on c.id_curso = r.id_curso
where c.id_ano=$ano and d.rut_emp = $doc
order by s.cod_subsector  ";
$result = pg_exec($conn,$sql);
return $result;
	
}
	
}?>