<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require('../../../../../util/header.inc');

class EnsayoSimce {
	
	private $conect;       

//constructor 
public function __construct($con){ 
      $this->conect = $con;  
    }
	
	public function carga_cursos($id_ano){
		
	  $sql="select * from curso c where c.id_ano=$id_ano and c.ensenanza>10 ORDER BY c.ensenanza, c.grado_curso, c.letra_curso"; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd  1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function carga_ramos($id_curso){
		
	 $sql="select ramo.id_ramo,su.nombre,ramo.id_orden,su.cod_subsector from ramo 
	inner join subsector su on ramo.cod_subsector=su.cod_subsector
	where ramo.id_curso=".$id_curso."order by ramo.id_orden ASC"; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error2".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function carga_lista_alumnos($id_curso,$ano){
		
	    $sql="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, 
		alumno.ape_mat, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, 
		matricula.num_mat FROM curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso 
		INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno 
		WHERE matricula.bool_ar=0 AND matricula.id_curso=".$id_curso." AND matricula.id_ano=".$ano." order by ape_pat, ape_mat, nombre_alu";
		
		 $regis = pg_Exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function carga_lista_puntajes($id_curso,$id_ramo){
		 
		   $sql="select distinct fecha from ensayos_simce  where id_curso=".$id_curso." and id_ramo=".$id_ramo." order by fecha";
		   $regis = pg_Exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function puntaje_alumno_fecha($id_curso,$id_ramo,$rut_alumno,$fecha){
		$sql="select * from ensayos_simce  where id_curso=".$id_curso." and id_ramo=".$id_ramo." and rut_alumno=".$rut_alumno." AND fecha='".$fecha."'";
		  $regis = pg_Exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function puntaje_curso_fecha($id_curso,$id_ramo,$fecha){
		$sql="select * from ensayos_simce  where id_curso=".$id_curso." and id_ramo=".$id_ramo."  AND fecha='".$fecha."'";
		  $regis = pg_Exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function guardaPuntaje($ano,$id_ramo,$id_curso,$rut_alumno,$fecha,$puntaje){
		  $sql = "INSERT INTO ensayos_simce(id_ano,id_ramo,id_curso,rut_alumno,fecha,puntaje) VALUES (".$ano.",".$id_ramo.",".$id_curso.",".$rut_alumno.",'".$fecha."',".$puntaje.");";
					 					 
					// if($_PERFIL==0){echo $sql;}

	               $regis = pg_Exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
		}
		
		
public function elimina_puntaje($curso,$ramo,$fecha){
	  $sql ="delete from ensayos_simce where id_ramo=".$ramo." and id_curso=".$curso." and fecha='".$fecha."'";
	 $regis = pg_Exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	
	
}

public function actPuntaje($curso,$ramo,$alumno,$fecha,$puntaje){
		   $sql="update ensayos_simce set puntaje =$puntaje where rut_alumno = $alumno and id_ramo = $ramo and fecha='$fecha'";
		$regis = pg_Exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
}//fin clase
?>