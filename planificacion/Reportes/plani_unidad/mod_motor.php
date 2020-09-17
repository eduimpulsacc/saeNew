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
	
	public function Ramo($conn,$ano,$curso,$_PERFIL,$rut){
		if($_PERFIL==17){
			$sql="SELECT s.cod_subsector,nombre,r.id_ramo FROM ramo r INNER JOIN subsector s ON r.cod_subsector=s.cod_subsector INNER JOIN dicta ON dicta.id_ramo=r.id_ramo WHERE id_curso=".$curso." AND rut_emp=".$rut." ORDER BY id_orden ASC";
		}else{
			$sql="SELECT s.cod_subsector,nombre,id_ramo FROM ramo r INNER JOIN subsector s ON r.cod_subsector=s.cod_subsector WHERE id_curso=".$curso." ORDER BY id_orden ASC";
		}
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	
	public function traeRamo($conn,$curso,$ramo=''){

  $qry="SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector, ramo.eee,  ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, ramo.porc_examen, ramo.conexper,ramo.prueba_especial,ramo.bool_nquiz,ramo.conexquiz, ramo.coef2,ramo.bool_pu FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso."))";
 
 if($ramo){
$qry.=" and ramo.id_ramo=$ramo";
}
 
 $qry.=" order by ramo.id_orden";	
 
 //echo $qry;		   
             $result = pg_exec($conn,$qry);
		
		return $result;	
}


public function traeUnidad($conn,$idUnidad){
 $sql="select * from planificacion.unidad where id_unidad=$idUnidad";
 $result = pg_exec($conn,$sql);
		
		return $result;	

}
	
	
	
}

?>