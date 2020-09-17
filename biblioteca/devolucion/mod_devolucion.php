<?
class Devolucion{
	public function construct(){
		
	}
	
public function libro($conn,$rdb){
	$sql="SELECT * FROM biblio.libro where rdb=$rdb order by titulo";
	$result = pg_exec($conn,$sql);
	
	return $result;	
}

public function buscaLibro($conn,$id_libro,$ano){
	  $sql="select l.titulo,e.codigo,p.id_prestamo,e.id_ejemplar,p.estado_prestamo,p.tipo_usuario,p.rut_usuario,p.fecha_devolucion from biblio.ejemplares e 
inner join biblio.prestamo p on e.id_ejemplar = p.id_ejemplar   
inner join biblio.libro l on l.id_libro = e.id_libro
 where p.id_libro =$id_libro and e.estado=2 and p.estado_prestamo in(1,3,4) and p.id_ano=$ano";
 $result = pg_exec($conn,$sql);
	
	return $result;	
}
public function buscaCodigo($conn,$codigo,$rdb,$ano){
	  $sql="select l.titulo,e.codigo,p.id_prestamo,e.id_ejemplar,p.estado_prestamo,p.tipo_usuario,p.rut_usuario,p.fecha_devolucion from biblio.ejemplares e 
inner join biblio.prestamo p on e.id_ejemplar = p.id_ejemplar   
inner join biblio.libro l on l.id_libro = e.id_libro
where p.estado_prestamo in(1,3,4)
and l.rdb=$rdb
and e.estado =2
and  CAST(codigo AS TEXT) LIKE '%$codigo%'
and p.id_ano=$ano";
$result = pg_exec($conn,$sql);
	
	return $result;	
}

public function dprestamo($conn,$id_prestamo){
	 $sql="update biblio.prestamo set estado_prestamo=2,fecha_entrega='".date("Y-m-d")."' where id_prestamo = ".$id_prestamo;
	$result = pg_exec($conn,$sql);
	
	return $result;	
}

public function dprestamoM($conn,$id_prestamo){
	$sql="update biblio.prestamo set estado_prestamo=4 where id_prestamo = ".$id_prestamo;
	$result = pg_exec($conn,$sql);
	
	return $result;	
}

public function dejemplar($conn,$id_ejemplar){
	$sql="update biblio.ejemplares set estado=1 where id_ejemplar=".$id_ejemplar;
	$result = pg_exec($conn,$sql);
	
	return $result;	
}

public function traeEmp($conn,$emp){
	 $sql = "select a.rut_emp rut, a.ape_pat||' '||a.ape_mat||' '||a.nombre_emp  nombre from empleado a where rut_emp=$emp";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function traeApo($conn,$apo){
 $sql = "select a.rut_apo rut, a.ape_pat||' '||a.ape_mat||' '||a.nombre_apo  nombre from apoderado a where rut_apo=$apo";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function traeAlu($conn,$alu){
	 $sql = "select a.rut_alumno rut, a.ape_pat||' '||a.ape_mat||' '||a.nombre_alu  nombre from alumno a where rut_alumno=$alu";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function tengoMulta($conn,$rdb){
	  $sql = "select * from biblio.multa_config where rdb=$rdb and estado=1";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function anoEs($conn,$ano){
	  $sql = "select * from ano_escolar where id_ano=$ano";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function feriadoAno($conn,$ano){
	  $sql = "select * from feriado where id_ano=$ano";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function datopres($conn,$id){
	  $sql = "select * from biblio.prestamo  where id_prestamo=$id";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function buscaLibroCodigo($conn,$id_libro){
	$sql="select * from biblio.libro where id_libro=$id_libro";
 $result = pg_exec($conn,$sql);
	
	return $result;	
}

	public function cpal($conn,$ano,$ruta){
  $sql="select id_curso from matricula where id_ano=$ano and rut_alumno=$ruta";
$result = pg_exec($conn,$sql);
		
		return $result;	
}


public function pagaMulta2($conn,$ano,$ejemplar,$usuario,$datraso,$multa,$prestamo){
	   $sql="insert into biblio.multa_usuario(id_ano,id_ejemplar,rut_usuario,dias_atraso,monto,rebaja,estado,fecha_multa,id_prestamo) values($ano,$ejemplar,$usuario,$datraso,$multa,0,0,'".date("Y-m-d")."',$prestamo)";
	$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	
public function pagaMulta($conn,$id,$monto,$rebaja){
  $sql="update biblio.multa_usuario set monto=$monto,rebaja=$rebaja,estado=0 where id_multa=$id";
$result = pg_exec($conn,$sql);
		
		return $result;	
}


}//fin clase
?>