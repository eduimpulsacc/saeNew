<?
require "../../class/Coneccion.class.php";

class Relacion_agrupaevaluados{
       
	public $Conec;
	
	//constructor 
	public function Relacion_agrupaevaluados($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
       

	public function insertarevaluado($id_bloque,$rut_evaluado,$id_cargo){ 
				
	  $sql = "INSERT INTO evados.eva_grupo_evaluado(id_bloq_evaluado,rut_evaluado,id_cargo_evaluado) 
VALUES ($id_bloque,$rut_evaluado,$id_cargo)  ; ";
	  
	    $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert ".$sql );
			
			if($regis){
				   return true;
			}else{
				  return false;
			}
	
	}


	public function cargabloques(){
			
	$sql = "SELECT * FROM evados.eva_bloque_evaluado order by 1 desc;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 1" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			 
	 } 


		public function cargacargos(){
				
		$sql = "SELECT * FROM cargos ORDER BY nombre_cargo ASC;";
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
				if($regis){
					   return $regis;
				}else{
					  return false;
				}
				 
		 } 

    
	    public function buscarevaluadores($id_cargo,$id_ano,$institucion){
			
				$sql = "SELECT  DISTINCT  ca.nombre_cargo,em.nombre_emp,em.ape_pat,
					em.ape_mat,evaeva.rut_evaluado,ebe.id_bloq_evaluado,ebe.nombre_bloq_eva
					FROM cargos ca 
					INNER JOIN trabaja tra on tra.cargo = ca.id_cargo  and tra.rdb=$institucion
					INNER JOIN empleado em on em.rut_emp = tra.rut_emp
					INNER JOIN evados.eva_evaluado evaeva on evaeva.rut_evaluado = em.rut_emp
					LEFT JOIN evados.eva_grupo_evaluado ege on ege.rut_evaluado = evaeva.rut_evaluado 
					LEFT JOIN evados.eva_bloque_evaluado ebe on ebe.id_bloq_evaluado = ege.id_bloq_evaluado
					WHERE ca.id_cargo = $id_cargo";		
					
		        $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
				
				if($regis){
				    return $regis;
				}else{
				    return false;
				   }
		
			}
	
	

	public function eliminarevaluado($id_bloque,$rut_evaluado,$id_cargo){
			
	    $sql = "DELETE FROM evados.eva_grupo_evaluado WHERE id_bloq_evaluado = $id_bloque AND rut_evaluado =    
		$rut_evaluado AND id_cargo_evaluado = $id_cargo;";
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Delete 1" );
		
		if($regis){
		   return true;
		}else{
 		   return false;
		}
		
   } 


			 
} // FIN FUNCION


?>
