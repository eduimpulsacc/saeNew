<?
header( 'Content-type: text/html; charset=iso-8859-1' );
require "../../class/Coneccion.class.php";

class Concepto {
       
	public $Conec;

//constructor 
public function Concepto($ip,$bd){
	$this->Conec = new DBManager($ip,$bd);
 } 
       
		public function insertarconcepto($categoria,$concepto,$sigla,$id_nacional,$critico,$estado,$peso,$optimo){ 
		
		$categoria2 = utf8_decode($categoria);
		$concepto2 = utf8_decode($concepto);
		
		$sql = "INSERT INTO evados.eva_concepto 
		( categoria,concepto,sigla,id_nacional,critico,estado,peso,optimo) VALUES ('$categoria2','$concepto2','$sigla',$id_nacional,$critico,$estado,$peso,$optimo);";
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 1" );
		
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}

		
	public function actualizaconcepto($categoria,$concepto,$sigla,$critico,$id_concepto){
	 
	 	$categoria2 = utf8_decode($categoria);
		$concepto2 = utf8_decode($concepto);
	 
	$sql = "UPDATE evados.eva_concepto SET 
	 categoria = '$categoria2', concepto = '$concepto2',
     sigla = '$sigla',critico = $critico  
	 WHERE  id_concepto = $id_concepto;";
	 
		 $result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Fallo Actualizar" );
		 
	 	    if($result){
				   return $result;
			}else{
				  return false;
			}
	 
	 }	  
		  
		  

		public function cargaconcepto($id_nacional){
		$sql = "SELECT id_concepto,categoria,concepto,sigla,critico,estado,peso FROM evados.eva_concepto WHERE id_nacional=$id_nacional ORDER BY 6,7 DESC;";
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 1" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			 
		} 
		
		public function eliminaconcepto($id){
			$sql="DELETE FROM evados.eva_concepto WHERE id_concepto=$id;";
			$result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Delete fallo:" );
			if($result){
				   return $result;
			}else{
				  return false;
			}
		}			 


      public function buscarconcepto($id_concepto){
	  
	    $sql = "SELECT id_concepto,categoria,concepto,sigla,critico
         FROM evados.eva_concepto WHERE id_concepto=$id_concepto;";
		 $result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Fallo Buscador" );
	      	if($result){
				   return $result;
			}else{
				  return false;
			}
	  
	  }
	  
			 
} // FIN FUNCION


?>
