<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
//print_r($_POST);
require "../../class/Coneccion.class.php";

class Evaluaciones {
	   
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
	 
	public function cargos(){
		$sql="SELECT id_cargo,nombre_cargo FROM cargos ORDER BY 2 ASC";
		$result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error SQL".$sql);	
		
		return $result;		
	}
	
	public function empleado($cargo,$rdb,$ano,$periodo){
		if($cargo==100){
			$sql = "SELECT 'Alumno' as nombre_cargo,UPPER(a.nombre_alu) ||' '|| UPPER(a.ape_pat) 
					||' '|| UPPER(a.ape_mat) as nombre,evaeva.rut_evaluador,
					bloeva.id_bloque,evablo.nombre as nombr, a.rut_alumno as rut_emp 
					FROM evados.eva_evaluador as evaeva  
					INNER JOIN public.alumno as a ON a.rut_alumno = evaeva.rut_evaluador
					LEFT OUTER JOIN evados.eva_bloque_evaluador bloeva on bloeva.rut_evaluador = evaeva.rut_evaluador 
					and bloeva.id_cargo = ".$cargo." 
					LEFT OUTER JOIN evados.eva_bloque evablo on evablo.id_bloque = bloeva.id_bloque 
					WHERE evaeva.id_cargo = ".$cargo." and evaeva.id_ano = ".$ano." and evaeva.id_periodo = ".$periodo."
					ORDER BY nombre ASC";
				
		}else if($cargo==101){
			$sql = "SELECT  'Apoderado' as nombre_cargo,UPPER(a.nombre_apo) ||' '||	UPPER(a.ape_pat) 
					||' '|| UPPER(a.ape_mat) as nombre,evaeva.rut_evaluador,bloeva.id_bloque,
					evablo.nombre as nombr, a.rut_apo as rut_emp
					FROM evados.eva_evaluador as evaeva  
					INNER JOIN public.apoderado as a ON a.rut_apo = evaeva.rut_evaluador
					LEFT OUTER JOIN evados.eva_bloque_evaluador bloeva on bloeva.rut_evaluador = 
					evaeva.rut_evaluador 
					and bloeva.id_cargo = ".$cargo." 
					LEFT OUTER JOIN evados.eva_bloque evablo on evablo.id_bloque = bloeva.id_bloque 
					WHERE evaeva.id_cargo = ".$cargo." and evaeva.id_ano = ".$ano." and evaeva.id_periodo = ".$periodo."
					ORDER BY nombre ASC ";
		}else{
			$sql="SELECT e.rut_emp , e.nombre_emp ||' '|| e.ape_pat ||' '|| e.ape_mat as nombre
				FROM empleado e
				INNER JOIN trabaja t ON e.rut_emp=t.rut_emp
				WHERE t.rdb=".$rdb."";
				if($cargo!=0){
					 $sql.=" and cargo=".$cargo."";
				}
				$sql.=" ORDER BY nombre ASC";
		}
		$result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error SQL".$sql);	
		
		return $result;		
	}
	
	public function relaciones($ano,$periodo,$rut){
		 $sql=" SELECT  DISTINCT e.rut_emp,e.nombre_emp ||' '|| e.ape_pat ||' '|| e.ape_mat as nombre, epe.rut_evaluado,
			 ere.fecha_evaluacion
			 FROM empleado e 
			 INNER JOIN evados.eva_plantilla_evaluacion epe ON e.rut_emp=epe.rut_evaluado
			 INNER JOIN evados.eva_relacion_evaluacion ere ON ere.rut_evaluador=epe.rut_evaluador 
			 AND ere.rut_evaluado=epe.rut_evaluado AND ere.id_ano=".$ano."
			 WHERE epe.id_ano=".$ano." and epe.ip_periodo=".$periodo." and epe.rut_evaluador=".$rut." and ere.fecha_evaluacion is not null	
			 ORDER By 2 ASC";
		$result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error SQL".$sql);	
		
		return $result;		
		
			 
	}
	
	public function Elimina($ano,$periodo,$rut,$rut_evaluado){
		$sql="UPDATE evados.eva_relacion_evaluacion ere SET fecha_evaluacion=NULL WHERE ere.id_ano=".$ano." AND id_periodo=".$periodo." and ere.rut_evaluador=".$rut." AND ere.rut_evaluado=".$rut_evaluado;
		$result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error SQL".$sql);	

		$sql="DELETE FROM evados.eva_plantilla_evaluacion epe WHERE epe.id_ano=".$ano." AND ip_periodo=".$periodo." AND epe.rut_evaluador=".$rut." and epe.rut_evaluado=".$rut_evaluado;
		$result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error SQL".$sql);	
		
		return $result;
	}
}
?>

