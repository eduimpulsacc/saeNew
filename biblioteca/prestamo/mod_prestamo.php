<?php 
 require("../../util/header.php");
class Prestamo{
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

public function Ejemplares($conn,$id_libro){
$sql="select * from biblio.ejemplares where id_libro=$id_libro and estado in(1,2)";
$result = pg_exec($conn,$sql);
		
		return $result;
}
public function copiaDis($conn,$id_libro){
$sql="select min(id_ejemplar) from biblio.ejemplares where id_libro=$id_libro and estado =1";
$result = pg_exec($conn,$sql);
		
		return $result;
}
    
public function guardaPrestamo($conn,$id_ejemplar,$id_libro,$fecha_devolucion,$rut_usuario,$tipou,$id_ano,$tipop,$rdb){
   $sql="insert into biblio.prestamo (id_ejemplar,id_libro,fecha_prestamo,fecha_devolucion,rut_usuario,estado_prestamo,tipo_usuario,id_ano,tipo_prestamo,rdb) values($id_ejemplar,$id_libro,'".date("Y-m-d")."','$fecha_devolucion',$rut_usuario,1,$tipou,$id_ano,$tipop,$rdb)";
$result = pg_exec($conn,$sql);

$sql2="update biblio.ejemplares set estado=2 where id_ejemplar=$id_ejemplar";
$result = pg_exec($conn,$sql2);
return $result;

}


public function ejemplarPrestado($conn,$id_ejemplar){
  $sql="select * from biblio.prestamo where id_ejemplar=$id_ejemplar order by id_prestamo desc limit 1";
$result = pg_exec($conn,$sql);
		
		return $result;
}

public function libroPrestado($conn,$rut_usuario,$ano,$id_libro){
  $sql="select * from biblio.prestamo where id_libro=$id_libro and id_ano=$ano and rut_usuario=$rut_usuario and estado_prestamo=1";
$result = pg_exec($conn,$sql);
		
		return $result;
}

public function prestamoUsuario($conn,$rut,$ano){
  $sql="select p.*,l.titulo,e.codigo from biblio.prestamo p
inner join biblio.libro l
on l.id_libro = p.id_libro
inner join biblio.ejemplares e
on e.id_ejemplar = p.id_ejemplar
where p.id_ano = $ano
and p.rut_usuario = $rut
and p.estado_prestamo in (1,3,4)";
$result = pg_exec($conn,$sql);
		
		return $result;
}

public function reservaUsuario($conn,$rut,$ano){
   $sql="select p.*,l.titulo from biblio.reserva p
inner join biblio.libro l
on l.id_libro = p.id_libro
where p.id_ano = $ano
and p.rut_usuario = $rut
and p.estado = 1";
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

public function prestamoUno($conn,$id){
	 $sql = "select * from biblio.prestamo where id_prestamo=$id";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function dprestamo($conn,$id_prestamo){
	  $sql="update biblio.prestamo set estado_prestamo=2,fecha_entrega='".date("Y-m-d")."' where id_prestamo = ".$id_prestamo;
	$result = pg_exec($conn,$sql);
	
	return $result;	
}

public function dejemplar($conn,$id_ejemplar){
	  $sql="update biblio.ejemplares set estado=1 where id_ejemplar=".$id_ejemplar;
	$result = pg_exec($conn,$sql);
	
	return $result;	
}

public function minejemplar($conn,$id_libro){
 $sql="select * from biblio.ejemplares where id_libro=$id_libro and estado=1 order by id_ejemplar asc limit 1";
$result = pg_exec($conn,$sql);
		
		return $result;
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



public function traeEmp1($conn,$emp){
	 $sql = "select a.rut_emp rut, a.ape_pat||' '||a.ape_mat||' '||a.nombre_emp  nombre from empleado a where rut_emp=$emp";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function traeApo1($conn,$apo){
 $sql = "select a.rut_apo rut, a.ape_pat||' '||a.ape_mat||' '||a.nombre_apo  nombre from apoderado a where rut_apo=$apo";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function traeAlu1($conn,$alu){
	 $sql = "select a.rut_alumno rut, a.ape_pat||' '||a.ape_mat||' '||a.nombre_alu  nombre from alumno a where rut_alumno=$alu";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function tengoMulta($conn,$rdb){
	  $sql = "select * from biblio.multa_config where rdb=$rdb and estado=1";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function multaUsuario($conn,$ano,$rut){
   $sql="select * from biblio.multa_usuario where id_ano=$ano and rut_usuario=$rut and estado=1";
$result = pg_exec($conn,$sql);
return $result;	
}


public function codigoEjemplar($conn,$id_ejemplar){
  $sql="select eje.*,li.titulo from biblio.ejemplares  eje inner join biblio.libro li on li.id_libro = eje.id_libro where eje.codigo = '$id_ejemplar'";
$result = pg_exec($conn,$sql);
return $result;	
}

public function EjemplaresUno($conn,$id_libro,$ejemplar){
//$sql="select biblio.ejemplares.*,biblio.libro.titulo from biblio.ejemplares inner join libro on biblio.libro.id_libro = biblio.ejemplares.id_libro  where id_libro=$id_libro and codigo = $ejemplar";
$sql="select e.*,l.titulo 
from biblio.ejemplares  e
inner join biblio.libro l on l.id_libro = e.id_libro 
where l.id_libro=$id_libro and codigo = $ejemplar";
$result = pg_exec($conn,$sql);
		
		return $result;
}

public function existeEmp($conn,$rdb,$emp){
	 $sql = "select distinct(e.*) from empleado e
	inner join trabaja t on t.rut_emp = e.rut_emp
	where t.rdb=$rdb and t.rut_emp= $emp order by ape_pat,ape_mat,nombre_emp";
	$result = pg_exec($conn,$sql);
	return $result;	
}

public function existeApo($conn,$ano,$apo){
	$sql="select distinct (a.*) from apoderado a
inner join tiene2 t on t.rut_apo = a.rut_apo
where t.rut_alumno in(
select rut_alumno from matricula where id_ano =$ano and bool_ar=0
) and a.rut_apo = apo";
$result = pg_exec($conn,$sql);
	return $result;
}

public function existeAlu($conn,$ano,$alu){
	$sql="select distinct (a.*) from alumno a
	inner join matricula m on m.rut_alumno = a.rut_alumno
	where a.rut_alumno = $alu and m.id_ano = $ano and m.bool_ar=0;
	";
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
	select l.id_libro, l.titulo,e.codigo,e.id_ejemplar,e.estado from biblio.libro l
inner join  biblio.ejemplares e on l.id_libro = e.id_libro
inner join biblio.libro_autor a on a.id_libro = l.id_libro
inner join biblio.libro_categoria c on c.id_libro = l.id_libro
where 
 l.rdb=$rdb
 and e.estado in(1,2)
 $cont 
 GROUP by 1,2,3,4,5
 order by 2";
 $result = pg_exec($conn,$sql);
	return $result;	
}

public function Cuentaferiados($conn,$ano,$fini,$fter){
$sql ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$ano."  AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
$result = pg_exec($conn,$sql);
	return $result;	
}

public function haybloqueo($conn,$rdb){
$sql="select lim_diasbloqueo from biblio.restriccion where rdb=$rdb";
$result = pg_exec($conn,$sql);
	return $result;
}

public function bloquearUsuario($conn,$rut,$rdb,$id_ano,$id_prestamo,$fecha_desde,$fecha_hasta,$estado){
 $sql="insert into biblio.bloqueo (rut_usuario,rdb,id_ano,id_prestamo,fecha_desde,fecha_hasta,estado) values($rut,$rdb,$id_ano,$id_prestamo,'$fecha_desde','$fecha_hasta',$estado)";
$result = pg_exec($conn,$sql);
	return $result;
}
public function usuarioBloqueado($conn,$ano,$rdb,$rut,$estado){
 $sql="select * from biblio.bloqueo where rdb=$rdb and rut_usuario=$rut and id_ano=$ano and estado=1 "	;
$result = pg_exec($conn,$sql);
	return $result;
}

public function desbloqueoUsuario($conn,$ano,$rdb,$rut,$id_prestamo){
$sql="update biblio.bloqueo set estado=0 where rut_usuario=$rut and id_ano=$ano and id_prestamo=$id_prestamo";	
$result = pg_exec($conn,$sql);
	return $result;
}


}//fin clase ?>