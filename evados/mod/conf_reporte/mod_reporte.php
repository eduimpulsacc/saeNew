<?

require "../../class/Coneccion.class.php";

class Reporte{
       
	public $Conec;
	
	//constructor 
	public function Reporte($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 

	public function listadoReporte(){  // guarda en la base datos 
	
		  $sql="SELECT id_reporte, id_item_reporte, nombre FROM evados.eva_item_reporte";
		  $result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			
		return $result;
		
	}
	
	public function InsertaReporte($reporte,$perfil,$rdb,$id_reporte){
		$sql ="INSERT INTO evados.eva_reporte_perfil (id_item_reporte,id_perfil,rdb,id_reporte) VALUES(".$reporte.",".$perfil.",".$rdb.",".$id_reporte.")";
		$rs_reporte = pg_exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		
		if($rs_reporte){
			return true;
		}else{
			return $sql;
		}
	}
	public function existeReporte($reporte,$perfil,$rdb){
		$sql ="SELECT * FROM evados.eva_reporte_perfil WHERE rdb=".$rdb." AND id_perfil=".$perfil." AND id_item_reporte=".$reporte;
		$rs_existe = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		
		return $rs_existe;
	}
	
	public function EliminaReporte($reporte,$perfil,$rdb){
		
		$sql ="DELETE FROM evados.eva_reporte_perfil WHERE id_item_reporte=".$reporte." AND id_perfil=".$perfil." AND rdb=".$rdb;
		
		$rs_reporte = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		
		if($rs_reporte){
			return true;
		}else{
			return $sql;
		}
	 
	 }



 }	




	



?>

