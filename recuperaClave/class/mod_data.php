<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require('../../../util/header.inc');

class EnsayoPSU {
	

  private $conect;
  
  public function __construct($con){ 
      $this->conect = $con;  
    }
	  public function carga_anos($rdb){
		
	 $sql="select * from ano_escolar an where an.id_institucion=$rdb order by an.nro_ano desc"; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function carga_cursos($id_ano){
		
	  $sql="select * from curso c where c.id_ano=$id_ano ORDER BY c.ensenanza, c.grado_curso, c.letra_curso"; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd  1".$sql);		
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
		WHERE matricula.id_curso=".$id_curso." AND matricula.id_ano=".$ano." order by ape_pat, ape_mat, nombre_alu";
		
		 $regis = pg_Exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	

	public function asignabeca($rut,$ano,$beca,$accion){
		
	//ingresar
	if($accion==1){
	 $sql = "insert into becas_benef(rut_alumno,id_beca,id_ano,fecha_postul) values($rut,$beca,$ano,'".date("Y-m-d")."')";
	}
	
	//eliminar
	else if($accion==2){
	 $sql = "delete from becas_benef where rut_alumno = $rut and id_beca = $beca and id_ano = $ano";
	}
	

		 $regis = pg_Exec($this->conect,$sql) or die( "Error3 ".$sql);	
			
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	
	}
	
	public function chk_beca($rut,$ano,$beca){
		
	  $sql = "select * from becas_benef where rut_alumno = $rut and id_beca = $beca and id_ano = $ano";
	  $regis = pg_Exec($this->conect,$sql) or die( "Error3 ".$sql);	
	  if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	 
}
?>