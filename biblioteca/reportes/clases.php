<? 
class Reporte{
	
	public function Membrete($conn,$rdb){
		$sql="SELECT * FROM institucion WHERE rdb=".$rdb;
		$result = pg_exec($conn,$sql);
		$fila = pg_fetch_array($result,0);
		
		return $fila;
	}
	
	public function empleadoUno($conn,$rut){
		 $sql="SELECT e.rut_emp rut, e.ape_pat||' '||e.ape_mat||' '||e.nombre_emp nombre FROM empleado e WHERE rut_emp=".$rut;
		
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function apoderadoUno($conn,$rut){
		 $sql="SELECT e.rut_apo rut, e.ape_pat||' '||e.ape_mat||' '||e.nombre_apo nombre FROM apoderado e WHERE rut_apo=".$rut;
		
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	
	public function AlumnoUno($conn,$rut){
		  $sql="SELECT e.rut_alumno rut, e.ape_pat||' '||e.ape_mat||' '||e.nombre_alu nombre FROM alumno e WHERE rut_alumno=".$rut;
		
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	/*public function empleado($conn,$rdb){
		$sql="SELECT e.rut_emp rut, e.ape_pat||' '||e.ape_mat||' '||e.nombre_emp nombre  FROM empleado e inner join trabaja t on t.rut_emp = e.rut_emp  WHERE rdb=".$rdb;
		$result = pg_exec($conn,$sql);
		$fila = pg_fetch_array($result,0);
		
		return $fila;
	}*/
	
	public function Ano($conn,$ano){
		$sql="SELECT * FROM ano_Escolar WHERE id_ano=".$ano;
		$result = pg_exec($conn,$sql);
		$fila = pg_fetch_array($result,0);
		
		return $fila;	
	}
	
	public function AnoTodos($conn,$rdb){
		 $sql="SELECT * FROM ano_escolar WHERE id_institucion=".$rdb." order by nro_ano desc";
		$result = pg_exec($conn,$sql);
		
		
		return $result;	
	}
	
	public function listaReservaEmpleadoTodos($conn,$rdb,$id_ano){
  $sql="select 
 r.id_reserva,r.id_libro,l.titulo,r.fecha_reserva,r.tipo_usuario,r.rut_usuario,a.rut_emp rut, a.ape_pat||' '||a.ape_mat||' '||a.nombre_emp nombre,r.estado 
 from biblio.reserva r
inner join biblio.libro l on l.id_libro = r.id_libro
inner join empleado a on a.rut_emp = r.rut_usuario
where r.rut_usuario!=0 and r.rdb=$rdb and r.id_ano=$id_ano
and r.tipo_usuario=1 ";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function listaReserva($conn,$rut_usuario,$rdb,$id_ano){
   $sql="select r.id_reserva,r.id_libro,l.titulo,r.fecha_reserva,r.tipo_usuario,r.rut_usuario,r.estado from biblio.reserva r
inner join biblio.libro l on l.id_libro = r.id_libro
where r.rut_usuario!=0 and r.rut_usuario =$rut_usuario and r.rdb=$rdb and r.id_ano=$id_ano
";
$result = pg_exec($conn,$sql);
		
		return $result;	
}
	
	public function listaReservaApoderadoTodos($conn,$rdb,$id_ano,$curso){
    $sql="select r.id_reserva,r.id_libro,l.titulo,r.fecha_reserva,r.tipo_usuario,
r.rut_usuario, a.ape_pat||' '||a.ape_mat||' '||a.nombre_apo nombre,
r.estado from biblio.reserva r 
inner join biblio.libro l on l.id_libro = r.id_libro 
left join apoderado a on a.rut_apo = r.rut_usuario 
left join tiene2 t on t.rut_apo = a.rut_apo
left join matricula m on m.rut_alumno = t.rut_alumno
where r.rut_usuario!=0 and r.rdb=$rdb and r.id_ano=$id_ano
and r.tipo_usuario=2 and m.id_curso=$curso ";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function listaReservaALumnoTodos($conn,$rdb,$id_ano,$curso){
    $sql="select r.id_reserva,r.id_libro,l.titulo,r.fecha_reserva,r.tipo_usuario,
 r.rut_usuario, a.ape_pat||' '||a.ape_mat||' '||a.nombre_alu nombre, 
 r.estado from biblio.reserva r inner 
 join biblio.libro l on l.id_libro = r.id_libro 
 left join alumno a on a.rut_alumno = r.rut_usuario 
 left join matricula m on m.rut_alumno = r.rut_usuario
where r.rut_usuario!=0 and r.rdb=$rdb and r.id_ano=$id_ano and r.tipo_usuario=3
and m.id_curso=$curso";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function listaReservaTituloTodos($conn,$rdb,$id_ano,$id_libro){
    $sql="select r.id_reserva,r.id_libro,l.titulo,r.fecha_reserva,r.tipo_usuario,
 r.rut_usuario, r.estado from biblio.reserva r inner 
 join biblio.libro l on l.id_libro = r.id_libro 
 where r.rut_usuario!=0 
 and r.rdb=$rdb and r.id_ano=$id_ano and r.id_libro=$id_libro ";
$result = pg_exec($conn,$sql);
		
		return $result;	
}
public function iLibro($conn,$id_libro){
$sql="select * from biblio.libro where id_libro=$id_libro";
$result = pg_exec($conn,$sql);
return $result;	
}


public function prestamoUsuario($conn,$libro,$ano,$estado){
$sql="select p.*,l.titulo,e.codigo from biblio.prestamo p 
inner join biblio.libro l on l.id_libro = p.id_libro 
inner join biblio.ejemplares e on e.id_ejemplar = p.id_ejemplar
 where p.id_ano = $ano and p.id_libro=$libro";

if($estado==1){
	$sql.=" and p.estado_prestamo=1";
}

if($estado==0){
	$sql.=" and p.estado_prestamo in(1,3)";
}


$result = pg_exec($conn,$sql);
		
		return $result;
}

public function prestamoTitulo($conn,$libro,$ano,$estado){
$sql="select p.*,l.titulo,e.codigo,p.estado_prestamo,p.fecha_devolucion from biblio.prestamo p 
inner join biblio.libro l on l.id_libro = p.id_libro 
inner join biblio.ejemplares e on e.id_ejemplar = p.id_ejemplar
 where p.id_ano = $ano and p.id_libro=$libro";

if($estado==1){
	$sql.=" and (p.estado_prestamo=1 or p.estado_prestamo =3)";
}

if($estado==0){
	$sql.=" and p.estado_prestamo in(1,3)";
}
//echo $sql;

$result = pg_exec($conn,$sql);
		
		return $result;

}


public function listaPrestamoEmpleadoTodos($conn,$rdb,$id_ano,$estado){
	 $sql="select p.id_prestamo,p.id_libro,l.titulo,p.fecha_prestamo,p.fecha_devolucion,p.fecha_entrega,p.tipo_usuario,p.rut_usuario,a.rut_emp rut, a.ape_pat||' '||a.ape_mat||' '||a.nombre_emp nombre,p.estado_prestamo 
 from biblio.prestamo p
inner join biblio.libro l on l.id_libro = p.id_libro
inner join empleado a on a.rut_emp = p.rut_usuario
where p.rut_usuario!=0 and  p.id_ano=$id_ano
and p.tipo_usuario=1 ";

if($estado==1){
$sql.=" and p.estado_prestamo=1";
}
if($estado==0){
	$sql.=" and p.estado_prestamo in(1,3)";
}

$result = pg_exec($conn,$sql);
		
		return $result;	
}



public function listaPrestamoApoderadoTodos($conn,$rdb,$id_ano,$curso,$estado){
	 $sql="select p.* ,l.titulo, a.ape_pat||' '||a.ape_mat||' '||a.nombre_apo nombre
from biblio.prestamo p
inner join apoderado a on a.rut_apo = p.rut_usuario
inner join biblio.libro l on l.id_libro = p.id_libro
inner join tiene2 t on t.rut_apo = p.rut_usuario
inner join matricula m on m.rut_alumno = t.rut_alumno
where p.id_ano = $id_ano and m.id_curso = $curso and p.tipo_usuario=2 ";

if($estado==1){
$sql.=" and p.estado_prestamo=1";
}

if($estado==0){
	$sql.=" and p.estado_prestamo in(1,3)";
}

$result = pg_exec($conn,$sql);
		
		return $result;	
}


public function listaPrestamoAlumnoTodos($conn,$rdb,$id_ano,$curso,$estado){
	 $sql="select p.* ,l.titulo, a.ape_pat||' '||a.ape_mat||' '||a.nombre_alu nombre
from biblio.prestamo p
inner join alumno a on a.rut_alumno = p.rut_usuario
inner join biblio.libro l on l.id_libro = p.id_libro
inner join matricula m on m.rut_alumno = p.rut_usuario
where p.id_ano = $id_ano and m.id_curso = $curso  and p.tipo_usuario=3 ";

if($estado==1){
$sql.=" and p.estado_prestamo=1";
}
if($estado==0){
	$sql.=" and p.estado_prestamo in(1,3)";
}

$result = pg_exec($conn,$sql);
		
		return $result;	
}
	
public function listaDevolucionEmpleadoTodos($conn,$rdb,$id_ano,$fecha){
	 $sql=" select p.id_prestamo,p.id_libro,l.titulo,p.fecha_prestamo,p.fecha_devolucion,
 p.fecha_entrega,p.tipo_usuario,p.rut_usuario,a.rut_emp rut, 
 a.ape_pat||' '||a.ape_mat||' '||a.nombre_emp nombre,p.estado_prestamo 
 from biblio.prestamo p inner join biblio.libro l on l.id_libro = p.id_libro 
 inner join empleado a on a.rut_emp = p.rut_usuario 
 where p.rut_usuario!=0 and p.id_ano=$id_ano and p.tipo_usuario=1 
 and p.estado_prestamo=2 and  fecha_entrega <='$fecha'";
$result = pg_exec($conn,$sql);
return $result;	
}
	
	
public function listaDevolucionApoderadoTodos($conn,$rdb,$id_ano,$curso,$fecha){
	  $sql="select p.* ,l.titulo, a.ape_pat||' '||a.ape_mat||' '||a.nombre_apo nombre
from biblio.prestamo p inner join apoderado a on a.rut_apo = p.rut_usuario
inner join biblio.libro l on l.id_libro = p.id_libro
inner join tiene2 t on t.rut_apo = p.rut_usuario
inner join matricula m on m.rut_alumno = t.rut_alumno
where p.id_ano = $id_ano and m.id_curso = $curso and p.tipo_usuario=2  and p.estado_prestamo=2 and fecha_entrega <='$fecha' ";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function listaDevolucionAlumnoTodos($conn,$rdb,$id_ano,$curso,$fecha){
	  $sql="select p.* ,l.titulo, a.ape_pat||' '||a.ape_mat||' '||a.nombre_alu nombre
from biblio.prestamo p inner join alumno a on a.rut_alumno = p.rut_usuario
inner join biblio.libro l on l.id_libro = p.id_libro
inner join matricula m on m.rut_alumno = p.rut_usuario
where p.id_ano = $id_ano and m.id_curso = $curso and p.tipo_usuario=3  and p.estado_prestamo=2 and fecha_entrega <='$fecha' ";
$result = pg_exec($conn,$sql);
		
		return $result;	
}


public function devolucionTitulo($conn,$libro,$ano,$fecha){
  $sql="select p.*,l.titulo,e.codigo,p.estado_prestamo,p.fecha_devolucion,fecha_entrega from biblio.prestamo p 
inner join biblio.libro l on l.id_libro = p.id_libro 
inner join biblio.ejemplares e on e.id_ejemplar = p.id_ejemplar
 where p.id_ano = $ano and p.id_libro=$libro and p.estado_prestamo=2 and fecha_entrega<='$fecha'";



$result = pg_exec($conn,$sql);
		
		return $result;

}

	
public function listaDevolucion($conn,$rut_usuario,$id_ano,$fecha){
    $sql="select p.id_prestamo,p.id_libro,l.titulo,p.fecha_entrega,p.tipo_usuario,p.rut_usuario,p.estado_prestamo from biblio.prestamo p
inner join biblio.libro l on l.id_libro = p.id_libro
where p.rut_usuario!=0 and p.rut_usuario =$rut_usuario and  p.id_ano=$id_ano and p.estado_prestamo=2 and p.fecha_entrega <='$fecha';
";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function catalogocomp($conn,$tipo,$filtro,$rdb){
/*$sql="select l.*, a.nombre nomautor,e.nombre nomeditorial,c.nombre nomcatego
 from biblio.libro l 
inner join biblio.autor a on a.id_autor=l.autor
inner join biblio.editorial e on e.id_editorial = l.editorial
inner join biblio.categoria c on c.id_categoria = l.categoria  where l.rdb = ".$rdb."";*/
 $sql="select DISTINCT(l.*),e.nombre nomeditorial
from biblio.libro l 
inner join biblio.libro_autor la on la.id_libro = l.id_libro
inner join biblio.libro_categoria lc on lc.id_libro = l.id_libro
inner join biblio.editorial e on e.id_editorial = l.editorial
where l.rdb = $rdb
and l.estado=1";

if($tipo==1){
$sql.=" and lc.categoria=$filtro ";
}

if($tipo==2){
$sql.=" and l.editorial=$filtro ";
}

if($tipo==3){
$sql.=" and la.autor=$filtro ";
}

$sql.="  order by l.titulo";
//echo $sql;

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

public function ejemplares($conn,$id){
$sql="select count(*) from biblio.ejemplares where id_libro=$id and estado in (1,2)";
$result = pg_exec($conn,$sql);
		
		return $result;
}


public function prestamoLibroTodo($conn,$ano,$estado){
/*$sql="select p.*,l.titulo,e.codigo,p.estado_prestamo,p.fecha_devolucion from biblio.prestamo p 
inner join biblio.libro l on l.id_libro = p.id_libro 
inner join biblio.ejemplares e on e.id_ejemplar = p.id_ejemplar
 where p.id_ano = $ano and p.estado_prestamo=1";*/
 $sql="	select p.*,l.titulo,e.codigo,p.estado_prestamo,p.fecha_devolucion,
		case when (p.tipo_usuario=1) then emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat
			 when (p.tipo_usuario=2) then apo.nombre_apo ||' '|| apo.ape_pat ||' '|| apo.ape_mat
			 when (p.tipo_usuario=3) then al.nombre_alu ||' '|| al.ape_pat ||' '|| al.ape_mat
			 end as nombre
		from biblio.prestamo p 
		inner join biblio.libro l on l.id_libro = p.id_libro 
		inner join biblio.ejemplares e on e.id_ejemplar = p.id_ejemplar 
		left join empleado emp ON emp.rut_emp=p.rut_usuario
		left join apoderado apo ON apo.rut_apo=p.rut_usuario
		left join alumno al ON al.rut_alumno=p.rut_usuario
		where p.id_ano = $ano and p.estado_prestamo in(1,3)
		ORDER BY p.fecha_prestamo ASC";


//echo $sql;
$result = pg_exec($conn,$sql);
		
		return $result;

}

function ActualizaRegistro($conn,$ano){
	$fecha = date("Y-m-d");
	$sql="SELECT id_prestamo,fecha_devolucion,fecha_entrega,estado_prestamo FROM biblio.prestamo WHERE id_ano=".$ano." AND estado_prestamo=1";
	$result = pg_exec($conn,$sql) or die("Error en SQL -->".$sql);	
	
	for($i=0;$i<pg_numrows($result);$i++){
		$fila = pg_fetch_array($result,$i);
		
		if($fecha>$fila['fecha_devolucion'] && strlen($fila['fecha_entrega'])==0 && $fila['estado_prestamo']==1){
			$sql="UPDATE biblio.prestamo SET estado_prestamo=3 WHERE id_prestamo=".$fila['id_prestamo'];
			$rs_prestamo = pg_exec($conn,$sql);		
		}else{
			//echo "<br>i-->".$i." fecha-->".$fecha."  fecha_dev-->".$fila['fecha_devolucion'];
		}
			
	}
}
	public function cpal($conn,$ano,$ruta){
  $sql="select id_curso from matricula where id_ano=$ano and rut_alumno=$ruta";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function cpapo($conn,$ano,$rutp){
  $sql="select a.rut_apo,m.id_curso
 from apoderado a inner join tiene2 t on t.rut_apo = a.rut_apo
 inner join matricula m on m.rut_alumno = t.rut_alumno
 where m.id_ano=$ano and a.rut_apo = $rutp;
 ";
$result = pg_exec($conn,$sql);
		
		return $result;	
}


public function traeCurso($conn,$ano){
	  $sql = "select * from curso where id_ano=$ano order by ensenanza,grado_curso,letra_curso";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function buscoMulta($conn,$ano,$rut){

    $sql="select mu.*,lb.titulo ,lp.*
from biblio.multa_usuario mu inner join biblio.prestamo pr 
on pr.id_ejemplar = mu.id_ejemplar
inner join biblio.ejemplares ej on ej.id_ejemplar = mu.id_ejemplar
inner join biblio.prestamo lp on lp.id_ejemplar = mu.id_ejemplar
 inner join biblio.libro lb on lb.id_libro = lp.id_libro
 where lp.id_ano = $ano and lp.rut_usuario = $rut and mu.estado=1 ";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function buscoMoraTodos($conn,$ano){

  /* $sql="select distinct(lp.id_prestamo),mu.*,lb.titulo ,lp.*
from biblio.multa_usuario mu inner join biblio.prestamo pr 
on pr.id_ejemplar = mu.id_ejemplar
inner join biblio.ejemplares ej on ej.id_ejemplar = mu.id_ejemplar
inner join biblio.prestamo lp on lp.id_ejemplar = mu.id_ejemplar
 inner join biblio.libro lb on lb.id_libro = lp.id_libro
 where lp.id_ano = $ano  and mu.estado=1 order by lp.id_prestamo";*/
 $sql="select mu.*,lb.titulo,lp.fecha_devolucion,lp.tipo_usuario
from biblio.multa_usuario mu
left join biblio.prestamo lp on lp.id_prestamo= mu.id_prestamo 
left join biblio.libro lb on lb.id_libro = lp.id_libro
where lp.id_ano = $ano and mu.estado=1  order by lp.id_prestamo";
$result = pg_exec($conn,$sql);
		
		return $result;	
}


public function listaPrestamoUsuario($conn,$usuario,$ano){
 $sql="select p.*,l.titulo,e.codigo from biblio.prestamo p 
inner join biblio.libro l on l.id_libro = p.id_libro 
inner join biblio.ejemplares e on e.id_ejemplar = p.id_ejemplar
 where p.id_ano = $ano and p.rut_usuario=$usuario and p.estado_prestamo in(1,3)";

 
$result = pg_exec($conn,$sql);
		
		return $result;
}

public function patrasados($conn,$ano){
  $sql="select p*,l.titulo from biblio.prestamo p
inner join biblio.libro l on l.id_libro = p.id_libro
where id_ano= $ano and (fecha_entrega is null or fecha_entrega > fecha_devolucion) and estado_prestamo in (3,4)";	
$result = pg_exec($conn,$sql);
		
		return $result;
}

public function pmulta($conn,$id_prestamo){
  $sql="select * from biblio.multa_usuario where id_prestamo = $id_prestamo and estado=1";	
$result = pg_exec($conn,$sql);
		
		return $result;
}

public function cantEjemplaresPrestados($conn,$id_libro){
 $sql="select * from biblio.ejemplares where id_libro = $id_libro and estado=2";
$result = pg_exec($conn,$sql);
		
		return $result;	

}

public function cantAutores($conn,$id_libro){
$sql="
select a.nombre
from biblio.autor a
inner join biblio.libro_autor la
on la.id_autor = a.id_autor
where la.id_libro = $id_libro";
$result = pg_exec($conn,$sql);
return $result;	
}

public function cantCategorias($conn,$id_libro){
$sql="
select a.nombre
from biblio.categoria a
inner join biblio.libro_categoria la
on la.id_categoria = a.id_categoria
where la.id_libro = $id_libro";
$result = pg_exec($conn,$sql);
return $result;	
}



}//fin clase



?>