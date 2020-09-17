<?
header( 'Content-type: text/html; charset=iso-8859-1' );

require "../../class/Coneccion.class.php";

class grupoevaluados {
       
	public $Conec;
	
	//constructor 
	public function grupoevaluados($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
       

	public function insertargrupoevaluados($nombre,$porcentaje){ 
	
	$nombre = utf8_decode($nombre);
		
	$sql = "INSERT INTO evados.eva_bloque_evaluado(nombre_bloq_eva,porcentaje_bloq_eva) 
	VALUES ( '$nombre',$porcentaje );";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 1" );
	   if($regis){
		  return true;
	   }else{
		  return false;
	   }
	 }


	public function cargagrupoevaluados($_ano){
			
	$sql = "SELECT * FROM evados.eva_bloque_evaluado order by 1 desc ;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 1" );
			if($regis){
			  return $regis;
			}else{
			  return false;
			}
		  } 


	public function eliminarbloques($id_bloque){
			
	$sql = "DELETE FROM evados.eva_bloque_evaluado WHERE id_bloq_evaluado = $id_bloque ;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Delete 1" );
		if($regis){
		   return true;
		}else{
 		   return false;
		}
      } 


	public function modificargrupoevaluados($id_bloque,$nombre_bloque,$porcentaje_bloque){
	
	$nombre_bloque = utf8_decode($nombre_bloque);
			
   $sql = "UPDATE evados.eva_bloque_evaluado 
   SET nombre_bloq_eva = '".trim($nombre_bloque)."' ,
   porcentaje_bloq_eva = $porcentaje_bloque 
   WHERE id_bloq_evaluado = $id_bloque ;";

	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Update 1" );
	
		if($regis){
		  return true;
		}else{
		  return false;
		   }
	} 
		
		
	
	public function buscargrupoevaluados($id_bloq_evaluado){
			
	$sql = "SELECT  * FROM evados.eva_bloque_evaluado 
	WHERE id_bloq_evaluado= $id_bloq_evaluado;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Select 2" );
	
		if($regis){
			   return $regis;
		}else{
			  return false;
				}
				
	      } 
		


			 
} // FIN FUNCION


?>
