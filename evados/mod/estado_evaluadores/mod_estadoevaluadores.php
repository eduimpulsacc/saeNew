<?

require "../../class/Coneccion.class.php";

class estado_evaluadores{
       
	public $Conec;
	
	
	//constructor 
	public function estado_evaluadores($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 


	public function listadoReporte($ano){  // guarda en la base datos 
	
		  $sql="SELECT evev.id_cargo,
					CASE 
					WHEN evev.id_cargo = 100 THEN 'Alumno'
					WHEN evev.id_cargo = 101 THEN 'Apoderado'
					ELSE ca.nombre_cargo END as nombre_cargo
					FROM evados.eva_evaluador evev
					LEFT JOIN cargos ca ON ca.id_cargo = evev.id_cargo
					WHERE evev.id_ano = $ano
					group by 1,2 order by 1";
		  			$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			
		return $result;
		
	}
	

	public function activarevaluadores($id_cargo,$ano,$modo,$inti,$based){
	
	$sql = "SELECT cast(evev.rut_evaluador as text) as rut
	FROM evados.eva_evaluador evev 
	WHERE evev.id_ano = ".$ano." AND evev.id_cargo = ".$id_cargo.";";
	$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
	
	if($result>0){
		
	for( $e=0; $e<pg_num_rows($result);$e++ ){
		 
		  	$fila = pg_fetch_array($result,$e);
		  	
			if(!$this->crear_perfil($fila['rut'],$inti)){ 

			return false; 
			
			}else{
				
				 if($inti==1598){
						$base = $based;  
				   }else{
						$base = $based;   
				   }
						
			$sql = "SELECT array_to_string(array(SELECT evev.rut_evaluador 
					FROM evados.eva_evaluador evev 
					WHERE evev.id_ano = $ano 
					AND evev.id_cargo = $id_cargo ),',') as evaluadores;";
			$rs = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			$fila =  pg_fetch_array($rs,0); 
								
			$sql = "UPDATE public.accede  
			SET estado = ".$modo.", id_base=".$base." WHERE  id_usuario IN (SELECT id_usuario FROM usuario 
			WHERE CAST(nombre_usuario as INTEGER) IN (".$fila[0].")
			AND nombre_usuario <> 'evados' AND nombre_usuario <> 'admin')
			AND public.accede.id_perfil = 41 AND public.accede.rdb = ".$inti.";";
			
			$rs_evaluadores = pg_exec($this->Conec->coi_usuario(),$sql) or die ("fallo:".$sql);
		    
			}
			
			
		}
		
	}
	
	  if($rs_evaluadores){ 
	     return true;
	  }else{
		 return false;
		  }	
				
	}
	
	
		public function crear_perfil($rut_evaluador,$rdb){
		
		// Busco el id usuario para insertar un registro en la tabla accede con perfil evaluador
		$sql_3 = "SELECT * FROM usuario WHERE nombre_usuario = '".$rut_evaluador."'; ";
		$rs_usuario = pg_exec($this->Conec->coi_usuario(),$sql_3) or die("Error Sistema");
		
		if($rs_usuario){
			
			if(pg_num_rows($rs_usuario)!=0){
					 
			   $fila = pg_fetch_array($rs_usuario,0);
					
			  $sql_5 = "SELECT * FROM public.accede WHERE id_usuario= ".$fila['id_usuario']." 
			   AND id_perfil= 41 AND rdb = ".$rdb."; ";
			   $rs_accede = pg_exec($this->Conec->coi_usuario(),$sql_5);
					
			   if(pg_num_rows($rs_accede)==0){
				   if($rdb==1598){
						$base = 1;  
				   }else{
						$base = 2;   
				   }
				   					
				  $insert_accede = "INSERT INTO 
				  public.accede(id_usuario,id_perfil,rdb,id_sistema,id_base,estado) 		      
				  VALUES(".$fila['id_usuario'].",41,".$rdb.",3,".$base.",0);";
					  
				  $rs_accede = pg_exec($this->Conec->coi_usuario(),$insert_accede);								
			   
			   }else{ 
				 return true; 
			    }
					
				}else{ 
				
				// en caso que no existe el usuario creo el registro en tabla usuario y accede con perfil evaluador
				$sql_4 = "SELECT max(id_usuario) FROM public.usuario;";
				$rs_usuario = pg_exec($this->Conec->coi_usuario(),$sql_4);
				 
				if($rs_usuario){
				  if(pg_num_rows($rs_usuario)!=0){
						 
					$fila = pg_fetch_array($rs_usuario,0);
						 
					$id=$fila['max']+1;
					 
					$insert_usuario =  "INSERT INTO public.usuario(id_usuario,nombre_usuario,pw) 
					VALUES (".$id.",'".$rut_evaluador."','12345');";
                    $rs_insert = pg_exec($this->Conec->coi_usuario(),$insert_usuario);
						 
					$insert_accede = "INSERT INTO 
					public.accede(id_usuario,id_perfil,rdb,id_sistema,id_base,estado) 
					VALUES (".$id.",41,".$rdb.",3,2,0);";
					$rs_accede = pg_exec($this->Conec->coi_usuario(),$insert_accede);	
						 
				  }
				 }
				 
		     }
			 
		}else{

			return false; // Error al conectar
			
			}
         
		 
		   if($rs_accede){
		   return true;  		    
		   }else{
			   return false;
			   }
			   
		}
	
	
	
	public function estadoperfilevaluadores($id_cargo,$ano,$rdb){
		
		$sql = "SELECT array_to_string(array(SELECT evev.rut_evaluador 
				FROM evados.eva_evaluador evev 
				WHERE evev.id_ano = $ano 
				AND evev.id_cargo = $id_cargo ),',') as evaluadores;";
		$rs = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		$fila =  pg_fetch_array($rs,0); 
			
			
		$sql = " SELECT SUM(estado) as estado 
		FROM public.accede acc
		INNER JOIN usuario us ON us.id_usuario = acc.id_usuario  
		WHERE CAST(us.nombre_usuario as INTEGER) IN  (".$fila[0].") 
		AND acc.id_perfil = 41 
		AND acc.rdb = ".$rdb." 
		AND us.nombre_usuario <> 'evados' 
		AND us.nombre_usuario <> 'admin' ";
	    $rs_reporte = pg_Exec($this->Conec->coi_usuario(),$sql) or die ("fallo:".$sql);
		
		if($rs_reporte){
			
		 $fila = @pg_fetch_array($rs_reporte,0);
			
		 return $fila['estado'];
			
		}else{
			
		 return false;
			
		}
		
	}



 }	




	



?>

