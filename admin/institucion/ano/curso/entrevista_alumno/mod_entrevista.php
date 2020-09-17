<?php 
require('../../../../../util/header.inc');

class Entrevista {
	
	private $conect;       

//constructor 
public function __construct($con){ 
      $this->conect = $con;  
    }
	
	public function carga_lista_alumnos($conn,$id_curso,$ano){
		
	    $sql="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, 
		alumno.ape_mat, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, 
		matricula.num_mat FROM curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso 
		INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno 
		WHERE matricula.bool_ar=0 AND matricula.id_curso=".$id_curso." AND matricula.id_ano=".$ano." order by ape_pat, ape_mat, nombre_alu";
		
		 $regis = pg_Exec($conn,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function carga_entrevista_todo($conn,$curso,$ano,$alumno){
		
	    $sql="SELECT e.*,emp.ape_pat||' '||emp.ape_mat||' '||emp.nombre_emp as entrevistador
		from entrevista_alumno e inner join empleado emp on emp.rut_emp = e.rut_entrevistador 
		where rut_entrevistado = $alumno and id_curso=$curso and id_ano =$ano";
		
		 $regis = pg_Exec($conn,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function empcargo($conn,$rdb,$cargo){
	 $sql="select emp.* from empleado emp inner join trabaja on trabaja.rut_emp = emp.rut_emp
where trabaja.rdb=$rdb and trabaja.cargo=$cargo ";	
$regis = pg_Exec($conn,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}	
	}
	
//	profe jefe
public function profejefe($conn,$curso){
	 $sql="select emp.* from empleado emp inner join supervisa on supervisa.rut_emp = emp.rut_emp
where  supervisa.id_curso=$curso ";	
$regis = pg_Exec($conn,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}	
	}
	
	
public function docente($conn,$rdb){
	//  $sql="select DISTINCT(emp.rut_emp),emp.ape_pat,emp.ape_mat,emp.nombre_emp from empleado emp inner join dicta on dicta.rut_emp = emp.rut_emp where id_ramo in (select id_ramo from ramo where id_curso=$curso) order by emp.ape_pat,emp.ape_mat,emp.nombre_emp ";	
	 $sql="select DISTINCT(emp.rut_emp),emp.ape_pat,emp.ape_mat,emp.nombre_emp from empleado emp inner join trabaja on trabaja.rut_emp = emp.rut_emp where trabaja.rdb = $rdb and cargo=5";
$regis = pg_Exec($conn,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}	
	}

public function selcurso($conn,$ano){
$sql = "select id_curso from curso where id_ano= $ano order by ensenanza, grado_curso,letra_curso";	
$regis = pg_Exec($conn,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}	
	}
	
public function traeAlumno($conn,$curso){
$sql = "select a.* from alumno inner join matricula m on m.rut_alumno = a.rut_alumno where m.id_curso=$curso and m.bool_ar=0 ";
$regis = pg_Exec($conn,$sql) or die( "Error3 ".$sql);	
if($regis){
				   return $regis;
			}else{
				 return false;
		}	
}
	
	public function guardaNuevo($conn,$curso,$ano,$entrevistador,$entrevistado,$tipo,$descripcion,$observaciones,$acuerdos,$fecha){
		 $sql="insert into entrevista_alumno(id_ano,id_curso,tipo_entrevista,rut_entrevistador,rut_entrevistado,descripcion,observaciones,acuerdos,fecha) values($ano,$curso,$tipo,$entrevistador,$entrevistado,'$descripcion','$observaciones','$acuerdos','$fecha');";
		$regis = pg_Exec($conn,$sql) or die( "Error3 ".$sql);	
		if($regis){
				   return $regis;
			}else{
				 return false;
		}	

		
}

public function eliminarE($conn,$id_entrevista){
	 $sql="delete from entrevista_alumno where id_entrevista=$id_entrevista";
	$regis = pg_Exec($conn,$sql) or die( "Error3 ".$sql);	
		if($regis){
				   return $regis;
			}else{
				 return false;
		}	
	}
	
public function carga_entrevista_uno($conn,$ide){
		
	    $sql="SELECT e.*,emp.ape_pat||' '||emp.ape_mat||' '||emp.nombre_emp as entrevistador
		from entrevista_alumno e inner join empleado emp on emp.rut_emp = e.rut_entrevistador 
		where id_entrevista=$ide";
		
		 $regis = pg_Exec($conn,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function empleado($conn,$rute){
	 $sql="select * from empleado where rut_emp=$rute ";	
$regis = pg_Exec($conn,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}	
	}
	
	public function alumno($conn,$ruta){
	 $sql="select * from alumno where rut_alumno=$ruta ";	
$regis = pg_Exec($conn,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}	
	}
	
	public function upEntrevista($conn,$ide,$fecha,$descripcion,$observaciones,$acuerdos){
		
		 $sql="update entrevista_alumno set fecha='$fecha',descripcion='$descripcion',observaciones='$observaciones',acuerdos='$acuerdos' where id_entrevista=$ide";
		$regis = pg_Exec($conn,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}	
		}
}//fin clase
?>