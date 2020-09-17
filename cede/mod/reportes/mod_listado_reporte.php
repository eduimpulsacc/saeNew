<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../../Class/Membrete.php";
//require "../../Class/Coneccion.php";
class Reportes {
	   
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
	 
	 public function carga_perfil(){
	$sql="SELECT id_perfil,nombre_perfil FROM perfil WHERE id_perfil not in (0,24,15,16,26)  ORDER BY nombre_perfil ASC ;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return $regis;
			}else{
				 return false;
		}
	}
	 
	public function ListadoReportes(){
		$sql="SELECT id_reporte,nombre,url FROM cede.reportes";
		$result =@pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2".$sql );
		return $result;	
	}
	public function Ano($rdb){
		$sql= "	SELECT id_ano, nro_ano, situacion FROM ano_Escolar WHERE id_institucion=".$rdb;
		$result =@pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2".$sql );
		return $result;
	}
	
	public function Curso($ano){
		$sql="SELECT c.id_curso,grado_curso, letra_curso, nombre_tipo, cod_tipo FROM curso c INNER JOIN tipo_ensenanza te ON c.ensenanza=te.cod_tipo WHERE id_ano=".$ano." ORDER BY cod_tipo, grado_curso, letra_curso ASC";
		$result =@pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2".$sql );
		return $result;	
	}
	
	 /*CARGA ALUMNOS*/
	  
		public function Carga_Alumnos($id_curso,$id_ano){
		  
	      $sql = "SELECT alumno.rut_alumno,
						alumno.dig_rut, alumno.nombre_alu, 
						alumno.ape_pat, alumno.ape_mat,
						alumno.telefono, alumno.calle,
						alumno.nro, alumno.depto,
						alumno.region, 	alumno.ciudad,
						alumno.comuna, matricula.id_curso,
						matricula.nro_lista, matricula.bool_ar,
						matricula.num_mat 
						FROM curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso 
						INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno 
						WHERE matricula.id_curso = $id_curso AND matricula.id_ano = $id_ano 
						ORDER BY ape_pat,ape_mat,nombre_alu ASC";
           
		   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Alumnos" );
		   
	       if($regis){ return $regis; }else{ return false; }}
	 
 public function listaApo($ano,$curso){
 $sql ="select DISTINCT a.rut_apo,a.dig_rut,
a.ape_pat,a.ape_mat,a.nombre_apo 
from tiene2 t
inner join matricula m on t.rut_alumno = m.rut_alumno
inner join apoderado a on t.rut_apo = a.rut_apo
where m.id_curso=$curso";
$sql.=" order by ape_pat,ape_mat, nombre_apo";


	 $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Alumnos" );
		   
	       if($regis){ return $regis; }else{ return false; }

}

public function enseCurso($curso){
	 $sql = "SELECT grado_curso,ensenanza from curso where id_curso=$curso ";
 $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Alumnos:".$sql );
		   
	       if($regis){ return $regis; }else{ return false; }
}


public function planActiva($ense,$grado,$tipo,$rbd){
 echo  $sql ="select id_plantilla,nombre_informe from plantilla_apo where tipo_ense=$ense and grado$grado=1 and activa=1 and tipo_plantilla =$tipo and rbd=$rbd order by id_plantilla";
 
  $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Alumnos:".$sql );
		   
	       if($regis){ return $regis; }else{ return false; }
}

public function listaCurso($ano){

 $sql_curso = "SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ";
		$sql_curso.= "curso.ensenanza, curso.cod_decreto ";
		$sql_curso.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql_curso.= "WHERE (((curso.id_ano)=".$ano.")) ";
		
		$sql_curso.= "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
	//	echo $sql_curso;
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Alumnos:".$sql_curso );
		   
	       if($regis){ return $regis; }else{ return false; }

}

public function listaalu($curso){

			
	$sql =" select matricula.rut_alumno, alumno.dig_rut,alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu from matricula, alumno ";
	$sql.=" where matricula.id_curso = ".$curso. " and matricula.rut_alumno = 	
			alumno.rut_alumno and bool_ar=0 ";
			$sql.=" order by ape_pat,ape_mat, nombre_alu";
		echo $sql;
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Alumnos2:".$sql );
		   
	       if($regis){ return $regis; }else{ return false; }
	}


public function listaTrabaja($institucion){
	
$sql="SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.email, trabaja.cargo,empleado.telefono,empleado.telefono2,empleado.telefono3, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.")) order by ape_pat, ape_mat, nombre_emp asc, trabaja.cargo ";
$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Alumnos:".$sql );
		   
	       if($regis){ return $regis; }else{ return false; }

}

public function planActivaEmp($tipo,$rbd){
 echo $sql ="select id_plantilla,nombre_informe from plantilla_apo where activa=1 and tipo_plantilla =$tipo  and rbd=$rbd order by id_plantilla";
 
 $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Carga Alumnos:".$sql );
		   
	       if($regis){ return $regis; }else{ return false; }
}


}
?>