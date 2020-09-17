<?php 
class Evaluacion{
	
	public function contructor(){
			
	}

public function traeCursos($conn,$ano){
	 $sql="SELECT id_curso,grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo AS curso, ensenanza FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza=tipo_ensenanza.cod_tipo WHERE id_ano=".$ano." and ensenanza>10 ORDER BY ensenanza,curso ASC";
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
	
	public function traeDicta($conn,$ramo){
 $qry = "select
d.rut_emp,
d.id_ramo,
e.nombre_emp||' '|| e.ape_pat||' '|| e.ape_mat as nombre
from dicta d
inner join empleado e on e.rut_emp = d.rut_emp
where d.id_ramo=$ramo"; 
$result = pg_exec($conn,$qry);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
}

public function traeRamoUno($conn,$ramo){
	 $sql="SELECT * FROM ramo WHERE  id_ramo=".$ramo;
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	
	public function Unidad($conn,$ano,$curso,$ramo){
		$sql="SELECT * FROM planificacion.unidad WHERE id_ano=".$ano." AND id_curso=".$curso." AND id_ramo=".$ramo." ORDER BY fecha_inicio ASC";
		$result =pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function Clase($conn,$ano,$curso,$unidad,$ramo){
		$sql="SELECT * FROM planificacion.clase WHERE id_curso=".$curso." AND id_ramo=".$ramo." and id_unidad=".$unidad." ORDER BY fecha_inicio ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	
	public function traeEvaluaciones($conn,$unidad,$clase){
	 $sql = "select * from planificacion.evaluacion where visible =1 and id_unidad=$unidad";
	
	if($clase!=0){
	$sql.=" and id_clase = $clase";	
	}
	
	$sql.=" order by fecha_creacion ";
	
	//echo $sql;
	$result = pg_exec($conn,$sql);
		
		return $result;	
		
	
	}
	
	public function guardaEvaluacion($conn,$id_unidad,$id_clase,$nombre,$descripcion){
	  $sql="insert into planificacion.evaluacion(id_unidad,id_clase,fecha_creacion,estado,visible,nombre,descripcion) values($id_unidad,$id_clase,'".date("Y-m-d")."',1,1,'".$nombre."','".$descripcion."')";
	$result = pg_exec($conn,$sql);
		
		return $result;	
	
	}
	
	
	public function traeEstadoUno($conn,$estado){
	 $sql="SELECT * FROM ramo WHERE  id_ramo=".$ramo;
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	
	public function traeEvaluacionUno($conn,$id_evaluacion,$clase){
	 $sql = "select * from planificacion.evaluacion where id_evaluacion =$id_evaluacion";
	
	if($clase!=0){
	$sql.=" and id_clase = $clase";	
	}
	
	$sql.=" order by fecha_creacion ";
	
	//echo $sql;
	$result = pg_exec($conn,$sql);
		
		return $result;	
		
	
	}

}//fin clase