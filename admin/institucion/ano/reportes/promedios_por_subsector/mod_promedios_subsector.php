<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require('../../../../../util/header.inc');

class PromSub {
	
	private $conect;       

//constructor 
public function __construct($con){ 
      $this->conect = $con;  
    }
	 
	 public function carga_periodo($id_ano){
	  $sql ="SELECT id_periodo, nombre_periodo FROM periodo WHERE id_ano=".$id_ano." ORDER BY id_periodo ASC";
		$result = pg_exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($result){
				   return $result;
			}else{
				 return false;
		}
		
	}
	
	
	public function carga_ramo($id_ano){
		
	 $sql="select distinct ramo.cod_subsector,subsector.nombre
FROM ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector 
WHERE id_curso in (SELECT id_curso 
FROM curso WHERE id_ano=$id_ano) "; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error2".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function nombreCurso($id_ano)
	{
	echo $sql="SELECT cu.id_curso,cu.grado_curso ||'-'||cu.letra_curso ||' '|| te.nombre_tipo as cursos
			from curso cu
			INNER JOIN tipo_ensenanza te ON te.cod_tipo=cu.ensenanza 
			where cu.id_ano=$id_ano and cu.ensenanza > 10
			order by ensenanza, grado_curso,letra_curso";	
			
		$result = pg_exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($result){
				   return $result;
			}else{
				 return false;
		}
	}
	
	public function detallado($id_periodo,$id_ramo,$id_curso)
	{
	$sql="select avg(promedio) from notas2013 WHERE
id_periodo =$id_periodo and id_ramo=$id_ramo and rut_alumno in(select promedio from matricula where id_curso=$id_curso)";	
			
		$result = pg_exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($result){
				   return $result;
			}else{
				 return false;
		}
	}
	
	 
	 
	 
}
?>