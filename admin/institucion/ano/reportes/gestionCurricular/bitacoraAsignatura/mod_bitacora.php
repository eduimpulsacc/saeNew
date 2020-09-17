<? 

class Bitacora{  
	public function BuscaAsignatura($conn,$id_curso){
	$sql = "SELECT subsector.cod_subsector, subsector.nombre, ramo.id_ramo FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector  where ramo.id_curso  = $id_curso order by ramo.id_orden;";
		$rs_alumno =pg_exec($conn,$sql);
		
		return $rs_alumno;
		
	}
}

?>