<?php 
 require("../../util/header.php");
class Reserva{
	public function construct(){
		
	}
	public function libro($conn,$rdb){
	  $sql="SELECT * FROM biblio.libro  where rdb=$rdb order by titulo";
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

public function listaReserva($conn,$rut_usuario,$rdb,$id_ano){
 $sql="select r.id_reserva,r.id_libro,l.titulo,r.fecha_reserva,r.tipo_usuario,r.rut_usuario from biblio.reserva r
inner join biblio.libro l on l.id_libro = r.id_libro
where r.rut_usuario!=0 and r.rut_usuario =$rut_usuario and r.rdb=$rdb and r.id_ano=$id_ano
and r.estado=1";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function reservaDuplicada($conn,$rut_usuario,$id_libro,$id_ano){
	$sql="select * from biblio.reserva where id_ano=$id_ano and id_libro=$id_libro and rut_usuario=$rut_usuario and estado=1";
	$result = pg_exec($conn,$sql);
		
		return $result;
}

public function stockLibro($conn,$id_libro){
	 $sql="select * from biblio.ejemplares where id_libro=$id_libro and estado=1";
	 $result = pg_exec($conn,$sql);
		
		return $result;
}

public function minprestamo($conn,$id_libro){
	 $sql="select * from biblio.prestamo where id_libro=$id_libro and estado_prestamo=1 order by fecha_devolucion asc limit 1";
	$result = pg_exec($conn,$sql);
		
		return $result;
}

public function guardaReserva($conn,$id_libro,$rut_usuario,$id_ano,$rdb,$fecha_reserva,$tipo_usuario){
 $sql = "insert into biblio.reserva (id_libro,rut_usuario,id_ano,fecha,estado,rdb,fecha_reserva,tipo_usuario)
 values($id_libro,$rut_usuario,$id_ano,'".date("Y-m-d")."',1,$rdb,'".CambioFE($fecha_reserva)."',$tipo_usuario)";	
 $result = pg_exec($conn,$sql);
		
		return $result;

}

public function traeEmpUno($conn,$rut){
	  $sql = "select a.rut_emp rut, a.ape_pat||' '||a.ape_mat||' '||a.nombre_emp  nombre from empleado a where rut_emp=$rut";
	$result = pg_exec($conn,$sql);
		
		return $result;	

}

public function traeApoUno($conn,$rut){
	 $sql = "select a.rut_apo rut, a.ape_pat||' '||a.ape_mat||' '||a.nombre_apo  nombre
from apoderado a where rut_apo = $rut";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function traeAluUno($conn,$rut){
	 $sql = "select a.rut_alumno rut, a.ape_pat||' '||a.ape_mat||' '||a.nombre_alu  nombre
from alumno a where rut_alumno = $rut";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function anula($conn,$id){
$sql="update biblio.reserva set estado=3 where id_reserva=$id";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function reservaUno($conn,$id){
	 $sql = "select * from biblio.reserva where id_reserva=$id";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function prestamosUsu($conn,$rut,$ano){
	 $sql="select * from biblio.prestamo where rut_usuario=$rut and estado_prestamo=1 and id_ano=$ano";
	$result = pg_exec($conn,$sql);
		
		return $result;
}
	
public function minejemplar($conn,$id_libro){
 $sql="select * from biblio.ejemplares where id_libro=$id_libro and estado=1 order by id_ejemplar asc limit 1";
$result = pg_exec($conn,$sql);
		
		return $result;
}

public function guardaPrestamo($conn,$id_ejemplar,$id_libro,$fecha_devolucion,$rut_usuario,$tipou){
 $sql="insert into biblio.prestamo (id_ejemplar,id_libro,fecha_prestamo,fecha_devolucion,rut_usuario,estado_prestamo,tipo_usuario) values($id_ejemplar,$id_libro,'".date("Y-m-d")."','$fecha_devolucion',$rut_usuario,1,$tipou)";
$result = pg_exec($conn,$sql);
}

public function cambiores($conn,$id){
 $sql="update biblio.reserva set estado=2 where id_reserva=$id";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function traeRes($conn,$rdb){
 $sql="select * from biblio.restriccion where rdb=$rdb";
$result = pg_exec($conn,$sql);
return $result;	
}
	
}//fin clase
?>