<?php  
require("../../../util/header.php");
class Filtro{
	public function construct(){
		
	}
	
	
public function libro($conn,$rdb){
	  $sql="SELECT * FROM biblio.libro  where rdb=$rdb and estado=1 order by titulo";
	  $result = pg_exec($conn,$sql);
	  return $result;	
}


public function traeEmp($conn,$rdb){
	 $sql = "select e.* from empleado e
	inner join trabaja t on t.rut_emp = e.rut_emp
	where t.rdb=$rdb order by ape_pat,ape_mat,nombre_emp";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}
public function traeCurso($conn,$ano){
	 $sql = "select * from curso where id_ano=$ano order by ensenanza,grado_curso,letra_curso";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}
public function traeAluCurso($conn,$curso){
	 $sql = "select a.rut_alumno rut, a.ape_pat||' '||a.ape_mat||' '||a.nombre_alu  nombre
from alumno a
inner join matricula m on m.rut_alumno = a.rut_alumno
where m.id_curso = $curso and m.bool_ar=0
order by nombre";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function traeApoCurso($conn,$curso){
	 $sql = "select a.rut_apo rut, a.ape_pat||' '||a.ape_mat||' '||a.nombre_apo  nombre
from apoderado a
inner join tiene2 t on t.rut_apo = a.rut_apo
inner join matricula m on m.rut_alumno = t.rut_alumno
where m.id_curso = $curso and m.bool_ar=0
order by nombre";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function catego($conn,$rdb){
 $sql ="select id_categoria id,nombre from biblio.categoria where rdb=$rdb order by nombre";
$result = pg_exec($conn,$sql);
		
		return $result;	

}

public function autor($conn,$rdb){
 $sql ="select id_autor id,nombre from biblio.autor where rdb=$rdb order by nombre";
$result = pg_exec($conn,$sql);
		
		return $result;	

}
public function editorial($conn,$rdb){
 $sql ="select id_editorial id,nombre from biblio.editorial where rdb=$rdb order by nombre";
$result = pg_exec($conn,$sql);
		
		return $result;	

}

public function catego1($conn,$id){
 $sql ="select * from biblio.categoria where id_categoria=$id ";
$result = pg_exec($conn,$sql);
		
		return $result;	

}

public function autor1($conn,$id){
 $sql ="select * from biblio.autor where id_autor=$id ";
$result = pg_exec($conn,$sql);
		
		return $result;	

}
public function editorial1($conn,$id){
$sql ="select * from biblio.editorial where id_editorial=$id";
$result = pg_exec($conn,$sql);
		
		return $result;	

}

}//fin clase

?>