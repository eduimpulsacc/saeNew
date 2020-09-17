<?
require "../../class/Coneccion.class.php";

class Ano{
       
	public $Conec;
	
	//constructor 
	public function Ano($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
       
	 
	 public function traeTodosAnos($rdb){ 
				
	   $sql = "select * from evados.eva_ano_escolar where id_institucion=$rdb order by nro_ano; ";
	  
	     $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd select ".$sql );
			
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
		
	 }
	 
	 public function Modifica($ano,$estado,$rdb){
		  $sql="UPDATE evados.eva_ano_escolar SET situacion=0 WHERE id_institucion=".$rdb;
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
		 
		 
		 $sql="UPDATE evados.eva_ano_escolar SET situacion=1 WHERE id_ano=".$ano;
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
 
 		return $result;	
	}
	
	public function traeAnoNotengo($rdb){
		$sql = "select * from public.ano_escolar where id_institucion=$rdb and id_ano not in(select id_ano from evados.eva_ano_escolar where id_institucion=$rdb) order by nro_ano; ";
	  
	     $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd select ".$sql );
			
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
	
	}
	
	public function BuscaPeriodo($ano){
		 $sql="SELECT id_periodo, fecha_inicio,fecha_termino,nombre_periodo,cerrado FROM evados.eva_periodo WHERE id_ano=".$ano." ORDER BY fecha_inicio ASC";	
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
 
 		return $result;	
	}
	
	public function guardaAno($ano){
	$sql="insert into evados.eva_ano_escolar(select id_ano,nro_ano,fecha_inicio,fecha_termino,situacion,id_institucion,ano_anterior,tipo_regimen,hora_entrada from ano_escolar where id_ano=$ano)";
	$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
	
	$sql="insert into evados.eva_periodo(select * from periodo where id_ano=$ano)";
	$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
 
 		return $result;
	
	}
	
}//fin clase

?>