<?
require "../../class/Coneccion.class.php";

class Relacion_e_b {
       
	public $Conec;
	
	//constructor 
	public function Relacion_e_b($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
       
	/*********************corregir insertar por ano_escolar y periodo***********************************/
	public function insertarevaluador($id_bloque,$rut_evaluador,$id_cargo,$id_periodo){ 
				
	    $sql = "INSERT INTO evados.eva_bloque_evaluador( id_bloque,rut_evaluador,id_cargo,id_periodo)  VALUES ($id_bloque,$rut_evaluador,$id_cargo,$id_periodo);";
	    $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert ".$sql );
			
			if($regis){
				   return true;
			}else{
				  return false;
			}
	
	}


	public function cargabloques($_ano){
			
	$sql = "SELECT id_bloque,nombre,porcentaje FROM evados.eva_bloque order by 1 desc ;";
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

    
	    public function buscarevaluadores($id_cargo,$id_ano,$rdb,$id_periodo){
			
			if($id_cargo != 0){ 
			 $validador ="WHERE ca.id_cargo = $id_cargo";
			 $filtro = "and evaeva.id_cargo = $id_cargo";
			}else{
			 $validador ="";	
				}
			
			
			if($id_cargo==100){
				
				$sql = "SELECT 'Alumno' as nombre_cargo,UPPER(a.nombre_alu) as nombre_emp,
				UPPER(a.ape_pat) as ape_pat,UPPER(a.ape_mat) as ape_mat,evaeva.rut_evaluador,
				bloeva.id_bloque,evablo.nombre 
				FROM evados.eva_evaluador as evaeva  
				INNER JOIN public.alumno as a ON a.rut_alumno = evaeva.rut_evaluador
				LEFT OUTER JOIN evados.eva_bloque_evaluador bloeva on bloeva.rut_evaluador = evaeva.rut_evaluador 
				and bloeva.id_cargo = ".$id_cargo." and bloeva.id_periodo=".$id_periodo."
				LEFT OUTER JOIN evados.eva_bloque evablo on evablo.id_bloque = bloeva.id_bloque 
				WHERE evaeva.id_cargo = ".$id_cargo." and evaeva.id_ano = ".$id_ano." and evaeva.id_periodo = ".$id_periodo." ; ";
				
				}else if ($id_cargo==101){
					
					$sql = "SELECT  'Apoderado' as nombre_cargo,UPPER(a.nombre_apo) as nombre_emp,
					UPPER(a.ape_pat) as ape_pat,UPPER(a.ape_mat) as ape_mat,evaeva.rut_evaluador,bloeva.id_bloque,
					evablo.nombre 
					FROM evados.eva_evaluador as evaeva  
					INNER JOIN public.apoderado as a ON a.rut_apo = evaeva.rut_evaluador
					LEFT OUTER JOIN evados.eva_bloque_evaluador bloeva on bloeva.rut_evaluador = 
					evaeva.rut_evaluador 
					and bloeva.id_cargo = ".$id_cargo."  and bloeva.id_periodo=".$id_periodo."
					LEFT OUTER JOIN evados.eva_bloque evablo on evablo.id_bloque = bloeva.id_bloque 
					WHERE evaeva.id_cargo = ".$id_cargo." and evaeva.id_ano = ".$id_ano." and evaeva.id_periodo = ".$id_periodo."; ";
					
					}else{
						
				     $sql = "SELECT ca.nombre_cargo,UPPER(em.nombre_emp) as nombre_emp
					,UPPER(em.ape_pat) as ape_pat,UPPER(em.ape_mat) as ape_mat,evaeva.rut_evaluador
					,bloeva.id_bloque,evablo.nombre,bloeva.id_periodo
					FROM cargos ca 
					INNER JOIN trabaja tra on tra.cargo = ca.id_cargo  AND tra.rdb = $rdb 
					INNER JOIN empleado em on em.rut_emp = tra.rut_emp
					INNER JOIN evados.eva_evaluador evaeva on evaeva.rut_evaluador = em.rut_emp and evaeva.id_ano = 
					".$id_ano." and evaeva.id_periodo=".$id_periodo." $filtro 
					LEFT OUTER JOIN evados.eva_bloque_evaluador bloeva on bloeva.rut_evaluador = 
					evaeva.rut_evaluador   and 
					bloeva.id_cargo = ".$id_cargo." and bloeva.id_periodo=".$id_periodo."
					LEFT OUTER JOIN evados.eva_bloque evablo on evablo.id_bloque = bloeva.id_bloque  
					$validador ";
						
						
						
						}	
						if($_PERFIL==0){
							//echo $sql;
							}
						
					
						$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
						
						if($regis){
						  return $regis;
						}else{
						  return false;
						}
		
		         
				 }
	
	
/*********************corregir eliminar por periodo***********************************/
	public function eliminarevaluador($id_bloque,$rut_evaluador,$id_cargo,$id_periodo){
			
	$sql = "DELETE FROM evados.eva_bloque_evaluador WHERE id_bloque = $id_bloque AND rut_evaluador = $rut_evaluador AND id_cargo=$id_cargo and id_periodo=$id_periodo ;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql )or die( "Error bd  Delete 1".$sql );
		if($regis){
		   return true;
		}else{
 		   return false;
		}
   } 

public function bloqueesta($id_bloque,$rut_evaluador,$id_cargo,$id_periodo){
	 $sql="select count(*) from evados.eva_bloque_evaluador WHERE id_bloque = $id_bloque AND rut_evaluador = $rut_evaluador AND id_cargo=$id_cargo and id_periodo=$id_periodo;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql );
		if($regis){
						  return $regis;
						}else{
						  return false;
						}
	}
	
	public function eliminarevaluadorTodo($id_bloque,$id_cargo,$id_periodo){
			
	 $sql = "DELETE FROM evados.eva_bloque_evaluador WHERE id_bloque = $id_bloque AND id_cargo=$id_cargo and id_periodo=$id_periodo ;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql )or die( "Error bd  Delete 1".$sql );
		if($regis){
		   return true;
		}else{
 		   return false;
		}
   } 
			 
} // FIN FUNCION


?>
