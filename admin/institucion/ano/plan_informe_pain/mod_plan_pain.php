<?php 
class PlanPain {

public function listacurso($conn,$ano){
	$sql="select id_curso from curso where id_ano=$ano order by ensenanza,grado_curso,letra_curso";
$result = pg_exec($conn,$sql);
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

public function guardaForm($conn,$ano,$curso,$personal_descripcion,$personal_responsable,$personal_contexto,$curricular_descripcion,$curricular_responsable,$curricular_contexto,$medios_descripcion,$medios_responsable,$medios_contexto,$org_descripcion,$org_responsable,$org_contexto,$familiar_descripcion,$familar_responsable,$familiar_contexto,$otros_descripcion,$otros_responsable,$otros_contexto)
{
 $sql="insert into pain_planificacion(id_ano,id_curso,
personal_descripcion,personal_responsable,personal_contexto,
curricular_descripcion,curricular_responsable,curricular_contexto,
medios_descripcion,medios_responsable,medios_contexto,
org_descripcion,org_responsable,org_contexto,
familar_descripcion,familar_responsable,familar_contexto,
otros_descripcion,otros_responsable,otros_contexto)
 values ($ano,$curso,
'$personal_descripcion',$personal_responsable,'$personal_contexto',
'$curricular_descripcion',$curricular_responsable,'$curricular_contexto',
'$medios_descripcion',$medios_responsable,'$medios_contexto',
'$org_descripcion',$org_responsable,'$org_contexto',
'$familiar_descripcion',$familar_responsable,'$familiar_contexto',
'$otros_descripcion',$otros_responsable,'$otros_contexto')";	
$result = pg_exec($conn,$sql);
return $result;		
} 

public function buscaPlan($conn,$curso){
	$sql="select * from pain_planificacion where id_curso=$curso";
	$result = pg_exec($conn,$sql);
return $result;	
}

public function updForm($conn,$personal_descripcion,$personal_responsable,$personal_contexto,$curricular_descripcion,$curricular_responsable,$curricular_contexto,$medios_descripcion,$medios_responsable,$medios_contexto,$org_descripcion,$org_responsable,$org_contexto,$familiar_descripcion,$familar_responsable,$familiar_contexto,$otros_descripcion,$otros_responsable,$otros_contexto,$id_plan)
{
   $sql="update pain_planificacion 
set  
personal_descripcion='$personal_descripcion',
personal_responsable=$personal_responsable,
personal_contexto='$personal_contexto',
curricular_descripcion='$curricular_descripcion',
curricular_responsable=$curricular_responsable,
curricular_contexto='$curricular_contexto',
medios_descripcion='$medios_descripcion',
medios_responsable=$medios_responsable,
medios_contexto='$medios_contexto',
org_descripcion='$org_descripcion',
org_responsable=$org_responsable,
org_contexto='$org_contexto',
familar_descripcion='$familiar_descripcion',
familar_responsable=$familar_responsable,
familar_contexto='$familiar_contexto',
otros_descripcion='$otros_descripcion',
otros_responsable=$otros_responsable,
otros_contexto='$otros_contexto' 
where id_plan=$id_plan";
$result = pg_exec($conn,$sql);
return $result;		
	
} 

}//fin clase
?>
