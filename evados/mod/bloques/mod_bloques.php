<? header( 'Content-type: text/html; charset=iso-8859-1' );
require "../../class/Coneccion.class.php";

class Bloques {
       
	public $Conec;
	
	//constructor 
	public function Bloques($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
       

	public function insertarbloque($nombre,$porcentaje,$tipo_evaluacion){ 
	
	$nombre = utf8_decode($nombre);
		
	$sql = "INSERT INTO evados.eva_bloque ( nombre,porcentaje,modo_eval ) VALUES ( '$nombre',$porcentaje,$tipo_evaluacion );";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 1" );
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


	public function eliminarbloques($id_bloque){
			
	$sql = "DELETE FROM eva_bloque WHERE evados.id_bloque = $id_bloque ;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Delete 1" );
		if($regis){
		   return true;
		}else{
 		   return false;
		}
   } 


	public function modificarbloques($id_bloque,$nombre_bloque,$porcentaje_bloque,$tipo_evaluacion){
	
	$nombre_bloque = utf8_decode($nombre_bloque);
			
   $sql = "UPDATE  evados.eva_bloque SET nombre = '".trim($nombre_bloque)."' ,porcentaje = $porcentaje_bloque ,modo_eval=$tipo_evaluacion WHERE  id_bloque =   $id_bloque ;";

	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Update 1" );
	
		if($regis){
			   return true;
		}else{
			  return false;
				}
	} 
		
	
	public function buscarbloque($id_bloque){
			
	$sql = "SELECT id_bloque,nombre,porcentaje 
	FROM evados.eva_bloque WHERE id_bloque= $id_bloque;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Select 2" );
	
		if($regis){
			   return $regis;
		}else{
			  return false;
				}
	} 
		


			 
} // FIN FUNCION


?>
