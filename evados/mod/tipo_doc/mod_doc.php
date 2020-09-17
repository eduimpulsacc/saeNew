<?
require "../../class/Coneccion.class.php";

class TipoDoc {
       
public $Conec;

//constructor 
public function TipoDoc($ip,$bd){
	$this->Conec = new DBManager($ip,$bd);
 } 
       
		public function insertardoc($nombre,$rdb){ 
		
		$sql = "INSERT INTO evados.eva_tipo_doc ( nombre,rdb) VALUES ( '$nombre',$rdb );";
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 1" );
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}
        
		
		public function actualizardoc($_id_tipo,$tipodoc,$rdb){
		
		$sql = "UPDATE evados.eva_tipo_doc SET nombre = '$tipodoc',rdb = $rdb WHERE id_tipo = $_id_tipo ;";
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error BD Actualizar" );
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}

		
		public function buscardoc($iddoc){
		$sql = "SELECT id_tipo,nombre,rdb FROM evados.eva_tipo_doc  as ed WHERE  ed.id_tipo = $iddoc ORDER BY nombre ASC;";
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select buscardoc" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}
		

		public function cargadoc(){
			
		$sql = "SELECT id_tipo,nombre FROM evados.eva_tipo_doc  ORDER BY 2;";
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 1" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			 
		} 
		
		public function eliminadoc($tipo){
			$sql="DELETE FROM evados.eva_tipo_doc WHERE id_tipo=$tipo;";
			$result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Delete fallo:" );
			if($result){
				   return $result;
			}else{
				  return false;
			}
		}			 

			 
} // FIN FUNCION


?>
