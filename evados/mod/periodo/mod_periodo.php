<?

require "../../class/Coneccion.class.php";


class Periodo{
	
public $Conec;
	
	//constructor 
	public function Periodo($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 }	
	 
	public function Modifica($periodo,$estado,$ano){
		 $sql="UPDATE evados.eva_periodo SET cerrado=1 WHERE id_ano=".$ano;
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
		
		
		$sql="UPDATE evados.eva_periodo SET cerrado=0 WHERE id_periodo=".$periodo;
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
 
 		return $result;	
	}
	
	public function BuscaPeriodo($ano){
		$sql="SELECT id_periodo, fecha_inicio,fecha_termino,nombre_periodo,cerrado FROM evados.eva_periodo WHERE id_ano=".$ano." ORDER BY fecha_inicio ASC";	
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
 
 		return $result;	
	}
	
	public function traeTodosAnos($rdb){ 
				
	   $sql = "select * from evados.eva_ano_escolar where id_institucion=$rdb order by nro_ano;";
	  
	     $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd select ".$sql );
			
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
		
	 }
	 	
}




?>