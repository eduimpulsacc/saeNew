<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();


class graficoporciclo {
	
	private $conect;       

	//constructor 
	public function __construct($con){ 
		  $this->conect = $con;  
		}
	 
	
    public function carga_anos($rdb){
		
	$sql="select * from ano_escolar an 
	where an.id_institucion=$rdb order by an.nro_ano desc"; 
   	
	$regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
	    
		if($regis){
			return $regis;
		}else{
			return false;
		}
	 
	 }
	
	
	public function carga_periodos($id_ano){
				
	 $sql = "select * from periodo p where p.id_ano = ".$id_ano." ; ";
		
	 $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
	    
	 if($regis){
		return $regis;
	  }else{
		return false;
	   }
		
	}
	
	
	
	
	public function carga_ciclos($id_periodo){
				
	 $sql = "select * from periodo p where p.id_periodo = ".$id_periodo." ";
	 $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
	 $fila = pg_fetch_array($regis,0);
	 
	 $sql = "select * from ciclo_conf c where c.id_ano = ".$fila['id_ano']." ";
	 $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql); 
	     
	 if($regis){
		return $regis;
	  }else{
		return false;
	   }
		
	}
	
	
	
	public function carga_subsectores($id_ciclo){
		
	$sql = "SELECT DISTINCT s.nombre,s.cod_subsector
			FROM ciclos c 
			INNER JOIN ramo r ON r.id_curso = c.id_curso
			INNER JOIN subsector s ON s.cod_subsector = r.cod_subsector
			WHERE c.id_ciclo = ".$id_ciclo." ";	
	$regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql); 		
	
	 if($regis){
		return $regis;
	  }else{
		return false;
	   }		
		
	} 
	
	
	
	public function carga_grados($id_ciclo){
		
	$sql = "SELECT DISTINCT cu.grado_curso FROM ciclos c 
			INNER JOIN curso cu ON cu.id_curso = c.id_curso
			WHERE c.id_ciclo = ".$id_ciclo." ";	
	$regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql); 		
	
	 if($regis){
		return $regis;
	  }else{
		return false;
	   }		
		
	} 
	
	
	public function carga_niveles($id_ciclo){	
	
	$sql = "SELECT DISTINCT cu.id_nivel,ni.nombre
			FROM ciclos c 
			INNER JOIN curso cu ON cu.id_curso = c.id_curso
			INNER JOIN niveles ni ON ni.id_nivel = cu.id_nivel
			WHERE c.id_ciclo = ".$id_ciclo."  ";
	$regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql); 		
	
	 if($regis){
		return $regis;
	  }else{
		return false;
	   }
	
	}


	 
  }
  
  
 ?>