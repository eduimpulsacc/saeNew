<?php class Justifica{
	
	public function contructor(){
			
	}
	
	
public function traeAno($conn,$rdb){
$sql ="select id_ano,nro_ano,situacion from ano_escolar where id_institucion=$rdb order by nro_ano";
$result = pg_exec($conn,$sql);
return $result;
}

public function traeCursos($conn,$ano){
$sql ="select id_curso from curso where id_ano=$ano order by ensenanza, grado_curso, letra_curso";
$result = pg_exec($conn,$sql);
return $result;
}

public function curso($conn,$curso){
$sql ="select id_curso,fecha_inicio,fecha_termino from curso where id_curso=$curso";
$result = pg_exec($conn,$sql);
return $result;
}

public function ano($conn,$ano){
$sql ="select id_ano,fecha_inicio,fecha_termino from ano_escolar where id_ano=$ano";
$result = pg_exec($conn,$sql);
return $result;
}

public function listaAlumno($conn,$ano,$mes,$curso,$numano){
$sql="select DISTINCT (a.rut_alumno),al.ape_pat,al.ape_mat,al.nombre_alu
from anotacion a 
inner join alumno al on al.rut_alumno = a.rut_alumno
where date_part('MONTH',fecha) = '$mes' and date_part('YEAR',fecha) = $numano
and a.tipo=2
and a.rut_alumno in (Select rut_alumno from matricula where id_curso=$curso)
order by 2,3,4 ";
$result = pg_exec($conn,$sql);
return $result;
	
}

public function Alumno($conn,$rut){
$sql="select al.rut_alumno,al.ape_pat,al.ape_mat,al.nombre_alu from alumno al where rut_alumno=$rut";
$result = pg_exec($conn,$sql);
return $result;
	
}

public function listaAtraso($conn,$ano,$mes,$curso,$numano,$alumno){
 $sql="select a.*
from anotacion a 
inner join alumno al on al.rut_alumno = a.rut_alumno
where date_part('MONTH',fecha) = '$mes' and date_part('YEAR',fecha) = $numano
and a.rut_alumno in (Select rut_alumno from matricula where id_curso=$curso)
and a.rut_alumno = $alumno
order by fecha,jornada asc ";
$result = pg_exec($conn,$sql);
return $result;
	
}

public function trajeJustificado($conn,$id_anotacion){
$sql ="select * from justifica_atraso where id_anotacion=$id_anotacion";
$result = pg_exec($conn,$sql);
return $result;
}

public function trajeJustificado2($conn,$rut,$fecha){
 $sql ="select * from justifica_atraso where rut_alumno=$rut and fecha='$fecha'";
$result = pg_exec($conn,$sql);
return $result;
}

public function Anotacion($conn,$id_anotacion){
$sql ="select * from anotacion where id_anotacion=$id_anotacion";
$result = pg_exec($conn,$sql);
return $result;
}

public function Anotacion2($conn,$rut,$fecha)
{
 $sql ="select * from anotacion where rut_alumno=$rut and fecha='$fecha' and tipo=2";
$result = pg_exec($conn,$sql);
return $result;
}

public function quitaJustificado($conn,$rut,$anio,$curso,$fecha){
$sql ="delete from justifica_atraso where ano=$anio and rut_alumno =$rut and id_curso=$curso and fecha='$fecha' ";
$result = pg_exec($conn,$sql);
return $result;
}

public function GuardaJustificado($conn,$id,$ano,$curso,$fecha,$rut,$text,$chk){
$sql ="insert into justifica_atraso (id_anotacion,rut_alumno,ano,id_curso,fecha,observacion,adjuntadoc) values($id,$rut,$ano,$curso,'$fecha','".utf8_decode($text)."',$chk)";
$result = pg_exec($conn,$sql);
return $result;
}
	
} //fin clase?>