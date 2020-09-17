<?php
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
 require_once('../../../../../../util/header.inc');

class AlumnoTaller

{
	
	private $conect;       

//constructor 
public function __construct($con){ 
      $this->conect = $con;  
    }
	
	
	public function carga_taller($rdb,$id_ano)
	{
	 $sql="select t.*,dt.*,em.nombre_emp||' '||em.ape_pat||' '||em.ape_mat as nombre_emp, 
			  case WHEN t.modo_eval=0 then 'Indeterminado' 
			  WHEN t.modo_eval=1 then 'Numerica' 
			  WHEN t.modo_eval=2 then 'Conceptual' end as modo_evaluacion
			  from taller t
			  JOIN dicta_taller dt on dt.id_taller=t.id_taller
			  JOIN empleado em on em.rut_emp=dt.rut_emp
			  where rdb=$rdb and id_ano=$id_ano AND dt.acargo=1";
		$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	}
	
	public function inscribe_taller($rut_alumno,$id_taller)
	{
		$sql="insert into tiene_taller VALUES (".$rut_alumno.",".$id_taller.")";
		$result=pg_Exec($this->conect,$sql)or die("Fallo 1 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
	}
	
	public function elimina_taller($rut_alumno,$id_taller)
	{
		$sql="delete from tiene_taller where rut_alumno=".$rut_alumno." and id_taller=".$id_taller."";
		$result=pg_Exec($this->conect,$sql)or die("Fallo 1 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
	}
			
}
?>