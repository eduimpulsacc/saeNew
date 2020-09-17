<? 
session_start();

class Infespecial{
	
	public function ano($conn,$rdb){
		$sql="SELECT id_ano, nro_ano,situacion FROM ano_escolar WHERE id_institucion=".$rdb." ORDER BY nro_ano ASC";
		$result = pg_exec($conn,$sql) or die("ERROR");
		
		return $result;
	}
	
	
	public function periodo($conn,$ano){
		$sql="SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano." ORDER BY fecha_inicio ASC";
		$result = pg_exec($conn,$sql) or die("ERROR: ");
		
		return $result;
	}
	
	public function curso($conn,$ano){
		$sql="SELECT id_curso,grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo AS curso, ensenanza FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza=tipo_ensenanza.cod_tipo WHERE id_ano=".$ano." ORDER BY ensenanza,curso ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function alumno($conn,$curso){
		$sql="SELECT nombre_alu ||' '|| ape_pat ||' '|| ape_mat as nombre, a.rut_alumno FROM alumno a INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno WHERE id_curso=".$curso." ORDER BY ape_pat,ape_pat,nombre_alu ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;
			
	}
	
	public function alumno1($conn,$alumno){
	$sql="SELECT nombre_alu ||' '|| ape_pat ||' '|| ape_mat as nombre, a.rut_alumno FROM alumno a WHERE rut_alumno=".$alumno." ORDER BY ape_pat,ape_pat,nombre_alu ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;
			
	}
	
	public function traeEntrevista($conn,$anio,$periodo,$curso,$alumno){
	 $sql="select * from necesidad_especial where id_ano = $anio and id_periodo = $periodo and id_curso = $curso and rut_alumno = $alumno";
	
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function empleado($conn,$rdb){
	
	  $qry="SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.email, trabaja.cargo,empleado.telefono,empleado.telefono2,empleado.telefono3, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$rdb.")) order by ape_pat, ape_mat, nombre_emp asc, trabaja.cargo ";
	$result = pg_exec($conn,$qry);
		
		return $result;
	}
	
	
	public function empleado1($conn,$rut_emp){
	
	 $qry="SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.email, trabaja.cargo,empleado.telefono,empleado.telefono2,empleado.telefono3, trabaja.fecha_ingreso, trabaja.fecha_retiro, cargos.nombre_cargo FROM empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp INNER JOIN institucion ON trabaja.rdb = institucion.rdb inner join cargos on trabaja.cargo = cargos.id_cargo WHERE empleado.rut_emp =$rut_emp order by ape_pat, ape_mat, nombre_emp asc, trabaja.cargo ";
	$result = pg_exec($conn,$qry);
		
		return $result;
	}
	
	public function guardar($conn,$id_ano,$id_periodo,$id_curso,$rut_alumno,$rut_emp,$nombre_recibe,$rut_recibe,$digrut_recibe,$relacion_recibe,$interprete_recibe,$tipo_eval,$motivo_evaluacion,$diagnostico,$academico_fortaleza,$academico_necesidad,$social_fortaleza,$social_necesidad,$salud_fortaleza,$salud_necesidad,$apoyo_hogar,$descrip_apoyo,$necesidad_apoyo,$acuerdo,$fecha_entrega,$prox_evaluacion){
	
	 $sql="insert into necesidad_especial(
	id_ano,
id_periodo,
id_curso,
rut_alumno,
rut_emp,
fecha_entrega,
rut_recibe,
digrut_recibe,
nombre_recibe,
relacion_recibe,
interprete_recibe,
tipo_evaluacion,
motivo_evaluacion,
diagnostico,
academico_fortaleza,
academico_necesidad,
social_fortaleza,
social_necesidad,
salud_fortaleza,
salud_necesidad,
apoyo_educativo,
descrip_apoyo,
necesidad_apoyo,
acuerdo,
prox_evaluacion,
apoyo_hogar
	)
	
values(
$id_ano,
$id_periodo,
$id_curso,
$rut_alumno,
$rut_emp,
'$fecha_entrega',
'$rut_recibe',
'$digrut_recibe',
'".utf8_decode($nombre_recibe)."',
'".utf8_decode($relacion_recibe)."',
'".utf8_decode($interprete_recibe)."',
$tipo_eval,
'".utf8_decode($motivo_evaluacion)."',
'".utf8_decode($diagnostico)."',
'".utf8_decode($academico_fortaleza)."',
'".utf8_decode($academico_necesidad)."',
'".utf8_decode($social_fortaleza)."',
'".utf8_decode($social_necesidad)."',
'".utf8_decode($salud_fortaleza)."',
'".utf8_decode($salud_necesidad)."',
'".utf8_decode($apoyo_educativo)."',
'".utf8_decode($descrip_apoyo)."',
'".utf8_decode($necesidad_apoyo)."',
'".utf8_decode($acuerdo)."',
'".utf8_decode($prox_evaluacion)."',
'".utf8_decode($apoyo_hogar)."'
)	
	";
	
	$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function traeReporte($conn,$id){
		 $sql ="select * from necesidad_especial where id_necesidad=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function eliminaReporte($conn,$id){
		$sql="delete from necesidad_especial where id_necesidad=$id";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function actualizar($conn,$cmb_empleado,$nombre_recibe,$rut_recibe,$digrut_recibe,$relacion_recibe,$interprete_recibe,$tipo_eval,$motivo_evaluacion,$diagnostico,$academico_fortaleza,$academico_necesidad,$social_fortaleza,$social_necesidad,$salud_fortaleza,$salud_necesidad,$apoyo_hogar,$descrip_apoyo,$necesidad_apoyo,$acuerdo,$fecha_entrega,$prox_evaluacion,$id_necesidad){
	
		 $sql="update necesidad_especial set
		rut_emp=$cmb_empleado,
		fecha_entrega='$fecha_entrega',
		rut_recibe=$rut_recibe,
		digrut_recibe='$digrut_recibe',
		nombre_recibe='".utf8_decode($nombre_recibe)."',
		relacion_recibe='".utf8_decode($relacion_recibe)."',
		interprete_recibe='".utf8_decode($interprete_recibe)."',
		tipo_evaluacion=$tipo_eval,
		motivo_evaluacion='".utf8_decode($motivo_evaluacion)."',
		diagnostico='".utf8_decode($diagnostico)."',
		academico_fortaleza='".utf8_decode($academico_fortaleza)."',
		academico_necesidad='".utf8_decode($academico_necesidad)."',
		social_fortaleza='".utf8_decode($social_fortaleza)."',
		social_necesidad='".utf8_decode($academico_necesidad)."',
		salud_fortaleza='".utf8_decode($salud_fortaleza)."',
		salud_necesidad='".utf8_decode($salud_necesidad)."',
		apoyo_educativo='".utf8_decode($apoyo_educativo)."',
		descrip_apoyo='".utf8_decode($descrip_apoyo)."',
		necesidad_apoyo='".utf8_decode($necesidad_apoyo)."',
		acuerdo='".utf8_decode($acuerdo)."',
		prox_evaluacion='".utf8_decode($prox_evaluacion)."',
		apoyo_hogar='".utf8_decode($apoyo_hogar)."'		
		where id_necesidad=$id_necesidad";
		$result = pg_exec($conn,$sql);
		
		return $result;
		
}

public function treaAlumno($conn,$alumno){
	$sql="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
	$result = pg_exec($conn,$sql);
		return $result;
	
	}
	
public function inst($conn,$rdb){
 $sql="select * from institucion where rdb=".$rdb;
$result = pg_exec($conn,$sql);
		return $result;
}

public function entPend ($conn,$anio,$periodo){
	   $sql="select * from necesidad_especial where id_ano = $anio and id_periodo = $periodo and prox_evaluacion>'".date("Y-m-d")."'";
	
		$result = pg_exec($conn,$sql);
		
		return $result;
	
	}
}//fin clase

?>