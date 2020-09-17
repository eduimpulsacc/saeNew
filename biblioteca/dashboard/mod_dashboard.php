<?php 
class Dashhoard{
	public function construct(){
		
	}
	
//top10 libros más solicitados
public function top10LibrosPrestados($conn,$ano){
	  $sql="select count(p.*) as cuenta,l.id_libro,l.titulo
from biblio.prestamo p
inner join biblio.libro l on l.id_libro = p.id_libro
where p.id_ano = $ano
group by l.id_libro,l.titulo
order by 1 desc limit 10";
	$reg = @pg_Exec($conn,$sql)or die("f".$sql);
		
		return $reg;
	}
	
	
//top10 usuarios
public function top10Usuarios($conn,$ano,$tipo){
	//empleado
	if($tipo==1){
		$campo="emp";
		$tabla = "empleado";
		$criterio = "emp";
	}
	if($tipo==2){
		$campo="apo";
		$tabla="apoderado";
		$criterio = "apo";
	}
	if($tipo==3){
		$campo="alu";
		$tabla="alumno";
		$criterio = "alumno";
	}
	
	  $sql="select count(p.*) as cuenta,a.ape_pat||' '||a.ape_mat||' '||a.nombre_$campo as nombre
from biblio.prestamo p
inner join $tabla a on a.rut_$criterio = p.rut_usuario
where p.id_ano = $ano and p.tipo_usuario = 3
group by 2
order by 1 desc limit 10
";
	$reg = @pg_Exec($conn,$sql)or die("f".$sql);
		
		return $reg;
	}
	
	public function dataAno($conn,$ano){
	 $sql="select * from ano_escolar where id_ano=".$ano;
	$reg = @pg_Exec($conn,$sql)or die("f2".$sql);
		
		return $reg;
	}
	
	public function cuentaPrestamosTodo($conn,$ano,$mes){
	$sql="select count(p.*) as cuenta
from biblio.prestamo p
where p.id_ano = $ano and date_part('month',p.fecha_prestamo)='$mes'";
;
	$reg = @pg_Exec($conn,$sql)or die("f2".$sql);
		
		return $reg;
	
	}
	
	public function cuentaPrestamosGroupCurso($conn,$ano){
	$sql="select count(p.*) as cuenta, c.id_curso,c.ensenanza,c.grado_curso,c.letra_curso
from biblio.prestamo p
INNER join matricula m on m.rut_alumno = p.rut_usuario and m.id_ano = $ano
inner join curso c on c.id_curso = m.id_curso
where p.id_ano = $ano
group by c.id_curso,c.ensenanza,c.grado_curso,c.letra_curso 
order by c.ensenanza,c.grado_curso,c.letra_curso";
$reg = @pg_Exec($conn,$sql)or die("f2".$sql);
		
		return $reg;
	}
	
public function bloqueosVencidos($conn,$rdb,$ano,$fecha){
 $sql="select * from biblio.bloqueo 
where rdb=$rdb  and id_ano=$ano and estado=1 
and fecha_hasta <='$fecha'";
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