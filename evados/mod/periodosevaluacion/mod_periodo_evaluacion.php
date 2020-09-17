<?  require "../../class/Coneccion.class.php";


class periodos_evaluacion{
	
	
	public $Conec;
	
	//Constructor 
	public function periodos_evaluacion($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
	
	
	public function  select_periodos($anio){
	   $sql="SELECT periodo.id_periodo, periodo.nombre_periodo
	  FROM evados.eva_ano_escolar 
	  INNER JOIN evados.eva_periodo periodo ON evados.eva_ano_escolar.id_ano = periodo.id_ano 
	  WHERE evados.eva_ano_escolar.id_ano=".$anio." ORDER BY periodo.fecha_inicio";
	  $result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo: Select Periodo");
	  return $result;
	}
	
	
	public function  consulta_periodo($periodo,$ano){
	   $sql="SELECT p.fecha_inicio,p.fecha_termino
	 FROM evados.eva_periodo p WHERE p.id_ano=$ano AND p.id_periodo=$periodo ORDER BY p.fecha_inicio";
 	  $result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:Select Consulta Periodo");
	  return $result;
	}
		
	
	public function  ingresa_periodo_evaluacion($id_anio,$id_periodo,$fecha_inicio,$fecha_termino){
	
	$sql = "SELECT CASE WHEN '$fecha_inicio' <= '$fecha_termino' THEN 0 ELSE 1 END as valor  FROM periodo LIMIT 1";
	$result = pg_Exec($this->Conec->conectar(),$sql);
	$fila = pg_fetch_array($result,0);
	
	if($fila['valor']==1){
        return false;			
	}else{
		$sql = "SELECT id_anio,id_periodo,fecha_inicio,fecha_termino FROM evados.eva_periodos_evaluacion
							  WHERE id_anio = $id_anio AND id_periodo= $id_periodo; ";
	   $result = pg_Exec($this->Conec->conectar(),$sql);
	   if(pg_num_rows($result)>0)   $this->elimina_periodo_evaluacion($id_anio,$id_periodo);
	   $sql = "INSERT INTO   evados.eva_periodos_evaluacion(  id_anio, id_periodo, fecha_inicio,  fecha_termino ) 
	   VALUES ( $id_anio,$id_periodo,'$fecha_inicio','$fecha_termino');";
	   $result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:Insert  Periodo Evaluacion");
	   return $result;
	  } 
   }
	
	
	public function select_periodos_evaluaciones($anio){
				
		         $sql = "SELECT eee.id_anio,eee.id_periodo,
								eee.fecha_inicio,eee.fecha_termino,
								p.nombre_periodo 
								FROM evados.eva_periodos_evaluacion eee 
								INNER JOIN evados.eva_periodo p on p.id_periodo = eee.id_periodo AND p.id_ano=eee.id_anio
								WHERE id_anio = $anio ";
 	     $result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:Insert  Periodo Evaluacion");
	     
	     return $result;
	  
	 }
	
	
	public function  elimina_periodo_evaluacion($anio,$periodo){
            	
         $sql =  "DELETE FROM  evados.eva_periodos_evaluacion  WHERE id_anio=$anio AND  id_periodo= $periodo;";
          
		 $result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:Insert  Periodo Evaluacion");
	 
	     return $result;

	 }	
	
}

 ?>
