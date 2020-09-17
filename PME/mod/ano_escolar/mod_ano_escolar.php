<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../../class/Membrete.class.php";

class AnoEscolar{
	
	public $conect;
	
	public function __construct($ip,$bd){
	$this->Conec = new DBManager($ip,$bd);
	}
	
	
	public function busca_anos($rdb)
	{
		 $sql="select p.rdb,p.id_proyecto,pa.nro_ano,pa.estado, 
				case when pa.estado=1 then 'Abierto'
				when pa.estado=0 then 'Cerrado' end as estados
				from pme.proyecto p   
				inner join pme.proyecto_ano pa on pa.id_proyecto=p.id_proyecto
				where p.rdb=$rdb order by nro_ano desc";
		$result = pg_exec($this->Conec->Conectar(),$sql)or die("fallo a1".$sql );
		
		if($result){
			return $result;
			}else{
			return false;	
			}
	}
	
		public function busca_ano_actual($nro_ano,$rdb)
	{
	
		$sql_1="update pme.proyecto_ano set estado=0 where estado=1";
		$result_1 = pg_exec($this->Conec->Conectar(),$sql_1)or die("fallo a1".$sql_1 );
		
		$sql_2="update pme.proyecto_ano set estado=1 where nro_ano=$nro_ano";
		$result_2 = pg_exec($this->Conec->Conectar(),$sql_2)or die("fallo a1".$sql_2 );
		
		 $sql="select p.rdb,p.id_proyecto,pa.nro_ano,pa.estado, 
				case when pa.estado=1 then 'Abierto'
				when pa.estado=0 then 'Cerrado' end as estados
				from pme.proyecto p   
				inner join pme.proyecto_ano pa on pa.id_proyecto=p.id_proyecto
				where pa.nro_ano=$nro_ano";
		$result = pg_exec($this->Conec->Conectar(),$sql)or die("fallo a1".$sql );
		
		
		
		if($result){
			return $result;
			}else{
			return false;	
			}
	}
	
	
	}

?>