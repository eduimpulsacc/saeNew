<?php 
 require("../../../util/header.inc");
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
 echo $sql = "insert into biblio.reserva (id_libro,rut_usuario,id_ano,fecha,estado,rdb,fecha_reserva,tipo_usuario)
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
	   $sql="select p.*,li.titulo,e.codigo from biblio.prestamo p 
	  inner join biblio.libro li on li.id_libro = p.id_libro
	  inner join biblio.ejemplares e on e.id_ejemplar = p.id_ejemplar
	  where p.rut_usuario=$rut and p.estado_prestamo=1 and p.id_ano=$ano";
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

/*Cambios 01-07-2019:
agregar búsqueda por autor y categoría
*/
public function autor($conn,$rdb){
	$sql="SELECT * FROM biblio.autor  where rdb=$rdb order by nombre";
	$result = pg_exec($conn,$sql);
	return $result;	
}

public function categoria($conn,$rdb){
	$sql="SELECT * FROM biblio.categoria  where rdb=$rdb order by nombre";
	$result = pg_exec($conn,$sql);
	return $result;	
}

public function titDisponible($conn,$rdb,$cont){
	 $sql="
	select l.id_libro, l.titulo from biblio.libro l
inner join  biblio.ejemplares e on l.id_libro = e.id_libro
inner join biblio.libro_autor a on a.id_libro = l.id_libro
inner join biblio.libro_categoria c on c.id_libro = l.id_libro
where 
 l.rdb=$rdb
 and e.estado=1
 $cont 
 GROUP by 1,2
 order by 2";
 $result = pg_exec($conn,$sql);
	return $result;	
}
	
	public function usuarioBloqueado($conn,$ano,$rdb,$rut,$estado){
  $sql="select * from biblio.bloqueo where rdb=$rdb and rut_usuario=$rut and id_ano=$ano and estado=1 "	;
$result = pg_exec($conn,$sql);
	return $result;
}

public function bloqueosVencidos($conn,$rdb,$ano,$fecha,$rut){
 $sql="select * from biblio.bloqueo 
where rdb=$rdb  and id_ano=$ano and estado=1 
and fecha_hasta <='$fecha' and rut_usuario=$rut";
$reg = @pg_Exec($conn,$sql)or die("f2".$sql);
return $reg;
}

public function desbloquearPrestamos($conn,$idprestamo){
 $sql="update biblio.bloqueo set estado = 0 where id_prestamo = $idprestamo";	
$reg = @pg_Exec($conn,$sql)or die("f2".$sql);
return $reg;
}
	
}//fin clase
?>