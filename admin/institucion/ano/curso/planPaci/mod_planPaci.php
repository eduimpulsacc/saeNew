<?php 
class PlanPaci {

public function dAlumno($conn,$alumno){
$sql="select * from alumno where rut_alumno=$alumno";
$result=pg_exec($conn,$sql);
return $result;	
}


public function dPlanificacion($conn,$curso){
$sql="select * from pain_planificacion where id_curso=$alumno";
$result=pg_exec($conn,$sql);
return $result;	
}

public function dPeriodo($conn,$ano){
$sql="select * from periodo where id_ano=$ano order by fecha_inicio";
$result=pg_exec($conn,$sql);
return $result;	
}

public function dPlan($conn,$ano,$curso){
 $sql="select * from pain_planificacion where id_ano=$ano and id_curso=$curso";
$result=pg_exec($conn,$sql);
return $result;	
}

public function contPlan($conn,$periodo,$curso,$alumno){
$sql="select * from pain_planificacion_continua where id_curso=$curso and id_periodo=$periodo and rut_alumno=$alumno";
$result=pg_exec($conn,$sql);
return $result;	
}

public function insComt($conn,$curso,$alumno,$periodo,$personal,$curricular,$medios,$organizacion,$familiar,$otros,$observaciones,$personal_descripcion,$personal_responsable,$personal_contexto,$curricular_descripcion,$curricular_responsable,$curricular_contexto,$medios_descripcion,$medios_responsable,$medios_contexto,$org_descripcion,$org_responsable,$org_contexto,$familiar_descripcion,$familiar_responsable,$familiar_contexto,$otros_descripcion,$otros_responsable,$otros_contexto){
 $sql="insert into pain_planificacion_continua(rut_alumno,id_curso,id_periodo,personal,curricular,medios,organizacion,familiar,otros,observaciones,personal_descripcion,personal_responsable,personal_contexto,curricular_descripcion,curricular_responsable,curricular_contexto,medios_descripcion,medios_responsable,medios_contexto,org_descripcion,org_responsable,org_contexto,familar_descripcion,familar_responsable,familar_contexto,otros_descripcion,otros_responsable,otros_contexto) values($alumno,$curso,$periodo,$personal,$curricular,$medios,$organizacion,$familiar,$otros,'$observaciones','$personal_descripcion','$personal_responsable','$personal_contexto'
,'$curricular_descripcion','$curricular_responsable','$curricular_contexto','$medios_descripcion','$medios_responsable','$medios_contexto','$org_descripcion','$org_responsable','$org_contexto','$familiar_descripcion','$familiar_responsable','$familiar_contexto','$otros_descripcion','$otros_responsable','$otros_contexto'
)"	;
$result=pg_exec($conn,$sql);
return $result;	
}

public function upComt($conn,$curso,$alumno,$periodo,$personal,$curricular,$medios,$organizacion,$familiar,$otros,$observaciones,$personal_descripcion,$personal_responsable,$personal_contexto,$curricular_descripcion,$curricular_responsable,$curricular_contexto,$medios_descripcion,$medios_responsable,$medios_contexto,$org_descripcion,$org_responsable,$org_contexto,$familiar_descripcion,$familiar_responsable,$familiar_contexto,$otros_descripcion,$otros_responsable,$otros_contexto){
$sql="update pain_planificacion_continua set personal=$personal,curricular=$curricular,medios=$medios,organizacion=$organizacion,familiar=$familiar,otros=$otros,observaciones='$observaciones',personal_descripcion='$personal_descripcion',personal_responsable='$personal_responsable',personal_contexto='$personal_contexto',
curricular_descripcion='$curricular_descripcion',curricular_responsable='$curricular_responsable',curricular_contexto='$curricular_contexto',medios_descripcion='$medios_descripcion',medios_responsable='$medios_responsable',medios_contexto='$medios_contexto',org_descripcion='$org_descripcion',org_responsable='$org_responsable',org_contexto='$org_contexto',familar_descripcion='$familiar_descripcion',familar_responsable='$familiar_responsable',familar_contexto='$familiar_contexto',otros_descripcion='$otros_descripcion',otros_responsable='$otros_responsable',otros_contexto='$otros_contexto'
 where rut_alumno=$alumno and id_curso=$curso and id_periodo=$periodo";
$result=pg_exec($conn,$sql);
return $result;	
}

public function temp($conn,$empleado){
 $sql="select * from empleado where rut_emp=$empleado";	
$result=pg_exec($conn,$sql);
return $result;	
}

public function listaPersonal($conn,$institucion){
$sql="select * from empleado
inner join trabaja on trabaja.rut_emp = empleado.rut_emp
where trabaja.rdb=$institucion
order by ape_pat,ape_mat,nombre_emp";
$result = pg_exec($conn,$sql);
return $result;	
}

}//fin clase
?>