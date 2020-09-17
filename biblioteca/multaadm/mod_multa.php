<?php 
require("../../util/header.php");

class MultaAdm{
	public function construct(){
		
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

public function multasUsuario($conn,$rut){
 $sql="select p.*, t.titulo from biblio.prestamo p
inner join biblio.libro t on t.id_libro = p.id_libro 
where rut_usuario =$rut and (fecha_entrega is null or fecha_entrega>fecha_devolucion)
and estado_prestamo not in (1,2)";	
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


public function traeEmpUno($conn,$emp){
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

public function buscaLibroCodigo($conn,$id_libro){
	$sql="select * from biblio.libro where id_libro=$id_libro";
 $result = pg_exec($conn,$sql);
	
	return $result;	
}

public function anoEs($conn,$ano){
	  $sql = "select * from ano_escolar where id_ano=$ano";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function rangoFeriadoAno($conn,$ano,$fecha_inicio,$fecha_fin){
	   $sql = "select * from feriado where id_ano=$ano and fecha_inicio>='$fecha_inicio' and fecha_fin<='$fecha_fin'";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function tengoMulta($conn,$rdb){
	  $sql = "select * from biblio.multa_config where rdb=$rdb and estado=1";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function creaMulta($conn,$ano,$ejemplar,$usuario,$datraso,$multa,$prestamo,$nano){
	  $sql="insert into biblio.multa_usuario(id_ano,id_ejemplar,rut_usuario,dias_atraso,monto,rebaja,estado,fecha_multa,id_prestamo) values($ano,$ejemplar,$usuario,$datraso,$multa,0,1,'$nano-".date("m-d")."',$prestamo)";
	$result1 = pg_exec($conn,$sql);
	
	 $sql2="update biblio.prestamo set estado_prestamo=4 where id_prestamo = $prestamo";
	$result = pg_exec($conn,$sql2);
		
		return $result1;	
	}


public function cpal($conn,$ano,$ruta){
  $sql="select id_curso from matricula where id_ano=$ano and rut_alumno=$ruta";
$result = pg_exec($conn,$sql);
		
		return $result;	
}
}//fin clase
?>